@extends('layouts.app')
@section('title', "Albums")
@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Album</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Album</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">

        <div class="jumbotron jumbotron-fluid">

            <div class="container">

                <div class="row">
                    <div class="col-sm-10">
                        <div class="info-box">
                            <span class="info-box-icon bg-warning"><i class="fa fa-image"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Total Number of Albums</span>
                                <span class="info-box-number">{{$albums->count()}}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </div>
                    <div class="col-sm-2 mb-2">
                        <button type="button" class="btn btn-info btn-block" data-toggle="modal"
                                data-target="#albumCreateModal"><i class="fa fa-plus"></i> Add New
                            Album
                        </button>
                    </div>
                </div>

                <div class="row">
                    @foreach($albums as $album)
                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <img class="card-img-top" src="{{asset($album->cover_photo)}}" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">{{$album->name}}</h5>
                                    <p class="card-text">{{$album->description}}</p>

                                </div>
                                <div class="card-footer">
                                    <div class="float-right">
                                    <a href="{{route('albums.show', $album->id)}}" class="btn btn-success">View</a>
                                    <a href="{{route('albums.edit', $album->id)}}" class="btn btn-primary">Edit </a>
                                    <a href="#" class="btn btn-danger">Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>


        <div class="modal fade" id="albumCreateModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Create New Album</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- form start -->
                    <form role="form" id="albumCreateForm" action="{{route('albums.store')}}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="name">Album Name</label>
                                        <input type="text"
                                               class="form-control @error('name') is-invalid @enderror"
                                               placeholder="Enter Album Name"
                                               name="name" id="name" autocomplete="off">
                                        @error('name') <span
                                            class="text-danger float-right">{{$errors->first('name') }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="description">Album Description</label>
                                        <textarea name="description" id="description" rows="3" class="form-control"
                                                  placeholder="Enter description / optional"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="service">Select Corresponding Service for this Album</label>
                                        <select id="service" class="custom-select">
                                            <option selected>Choose Service</option>
                                            @foreach($services as $service)
                                                <option value="{{$service->id}}">{{$service->name}}</option>
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
                                        @error('cover_photo') <span
                                            class="text-danger float-right">{{$errors->first('cover_photo') }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <img id="preview_output" class="preview_image" src="" alt="Album Cover"
                                         style="display: none">
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
        /*Preview Album Cover Photo*/
        let previewAlbumCover = function (event) {

            let output = document.getElementById('preview_output');

            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function () {
                URL.revokeObjectURL(output.src)
            }
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
            $('#albumCreateForm').validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 30,
                    },
                    cover_photo: {
                        required: true,
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
                        required: "Cover Photo is required for Album",
                        accept: "Please upload jpg, jpeg or png file",
                        filesize: "File size should be under 3 mb"
                    },

                },

            });

        });
    </script>
@endpush

