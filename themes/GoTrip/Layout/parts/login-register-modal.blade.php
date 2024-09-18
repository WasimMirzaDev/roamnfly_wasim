<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
    .carousel,
    .carousel-one,
    .carousel-two {
        width: 80%;
        max-width: 800px;
        overflow: hidden;
        position: relative;
        margin: 0 auto;
    }

    .carousel-item img,
    .carousel-item-one img,
    .carousel-item-two img {
        width: 100%;
        display: block;
    }

    .carousel-control-prev,
    .carousel-control-next {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background-color: rgba(0, 0, 0, 0.5);
        border: none;
        color: white;
        padding: 10px;
        cursor: pointer;
        font-size: 24px;
        z-index: 100;
    }

    .carousel-control-prev {
        left: 10px;
    }

    .carousel-control-next {
        right: 10px;
    }

    .modal-dialog {
        max-width: 100%;

        .content {
            width: 100%;
        }
    }

    .modal-content {
        flex-direction: row !important;
    }

    .slider-wrapper {

        height: 100%;
        width: 100%;
    }

    .carousel,
    .carousel-one,
    .carousel-two {
        height: 100%;
        width: 100%;
        border-radius: 15px 0 0 15px;
    }

    .content {
        background: white;
    }

    .modal-content {
        background: transparent ;
    }

    .carousel-inner,
    .carousel-inner-one,
    .carousel-inner-two {
        display: flex;
        transition: transform 0.5s ease-in-out;
        height: 100%;
    }

    .carousel-item,
    .carousel-item-one,
    .carousel-item-two {
        min-width: 100%;
        box-sizing: border-box;

        .container {
            max-width: 90%;
            margin: 0 auto;
            padding: 0 !important;
        }
    }

    .text-icon-wrapper {
        .icon-wrapper {
            width: 45px;
            height: 45px;
            flex-shrink: 0;

            & i {
                &::before {
                    font-size: x-large;
                }
            }
        }

        .text-wrapper {
            font-size: 19px !important;
            line-height: 25px;
        }
    }

    .text-icons-main-wrapper {
        margin: 2rem 0 0 1rem !important;
    }

    .main-wrapper {
        margin: 1rem 0 !important;

        .heading {
            font-size: 28px !important;
        }
    }

    .carousel-item,
    .carousel-item-one,
    .carousel-item-two {
        position: relative;
        background-image: url('images/plane-4245416.jpg');
        background-size: cover;
        background-position: center;
    }

    .background-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgb(81 80 80 / 45%);
        /* Adjust the opacity and color here */
        z-index: 1;
    }

    .carousel-item .container,
    .carousel-item-one .container,
    .carousel-item-two .container {
        position: relative;
        z-index: 55;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
        /* margin: 20px 0; */
    }

    @media (max-width: 426px) {
        .main-wrapper {
            .heading {
                font-size: 23px !important;
            }
        }
        .text-icons-main-wrapper {
    margin: 1rem 0 0 1rem !important;

    .icon-wrapper {
            width: 40px;
            height: 40px;
            flex-shrink: 0;

            & i {
                &::before {
                    font-size: large;
                }
            }
        }
        .text-wrapper {
        font-size: 15px !important;
        line-height: 20px;
    }
}
.carousel-control-prev,
     .carousel-control-next{
font-size: 7px !important;
    }
    }
    
  @media (min-width:991px){
    .sign-up-content,
    .log-in-content{
    height: 92vh !important;
    overflow-y: scroll !important;
    }
    .carousel-control-prev,
     .carousel-control-next{
        top: 78% !important;
        background-color: transparent !important;
     }
     .carousel-control-next {
    right: 100px !important;
}
.carousel-control-prev {
    left: 100px !important;
}
.login-sing-up-content{
border-radius: 0 15px 15px 0 ;
    }
  }
  @media (max-width:991px){
.modal-body-sing-up,
.modal-body-login{
    padding: 0px 40px ;
}
.gotrip-login-modal .modal-header, 
.gotrip-register-modal .modal-header{
    padding: 20px 40px ;
}
.carousel,
    .carousel-one,
    .carousel-two {
       
        border-radius: 10px 10px 0 0 !important;
    }
  }

</style>

<div class="modal fade login gotrip-login-modal" id="login" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content relative d-flex justify-content-center ">
            <div class="row">
<div class="col-2 ">

