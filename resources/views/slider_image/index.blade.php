@extends('layouts.app')
@section('title', "Slider Images")
@section('content')

    <div class="content-header" >
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Slider Images</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Slider Images</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">

        <div class="jumbotron jumbotron-fluid">

            <div class="container">

                <div class="row">
                    <div class="col-sm-9">
                        <div class="info-box">
                            <span class="info-box-icon bg-warning"><i class="fa fa-image"></i></span>

                            <div class="info-box-content">
                                <span> <b>Total Number of Slider Images:</b> {{$slider_images->count()}}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </div>
                    <div class="col-sm-3 mb-2">
                        <button type="button" class="btn btn-info btn-block" data-toggle="modal"
                                data-target="#sliderImageCreateModal"><i class="fa fa-plus"></i> Add New
                            Slider Image
                        </button>
                    </div>
                </div>

                <div class="row">
                    @foreach($slider_images as $slider_image)
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <div class="card">
                                <img class="card-img-top cover-image" src="{{asset($slider_image->image_location)}}" alt="Card image cap">
                                <div class="card-body description-box">
                                    <h5 class="card-title">{{$slider_image->caption}}</h5>
                                </div>
                                <div class="card-footer">
                                    <div class="float-right">
                                        <a href="{{route('slider_images.edit', $slider_image->id)}}" class="btn btn-primary">Edit </a>
                                        <a href="#" class="btn btn-danger">Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>


        <div class="modal fade" id="sliderImageCreateModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Create New Slider Image</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- form start -->
                    <form role="form" id="sliderImageCreateForm" action="{{route('slider_images.store')}}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">

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
                                        <span class="error" id="heightErrorMsg"></span>
                                        @error('image_location') <span
                                            class="text-danger float-right">{{$errors->first('image_location') }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <img id="preview_output" class="preview_image" src="" alt="Cover"
                                         style="display: none">
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
                                               name="caption" id="caption" autocomplete="off">
                                        @error('caption') <span
                                            class="text-danger float-right">{{$errors->first('caption') }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default float-right"
                                    data-dismiss="modal">Close
                            </button>
                            <button type="submit" class="btn btn-info float-right">Create</button>
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
            }

            img = new Image();
            img.src = URL.createObjectURL(event.target.files[0]);
            let imageHeight = 0;
            img.onload = function () {
                imageHeight = this.height;
                if (imageHeight > 1500) {
                    $('#heightErrorMsg').html('Maximum height for the slider image is 1500');
                    $('#sliderImageCreateForm').submit(function (e) {
                        //disable form submit
                        e.preventDefault();
                    });
                } else {
                    $('#heightErrorMsg').empty();
                    $('#sliderImageCreateForm').submit(function (e) {
                        e.preventDefault();
                        //enable form submit
                        $(this).unbind('submit').submit();
                    });
                }
                URL.revokeObjectURL(img.src)
            };
            $('#preview_output').show()
        };

        $.validator.addMethod('filesize', function (value, element, arg) {
            var minsize = 1000; // min 1kb
            let file_size = element.files[0].size;

            if ((arg > minsize) && (file_size <= arg)) {
                return true;
            } else {
                return false;
            }
        });

        $(document).ready(function () {
            $('#sliderImageCreateForm').validate({
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

