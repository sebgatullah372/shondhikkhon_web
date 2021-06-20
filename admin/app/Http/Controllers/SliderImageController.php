<?php

namespace App\Http\Controllers;

use App\Models\SliderImage;
use Illuminate\Http\Request;

class SliderImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     */
    public function index()
    {
        $slider_images = SliderImage::all();
        return view('slider_image.index', compact('slider_images'));
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
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'caption' => 'required|max:190',
            'image_location' => 'required|image|mimes:jpeg,jpg,png|max:3072|dimensions:max_height=1500'
        ],
            ['image_location.dimensions' => 'Please upload a landscape image with height not more than 1500px']);



        $data = $request->except('_token');

        if ($request->hasFile('image_location')) {
            $image = $request->file('image_location');
            $name = time() . '.' . $image->getClientOriginalExtension(); //getting the extension

            $image->storePubliclyAs('public/slider_images', $name);
            $image_path = "storage/slider_images/" . $name;
            $data['image_location'] = $image_path;
        }
        SliderImage::create($data);
        return redirect()->back()->with('success', ' New sldier image added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SliderImage  $sliderImage
     * @return \Illuminate\Http\Response
     */
    public function show(SliderImage $sliderImage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param SliderImage $slider_image
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     */
    public function edit(SliderImage $slider_image)
    {
        return view('slider_image.edit', compact('slider_image'));
    }

    /**
     *  Update the specified resource in storage.
     *
     * @param Request $request
     * @param SliderImage $slider_image
     * @return \Illuminate\Http\RedirectResponse
     *
     */
    public function update(Request $request, SliderImage $slider_image)
    {

        $request->validate([
            'caption' => 'required|max:190',
            'image_location' => 'required|image|mimes:jpeg,jpg,png|max:3072|dimensions:max_height=1500'
        ],
            ['image_location.dimensions' => 'Please upload a landscape image with height not more than 1500px']);


        $data = $request->except('_token', '_method');

        if ($request->hasFile('image_location')) {
            $image = $request->file('image_location');

            $file_path = public_path($slider_image->image_location);
            if (file_exists($file_path) && !empty($slider_image->image_location)) {
                unlink($file_path);
            }

            $name = time() . '.' . $image->getClientOriginalExtension(); //getting the extension

            $image->storePubliclyAs('public/slider_images', $name);
            $image_path = "storage/slider_images/" . $name;
            $data['image_location'] = $image_path;
        }

        $slider_image->update($data);
        return redirect()->back()->with('success', ' Slider image updated');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SliderImage  $sliderImage
     * @return \Illuminate\Http\Response
     */
    public function destroy(SliderImage $sliderImage)
    {
        //
    }
}
