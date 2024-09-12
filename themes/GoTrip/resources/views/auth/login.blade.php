@extends('layouts.app')

@section('content')
<div class="layout-pt-lg layout-pb-lg bg-blue-2 header-margin">
    <div class="container">
        <div class="row justify-center bravo-login-form-page bravo-login-page">
      <div class="col-lg-6 col-xl-6 col-md-12 p-0">
      <div class="slider-wrapper ">
                        <div class="carousel-two ">
                            <div class="carousel-inner-two ">
                                <div class="carousel-item-two " style="background-image: url('images/plane-4245416.jpg'); background-size: cover;">
                                    <div class="background-overlay">

                                    </div>

                                    <div class="container ">
                                        <div class="main-wrapper text-white">
                                            <h3 class="heading">
                                                Sign up/Login now to
                                            </h3>
                                            <div class="text-icons-main-wrapper mt-2">
                                                <div class="text-icon-wrapper d-flex justify-content-start align-items-start g-3">
                                                    <div class="icon-wrapper">
                                                        <i class="fa-solid fa-plane-departure"></i>
                                                    </div>
                                                    <div class="text-wrapper">
                                                        Lock Flight Prices & Pay Later
                                                    </div>
                                                </div>
                                                <div class="text-icon-wrapper d-flex justify-content-start align-items-start g-3">
                                                    <div class="icon-wrapper">
                                                        <i class="fa-solid fa-hotel"></i>
                                                    </div>
                                                    <div class="text-wrapper">
                                                        Book Hotels @&0
                                                    </div>
                                                </div>
                                                <div class="text-icon-wrapper d-flex justify-content-start align-items-start g-3">
                                                    <div class="icon-wrapper">
                                                        <i class="fa-solid fa-train"></i>
                                                    </div>
                                                    <div class="text-wrapper">
                                                        Get 3X refuned, if your waitlishted train does not confirmed
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="carousel-item-two " style="background-image: url('images/airplane-6867678.jpg'); background-size: cover;">
                                    <div class="background-overlay">

                                    </div>
                                    <div class="container ">
                                        <div class="main-wrapper text-white">
                                            <h3 class="heading">
                                                Sign up/Login now to
                                            </h3>
                                            <div class="text-icons-main-wrapper mt-2">
                                                <div class="text-icon-wrapper d-flex justify-content-start align-items-start g-3">
                                                    <div class="icon-wrapper">
                                                        <i class="fa-solid fa-plane-departure"></i>
                                                    </div>
                                                    <div class="text-wrapper">
                                                        Lock Flight Prices & Pay Later
                                                    </div>
                                                </div>
                                                <div class="text-icon-wrapper d-flex justify-content-start align-items-start g-3">
                                                    <div class="icon-wrapper">
                                                        <i class="fa-solid fa-hotel"></i>
                                                    </div>
                                                    <div class="text-wrapper">
                                                        Book Hotels @&0
                                                    </div>
                                                </div>
                                                <div class="text-icon-wrapper d-flex justify-content-start align-items-start g-3">
                                                    <div class="icon-wrapper">
                                                        <i class="fa-solid fa-train"></i>
                                                    </div>
                                                    <div class="text-wrapper">
                                                        Get 3X refuned, if your waitlishted train does not confirmed
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="carousel-item-two " style="background-image: url('images/plane-4245416.jpg'); background-size: cover;">
                                    <div class="background-overlay">

                                    </div>
                                    <div class="container ">
                                        <div class="main-wrapper text-white">
                                            <h3 class="heading">
                                                Sign up/Login now to
                                            </h3>
                                            <div class="text-icons-main-wrapper mt-2">
                                                <div class="text-icon-wrapper d-flex justify-content-start align-items-start g-3">
                                                    <div class="icon-wrapper">
                                                        <i class="fa-solid fa-plane-departure"></i>
                                                    </div>
                                                    <div class="text-wrapper">
                                                        Lock Flight Prices & Pay Later
                                                    </div>
                                                </div>
                                                <div class="text-icon-wrapper d-flex justify-content-start align-items-start g-3">
                                                    <div class="icon-wrapper">
                                                        <i class="fa-solid fa-hotel"></i>
                                                    </div>
                                                    <div class="text-wrapper">
                                                        Book Hotels @&0
                                                    </div>
                                                </div>
                                                <div class="text-icon-wrapper d-flex justify-content-start align-items-start g-3">
                                                    <div class="icon-wrapper">
                                                        <i class="fa-solid fa-train"></i>
                                                    </div>
                                                    <div class="text-wrapper">
                                                        Get 3X refuned, if your waitlishted train does not confirmed
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="carousel-control-prev" onclick="prevSlideTwo()">&#10094;</button>
                            <button class="carousel-control-next" onclick="nextSlideTwo()">&#10095;</button>
                        </div>
                    </div>
      </div>
            <div class="col-xl-6 col-lg-6 col-md-12 p-0">
                @include('Layout::admin.message')
                <div class="px-50 py-50 sm:px-20 sm:py-20 bg-white shadow-4 rounded-4">
                    <div class="row">
                        @include('Layout::auth.login-form',['captcha_action'=>'login_normal'])
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script>
        let currentIndexTwo = 0;

function showSlideTwo(index) {
    const slides = document.querySelectorAll('.carousel-item-two');
    const totalSlides = slides.length;

    if (index >= totalSlides) {
        currentIndexTwo = 0;
    } else if (index < 0) {
        currentIndexTwo = totalSlides - 1;
    } else {
        currentIndexTwo = index;
    }

    const offset = -currentIndexTwo * 100;
    document.querySelector('.carousel-inner-two').style.transform = `translateX(${offset}%)`;
}

function nextSlideTwo() {
    showSlideTwo(currentIndexTwo + 1);
}

function prevSlideTwo() {
    showSlideTwo(currentIndexTwo - 1);
}

// Initial display of the first slide
showSlideTwo(currentIndexTwo);
</script>