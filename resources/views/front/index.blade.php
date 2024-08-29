@extends('front.layouts.app')



@section('content')
    <!-- ============================================================== -->



    <!-- ============================ Hero Banner  Start================================== -->

    @include('front.includes.banner')

    <!-- ============================ Hero Banner End ================================== -->
    <style>
        .homepagehd {
            display: inline-block;
            padding: 0px 15px;
            background: #a30a0a !important;
            color: #fff;
            border-radius: 10px;
        }

        .ovr_top {
            margin-top: 30px;
        }

        .dro_140 {
            height: 95px
        }

        @media screen and (max-width: 767px) {
            .ovr_top {
                margin-top: 30px;
            }
        }
    </style>


    <!-- ================================ Tag Award ================================ -->

    <section class="p-0" style="background-color:#FFFBEB;" id="getcourses">

        <div class="container-fluid">

            <div class="row justify-content-center">

                <div class="col-lg-12 col-md-12 col-sm-12">

                    <div class="crp_box fl_color ovr_top">

                        <div class="row align-items-center" style="margin-bottom: 3%;">

                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">

                                <div class="dro_140">

                                    <div class="dro_141 de"><i class="fa fa-journal-whills"></i></div>

                                    <div class="dro_142">

                                        <h6>100+ courses</h6>

                                        <p>Choose from a wide range of 100+ interesting courses !!!</p>

                                    </div>

                                </div>

                            </div>

                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">

                                <div class="dro_140">

                                    <div class="dro_141 de"><i class="fa fa-user-shield"></i></div>

                                    <div class="dro_142">

                                        <h6>Age no bar</h6>

                                        <p>We have courses for people of all ages. Choose the one that interests you !!!</p>

                                    </div>

                                </div>

                            </div>

                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">

                                <div class="dro_140">

                                    <div class="dro_141 de"><i class="fa fa-users"></i></div>

                                    <div class="dro_142">

                                        <h6>Flexible</h6>

                                        <p>Learn from a teacher who takes classes at a time convenient to you !!!</p>

                                    </div>

                                </div>

                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">

                                <div class="dro_140">

                                    <div class="dro_141 de"><i class="fas fa-store"></i></i></div>

                                    <div class="dro_142">

                                        <h6>Convenient</h6>

                                        <p>Attend classes without leaving the comforts of your home !!!</p>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>



        </div>

    </section>


    <section class="all-in-1" style="padding: 0px 0px 60px">

        <div class="categiry_section_home">


            <!-- ============================ Categories Start ================================== -->

            @include('front.includes.category_section')

        </div>
        <div class="clearfix"></div>



        <!-- ============================ Categories End ================================== -->
        <section>
            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-12">
                    <div class="sec-heading center">
                        <h2 class="homepagehd">Trending course of the month </h2>
                    </div>
                </div>
            </div>

            <div>
                <div class="container-fluid">
                    <div class="row slider_1" style="padding: 20px">
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12" style="display: flex; align-items: center; justify-content: center;">
                            <div class="carousel_left">
                                <div class="carousel_left_inner">
                                    {{-- <img src="{{ url('front/assets/css/img/slider_logo1.svg') }}" class="img_slider"> --}}
                                    <h1>Dance till you drop !!!</h1>
                                    <p>Experience full-body workouts, featuring the most popular songs, best instructors and
                                        dance moves that'll hold your interest till you achieve your target and beyond !!!
                                    </p>
                                    <div class="btn_for_carousel">
                                        <a href="/" class="carouse_btn btn_bg">Get started</a>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-6">
                            <div class="carousel_right hhh">
                                <div class="carousel_right_inner">
                                    <video autoplay="" loop="" muted="" playsinline="" data-wf-ignore="true"
                                        data-object-fit="cover" class="carousel_videos">
                                        <source src="{{ url('front/assets/css/img/carousel_video1.mp4') }}"
                                            data-wf-ignore="true">
                                    </video>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            <!-- <div class="container-fluid">
                    <div class="row justify-content-center for_margin">

                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                            <div class="rating_left">
                                <div class="split-div">
                                    <div class="half_header bg_light">
                                        <h2 class="rating_header">Join New Dancers In 100+ Countries</h2>
                                        <div class="sub_header">Our global community’s here to give
                                            feedback, share tips, and take on dance challenges with you.
                                        </div>
                                    </div>
                                    <div class="rating_left_video w-embed">
                                        <iframe
                                            src="https://player.vimeo.com/video/559256456?iframe=1&lazyload=1&background=1;"
                                            width="100%" height="100%" frameborder="0" allow="autoplay; fullscreen"
                                            allowfullscreen;=""></iframe>

                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                            <div class="rating_right">
                                <div class="split-div">
                                    <div class="half_header">
                                        <div class="section_header_container half">
                                            <h2 class="rating_header white">1M+ Downloads</h2>
                                            <h2 class="rating_header white">12K+ Ratings</h2>
                                            <img src="./assets/img/Review_Stars.svg" alt=""
                                                class="img-fluid mb-4 w_on_1199">
                                            <div style="display: inline-block;">
                                                <a href="" class="store_icon">
                                                    <img src="./assets/img/App_Store.svg" alt="">
                                                </a>
                                                <a href="" class="store_icon">
                                                    <img src="./assets/img/Google_Play.svg" alt="">
                                                </a>
                                            </div>
                                            <div class="sub_header white">See what our members have to say:</div>
                                        </div>

                                    </div>


                                    <div class="review_section">
                                        <div class="review_box">
                                            <div class="review_box_inner">
                                                <h1>It's dope</h1>
                                                <img src="./assets/img/5_stars.svg" alt="" class="mt-2">
                                                <p class="review_p">Definitely beginner friendly, and of
                                                    great benefit to those may love dancing, but have never
                                                    trained in any discipline.</p>
                                            </div>
                                            <div class="text_box">Sticka Mayhem<br>App Store<br>July 2 2020
                                            </div>
                                        </div>
                                        <div class="review_box">
                                            <div class="review_box_inner">
                                                <h1>I didn’t know how much I needed this</h1>
                                                <img src="./assets/img/5_stars.svg" alt="" class="mt-2">
                                                <p class="review_p">the instructors, and
                                                    music choices. Highly recommended for a good sweat session
                                                    and confidence building!<br></p>
                                            </div>
                                            <div class="text_box">JulianaInBend<br>App Store<br>March 8
                                                2021</div>
                                        </div>
                                        <div class="review_box">
                                            <div class="review_box_inner">
                                                <h1>Great app</h1>
                                                <img src="./assets/img/5_stars.svg" alt="" class="mt-2">
                                                <p class="review_p">So much dance content! Pretty exciting
                                                    that the very people I was following online are now my dance
                                                    teachers.<br></p>
                                            </div>
                                            <div class="text_box">Karabouie<br>App Store<br>2020</div>
                                        </div>
                                        <div class="review_box">
                                            <div class="review_box_inner">
                                                <h1>Love it</h1>
                                                <img src="./assets/img/5_stars.svg" alt="" class="mt-2">
                                                <p class="review_p">I’m not only learning to dance, but
                                                    losing weight and becoming a healthier person.<br></p>
                                            </div>
                                            <div class="text_box">Miss Maja Danae<br>Google Play
                                                Store,<br>April 14 2021</div>
                                        </div>
                                        <div class="review_box">
                                            <div class="review_box_inner">
                                                <h1>Great Content <br>and Great UX<br></h1>
                                                <img src="./assets/img/5_stars.svg" alt="" class="mt-2">
                                                <p class="review_p">The instruction is really clear and easy
                                                    to follow. Great job to the whole team!<br></p>
                                            </div>
                                            <div class="text_box">Laurasanyz<br>&zwj;App Store<br>November
                                                9 2020</div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div> -->

        </section>

        <!-- ============================ Ratings End ================================== -->


        <!-- ============================ article Start ================================== -->

        <section class="min">

            <div class="container">



                <div class="row justify-content-center">

                    <div class="col-lg-12 col-md-12">

                        <div class="sec-heading center">


                            <h2 class="homepagehd">News & articles </h2>



                        </div>

                    </div>

                </div>



                <div class="row justify-content-center">



                    <!-- Single blog Grid -->

                    <div class="col-lg-4 col-md-6">

                        <div class="blg_grid_box">

                            <div class="blg_grid_thumb">

                                <a href="#"><img src="{{ asset('front/assets/img/Articles_img1.png') }}"
                                        class="img-fluid" alt=""></a>

                            </div>

                            <div class="blg_grid_caption">

                                <div class="blg_tag dark"><span>Marketing</span></div>

                                <div class="blg_title">
                                    <h4><a href="#">How To Improove Digital Marketing for Fast SEO</a>
                                    </h4>
                                </div>

                                <div class="blg_desc">
                                    <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis
                                        praesentium voluptatum</p>
                                </div>

                                <div class="blg_more"><a href="#">Reading Continues</a></div>

                            </div>

                        </div>

                    </div>



                    <!-- Single blog Grid -->

                    <div class="col-lg-4 col-md-6">

                        <div class="blg_grid_box">

                            <div class="blg_grid_thumb">

                                <a href="#"><img src="{{ asset('front/assets/img/Articles_img2.png') }}"
                                        class="img-fluid" alt=""></a>

                            </div>

                            <div class="blg_grid_caption">

                                <div class="blg_tag dark"><span>Marketing</span></div>

                                <div class="blg_title">
                                    <h4><a href="#">How To Improove Digital Marketing for Fast SEO</a>
                                    </h4>
                                </div>

                                <div class="blg_desc">
                                    <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis
                                        praesentium voluptatum</p>
                                </div>

                                <div class="blg_more"><a href="#">Reading Continues</a></div>

                            </div>

                        </div>

                    </div>



                    <!-- Single blog Grid -->

                    <div class="col-lg-4 col-md-6">

                        <div class="blg_grid_box">

                            <div class="blg_grid_thumb">

                                <a href="#"><img src="{{ asset('front/assets/img/Articles_img3.png') }}"
                                        class="img-fluid" alt=""></a>

                            </div>

                            <div class="blg_grid_caption">

                                <div class="blg_tag dark"><span>Marketing</span></div>

                                <div class="blg_title">
                                    <h4><a href="#">How To Improove Digital Marketing for Fast SEO</a>
                                    </h4>
                                </div>

                                <div class="blg_desc">
                                    <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis
                                        praesentium voluptatum</p>
                                </div>

                                <div class="blg_more"><a href="blog-detail.html">Reading Continues</a></div>

                            </div>

                        </div>

                    </div>



                </div>



            </div>

        </section>

        <div class="clearfix"></div>

        <!-- ============================ article End ================================== -->



    </section>







    <!-- ============================ Footer End ================================== -->
@endsection
