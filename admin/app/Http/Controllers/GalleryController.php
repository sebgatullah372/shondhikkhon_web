<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Gallery;
use App\Models\GalleryImage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param Gallery $gallery
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     */
    public function show(Gallery $gallery)
    {
        $gallery->load('album', 'galleryImages');
        return view('gallery.show', compact('gallery'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Gallery $gallery
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     */
    public function edit(Gallery $gallery)
    {
        $albums = Album::all();
        $gallery->load('album', 'galleryImages');
        return view('gallery.edit', compact('albums', 'gallery'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Gallery $gallery
     * @return \Illuminate\Http\RedirectResponse
     *
     */
    public function update(Request $request, Gallery $gallery)
    {
        //dd($request->all());
        //dd($gallery->galleryImages);
        $request->validate([
            'name' => 'required|max:190',
            'album' => 'required',
            'cover_photo' => 'image|mimes:jpeg,jpg,png|max:3072|dimensions:max_height=1500',
            'image_location.*' => 'image|mimes:jpeg,jpg,png|max:3072'
        ],
            [
                'cover_photo.dimensions' => 'Please upload a landscape image with height not more than 1500px',
                'image_location.*.image' => 'File must be an image',
                'image_location.*.mimes' => 'Please upload jpeg, jpg, png files only',
                'image_location.*.max' => 'The maximum limit of the image file is 3 MB'

            ]
        );

        $updateGallery = array();

        $updateGallery = [
            'name' => $request->name,
            'album_id' => $request->album,
            'description' => $request->description,
        ];

        if ($request->has('show_on_home')) {
            $updateGallery['show_on_home'] = 1;
        } else {
            $updateGallery['show_on_home'] = 0;
        }
        $galleryLocation = $gallery->cover_photo;
        $explodeGalleryLocation = explode('/', $galleryLocation);
        //Getting the gallery folder name when the gallery was first created
        $galleryFolderName = $explodeGalleryLocation[3];
        if ($request->hasFile('cover_photo')) {
            $file_path = public_path($gallery->cover_photo);

            if (file_exists($file_path) && !empty($gallery->cover_photo)) {
                unlink($file_path);
            }

            $image = $request->file('cover_photo');
            $name = time() . '.' . $image->getClientOriginalExtension(); //getting the extension
            $image->storePubliclyAs('public/albums/galleries/' . $galleryFolderName . '/cover_photo', $name);
            $image_path = 'storage/albums/galleries/' . $galleryFolderName . '/cover_photo/' . $name;
            $updateGallery['cover_photo'] = $image_path;
        }
        //Updating gallery basic information
        $gallery->update($updateGallery);

        //Updating the old image captions
        $oldImgIndex = 0;

        foreach ($gallery->galleryImages as $oldImage) {
            $oldImage->update(['image_caption' => $request->old_image_caption[$oldImgIndex]]);
            ++$oldImgIndex;
        }

        //Getting the old image ids which have to be removed
        $oldImagesRemoveList = $request->old_images_remove_list;
        $oldImagesRemoveList = explode(',', $oldImagesRemoveList);


        if (count($oldImagesRemoveList) > 0 && $oldImagesRemoveList[0] !== "") {//checking if the old image remove list is not empty

            foreach ($oldImagesRemoveList as $galleryImageId) {

                $galleryImage = $gallery->galleryImages()->where('id', $galleryImageId)->first();

                $file_path = public_path($galleryImage->image_location);
                if (file_exists($file_path) && !empty($galleryImage->image_location)) {
                    unlink($file_path);
                }
                $gallery->galleryImages()->where('id', $galleryImageId)->delete();

            }
        }
        //Adding new images to the gallery
        $newGalleryImage = array();
        $removeList = $request->remove_list;

        $removeList = explode(',', $removeList);

        if ($request->image_location !== null) {
            if ($removeList[0] == "") {
                //if there is no image to be removed then the array is made empty here. The exploded string of removeList returns "" in the 0 element. So it is removed using array_pop
                array_pop($removeList);

            }
            for ($i = 0; $i < sizeof($request->image_location); $i++) {


                if ($request->hasFile('image_location.' . $i) && in_array($i, $removeList) === false) {

                    $image = $request->file('image_location.' . $i);

                    $dimensions = getimagesize($image);

                    $image_name = hexdec(uniqid()) . mt_rand(1000, 9999);

                    $name = $image_name . '.' . $image->getClientOriginalExtension(); //getting the extension
                    $image->storePubliclyAs('public/albums/galleries/' . $galleryFolderName . '/', $name);
                    $image_path = 'storage/albums/galleries/' . $galleryFolderName . '/' . $name;
                    $singleGalleryImage['image_location'] = $image_path;
                    $singleGalleryImage['gallery_id'] = $gallery->id;
                    $singleGalleryImage['image_caption'] = $request->image_caption[$i];
                    $singleGalleryImage['width'] = $dimensions[0];
                    $singleGalleryImage['height'] = $dimensions[1];
                    if ($singleGalleryImage['height'] > 1500) {
                        $singleGalleryImage['image_type'] = 1; //portrait image
                    } else {
                        $singleGalleryImage['image_type'] = 0; //landscape image
                    }

                    array_push($newGalleryImage, $singleGalleryImage);
                }

            }
        }

        DB::table('gallery_images')->insert($newGalleryImage);

        return redirect()->back()->with('success', 'Gallery updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Gallery $gallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gallery $gallery)
    {
        //
    }

    /**
     * stores the gallery and the images by album
     * @param Request $request
     * @param Album $album
     * @return \Illuminate\Http\RedirectResponse
     *
     */

    public function storeGalleryByAlbum(Request $request, Album $album)
    {

        $request->validate([
            'name' => 'required|max:190',
            'cover_photo' => 'required|image|mimes:jpeg,jpg,png|max:3072|dimensions:max_height=1500',
            'image_location.*' => 'image|mimes:jpeg,jpg,png|max:3072'
        ],
            [
                'cover_photo.dimensions' => 'Please upload a landscape image with height not more than 1500px',
                'image_location.*.image' => 'File must be an image',
                'image_location.*.mimes' => 'Please upload jpeg, jpg, png files only',
                'image_location.*.max' => 'The maximum limit of the image file is 3 MB'

            ]
        );

        //dd($request->all());
        $newGallery = array();

        $newGallery = [
            'name' => $request->name,
            'album_id' => $album->id,
            'description' => $request->description,
        ];

        if ($request->has('show_on_home')) {
            $newGallery['show_on_home'] = 1;
        }

        $galleryName = Str::snake($newGallery['name']);

        $galleryName = $galleryName . time();

        if ($request->hasFile('cover_photo')) {
            $image = $request->file('cover_photo');
            $name = time() . '.' . $image->getClientOriginalExtension(); //getting the extension
            $image->storePubliclyAs('public/albums/galleries/' . $galleryName . '/cover_photo', $name);
            $image_path = 'storage/albums/galleries/' . $galleryName . '/cover_photo/' . $name;
            $newGallery['cover_photo'] = $image_path;
        }

        $gallery = Gallery::create($newGallery);
        $newGalleryImage = array();
        $removeList = $request->remove_list;
        $removeList = explode(',', $removeList);
        if ($request->image_location !== null) {

            if ($removeList[0] == "") {
                //if there is no image to be removed then the array is made empty here. The exploded string of removeList returns "" in the 0 element. So it is removed using array_pop
                array_pop($removeList);

            }

            for ($i = 0; $i < sizeof($request->image_location); $i++) {

                if ($request->hasFile('image_location.' . $i) && in_array($i, $removeList) === false) {
                    $image = $request->file('image_location.' . $i);
                    $dimensions = getimagesize($image);

                    $image_name = hexdec(uniqid()) . mt_rand(1000, 9999);

                    $name = $image_name . '.' . $image->getClientOriginalExtension(); //getting the extension
                    $image->storePubliclyAs('public/albums/galleries/' . $galleryName . '/', $name);
                    $image_path = 'storage/albums/galleries/' . $galleryName . '/' . $name;
                    $singleGalleryImage['image_location'] = $image_path;
                    $singleGalleryImage['gallery_id'] = $gallery->id;
                    $singleGalleryImage['image_caption'] = $request->image_caption[$i];
                    $singleGalleryImage['width'] = $dimensions[0];
                    $singleGalleryImage['height'] = $dimensions[1];
                    if ($singleGalleryImage['height'] > 1500) {
                        $singleGalleryImage['image_type'] = 1; //portrait image
                    } else {
                        $singleGalleryImage['image_type'] = 0; //landscape image
                    }

                    array_push($newGalleryImage, $singleGalleryImage);
                }
            }
        }


        DB::table('gallery_images')->insert($newGalleryImage);

        return redirect()->back()->with('success', ' New Gallery created');

    }
}
