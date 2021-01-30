@extends('layouts.app')
@section('title', "Album Details")
@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Album Details</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('albums.index')}}">Albums</a></li>
                        <li class="breadcrumb-item active">Album Details</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">

        <div class="jumbotron jumbotron-fluid">

            <div class="container">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <h5>Error List</h5>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="row">
                    <div class="col-sm-10">
                        <div class="info-box">
                            <span class="info-box-icon bg-warning"><i class="fa fa-image"></i></span>

                            <div class="info-box-content">
                                <div class="row">
                                    <div class="col">
                                        <span> <b>Album Name: </b> {{$album->name}}</span>
                                    </div>
                                    <div class="col">
                                        <span> <b>Total Number of Galleries: </b> {{$album->galleries->count()}}</span>
                                    </div>
                                </div>

                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </div>
                    <div class="col-sm-2 mb-2">
                        <button type="button" class="btn btn-info btn-block" data-toggle="modal"
                                data-target="#galleryCreateModal"><i class="fa fa-plus"></i> Create New
                            Gallery
                        </button>
                    </div>
                </div>

                <div class="row">
                    @foreach($album->galleries as $albumGallery)
                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card" >
                                <img class="card-img-top cover-image" src="{{asset($albumGallery->cover_photo)}}"
                                     alt="Card image cap">
                                <div class="card-body description-box">
                                    <h5 class="card-title">{{$albumGallery->name}}</h5>
                                    <p class="card-text">{{$albumGallery->description}}</p>

                                </div>
                                <div class="card-footer">
                                    <div class="float-right">
                                        <a href="{{route('galleries.show', $albumGallery->id)}}"
                                           class="btn btn-success">View</a>
                                        <a href="{{route('galleries.edit', $albumGallery->id)}}"
                                           class="btn btn-primary">Edit </a>
                                        <a href="#" class="btn btn-danger">Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>


        <div class="modal fade" id="galleryCreateModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Create New Gallery</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- form start -->
                    <form role="form" id="galleryCreateForm" action="{{route('store_gallery_by_album', $album->id)}}"
                          method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body" id="galleryCreateModalBody">


                            <div class="row">
                                <div class="col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="name">Gallery Name</label>
                                        <input type="text"
                                               class="form-control @error('name') is-invalid @enderror"
                                               placeholder="Enter Gallery Name"
                                               name="name" id="name" autocomplete="off">
                                        @error('name') <span
                                            class="text-danger float-right">{{$errors->first('name') }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="description">Gallery Description</label>
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
                                                   onchange="previewGalleryCover(event)"
                                                   name="cover_photo" id="cover_photo"
                                                   accept="image/png,image/jpeg, image/jpg">
                                            <label class="custom-file-label" for="cover_photo">Choose Gallery
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

                            <div class="row mb-3">
                                <div class="col-sm-12">
                                    <label for="show_on_home" class="d-block">Show on Home</label>
                                    <input type="checkbox" id="show_on_home" name="show_on_home"
                                           data-toggle="toggle" data-on="Yes" data-off="No" data-onstyle="success"
                                           data-offstyle="danger"></div>
                            </div>

                            <div class="row" id="gallery_images_input_row">
                                <div class="col-sm-12" id="gallery_images_input_col_0">
                                    <div class="form-group">
                                        <div class="custom-file">
                                            <input class="custom-file-input" type="file" multiple
                                                   onchange="previewGalleryImages(event)"
                                                   name="image_location[]" id="gallery_images"
                                                   accept="image/png,image/jpeg, image/jpg">
                                            <label class="custom-file-label" for="gallery_images">Choose Gallery
                                                Images</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{--                            Preview gallery image section appends here--}}

                            <input type="hidden" name="remove_list" id="removeList"/>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default float-right"
                                    data-dismiss="modal">Close
                            </button>
                            <button type="submit" class="btn btn-info float-right" id="galleryCreateFormSubmitBtn">
                                Create
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>


@endsection

