@extends('layouts.app')
@section('title', "Edit Slider Image")
@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Edit Slider Image</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('slider_images.index')}}">Slider Images</a></li>
                        <li class="breadcrumb-item active">Edit Slider Image</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">

        <div class="jumbotron jumbotron-fluid">

            <div class="container">
                <div class="card">
                    <h5 class="card-header">Edit Slider Image Here</h5>
                    <form role="form" id="sliderImageEditForm" action="{{route('slider_images.update', $slider_image->id)}}"
                          method="post"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="card-body">


                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="custom-file">
                                            <input class="custom-file-input" type="file"
                                                   onchange="previewSliderImage(event)"
                                                   name="image_location" id="image_location"
                                                   accept="image/png,image/jpeg, image/jpg">
                                            <label class="custom-file-label" for="image_location">Choose Slider Image</label>
                                        </div>
                                        <span class="error" id="sizeErrorMsg"></span>

                                        <span class="error" id="heightErrorMsg"></span>
                                        @error('image_location') <span
                                            class="text-danger float-right">{{$errors->first('image_location') }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <img id="preview_output" class="preview_image"
                                         src="{{asset($slider_image->image_location)}}"
                                         alt="Slider image"
                                    >
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="caption">Slider Image Caption</label>
                                        <input type="text"
                                               class="form-control @error('caption') is-invalid @enderror"
                                               placeholder="Enter Slider Image Caption"
                                               name="caption" id="caption" value="{{$slider_image->caption}}" autocomplete="off">
                                        @error('caption') <span
                                            class="text-danger float-right">{{$errors->first('caption') }}</span> @enderror
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success float-right">Update</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>


@endsection

@push('push-script')
    <script>
        /*Preview Slider Image*/
        let previewSliderImage = function (event) {

            let output = document.getElementById('preview_output');

            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function () {
                URL.revokeObjectURL(output.src)
            };


            img = new Image();
            img.src = URL.createObjectURL(event.target.files[0]);
            let imageHeight = 0;
            img.onload = function () {
                imageHeight = this.height;
                let file_size = event.target.files[0].size;
                if (imageHeight > 1500 && file_size > 3072000) {
                    $('#heightErrorMsg').html('Maximum height for the slider image is 1500 and ');
                    $('#sizeErrorMsg').html('&nbsp' + 'The file size should be under 3 mb');
                    $('#sliderImageEditForm').submit(function(e){
                        //disable form submit
                        e.preventDefault();
                    });


                } else if (imageHeight <= 1500 && file_size <= 3072000) {
                    $('#heightErrorMsg').empty();
                    $('#sizeErrorMsg').empty();
                    $('#sliderImageEditForm').submit( function(e){
                        e.preventDefault();
                        //enable form submit
                        $(this).unbind('submit').submit();
                    });

                }else if(imageHeight > 1500 && file_size <= 3072000){
                    $('#heightErrorMsg').html('Maximum height for the cover image is 1500 ');
                    $('#sizeErrorMsg').empty();
                    $('#sliderImageEditForm').submit(function(e){
                        //disable form submit
                        e.preventDefault();
                    });

                }else if(imageHeight <= 1500 && file_size > 3072000){
                    $('#heightErrorMsg').empty();
                    $('#sizeErrorMsg').html('File size should be under 3 mb');
                    $('#sliderImageEditForm').submit(function(e){
                        //disable form submit
                        e.preventDefault();
                    });

                }

                URL.revokeObjectURL(img.src)
            };

        };


        $(document).ready(function () {
            $('#sliderImageEditForm').validate({
                rules: {
                    caption: {
                        required: true,
                    },
                    image_location: {
                        required: true,
                        accept: "image/jpg,image/jpeg,image/png",
                        filesize: 3072000,
                    }
                },
                messages: {
                    name: {
                        required: "Please enter caption for the slider image",
                    },
                    image_location: {
                        required: "Slider Image is required",
                        accept: "Please upload jpg, jpeg or png file",
                        filesize: "File size should be under 3 mb"
                    },

                },

            });

        });
    </script>
@endpush

