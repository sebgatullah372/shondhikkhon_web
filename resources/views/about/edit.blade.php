@extends('layouts.app')
@section('title', "Edit About Information")
@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Edit About Information</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('about.index')}}">About Information</a></li>
                        <li class="breadcrumb-item active">Edit About Information</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">

        <div class="jumbotron jumbotron-fluid">

            <div class="container">

                <form role="form" id="aboutEditForm" action="{{route('about.update', $about->id)}}" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="card">
                        <h5 class="card-header">Edit About information here</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="edit_about">About information</label>
                                        <textarea name="about_text" id="edit_about" rows="5" class="form-control"
                                                  placeholder="Write about information here">{{$about->about_text}}</textarea>
                                    </div>
                                    @error('about_text') <span
                                        class="text-danger float-right">{{$errors->first('about_text') }}</span> @enderror
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="custom-file">
                                            <input class="custom-file-input" type="file"
                                                   onchange="previewImage(event)"
                                                   name="image" id="image"
                                                   accept="image/png,image/jpeg, image/jpg">
                                            <label class="custom-file-label" for="image">Choose About page
                                                image</label>
                                        </div>

                                        @error('image') <span
                                            class="text-danger float-right">{{$errors->first('image') }}</span> @enderror
                                    </div>
                                </div>
                            </div>



                                <div class="row">
                                    <div class="col-sm-12">
                                        <img id="preview_output" class="preview_image" src=""
                                             alt="About image"
                                        >
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
       let about = @json($about);
       const appUrl = $('meta[name="app-url"]').attr('content');
       //console.log(about.image);
       if(about.image !== null){
           $('#preview_output').attr('src', appUrl+'/'+about.image);
       }else{
           $('#preview_output').hide();
       }


        /*Preview about page photo*/
        let previewImage = function (event) {

            let output = document.getElementById('preview_output');

            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function () {
                URL.revokeObjectURL(output.src)
            };
            $('#preview_output').show();

        };

       $(document).ready(function () {
           $('#aboutEditForm').validate({
               rules: {
                   about_text: {
                       required: true,

                   },
                   image: {
                       accept: "image/jpg,image/jpeg,image/png",

                   }
               },
               messages: {
                   about_text: {
                       required: "Please enter about information",

                   },
                   image: {
                       accept: "Please upload jpg, jpeg or png file",

                   },

               },

           });

       });

    </script>

@endpush

