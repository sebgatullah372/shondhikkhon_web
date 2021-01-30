@extends('layouts.app')
@section('title', "Edit service")
@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Edit Service</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('services.index')}}">Services</a></li>
                        <li class="breadcrumb-item active">Edit Service</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">

        <div class="jumbotron jumbotron-fluid">

            <div class="container">
                <div class="card">
                    <h5 class="card-header">Edit Service Here</h5>
                    <form role="form" id="serviceEditForm" action="{{route('services.update', $service->id)}}"
                          method="post"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="card-body">

                            <div class="row">
                                <div class="col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="edit_name">Service Name</label>
                                        <input type="text"
                                               class="form-control @error('name') is-invalid @enderror"
                                               placeholder="Enter Album Name"
                                               name="name" id="edit_name" value="{{$service->name}}" autocomplete="off">
                                        @error('name') <span
                                            class="text-danger float-right">{{$errors->first('name') }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="edit_description">Service Description</label>
                                        <textarea name="description" id="edit_description" rows="3" class="form-control"
                                                  placeholder="Enter description / optional">{{$service->description}}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="custom-file">
                                            <input class="custom-file-input" type="file"
                                                   onchange="previewServiceCover(event)"
                                                   name="cover_photo" id="cover_photo"
                                                   accept="image/png,image/jpeg, image/jpg">
                                            <label class="custom-file-label" for="cover_photo">Choose Service
                                                Cover</label>
                                        </div>
                                        <span class="error" id="sizeErrorMsg"></span>

                                        <span class="error" id="heightErrorMsg"></span>
                                        @error('cover_photo') <span
                                            class="text-danger float-right">{{$errors->first('cover_photo') }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <img id="preview_output" class="preview_image"
                                         src="{{asset($service->cover_photo)}}"
                                         alt="Service Cover"
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
        /*Preview Service Cover Photo*/
        let previewServiceCover = function (event) {

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
                    $('#heightErrorMsg').html('Maximum height for the cover image is 1500 and ');
                    $('#sizeErrorMsg').html('&nbsp' + 'the file size should be under 3 mb');
                    $('#serviceEditForm').submit(function(e){
                        //disable form submit
                        e.preventDefault();
                    });


                } else if (imageHeight <= 1500 && file_size <= 3072000) {
                    $('#heightErrorMsg').empty();
                    $('#sizeErrorMsg').empty();
                    $('#serviceEditForm').submit( function(e){
                        e.preventDefault();
                        //enable form submit
                        $(this).unbind('submit').submit();
                    });

                }else if(imageHeight > 1500 && file_size <= 3072000){
                    $('#heightErrorMsg').html('Maximum height for the cover image is 1500 ');
                    $('#sizeErrorMsg').empty();
                    $('#serviceEditForm').submit(function(e){
                        //disable form submit
                        e.preventDefault();
                    });

                }else if(imageHeight <= 1500 && file_size > 3072000){
                    $('#heightErrorMsg').empty();
                    $('#sizeErrorMsg').html('File size should be under 3 mb');
                    $('#serviceEditForm').submit(function(e){
                        //disable form submit
                        e.preventDefault();
                    });

                }

                URL.revokeObjectURL(img.src)
            };

        };


        $(document).ready(function () {
            $('#serviceEditForm').validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 30,
                    },
                    cover_photo: {
                        accept: "image/jpg,image/jpeg,image/png",

                    }
                },
                messages: {
                    name: {
                        required: "Please enter service name",
                        maxlength: "service name should be under 30 characters"
                    },
                    cover_photo: {
                        accept: "Please upload jpg, jpeg or png file",

                    },

                },

            });

        });
    </script>
@endpush

