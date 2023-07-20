<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $reviews = Review::all();
        return view('review.index', compact('reviews'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_name' => 'required|max:80',
            'client_image' => 'required|image|mimes:jpeg,jpg,png|max:3072|dimensions:max_height=2500',
            'review' => 'required'
        ],
            ['client_image.dimensions' => 'Please upload a landscape image with height not more than 2500px']);
        $data = $request->except('_token');

        if ($request->hasFile('client_image')) {
            $image = $request->file('client_image');
            $name = time() . '.' . $image->getClientOriginalExtension(); //getting the extension

            $image->storePubliclyAs('public/reviews/client_images', $name);
            $image_path = "storage/reviews/client_images/" . $name;
            $data['client_image'] = $image_path;
        }
        Review::create($data);
        return redirect()->back()->with('success', ' New review created');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        return view('review.edit', compact('review'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        $request->validate([
            'client_name' => 'required|max:80',
            'client_image' => 'required|image|mimes:jpeg,jpg,png|max:3072|dimensions:max_height=2500',
            'review' => 'required'
        ],
            ['client_image.dimensions' => 'Please upload a landscape image with height not more than 2500px']);

        $data = $request->except('_token', '_method');

        if ($request->hasFile('client_image')) {
            $image = $request->file('client_image');
            $file_path = public_path($review->client_image);
            if (file_exists($file_path) && !empty($review->client_image)) {
                unlink($file_path);
            }

            $name = time() . '.' . $image->getClientOriginalExtension(); //getting the extension

            $image->storePubliclyAs('public/reviews/client_images', $name);
            $image_path = "storage/reviews/client_images/" . $name;
            $data['client_image'] = $image_path;
        }

        $review->update($data);
        return redirect()->back()->with('success', ' Review updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        if($review->client_image){
            $file_path = public_path($review->client_image);
            if (file_exists($file_path) && !empty($review->client_image)) {
                unlink($file_path);
            }
        }
        $review->delete();
        return redirect()->back()->with('success', ' Review deleted');
    }
}
