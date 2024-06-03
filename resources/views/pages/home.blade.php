@extends('app')

@section('title', 'Home')

@section('content')

    {{-- Carousel --}}
    <header class="header-home">
        <div id="customCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach ($slides as $index => $slide)
                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                    <div class="container align-items-center h-100 d-flex justify-content-center animate-slide">
                        <div class="row align-items-center template-paw">
                            <div class="col-md-6 image-container" style="padding:0;">
                                <img src="{{ asset($slide['image']) }}" alt="Anjing" class="img-fluid template-img carousel-image">
                            </div>
                            <div class="col-md-6 text-container">
                                <div class="text-content text-center">
                                    <h1 class='fw-bolder text-white'>{{ $slide['title'] }}</h1>
                                    <p class='text-white'>{{ $slide['description'] }}</p>
                                    <a href="#" class="btn btn-outline-light stretched-link book-button">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

        {{-- Controls --}}
        <button class="carousel-control-prev" type="button" style="z-index:1" data-bs-target="#customCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" style="z-index:1"  data-bs-target="#customCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>

        {{-- Indicators --}}
        <div class="carousel-indicators" style="z-index:1" >
            <button type="button" data-bs-target="#customCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#customCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#customCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        </div>
    </header>

    {{-- small card --}}
    <section class="py-5">
        <h1 class='h1-services fw-bolder text-white text-center'>Solusi Terlengkap untuk Perawatan Anjing Anda</h1>
        <div class="container px-4 py-5 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                @foreach ($cards as $index => $card)
                    <div class='col mb-4 animate-slide'>
                        <div class='card h-100 template-paw'>
                            <img class='card-img-top template-img' src='{{ asset($card['image']) }}'/>
                            <div class='card-body p-4'>
                                <div class='text-center'>
                                    <h5 class='fw-bolder text-white'>{{ $card['title'] }}</h5>
                                    <p class="text-white">{{ $card['description'] }}</p>
                                </div>
                            </div>
                            <div class='card-footer pt-0 border-top-0 bg-transparent'>
                                <div class='text-center'>
                                    <a href='{{ $card['link'] }}'>
                                        <button class='btn btn-outline-light stretched-link' type='submit'>Order Now</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Testimoni --}}
    <section class="py-5">
        <h1 class='h1-testimoni fw-bolder text-white text-center'>Testimoni</h1>
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                @foreach ($testimoni as $index => $testimoni)
                    <div class="col mb-4 ml-5 mr-5 animate-slide">
                        <div class="card template-paw text-white h-100">
                            <div class="card-body">
                                <figure>
                                    <blockquote class="blockquote mb-0" style="font-size:20px;">
                                        <h1 class="display-6 fw-bolder">"{{ $testimoni['title'] }}"</h1>
                                        <p class="text-center">{{ $testimoni['description'] }}</p>
                                    </blockquote>
                                    <figcaption class="blockquote-footer" style="font-size:20px; color:rgba(255, 255, 255, 0.8);">
                                        <strong>{{ $testimoni['author'] }}</strong>
                                    </figcaption>
                                </figure>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection
