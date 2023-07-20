@extends('layouts.app')

@section('content')

    <div class="site-section" data-aos="fade">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-6  mb-5">
                    <img src="{{$adminUrl.$about->image}}" alt="Images" class="img-fluid">
                </div>
                <div class="col-md-5 ml-auto pt-5">

                    <p>{{$about->about_text}}</p>

                    <p class="mt-5 mb-3">Follow us</p>
                    <p>
                        <a href="{{$contactInformation->twitter_link}}" class="pr-2"><span class="icon-twitter"></span></a>
                        <a href="{{$contactInformation->instagram_link}}" class="p-2"><span
                                class="icon-instagram"></span></a>
                        <a href="{{$contactInformation->facebook_link}}" class="p-2"><span class="icon-facebook"></span></a>
                    </p>
                </div>
            </div>
        </div>
    </div>

@endsection

