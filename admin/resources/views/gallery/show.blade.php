@extends('layouts.app')
@section('title', "Albums")
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
                        <li class="breadcrumb-item"><a href="{{route('galleries.index')}}">Gallery</a></li>
                        <li class="breadcrumb-item active">Gallery Details</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container">

            <div class="row">
                <div class="col-sm-10">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="fa fa-image"></i></span>

                        <div class="info-box-content">
                            <div class="row">
                                <div class="col">
                                    <span> <b>Gallery Name: </b> {{$gallery->name}}</span>
                                </div>
                                <div class="col">
                                    <span> <b>Total Number of Image in Gallery: </b> {{$gallery->galleryImages->count()}}</span>
                                </div>
                                <div class="col">
                                    <span> <b>Album Name: </b> {{$gallery->album->name}}</span>
                                </div>
                            </div>

                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>
                <div class="col-sm-2 mb-2">
                    <button type="button" class="btn btn-info btn-block"><i class="fa fa-plus"></i> Edit Gallery
                    </button>
                </div>
            </div>

            <div class="row no-gutters bg-img" id="lightgallery">

                @foreach($gallery->galleryImages as $galleryImage)
                    <div
                        class="col-sm-6 item"
                        data-aos="fade"
                        data-src="{{asset($galleryImage->image_location)}}"
                    >
                        <a href="#"
                        ><img
                                src="{{asset($galleryImage->image_location)}}"
                                alt="{{$galleryImage->image_caption}}"
                                class="img-fluid"
                            /></a>
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

