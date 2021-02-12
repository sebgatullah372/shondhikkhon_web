@extends('layouts.app')
@section('title', "About Information")
@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">About Information</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">About Information</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">

        <div class="jumbotron jumbotron-fluid">

            <div class="container">

                <div class="card">
                    @if(isset($about->image))
                    <img class="card-img-top" src="{{asset($about->image)}}" alt="Card image cap">
                    @endif
                    <div class="card-body description-box">
                        <h5 class="card-title">About details</h5>
                        <p class="card-text">{{$about->about_text}}</p>

                    </div>
                    <div class="card-footer">
                        <div class="float-right">
                            <a href="{{route('about.edit', $about->id)}}" class="btn btn-primary">Edit </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </section>


@endsection

@push('push-script')
    <script>

        $(document).ready(function () {
            $('#aboutEditForm').validate({
                rules: {
                    about_text: {
                        required: true,
                    },
                },
                messages: {
                    name: {
                        required: "Please enter about information",

                    },

                },

            });

        });
    </script>
@endpush

