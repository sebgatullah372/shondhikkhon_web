
@extends('layouts.app')
@section('title', "Edit Site Settings")
@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Edit Site Settings</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('site_settings.index')}}">Site Settings</a></li>
                        <li class="breadcrumb-item active">Edit Site Settings</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">

        <div class="jumbotron jumbotron-fluid">

            <div class="container">

                <form role="form" id="siteSettingsEditForm" action="{{route('site_settings.update', $site_setting->id)}}" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="card">
                        <h5 class="card-header">Edit Site Settings here</h5>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="custom-file">
                                            <input class="custom-file-input" type="file"
                                                   onchange="previewLogo(event)"
                                                   name="logo" id="logo"
                                                   accept="image/png,image/jpeg, image/jpg">
                                            <label class="custom-file-label" for="logo">Choose Logo</label>
                                        </div>

                                        @error('logo') <span
                                            class="text-danger float-right">{{$errors->first('logo') }}</span> @enderror
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-sm-12">
                                    <img id="preview_output" class="preview_image" src=""
                                         alt="Logo image"
                                    >
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="edit_site_settings"> Site Settings</label>
                                        <textarea name="tagline" id="edit_site_settings" rows="5" class="form-control"
                                                  placeholder="Write tagline here">{{$site_setting->tagline}}</textarea>
                                    </div>
                                    @error('tagline') <span
                                        class="text-danger float-right">{{$errors->first('tagline') }}</span> @enderror
                                </div>
                            </div>


                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success float-right">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>


@endsection

@push('push-script')

    <script>
        let site_settings = @json($site_setting);
        const appUrl = $('meta[name="app-url"]').attr('content');
        //console.log(about.image);
        if(site_settings.logo !== null){
            $('#preview_output').attr('src', appUrl+'/'+site_settings.logo);
        }else{
            $('#preview_output').hide();
        }


        /*Preview about page photo*/
        let previewLogo = function (event) {

            let output = document.getElementById('preview_output');

            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function () {
                URL.revokeObjectURL(output.src)
            };
            $('#preview_output').show();

        };

        $(document).ready(function () {
            $('#siteSettingsEditForm').validate({
                rules: {
                    tagline: {
                        required: true,

                    },
                    logo: {
                        accept: "image/jpg,image/jpeg,image/png",

                    }
                },
                messages: {
                    tagline: {
                        required: "Please enter about information",

                    },
                    logo: {
                        accept: "Please upload jpg, jpeg or png file",

                    },

                },

            });

        });

    </script>

@endpush

