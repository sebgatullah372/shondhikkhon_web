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
     * @param \App\Models\Gallery $gallery
     * @return \Illuminate\Http\Response
     */
    public function show(Gallery $gallery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Gallery $gallery
     * @return \Illuminate\Http\Response
     */
    public function edit(Gallery $gallery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Gallery $gallery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gallery $gallery)
    {
        //
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

            ]);

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
