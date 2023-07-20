@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <section>
            <div
                id="carouselExampleControls"
                class="carousel slide"
                data-ride="carousel"
            >
                <div class="carousel-inner">
                    @foreach($sliderImages as $sliderImage)
                        <div class="carousel-item {{$loop->index==1?"active":""}}">
                            <img
                                class="d-block w-100"
                                src="{{$adminUrl.$sliderImage->image_location}}"
                                alt="{{$sliderImage->caption}}"
                            />
                            <div class="carousel-caption d-none d-md-block">

                                <h5>{{$sliderImage->caption}}</h5>
                            </div>
                        </div>
                    @endforeach

                </div>
                <a
                    class="carousel-control-prev"
                    href="#carouselExampleControls"
                    role="button"
                    data-slide="prev"
                >
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a
                    class="carousel-control-next"
                    href="#carouselExampleControls"
                    role="button"
                    data-slide="next"
                >
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </section>
        <div class="site-section" data-aos="fade">
            <div class="container">
                <div class="row mb-5">
                    <div class="col-12">
                        <h2 class="site-section-heading text-center">
                            Services we provide
                        </h2>
                    </div>
                </div>
                <div class="row">
                    @foreach($services as $service)
                        <div class="col-md-6">
                            <a class="servicesLinks" href="{{route('albums.show', $service->album->id)}}">
                                <div class="site-block-half d-lg-flex">
                                    <div
                                        class="image"
                                        style="
                      background-image: url({{$adminUrl.$service->cover_photo}});
                    "
                                    ></div>
                                    <div class="text">
                                        <h3>{{$service->name}}</h3>
                                        <p>
                                            {{$service->description}}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="site-section">
            <div class="container">
                <div class="row text-center justify-content-center mb-5">
                    <div class="col-md-7" data-aos="fade-up">
                        <h2>Browse Our Works</h2>
                    </div>
                </div>

                <div class="row">
                    @foreach($galleries as $gallery)
                        <div
                            class="col-md-6 col-lg-4"
                            data-aos="fade-up"
                            data-aos-delay="100"
                        >
                            <a class="image-gradient" href="imon_anty_holud_gallery.html">
                                <figure>
                                    <img
                                        src="{{$adminUrl.$gallery->cover_photo}}"
                                        alt=""
                                        class="img-fluid"
                                    />
                                </figure>
                                <div class="text">
                                    <h3>{{$gallery->name}}</h3>
                                    <span>{{$gallery->gallery_images_count}} photos</span>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <h2 class="site-section-heading text-center">What our clients say</h2>
        <div
            class="py-5 site-block-testimonial"
            style="background-image: url('asset/images/bg/reviewbg3.jpg')"
            data-stellar-background-ratio="0.5"
        >
            <div class="container">
                <div class="row block-13 mb-5">
                    <div class="col-md-12 text-center" data-aos="fade">
                        <div class="nonloop-block-13 owl-carousel">
                            @foreach($reviews as $review)
                                <div class="block-testimony">
                                    <img
                                        src="{{$adminUrl.$review->client_image}}"
                                        alt="Image"
                                        class="img-fluid"
                                    />
                                    <blockquote>
                                        {{$review->review}}
                                    </blockquote>
                                    <p class="small">&mdash; {{$review->client_name}}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-3 mb-5 mt-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 d-md-flex align-items-center" data-aos="fade">
                        <h2 class="text-black mb-5 mb-md-0 text-center text-md-left">
                            Need professionals for your event?
                        </h2>
                        <div class="ml-auto text-center text-md-left">
                            <a href="{{route('contact.index')}}" class="btn btn-danger py-3 px-5 rounded"
                            >Contact Us</a
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
