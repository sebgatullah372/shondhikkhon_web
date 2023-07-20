@extends('layouts.app')
@section('title', "Reviews")
@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Reviews</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Reviews</li>
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
                                <span> <b>Total Number of Reviews:</b> {{$reviews->count()}}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </div>
                    <div class="col-sm-2 mb-2">
                        <button type="button" class="btn btn-info btn-block" data-toggle="modal"
                                data-target="#reviewCreateModal"><i class="fa fa-plus"></i> Add New
                            Review
                        </button>
                    </div>
                </div>

                <div class="row">
                    @foreach($reviews as $review)
                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <img class="card-img-top cover-image" src="{{asset($review->client_image)}}" alt="Card image cap">
                                <div class="card-body description-box">
                                    <h5 class="card-title">{{$review->client_name}}</h5>
                                    <p class="card-text">{{$review->review}}</p>

                                </div>
                                <div class="card-footer">
                                    <div class="d-flex justify-content-end">
                                        <a href="{{route('reviews.edit', $review->id)}}" class="btn btn-primary mr-2">Edit </a>
                                        <form method="post" action="{{route('reviews.destroy', $review->id)}}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                   </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>


        <div class="modal fade" id="reviewCreateModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Create New Review</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- form start -->
                    <form role="form" id="reviewCreateForm" action="{{route('reviews.store')}}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="client_name">Client Name</label>
                                        <input type="text"
                                               class="form-control @error('client_name') is-invalid @enderror"
                                               placeholder="Enter Client Name"
                                               name="client_name" id="client_name" autocomplete="off">
                                        @error('client_name') <span
                                            class="text-danger float-right">{{$errors->first('client_name') }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="review">Review</label>
                                        <textarea name="review" id="review" rows="3" class="form-control"
                                                  placeholder="Enter review"></textarea>
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
                                            <label class="custom-file-label" for="client_image">Choose Client image</label>
                                        </div>
                                        <span class="error" id="heightErrorMsg"></span>
                                        @error('client_image') <span
                                            class="text-danger float-right">{{$errors->first('client_image') }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <img id="preview_output" class="preview_image" src="" alt="Client Image"
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

        /*Preview Client image*/
        let previewClientImage = function (event) {

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
                if (imageHeight > 2500) {
                    $('#heightErrorMsg').html('Maximum height for the cover image is 2500');
                    $('#reviewCreateForm').submit(function (e) {
                        //disable form submit
                        e.preventDefault();
                    });
                } else {
                    $('#heightErrorMsg').empty();
                    $('#reviewCreateForm').submit(function (e) {
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
            $('#reviewCreateForm').validate({
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

