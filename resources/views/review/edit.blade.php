@extends('layouts.app')
@section('title', "Edit Review")
@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Edit Review</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('reviews.index')}}">Reviews</a></li>
                        <li class="breadcrumb-item active">Edit Review</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">

        <div class="jumbotron jumbotron-fluid">

            <div class="container">
                <div class="card">
                    <h5 class="card-header">Edit Review Here</h5>
                    <form role="form" id="reviewEditForm" action="{{route('reviews.update', $review->id)}}"
                          method="post"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="card-body">

                            <div class="row">
                                <div class="col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="edit_client_name">Client Name</label>
                                        <input type="text"
                                               class="form-control @error('client_name') is-invalid @enderror"
                                               placeholder="Enter Client Name"
                                               name="client_name" id="edit_client_name" value="{{$review->client_name}}" autocomplete="off">
                                        @error('client_name') <span
                                            class="text-danger float-right">{{$errors->first('client_name') }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="edit_review">Review</label>
                                        <textarea name="review" id="review" rows="3" class="form-control"
                                                  placeholder="Enter review">{{$review->review}}</textarea>
                                        @error('review') <span
                                            class="text-danger float-right">{{$errors->first('review') }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="custom-file">
                                            <input class="custom-file-input" type="file"
                                                   onchange="previewClientImage(event)"
                                                   name="client_image" id="client_image"
                                                   accept="image/png,image/jpeg, image/jpg">
                                            <label class="custom-file-label" for="client_image">Choose Client Image</label>
                                        </div>
                                        <span class="error" id="sizeErrorMsg"></span>

                                        <span class="error" id="heightErrorMsg"></span>
                                        @error('client_image') <span
                                            class="text-danger float-right">{{$errors->first('client_image') }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <img id="preview_output" class="preview_image"
                                         src="{{asset($review->client_image)}}"
                                         alt="Review Client image"
                                    >
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
        /*Preview Review Client image*/
        let previewClientImage = function (event) {

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
                if (imageHeight > 2500 && file_size > 3072000) {
                    $('#heightErrorMsg').html('Maximum height for the cover image is 2500 and ');
                    $('#sizeErrorMsg').html('&nbsp' + 'the file size should be under 3 mb');
                    $('#reviewEditForm').submit(function(e){
                        //disable form submit
                        e.preventDefault();
                    });


                } else if (imageHeight <= 2500 && file_size <= 3072000) {
                    $('#heightErrorMsg').empty();
                    $('#sizeErrorMsg').empty();
                    $('#reviewEditForm').submit( function(e){
                        e.preventDefault();
                        //enable form submit
                        $(this).unbind('submit').submit();
                    });

                }else if(imageHeight > 2500 && file_size <= 3072000){
                    $('#heightErrorMsg').html('Maximum height for the cover image is 2500 ');
                    $('#sizeErrorMsg').empty();
                    $('#reviewEditForm').submit(function(e){
                        //disable form submit
                        e.preventDefault();
                    });

                }else if(imageHeight <= 1500 && file_size > 3072000){
                    $('#heightErrorMsg').empty();
                    $('#sizeErrorMsg').html('File size should be under 3 mb');
                    $('#reviewEditForm').submit(function(e){
                        //disable form submit
                        e.preventDefault();
                    });

                }

                URL.revokeObjectURL(img.src)
            };

        };


        $(document).ready(function () {
            $('#reviewEditForm').validate({
                rules: {
                    client_name: {
                        required: true,
                        maxlength: 80,
                    },
                    client_image: {
                        accept: "image/jpg,image/jpeg,image/png",
                        filesize: 3072000,
                    },
                    review: {
                        required: true,
                    }
                },
                messages: {
                    client_name: {
                        required: "Please enter client name",
                        maxlength: "Service name should be under 80 characters"
                    },
                    client_image: {
                        accept: "Please upload jpg, jpeg or png file",
                        filesize: "File size should be under 3 mb"
                    },
                    review: {
                        required: "Review is required"
                    }
                },

            });

        });
    </script>
@endpush

