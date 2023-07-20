<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Review;
use App\Models\Service;
use App\Models\SliderImage;
use Illuminate\Http\Request;

class HomeController extends Controller
{
//    /**
//     * Create a new controller instance.
//     *
//     * @return void
//     */
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $sliderImages = SliderImage::activeStatus()->get();
        $services = Service::with('album')->activeStatus()->get();
        $galleries = Gallery::withCount('gallery_images')->showOnHome()->get();
        $reviews= Review::activeStatus()->get();
        return view('home', compact('sliderImages', 'services', 'galleries', 'reviews'));
    }


}
