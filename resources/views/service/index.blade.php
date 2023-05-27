@extends('layouts.app')
@section('title', "Services")
@section('content')

    <div class="content-header" >
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Services</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Services</li>
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
                            <span class="info-box-icon bg-warning"><i class="fa fa-camera-retro"></i></span>

                            <div class="info-box-content">
                                <span> <b>Total Number of Services:</b> {{$services->count()}}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </div>
                    <div class="col-sm-2 mb-2">
                        <button type="button" class="btn btn-info btn-block" data-toggle="modal"
                                data-target="#serviceCreateModal"><i class="fa fa-plus"></i> Add New
                            Service
                        </button>
                    </div>
                </div>

                <div class="row">
                    @foreach($services as $service)
                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <img class="card-img-top cover-image" src="{{asset($service->cover_photo)}}" alt="Card image cap">
                                <div class="card-body description-box">
                                    <h5 class="card-title">{{$service->name}}</h5>
                                    <p class="card-text">{{$service->description}}</p>

                                </div>
                                <div class="card-footer">
                                    <div class="float-right">
                                        <a href="{{route('services.edit', $service->id)}}" class="btn btn-primary">Edit </a>
                                        <a href="#" class="btn btn-danger">Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>


        <div class="modal fade" id="serviceCreateModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Create New Service</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- form start -->
                    <form role="form" id="serviceCreateForm" action="{{route('services.store')}}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="name">Service Name</label>
                                        <input type="text"
                                               class="form-control @error('name') is-invalid @enderror"
                                               placeholder="Enter Service Name"
                                               name="name" id="name" autocomplete="off">
                                        @error('name') <span
                                            class="text-danger float-right">{{$errors->first('name') }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="description">Service Description</label>
                                        <textarea name="description" id="description" rows="3" class="form-control"
                                                  placeholder="Enter description / optional"></textarea>
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
                                        <span class="error" id="heightErrorMsg"></span>
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
        /*Preview Service Cover Photo*/
        let previewServiceCover = function (event) {

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
                    $('#heightErrorMsg').html('Maximum height for the cover image is 1500');
                    $('#serviceCreateForm').submit(function (e) {
                        //disable form submit
                        e.preventDefault();
                    });
                } else {
                    $('#heightErrorMsg').empty();
                    $('#serviceCreateForm').submit(function (e) {
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
            $('#serviceCreateForm').validate({
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
                        required: "Please enter service name",
                        maxlength: "Service name should be under 30 characters"
                    },
                    cover_photo: {
                        required: "Cover Photo is required for service",
                        accept: "Please upload jpg, jpeg or png file",
                        filesize: "File size should be under 3 mb"
                    },

                },

            });

        });
    </script>
@endpush

