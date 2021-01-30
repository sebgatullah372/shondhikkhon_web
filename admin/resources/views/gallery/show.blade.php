@extends('layouts.app')
@section('title', "Gallery Details")
@push('push-style')

@endpush
@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Gallery Details</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('galleries.index')}}">Galleries</a></li>
                        <li class="breadcrumb-item active">Gallery Details</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container">

            <div class="row no-gutters">
                <div class="col-md-9 col-sm-10">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="fa fa-image"></i></span>

                        <div class="info-box-content">
                            <div class="row">
                                <div class="col-md-3 col-sm-12 mb-2">
                                    <span> <b>Gallery Name: </b> {{$gallery->name}}</span>
                                </div>
                                <div class="col-md-5 col-sm-12 mb-2">
                                    <span> <b>Total Number of Image in Gallery: </b> {{$gallery->galleryImages->count()}}</span>
                                </div>
                                <div class="col-md-4 col-sm-12 mb-2">
                                    <span> <b>Album Name: </b> {{$gallery->album->name}}</span>
                                </div>
                            </div>

                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>
                <div class="col-md-3 col-sm-2 mb-2 pl-3">
                    <a role="button" href="{{route('galleries.edit', $gallery->id)}}" class="btn btn-info btn-block"><i class="fa fa-plus"></i> Edit Gallery
                    </a>
                </div>
            </div>

            <div class="row" id="lightgallery">

                @foreach($gallery->galleryImages as $galleryImage)
                    <div
                        class="col-sm-6 item"
                        data-aos="fade"
                        data-src="{{asset($galleryImage->image_location)}}">

                        <div class="card">
                            <img
                                src="{{asset($galleryImage->image_location)}}"
                                alt="{{$galleryImage->image_caption}}"
                                class="img-fluid gallery-image"/>
                            <div class="card-body description-box">
                                @if($galleryImage->image_caption != null)
                                    <p class="card-text">{{$galleryImage->image_caption}}</p>
                                @else
                                    <p class="card-text text-muted">No caption</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>


    </section>


@endsection

@push('push-script')


    <script>
        $(document).ready(function () {
            $("#lightgallery").lightGallery();
        });
    </script>

@endpush

