@extends('layouts.app')
@section('title', "Contact Information")
@push('push-style')
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
@endpush

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Contact Information</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Contact Information</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">

        <div class="jumbotron jumbotron-fluid">

            <div class="container">

                <div class="card">
                    <h5 class="card-header">Contact Information</h5>
                    <form role="form" id="contactEditForm" action="{{route('contact.update', $contact->id)}}" method="post">
                        @csrf
                        @method('PATCH')
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-4 col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="phone1">Phone No. </label>
                                        <input type="number"
                                               class="form-control @error('phone1') is-invalid @enderror"
                                               placeholder="Enter Phone No."
                                               name="phone1" id="phone1" value="{{$contact->phone1}}" autocomplete="off">
                                        @error('phone1') <span
                                            class="text-danger float-right">{{$errors->first('phone1') }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="phone2">Alternative Phone No. 1 </label>
                                        <input type="number"
                                               class="form-control @error('phone2') is-invalid @enderror"
                                               placeholder="Enter Alternative Phone No. 1 (Optional)"
                                               name="phone2" id="phone2" value="{{$contact->phone2}}" autocomplete="off">
                                        @error('phone2') <span
                                            class="text-danger float-right">{{$errors->first('phone2') }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="phone3">Alternative Phone No. 2</label>
                                        <input type="number"
                                               class="form-control @error('phone3') is-invalid @enderror"
                                               placeholder="Enter Alternative Phone No. 2 (Optional)"
                                               name="phone3" id="phone3" value="{{$contact->phone3}}" autocomplete="off">
                                        @error('phone3') <span
                                            class="text-danger float-right">{{$errors->first('phone3') }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="email">Official Email </label>
                                        <input type="email"
                                               class="form-control @error('email') is-invalid @enderror"
                                               placeholder="Enter Official Email"
                                               name="email" id="email" value="{{$contact->email}}" autocomplete="off">
                                        @error('email') <span
                                            class="text-danger float-right">{{$errors->first('email') }}</span> @enderror
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="facebook_link">Official facebook page link </label>
                                        <input type="url"
                                               class="form-control @error('facebook_link') is-invalid @enderror"
                                               placeholder="Enter Official facebook page link"
                                               name="facebook_link" id="facebook_link" value="{{$contact->facebook_link}}" autocomplete="off">
                                        @error('facebook_link') <span
                                            class="text-danger float-right">{{$errors->first('facebook_link') }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                   <div class="form-group">
                                        <label for="twitter_link">Official twitter link </label>
                                        <input type="url"
                                               class="form-control @error('twitter_link') is-invalid @enderror"
                                               placeholder="Enter Official twitter link"
                                               name="twitter_link" id="twitter_link" value="{{$contact->twitter_link}}" autocomplete="off">
                                        @error('twitter_link') <span
                                            class="text-danger float-right">{{$errors->first('twitter_link') }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="instagram_link">Official instagram link </label>
                                        <input type="url"
                                               class="form-control @error('instagram_link') is-invalid @enderror"
                                               placeholder="Enter Official instagram link"
                                               name="instagram_link" id="instagram_link" value="{{$contact->instagram_link}}" autocomplete="off">
                                        @error('instagram_link') <span
                                            class="text-danger float-right">{{$errors->first('instagram_link') }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="youtube_link">Official youtube channel link </label>
                                        <input type="url"
                                               class="form-control @error('youtube_link') is-invalid @enderror"
                                               placeholder="Enter Official youtube channel link"
                                               name="youtube_link" id="youtube_link" value="{{$contact->youtube_link}}" autocomplete="off">
                                        @error('youtube_link') <span
                                            class="text-danger float-right">{{$errors->first('youtube_link') }}</span> @enderror
                                    </div>
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

        //email validation check
        $.validator.addMethod("emailCheck",
            function (value, element) {
                return /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(value);
            },
        );

        $(document).ready(function () {

            $('#contactEditForm').validate({
                rules: {
                    phone1: {
                        required: true,
                        number: true,
                    },
                    email: {
                        required: true,
                        emailCheck: true
                    },
                    phone2:{
                        number: true
                    },
                    phone3:{
                        number: true
                    }


                },
                messages: {
                    phone1: {
                        required: "Please enter about information",

                    },
                    email: {
                        required: "Please enter official email",
                        emailCheck: "Please enter valid email"
                    },

                },

            });

        });
    </script>
@endpush