</div>
                <div class="col-lg-3 col-xl-3 col-md-12 p-0 ">
                    <div class="slider-wrapper ">
                        <div class="carousel ">
                            <div class="carousel-inner ">
                                <div class="carousel-item " style="background-image: url('images/plane-4245416.jpg'); background-size: cover;">
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
                                                    Lock cheapest flight
                                                    </div>
                                                </div>
                                                <div class="text-icon-wrapper d-flex justify-content-start align-items-start g-3">
                                                    <div class="icon-wrapper">
                                                        <i class="fa-solid fa-hotel"></i>
                                                    </div>
                                                    <div class="text-wrapper">
                                                    Book Best Hotel @ Cheapest Price
                                                    </div>
                                                </div>
                                                <div class="text-icon-wrapper d-flex justify-content-start align-items-start g-3">
                                                    <div class="icon-wrapper">
                                                        <i class="fa-solid fa-train"></i>
                                                    </div>
                                                    <div class="text-wrapper">
                                                        Get Real-time updates on your every bookings 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="carousel-item " style="background-image: url('images/airplane-6867678.jpg'); background-size: cover;">
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
                                                        Lock Cheapest Flight
                                                    </div>
                                                </div>
                                                <div class="text-icon-wrapper d-flex justify-content-start align-items-start g-3">
                                                    <div class="icon-wrapper">
                                                        <i class="fa-solid fa-hotel"></i>
                                                    </div>
                                                    <div class="text-wrapper">
                                                    Book Best Hotel @ Cheapest Price
                                                    </div>
                                                </div>
                                                <div class="text-icon-wrapper d-flex justify-content-start align-items-start g-3">
                                                    <div class="icon-wrapper">
                                                        <i class="fa-solid fa-train"></i>
                                                    </div>
                                                    <div class="text-wrapper">
                                                    Get Real-time Updates On Your Every Bookings 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="carousel-item " style="background-image: url('images/plane-4245416.jpg'); background-size: cover;">
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
                                                    Lock Cheapest Flight
                                                    </div>
                                                </div>
                                                <div class="text-icon-wrapper d-flex justify-content-start align-items-start g-3">
                                                    <div class="icon-wrapper">
                                                        <i class="fa-solid fa-hotel"></i>
                                                    </div>
                                                    <div class="text-wrapper">
                                                    Book Best Hotel @ Cheapest Price
                                                    </div>
                                                </div>
                                                <div class="text-icon-wrapper d-flex justify-content-start align-items-start g-3">
                                                    <div class="icon-wrapper">
                                                        <i class="fa-solid fa-train"></i>
                                                    </div>
                                                    <div class="text-wrapper">
                                                    Get Real-time Updates On Your Every Bookings 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="carousel-control-prev" onclick="prevSlide()">&#10094;</button>
                            <button class="carousel-control-next" onclick="nextSlide()">&#10095;</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-xl-5 col-md-12 p-0">
                    <div class="content login-sing-up-content h-100 log-in-content">
                        <div class="modal-header border-dashed">
                            <h4 class="modal-title">{{__('Log In')}}</h4>
                            <span class="c-pointer" data-bs-dismiss="modal" aria-label="Close">
                                <i class="input-icon field-icon fa">
                                    <img src="{{url('images/ico_close.svg')}}" alt="close">
                                </i>
                            </span>
                        </div>
                        <div class="modal-body relative modal-body-sing-up">
                            @include('Layout::auth/login-form')
                        </div>
                    </div>
                </div>

                <div class="col-2">

</div>
            </div>


        </div>
    </div>
</div>

