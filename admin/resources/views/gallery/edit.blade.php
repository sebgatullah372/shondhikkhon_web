@extends('layouts.app')
@section('title', "Albums")
@push('push-style')

@endpush
@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Edit Gallery</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('galleries.index')}}">Galleries</a></li>
                        <li class="breadcrumb-item active">Edit Gallery</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">

        <div class="jumbotron jumbotron-fluid">

            <div class="container">

                <div class="info-box">
                    <span class="info-box-icon bg-warning"><i class="fa fa-image"></i></span>

                    <div class="info-box-content">
                        <div class="row">
                            <div class="col-md-3 col-sm-12 mb-2">
                                <span> <b>Gallery Name: </b> {{$gallery->name}}</span>
                            </div>
                            <div class="col-md-5 col-sm-12 mb-2">
                                <span> <b>Total Number of Image in Gallery: </b> {{$gallery->galleryImages->count()}}</span>
                            </div>
                            <div class="col-md-4 col-sm-12 mb-2">
                                <span> <b>Album Name: </b> {{$gallery->album->name}}</span>
                            </div>
                        </div>

                    </div>
                    <!-- /.info-box-content -->
                </div>

                <div class="card">
                    <h5 class="card-header">Edit Gallery Here</h5>
                    <form role="form" id="galleryEditForm" action="{{route('galleries.update', $gallery->id)}}"
                          method="post"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="card-body" id="galleryEditCardBody">
                            <div class="row">
                                <div class="col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="edit_name">Gallery Name</label>
                                        <input type="text"
                                               class="form-control @error('name') is-invalid @enderror"
                                               placeholder="Enter Gallery Name"
                                               name="name" id="edit_name" value="{{$gallery->name}}" autocomplete="off">
                                        @error('name') <span
                                            class="text-danger float-right">{{$errors->first('name') }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="edit_description">Gallery Description</label>
                                        <textarea name="description" id="edit_description" rows="3" class="form-control"
                                                  placeholder="Enter description / optional">{{$gallery->description}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="album">Select Album</label>
                                        <select id="album" name="album" class="custom-select">
                                            <option selected>Choose Album</option>
                                            @foreach($albums as $album)
                                                <option
                                                    value="{{$album->id}}" {{$gallery->album_id == $album->id? "selected":""}}>{{$album->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('album') <span
                                            class="text-danger float-right">{{$errors->first('album') }}</span> @enderror
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
                                    <img id="preview_output" class="preview_image"
                                         src="{{asset($gallery->cover_photo)}}"
                                         alt="Album Cover"
                                    >
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-12">
                                    <label for="show_on_home" class="d-block">Show on Home</label>
                                    <input type="checkbox" id="show_on_home" name="show_on_home"
                                           {{$gallery->show_on_home == 1? "checked":""}}
                                           data-toggle="toggle" data-on="Yes" data-off="No" data-onstyle="success"
                                           data-offstyle="danger"></div>
                            </div>

                            <hr class="border-primary">
                            <h4>Current Images</h4>
                            <div class="row">
                                @foreach($gallery->galleryImages as $galleryImage)
                                    <div class="col-sm-6 item">

                                        <div class="card" id="preview_old_image_card_{{$galleryImage->id}}">
                                            <div class="float-right">
                                                <button type="button" class="close"
                                                        onclick="closeGalleryPreviewCardOldImage(event)"
                                                        aria-label="Close">
                                                    <span aria-hidden="true"
                                                          id="remove_old_image_{{$galleryImage->id}}">&times;</span>
                                                </button>
                                            </div>
                                            <img
                                                src="{{asset($galleryImage->image_location)}}"
                                                alt="{{$galleryImage->image_caption}}"
                                                class="img-fluid gallery-image"/>
                                            <div class="card-body description-box">

                                                <textarea name="old_image_caption[]"
                                                          id="old_image_caption" rows="3"
                                                          class="form-control"
                                                          placeholder="Write caption here">{{$galleryImage->image_caption}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <hr class="border-primary">

                            <div class="row" id="gallery_images_input_row">
                                <div class="col-sm-12" id="gallery_images_input_col_0">
                                    <div class="form-group">
                                        <div class="custom-file">
                                            <input class="custom-file-input" type="file" multiple
                                                   onchange="previewGalleryImages(event)"
                                                   name="image_location[]" id="gallery_images"
                                                   accept="image/png,image/jpeg, image/jpg">
                                            <label class="custom-file-label" for="gallery_images">Add New
                                                Images in the Gallery</label>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <input type="hidden" name="remove_list" id="removeList"/>
                            <input type="hidden" name="old_images_remove_list" id="oldImagesRemoveList"/>

                            {{--                            Preview gallery image section appends here--}}
                            <hr class="border-success">



                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success float-right" id="galleryEditFormSubmitBtn">
                                Update
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
                    $('#galleryEditForm').submit(function (e) {
                        //disable form submit
                        e.preventDefault();
                    });
                } else {
                    $('#heightErrorMsg').empty();
                    $('#galleryEditForm').submit(function (e) {
                        e.preventDefault();
                        //enable form submit
                        $(this).unbind('submit').submit();
                    });
                }
                URL.revokeObjectURL(img.src)
            };


            $('#preview_output').show()
        };


        //Handles the remove event of old images in the gallery
        var oldImagesRemoveList = [];

        function closeGalleryPreviewCardOldImage(event) {
            let closeBtnId = event.target.id;
            let closeBtnIdSplit = closeBtnId.split('_');

            //closeBtnIdNumber is the button number of the close button which is clicked. This is the id of gallery image id
            let closeBtnIdNumber = Number(closeBtnIdSplit[closeBtnIdSplit.length - 1]);
            //creating a remove list array which will be used in the backend to identify the particular old image which user wants to remove from the gallery
            oldImagesRemoveList.push(closeBtnIdNumber);
            $('#oldImagesRemoveList').val(oldImagesRemoveList);

            $('#preview_old_image_card_' + closeBtnIdNumber).hide();

        }

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
                '                    <label class="custom-file-label" for="gallery_images">Add New\n' +
                '                        Images</label>\n' +
                '                </div>\n' +
                '         \n' +
                '            </div>\n' +
                '        </div>');

            //Every time the user uploads new  bunch of images a new row is created and under that row the columns are appended
            $('#galleryEditCardBody').append('<div class="row" id="previewGalleryImageSection_' + window.previewGalleryImageSectionCount + '">' +
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
                    '<span class="error float-right mb-1" id="filesizeError_' + window.previewOutputId + '"></span>' +
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
                    $('#galleryEditFormSubmitBtn').prop('disabled', true);
                    window.filesizeErrorIds.push(window.previewOutputId);
                }
                ++window.previewOutputId;
            }
            ++window.previewGalleryImageSectionCount;
        }

        //Handles the remove of new added images in the gallery
        var removeList = [];

        function closeGalleryPreviewCardImage(event) {
            let closeBtnId = event.target.id;
            let closeBtnIdSplit = closeBtnId.split('_');
            //closeBtnIdNumber is the button number of the close button which is clicked. It start from 0.
            let closeBtnIdNumber = Number(closeBtnIdSplit[closeBtnIdSplit.length - 1]);
            //creating a remove list array which will be used in the backend to identify the particular image which user has cancelled uploading
            removeList.push(closeBtnIdNumber);
            $('#removeList').val(removeList);

            if (window.filesizeErrorIds.includes(closeBtnIdNumber)) {

                let indexOfCloseBtnIdNumber = window.filesizeErrorIds.indexOf(closeBtnIdNumber);

                if (indexOfCloseBtnIdNumber > -1) {
                    window.filesizeErrorIds.splice(indexOfCloseBtnIdNumber, 1);
                }

                if (window.filesizeErrorIds.length == 0) {
                    $('#galleryEditFormSubmitBtn').prop('disabled', false);
                }
            }

            $('#preview_image_card_' + closeBtnIdNumber).hide();

        }

        $(document).ready(function () {
            $('#galleryEditForm').validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 30,
                    },
                    album:{
                        required: true,
                    },
                    cover_photo: {

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
                    album:{
                        required: "Please select album for this gallery",
                    },
                    cover_photo: {

                        accept: "Please upload jpg, jpeg or png file",
                        filesize: "File size should be under 3 mb",

                    },

                },

            });

        });
    </script>



@endpush

