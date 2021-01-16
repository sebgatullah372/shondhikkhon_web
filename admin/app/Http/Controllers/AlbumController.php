<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Service;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Auth;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     */
    public function index()
    {
        $services = Service::all();
        $albums = Album::all();
        return view('album.index', compact('albums','services'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     *
     */
    public function store(Request $request)
    {

       $request->validate([
            'name' => 'required|max:190',
            'cover_photo' => 'required|image|mimes:jpeg,jpg,png|max:3072|dimensions:max_height=1400'
            ],
            ['cover_photo.dimensions' => 'Please upload a landscape image with height not more than 1400px']);



        $data = $request->except('_token');
//        if($request->has('show_on_home')){
//            $data['show_on_home'] = 1;
//        }
        if ($request->hasFile('cover_photo')) {
            $image = $request->file('cover_photo');
//            $image_resize = Image::make($image->getRealPath());
//            $resized_image = $image_resize->resize(300, 300);
            $name = time() . '.' . $image->getClientOriginalExtension(); //getting the extension

            $image->storePubliclyAs('public/albums/cover_photos', $name);
            $image_path = "storage/albums/cover_photos/" . $name;
            $data['cover_photo'] = $image_path;
        }
        Album::create($data);
        return redirect()->back()->with('success', ' New Album created');

    }

    /**
     *Display the specified resource.

     *
     * @param Album $album
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     */
    public function show(Album $album)
    {
        $album->load('galleries');

        return view('album.show', compact('album'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Album $album
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     */
    public function edit(Album $album)
    {
        $services = Service::all();

        return view('album.edit', compact('album','services'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Album $album
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Album $album)
    {


        $request->validate([
            'name' => 'required|max:190',
            'cover_photo' => 'image|mimes:jpeg,jpg,png|max:3072|dimensions:max_height=1400'
        ],
            ['cover_photo.dimensions' => 'Please upload a landscape image with height not more than 1400px']);


        $data = $request->except('_token', '_method');
//        if($request->has('show_on_home')){
//            $data['show_on_home'] = 1;
//        }else{
//            $data['show_on_home'] = 0;
//        }
        if ($request->hasFile('cover_photo')) {
            $image = $request->file('cover_photo');
            $file_path = public_path($album->cover_photo);
            if (file_exists($file_path) && !empty($album->cover_photo)) {
                unlink($file_path);
            }
            $name = time() . '.' . $image->getClientOriginalExtension(); //getting the extension

            $image->storePubliclyAs('public/albums/cover_photos', $name);
            $image_path = "storage/albums/cover_photos/" . $name;
            $data['cover_photo'] = $image_path;
        }
        $album->update($data);
        return redirect()->back()->with('success', ' Album updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function destroy(Album $album)
    {
        //
    }
}