@push('push-script')
    <script>
        /*Preview Gallery Cover Photo*/
        let previewGalleryCover = function (event) {

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
                if (imageHeight > 1500) {
                    $('#heightErrorMsg').html('Maximum height for the cover image is 1500');
                    $("#galleryCreateForm").submit(function (e) {
                        //disable form submit
                        e.preventDefault();
                    });
                } else {
                    $('#heightErrorMsg').empty();
                    $('#galleryCreateForm').submit(function (e) {
                        e.preventDefault();
                        //enable form submit
                        $(this).unbind('submit').submit();
                    });
                }
                URL.revokeObjectURL(img.src)
            };


            $('#preview_output').show()
        };

        window.currentActiveGalleryImageInputCol = 0;
        window.previewGalleryImageSectionCount = 0;
        window.previewOutputId = 0;
        window.filesizeErrorIds = [];

        /* Preview Gallery Images*/
        let previewGalleryImages = function (event) {
            //For multiple select the previous input file is hidden and new input file form is appended here so that the previous file does not get overridden and the user can upload as many photo as they want from different folders as well
            $('#gallery_images_input_col_' + window.currentActiveGalleryImageInputCol).hide();//hiding current input file
            ++window.currentActiveGalleryImageInputCol;
            //Appending new input file
            $('#gallery_images_input_row').append('<div class="col-sm-12" id="gallery_images_input_col_' + window.currentActiveGalleryImageInputCol + '">\n' +
                '            <div class="form-group">\n' +
                '                <div class="custom-file">\n' +
                '                    <input class="custom-file-input" type="file" multiple\n' +
                '                           onchange="previewGalleryImages(event)"\n' +
                '                           name="image_location[]" id="gallery_images"\n' +
                '                           accept="image/png,image/jpeg, image/jpg">\n' +
                '                    <label class="custom-file-label" for="gallery_images">Choose Gallery\n' +
                '                        Images</label>\n' +
                '                </div>\n' +
                '         \n' +
                '            </div>\n' +
                '        </div>');

            //Every time the user uploads new  bunch of images a new row is created and under that row the columns are appended
            $('#galleryCreateModalBody').append('<div class="row" id="previewGalleryImageSection_' + window.previewGalleryImageSectionCount + '">' +
                '</div>'
            );//Creating rows here


            //Appending the columns here
            let i = 0;
            for (i = 0; i < event.target.files.length; i++) {

                $('#previewGalleryImageSection_' + window.previewGalleryImageSectionCount).append('<div class="col-sm-12 col-md-6 col-lg-6" id="preview_image_card_' + window.previewOutputId + '">\n' +
                    '            <div class="card shadow">\n' +
                    '                <div class="float-right">\n' +
                    '                    <button type="button" class="close"  onclick="closeGalleryPreviewCardImage(event)" aria-label="Close">\n' +
                    '                        <span aria-hidden="true" id="close_preview_output_' + window.previewOutputId + '">&times;</span>\n' +
                    '                    </button>\n' +
                    '                </div>\n' +
                    '                <img class="card-img-top gallery-image" src="" id="preview_output_' + window.previewOutputId + '" alt="Card image cap">\n' +
                    '\n' +
                    '                <div class="card-body">\n' + '<span class="mb-1" id="filename_' + window.previewOutputId + '"></span>' + '' +
                    '<span class="text-danger float-right mb-1" id="filesizeError_' + window.previewOutputId + '"></span>' +
                    '                    <textarea name="image_caption[]" id="image_caption_' + window.previewOutputId + '" rows="3" class="form-control"\n' +
                    '                              placeholder="Write caption here"></textarea>\n' +
                    '                </div>\n' +
                    '            </div>\n' +
                    '        </div>');

                let output = document.getElementById('preview_output_' + window.previewOutputId);

                output.src = URL.createObjectURL(event.target.files[i]);
                output.onload = function () {
                    URL.revokeObjectURL(output.src)
                };
                $('#filename_' + window.previewOutputId).html(event.target.files[i].name);
                if (event.target.files[i].size > 3072000) {
                    $('#filesizeError_' + window.previewOutputId).html('File size should not be more than 3 MB. Remove the File to continue');
                    $('#galleryCreateFormSubmitBtn').prop('disabled', true);
                    window.filesizeErrorIds.push(window.previewOutputId);
                }
                ++window.previewOutputId;
            }
            ++window.previewGalleryImageSectionCount;
        }


        var removeList = [];

        function closeGalleryPreviewCardImage(event) {
            let closeBtnId = event.target.id;
            let closeBtnIdSplit = closeBtnId.split('_');
            //closeBtnIdNumber is the button number of the close button which is clicked. It start from 0.
            let closeBtnIdNumber = Number(closeBtnIdSplit[closeBtnIdSplit.length - 1]);
            //creating a remove list array which will be used in the backend to identify the particular image which user has cancelled uploading
            removeList.push(closeBtnIdNumber);
            $('#removeList').val(removeList);

            // console.log(typeof closeBtnIdNumber);
            // console.log(typeof window.filesizeErrorIds[0]);
            // console.log(window.filesizeErrorIds.find(error_id => error_id == closeBtnIdNumber));
            // let removefilesizeError = window.filesizeErrorIds.find(error_id => error_id == closeBtnIdNumber);
            // if(removefilesizeError !== undefined){
            //    let indexOfCloseBtnIdNumber =  window.filesizeErrorIds.indexOf(closeBtnIdNumber);
            //    console.log('index', indexOfCloseBtnIdNumber);
            // }
            if (window.filesizeErrorIds.includes(closeBtnIdNumber)) {

                let indexOfCloseBtnIdNumber = window.filesizeErrorIds.indexOf(closeBtnIdNumber);

                if (indexOfCloseBtnIdNumber > -1) {
                    window.filesizeErrorIds.splice(indexOfCloseBtnIdNumber, 1);
                }

                if (window.filesizeErrorIds.length == 0) {
                    $('#galleryCreateFormSubmitBtn').prop('disabled', false);
                }
            }

            $('#preview_image_card_' + closeBtnIdNumber).hide();

        }

        $.validator.addMethod('filesize', function (value, element, arg) {
            var minsize = 1000; // min 1kb
            let file_size = element.files[0].size;

            return (arg > minsize) && (file_size <= arg);
        });

        $(document).ready(function () {
            $('#galleryCreateForm').validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 30,
                    },
                    cover_photo: {
                        required: true,
                        accept: "image/jpg,image/jpeg,image/png",
                        filesize: 3072000,
                        //max_height: 1500,
                    },

                },
                messages: {
                    name: {
                        required: "Please enter gallery name",
                        maxlength: "Gallery name should be under 30 characters"
                    },
                    cover_photo: {
                        required: "Cover Photo is required for Gallery",
                        accept: "Please upload jpg, jpeg or png file",
                        filesize: "File size should be under 3 mb",
                        //max_height: "Maximum height for the cover photo is 1500"
                    },

                },

            });

        });
    </script>
@endpush

