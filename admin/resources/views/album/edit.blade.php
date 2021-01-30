@extends('layouts.app')
@section('title', "Albums")
@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Edit Album</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('albums.index')}}">Albums</a></li>
                        <li class="breadcrumb-item active">Edit Album</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">

        <div class="jumbotron jumbotron-fluid">

            <div class="container">
                <div class="card">
                    <h5 class="card-header">Edit Album Here</h5>
                    <form role="form" id="albumEditForm" action="{{route('albums.update', $album->id)}}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="card-body">

                            <div class="row">
                                <div class="col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="edit_name">Album Name</label>
                                        <input type="text"
                                               class="form-control @error('name') is-invalid @enderror"
                                               placeholder="Enter Album Name"
                                               name="name" id="edit_name" value="{{$album->name}}" autocomplete="off">
                                        @error('name') <span
                                            class="text-danger float-right">{{$errors->first('name') }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="edit_description">Album Description</label>
                                        <textarea name="description" id="edit_description" rows="3" class="form-control"
                                                  placeholder="Enter description / optional">{{$album->description}}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="service">Select Corresponding Service for this Album</label>
                                        <select id="service" class="custom-select" name="service">
                                            <option selected>Choose Service</option>
                                            @foreach($services as $service)
                                                <option
                                                    value="{{$service->id}}" {{$album->service_id == $service->id? "selected":""}}>{{$service->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="custom-file">
                                            <input class="custom-file-input" type="file"
                                                   onchange="previewAlbumCover(event)"
                                                   name="cover_photo" id="cover_photo"
                                                   accept="image/png,image/jpeg, image/jpg">
                                            <label class="custom-file-label" for="cover_photo">Choose Album
                                                Cover</label>
                                        </div>
                                        <span class="error" id="heightErrorMsg"></span>
                                        @error('cover_photo') <span
                                            class="text-danger float-right">{{$errors->first('cover_photo') }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <img id="preview_output" class="preview_image" src="{{asset($album->cover_photo)}}"
                                         alt="Album Cover"
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
        /*Preview Album Cover Photo*/
        let previewAlbumCover = function (event) {

            let output = document.getElementById('preview_output');

            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function () {
                URL.revokeObjectURL(output.src)
            }

            img = new Image();
            img.src = URL.createObjectURL(event.target.files[0]);
            let imageHeight = 0;
            img.onload = function(){
                imageHeight = this.height;
                if(imageHeight > 1500){
                    $('#heightErrorMsg').html('Maximum height for the cover image is 1500');
                    $("#albumEditForm").submit(function(e){
                        //disable form submit
                        e.preventDefault();
                    });
                }else{
                    $('#heightErrorMsg').empty();
                    $('#albumEditForm').submit( function(e){
                        e.preventDefault();
                        //enable form submit
                        $(this).unbind('submit').submit();
                    });
                }
                URL.revokeObjectURL(img.src)
            };

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
            $('#albumEditForm').validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 30,
                    },
                    cover_photo: {
                        accept: "image/jpg,image/jpeg,image/png",
                        filesize: 3072000,
                    }
                },
                messages: {
                    name: {
                        required: "Please enter Album Name",
                        maxlength: "Album name should be under 30 characters"
                    },
                    cover_photo: {
                        accept: "Please upload jpg, jpeg or png file",
                        filesize: "File size should be under 3 mb"
                    },

                },

            });

        });
    </script>
@endpush