<div class="modal fade login gotrip-register-modal" id="register" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content relative">

            <div class="row">
                <div class="col-lg-2">
                </div>
                <div class="col-lg-3 col-xl-3 col-md-12 p-0 ">
                    <div class="slider-wrapper slider-wrapper-one">
                        <div class="carousel-one ">
                            <div class="carousel-inner-one ">
                                <div class="carousel-item-one " style="background-image: url('images/plane-4245416.jpg'); background-size: cover;">
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
                                                    Lock cheapest flight
                                                    </div>
                                                </div>
                                                <div class="text-icon-wrapper d-flex justify-content-start align-items-start g-3">
                                                    <div class="icon-wrapper">
                                                        <i class="fa-solid fa-hotel"></i>
                                                    </div>
                                                    <div class="text-wrapper">
                                                    Book Best Hotel @ Cheapest Price
                                                    </div>
                                                </div>
                                                <div class="text-icon-wrapper d-flex justify-content-start align-items-start g-3">
                                                    <div class="icon-wrapper">
                                                        <i class="fa-solid fa-train"></i>
                                                    </div>
                                                    <div class="text-wrapper">
                                                    Get Real-time Updates On Your Every Bookings 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="carousel-item-one " style="background-image: url('images/airplane-6867678.jpg'); background-size: cover;">
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
                                                    Lock cheapest flight
                                                    </div>
                                                </div>
                                                <div class="text-icon-wrapper d-flex justify-content-start align-items-start g-3">
                                                    <div class="icon-wrapper">
                                                        <i class="fa-solid fa-hotel"></i>
                                                    </div>
                                                    <div class="text-wrapper">
                                                    Book Best Hotel @ Cheapest Price
                                                    </div>
                                                </div>
                                                <div class="text-icon-wrapper d-flex justify-content-start align-items-start g-3">
                                                    <div class="icon-wrapper">
                                                        <i class="fa-solid fa-train"></i>
                                                    </div>
                                                    <div class="text-wrapper">
                                                    Get Real-time Updates On Your Every Bookings 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="carousel-item-one " style="background-image: url('images/plane-4245416.jpg'); background-size: cover;">
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
                                                    Lock cheapest flight
                                                    </div>
                                                </div>
                                                <div class="text-icon-wrapper d-flex justify-content-start align-items-start g-3">
                                                    <div class="icon-wrapper">
                                                        <i class="fa-solid fa-hotel"></i>
                                                    </div>
                                                    <div class="text-wrapper">
                                                    Book Best Hotel @ Cheapest Price
                                                    </div>
                                                </div>
                                                <div class="text-icon-wrapper d-flex justify-content-start align-items-start g-3">
                                                    <div class="icon-wrapper">
                                                        <i class="fa-solid fa-train"></i>
                                                    </div>
                                                    <div class="text-wrapper">
                                                    Get Real-time Updates On Your Every Bookings 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="carousel-control-prev" onclick="prevSlideOne()">&#10094;</button>
                            <button class="carousel-control-next" onclick="nextSlideOne()">&#10095;</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-xl-5 col-md-12 p-0">
                    <div class="content login-sing-up-content h-100 sign-up-content">
                        <div class="modal-header">
                            <h4 class="modal-title">{{__('Sign Up')}}</h4>
                            <span class="c-pointer" data-bs-dismiss="modal" aria-label="Close">
                                <i class="input-icon field-icon fa">
                                    <img src="{{url('images/ico_close.svg')}}" alt="close">
                                </i>
                            </span>
                        </div>
                        <div class="modal-body modal-body-login">
                            @include('Layout::auth/register-form')
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">

                </div>

            </div>






















        </div>
    </div>
</div>

<script>
    let currentIndex = 0;

    function showSlide(index) {
        const slides = document.querySelectorAll('.carousel-item');
        const totalSlides = slides.length;

        if (index >= totalSlides) {
            currentIndex = 0;
        } else if (index < 0) {
            currentIndex = totalSlides - 1;
        } else {
            currentIndex = index;
        }

        const offset = -currentIndex * 100;
        document.querySelector('.carousel-inner').style.transform = `translateX(${offset}%)`;
    }

    function nextSlide() {
        showSlide(currentIndex + 1);
    }

    function prevSlide() {
        showSlide(currentIndex - 1);
    }

    // Initial display of the first slide
    showSlide(currentIndex);



    let currentIndexOne = 0;

    function showSlideOne(index) {
        const slides = document.querySelectorAll('.carousel-item-one');
        const totalSlides = slides.length;

        if (index >= totalSlides) {
            currentIndexOne = 0;
        } else if (index < 0) {
            currentIndexOne = totalSlides - 1;
        } else {
            currentIndexOne = index;
        }

        const offset = -currentIndexOne * 100;
        document.querySelector('.carousel-inner-one').style.transform = `translateX(${offset}%)`;
    }

    function nextSlideOne() {
        showSlideOne(currentIndexOne + 1);
    }

    function prevSlideOne() {
        showSlideOne(currentIndexOne - 1);
    }

    // Initial display of the first slide
    showSlideOne(currentIndexOne);
</script>