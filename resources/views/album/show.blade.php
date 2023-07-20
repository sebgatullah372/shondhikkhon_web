@extends('layouts.app')

@section('content')

    <div class="site-section border-bottom">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>

                    <li class="breadcrumb-item active" aria-current="page">
                        {{$album->name}} Albums
                    </li>
                </ol>
            </nav>

            <div class="row text-center justify-content-center mb-5">
                <div class="col-md-7" data-aos="fade-up">
                    <h2>{{$album->name}} Albums</h2>
                </div>
            </div>
            <div class="row">
                @foreach($album->galleries as $albumGallery)
                <div
                    class="col-md-6 col-lg-4"
                    data-aos="fade-up"
                    data-aos-delay="100"
                >
                    <a class="image-gradient" href="{{route('galleries.show', $albumGallery->id)}}">
                        <figure>
                            <img src="{{$adminUrl.$albumGallery->cover_photo}}" alt="" class="img-fluid"/>
                        </figure>
                        <div class="text">
                            <h3>{{$albumGallery->name}}</h3>
                            <span>{{count($albumGallery->gallery_images)}} photos</span>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection
