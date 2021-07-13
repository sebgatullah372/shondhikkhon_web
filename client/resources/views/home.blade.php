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
</div>
@endsection
