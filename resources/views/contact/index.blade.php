@extends('layouts.app')

@section('content')

    <div class="site-section" data-aos="fade">
        <div class="container-fluid">

            <div class="row justify-content-center">
                <div class="col-md-7">


                    <div class="row">
                        <div class="col-lg-8 mb-5">
                            <form action="#">


                                <div class="row form-group">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <label class="text-black" for="fname">First Name</label>
                                        <input type="text" id="fname" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-black" for="lname">Last Name</label>
                                        <input type="text" id="lname" class="form-control">
                                    </div>
                                </div>

                                <div class="row form-group">

                                    <div class="col-md-12">
                                        <label class="text-black" for="email">Email</label>
                                        <input type="email" id="email" class="form-control">
                                    </div>
                                </div>

                                <div class="row form-group">

                                    <div class="col-md-12">
                                        <label class="text-black" for="subject">Subject</label>
                                        <input type="subject" id="subject" class="form-control">
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-md-12">
                                        <label class="text-black" for="message">Message</label>
                                        <textarea name="message" id="message" cols="30" rows="7" class="form-control"
                                                  placeholder="Write your notes or questions here..."></textarea>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-md-12">
                                        <input type="submit" value="Send Message"
                                               class="btn btn-primary py-2 px-4 text-white">
                                    </div>
                                </div>


                            </form>
                        </div>
                        <div class="col-lg-3 ml-auto">
                            <div class="mb-3 bg-white">


                                <p class="mb-0 font-weight-bold">Phone</p>
                                <p class="mb-4"><a href="#">{{$contactInformation->phone1}}</a></p>
                                <p class="mb-4"><a href="#">{{$contactInformation->phone1}}</a></p>
                                <p class="mb-0 font-weight-bold">Email Address</p>
                                <p class="mb-0"><a href="#">{{$contactInformation->email}}</a></p>

                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

