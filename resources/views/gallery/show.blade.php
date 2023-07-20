@extends('layouts.app')

@section('content')

    <div class="site-section" data-aos="fade">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item">
                        <a href="{{route('albums.show', $gallery->album->id)}}">{{$gallery->album->name}} Albums</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{$gallery->name}}
                    </li>
                </ol>
            </nav>
            <h2 class="text-center">{{$gallery->name}}</h2>
            <div class="row no-gutters bg-img" id="lightgallery">
                @foreach($gallery->gallery_images as $galleryImage)
                <div
                    class="col-sm-6 item"
                    data-aos="fade"
                    data-src="{{$adminUrl.$galleryImage->image_location}}"
                >
                    <a href="#"
                    ><img
                            src="{{$adminUrl.$galleryImage->image_location}}"
                            alt="{{$galleryImage->image_caption}}"
                            class="img-fluid"
                        /></a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="py-3 mb-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12 d-md-flex align-items-center" data-aos="fade">
                    <h2 class="text-black mb-5 mb-md-0 text-center text-md-left">
                        Need professionals for your event?
                    </h2>
                    <div class="ml-auto text-center text-md-left">
                        <a href="{{route('contact.index')}}" class="btn btn-danger py-3 px-5 rounded"
                        >Contact Us</a
                        >
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
