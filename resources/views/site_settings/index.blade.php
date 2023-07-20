@extends('layouts.app')
@section('title', "Site Settings")
@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Site Settings</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Site Settings</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">

        <div class="jumbotron jumbotron-fluid">

            <div class="container">

                <div class="card">
                    <h2>{{$site_settings->company_name}}</h2>
                    @if(isset($site_settings->logo))

                        <img class="card-img-top preview_image" src="{{asset($site_settings->logo)}}" alt="Card image cap">
                    @endif
                    <div class="card-body description-box">
                        <h5 class="card-title">Site tagline</h5>
                        <p class="card-text">{{$site_settings->tagline}}</p>

                    </div>
                    <div class="card-footer">
                        <div class="float-right">
                            <a href="{{route('site_settings.edit', $site_settings->id)}}" class="btn btn-primary">Edit </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </section>


@endsection
