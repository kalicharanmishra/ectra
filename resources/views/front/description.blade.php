@extends('front.layouts.app')

<style>
   
    .accordion_one .panel-group {
        border: 1px solid #f1f1f1;
    }
    a:link {
        text-decoration: none
    }
    .accordion_one .panel {
        background-color: transparent;
        box-shadow: none;
        border-bottom: 0px solid transparent;
        border-radius: 0;
        margin: 0;
    }
    .accordion_one .panel-default {
        border: 0;
    }
    .accordion-wrap .panel-heading {
        padding: 0px;
        border-radius: 0px;
    }
    h4 {
        font-size: 18px;
        line-height: 24px;
    }
    .accordion_one .panel .panel-heading a.collapsed {
        color: #999999;
        display: block;
        padding: 12px 12px 12px 50px;
        border-top: 0px;
        border-bottom: 1px solid #f1f1f1;
        ;
    }


    .accordion_one .panel .panel-heading a {
        display: block;
        padding: 12px 12px 12px 50px;
        background: #fff;
        color: #313131;
        border-bottom: none;
        position: relative;
    }

    .accordion-wrap .panel .panel-heading a {
        font-size: 14px;
        position: relative;
    }

    .accordion_one .panel-group .panel-heading+.panel-collapse>.panel-body {
        border-top: 0;
        padding-top: 0;
        padding: 15px;
        background: #fff;
        color: #999999;
        border-bottom: 1px solid #f1f1f1;
    }

    .img-accordion {
        width: 81px;
        float: left;
        margin-right: 15px;
        display: block;
    }

    .accordion_one .panel .panel-heading a.collapsed:after {
        content: "\2b";
        color: #999999;
        background: #f1f1f1;
    }

    .accordion_one .panel .panel-heading a:after {
        content: "\2212";
    }

    .accordion_one .panel .panel-heading a:after,
    .accordion_one .panel .panel-heading a.collapsed:after {
        font-family: 'FontAwesome';
        font-size: 15px;
        width: 36px;
        height: 48px;
        line-height: 48px;
        text-align: center;
        background: #a30a0a !important;
            color: #fff !important;
        position: absolute;
        top: 50%;
        left: 0;
        transform: translate(0, -50%)
    }
    .reach h4{
        font-size: 20px;
    }
    .custom_input{
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .custom_input input , textarea {
        width: 80% !important;
    }
    .custom_input label{
        width: 20%;
    }
</style>

@section('content')

    <!-- ============================================================== -->

    <section class="" style="background: #FFFBEB ;">

        <div >

            <div class="container">

                <div class="row">

                    <div class="col-lg-12 col-md-12">



                        <div class="breadcrumbs-wrap">


                            <nav class="transparent">

                                <ol class="breadcrumbb">

                                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                                    <li class="breadcrumb-item"><a href="/">Important links</a></li>

                                    <li class="breadcrumb-item active theme-cl" aria-current="page">{{ $detail->title }}
                                    </li>

                                </ol>

                            </nav>

                        </div>



                    </div>

                </div>

            </div>

        </div>

        <!-- ============================ Page Title Start================================== -->

        <section >
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div>

                            <h1 class=" text-center" style="color: #a30a0a;">{{ $detail->title }}</h1>

                        </div>



                    </div>

                </div>

            </div>

        </section>

        <!-- ============================ Page Title End ================================== -->



        <!-- ============================ About Detail ================================== -->


        @if ($name == 'contactus')
            <div>
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif





                <div class="container">

                    <div class="row align-items-center justify-content-between">

                  <div class="col-12 mb-3">
                    <h4 class="text-center">We're here to help and answer any queries that you might have.  <br>
                        Please fill in your details and type your message. <br>
                        We will revert to you very soon !!!</h4>
                                                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <form class="" method="post" action="{{ url('/sub_contact') }}">
                                @csrf
                                <div class="row justify-content-center">
                                    
                                    <div class="col-lg-7 col-md-12 col-sm-12 mt-2 custom_input">
                                        <label for="inputEmail4" class="form-label">Your name</label>
                                        <input type="name" name="name" class="form-control" id="inputEmail4">
                                    </div>
                                    <div class="col-lg-7 col-md-12 col-sm-12 mt-2 custom_input">
                                        <label for="inputAddress" class="form-label">Your mobile no.</label>
                                        <input type="number" name="mobile" class="form-control" id="inputAddress"
                                        >
                                    </div>
                                    <div class="col-lg-7 col-md-12 col-sm-12 mt-2 custom_input">
                                        <label for="inputPassword4" class="form-label">Your email id</label>
                                        <input type="email" name="email" class="form-control" id="inputPassword4">
                                    </div>
                                    <div class="col-lg-7 col-md-12 col-sm-12 mt-2 custom_input">
                                        <label for="inputAddress2" class="form-label">How can we help you?</label>
                                        <textarea id="inputAddress2" name="message" class="form-control" placeholder="Type your message here"></textarea>
                                    </div>
                                    <div class="col-lg-7 col-md-12 col-sm-12 mt-4">
                                        <input type="submit" class="btn" style="background: #a30a0a;display: block; margin: auto"
                                         value="Submit">
                                    </div>
                                </div>
                            </form>
                        </div>

                        {{-- <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">

                            <div class="lmp_thumb">

                                <img src="{{ asset('front/assets/img/about_us.jpg') }}" class="img-fluid" alt="" />

                            </div>

                        </div> --}}

                        <div class="col-12 mt-5 mb-5 reach">
                            <h2 class="text-center ">You can also reach us on:</h2>
                            <h4 class="text-center mt-3">Mobile no. - 9108449118 (between 10 am to 6 pm)</h4>
                            <h4 class="text-center"><strong>or</strong></h4>
                            <h4 class="text-center">Email id - support@etcetra.in</h4>
                            <p class="text-center">Address - 701, Sudha Building, 12th Road,<br/> Khar West, Mumbai - 400052</p>
                        </div>
                    </div>

                </div>

            </div>
        @endif
        <!-- ============================ About Detail ================================== -->



        <!-- ============================ partner Start ================================== -->



        <!-- ============================ partner End ================================== -->



        <!-- ============================ Students Reviews ================================== -->



        <!-- ============================ Students Reviews End ================================== -->

        @if ($name == 'FAQs')
            <div>

                <div class="container">
                    <div class="row">
                        <div class="col-sm-6  col-md-6 accordion_one">

                            <h4>FAQs for students</h4>
                            <div class="panel-group" id="accordionFourLeft">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion_oneLeft"
                                                href="#collapseFiveLeftone" aria-expanded="false" class="collapsed">

                                                Do you refund the fees after enrolling for any course or workshop?

                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseFiveLeftone" class="panel-collapse collapse" aria-expanded="false"
                                        role="tablist" style="height: 0px;">
                                        <div class="panel-body">
                                            <div class="img-accordion">
                                                <img src="https://img.icons8.com/color/81/000000/person-female.png"
                                                    alt="">
                                            </div>
                                            <div class="text-accordion">
                                                <p>
                                                    Refund is issued only in cases when the customer has paid the full
                                                    amount for any course or workshop and for some unforeseen reason, the
                                                    course/workshop did not start. In all other cases, refund is not issued
                                                    to the customer at any cost, because the fees gets passed on to the
                                                    teachers.
                                                </p>
                                            </div>
                                        </div>
                                        <!-- end of panel-body -->
                                    </div>
                                </div>
                                <!-- /.panel-default -->
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion_oneLeft"
                                                href="#collapseFiveLeftTwo" aria-expanded="false">
                                                What platform do you use to conduct online classes?
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseFiveLeftTwo" class="panel-collapse collapse" aria-expanded="false"
                                        role="tablist" style="height: 0px;">
                                        <div class="panel-body">
                                            <div class="img-accordion">
                                                <img src="https://img.icons8.com/color/81/000000/person-female.png"
                                                    alt="">
                                            </div>
                                            <div class="text-accordion">
                                                <p>
                                                    We use a reputed online platform to conduct online classes.
                                                </p>
                                            </div>
                                        </div>
                                        <!-- end of panel-body -->
                                    </div>
                                </div>
                                <!-- /.panel-default -->
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion_oneLeft"
                                                href="#collapseFiveLeftThree" aria-expanded="false">
                                                What are the pre-requites to start attending a class?
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseFiveLeftThree" class="panel-collapse collapse" aria-expanded="false"
                                        role="tablist">
                                        <div class="panel-body">
                                            <div class="img-accordion">
                                                <img src="https://img.icons8.com/color/81/000000/person-female.png"
                                                    alt="">
                                            </div>
                                            <div class="text-accordion">
                                                <p>
                                                    The only pre-requisites needed are a stable internet connection with
                                                    good speed. A laptop or a desktop is preferable but not mandatory.
                                                </p>
                                            </div>
                                        </div>
                                        <!-- end of panel-body -->
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion_oneLeft"
                                                href="#collapseFiveLeftThreeshare" aria-expanded="false">
                                                Do you share the students' personal details with teachers or third parties?
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseFiveLeftThreeshare" class="panel-collapse collapse"
                                        aria-expanded="false" role="tablist">
                                        <div class="panel-body">
                                            <div class="img-accordion">
                                                <img src="https://img.icons8.com/color/81/000000/person-female.png"
                                                    alt="">
                                            </div>
                                            <div class="text-accordion">
                                                <p>
                                                    To protect students' privacy, we do not share important personal
                                                    information of our students with anybody, including the teachers.
                                                </p>
                                            </div>
                                        </div>
                                        <!-- end of panel-body -->
                                    </div>
                                </div>



                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion_oneLeft"
                                                href="#collapseFiveLeftThreemaker" aria-expanded="false">
                                                I am a home-maker. Is there a course that I can join?
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseFiveLeftThreemaker" class="panel-collapse collapse"
                                        aria-expanded="false" role="tablist">
                                        <div class="panel-body">
                                            <div class="img-accordion">
                                                <img src="https://img.icons8.com/color/81/000000/person-female.png"
                                                    alt="">
                                            </div>
                                            <div class="text-accordion">
                                                <p>
                                                    We have various courses available. You can choose something that you
                                                    think you will enjoy and join the same.
                                                </p>
                                            </div>
                                        </div>
                                        <!-- end of panel-body -->
                                    </div>
                                </div>


                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion_oneLeft"
                                                href="#collapseFiveLeftThreejoin" aria-expanded="false">
                                                I recently retired from my job. Can I join a course or am I too old for it?
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseFiveLeftThreejoin" class="panel-collapse collapse"
                                        aria-expanded="false" role="tablist">
                                        <div class="panel-body">
                                            <div class="img-accordion">
                                                <img src="https://img.icons8.com/color/81/000000/person-female.png"
                                                    alt="">
                                            </div>
                                            <div class="text-accordion">
                                                <p>
                                                    Learning has no age. Retirement is the best time to start learning
                                                    something that you've always wanted to, but never found the time for,
                                                    during your working life.
                                                </p>
                                            </div>
                                        </div>
                                        <!-- end of panel-body -->
                                    </div>
                                </div>


                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion_oneLeft"
                                                href="#collapseFiveLeftThreejoinworld" aria-expanded="false">
                                                I am a busy executive in the corporate world. I do not have time during
                                                weekdays but my weekends are comparatively free. Would you have something
                                                for me?
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseFiveLeftThreejoinworld" class="panel-collapse collapse"
                                        aria-expanded="false" role="tablist">
                                        <div class="panel-body">
                                            <div class="img-accordion">
                                                <img src="https://img.icons8.com/color/81/000000/person-female.png"
                                                    alt="">
                                            </div>
                                            <div class="text-accordion">
                                                <p>
                                                    Out of so many teachers that we have, you can look for a teacher who
                                                    conducts classes during weekends. You can also join one of our weekend
                                                </p>
                                            </div>
                                        </div>
                                        <!-- end of panel-body -->
                                    </div>
                                </div>


                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion_oneLeft"
                                                href="#collapseFiveLeftThreejoinnext" aria-expanded="false"
                                                style="border: none">
                                                How do I get the referral benefit for my next purchase?
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseFiveLeftThreejoinnext" class="panel-collapse collapse"
                                        aria-expanded="false" role="tablist">
                                        <div class="panel-body">
                                            <div class="img-accordion">
                                                <img src="https://img.icons8.com/color/81/000000/person-female.png"
                                                    alt="">
                                            </div>
                                            <div class="text-accordion">
                                                <p>
                                                    Invite your friends to sign up with Etcetra and enter your registered
                                                    mobile number. When your friend makes his / her first purchase, he / she
                                                    gets Rs. 100/- off and the same amount gets added to your Etcetra wallet
                                                    which you can use during your next purchase of any course from our
                                                    website. So this way, both you and your friend get the benefit.
                                                </p>
                                            </div>
                                        </div>
                                        <!-- end of panel-body -->
                                    </div>
                                </div>

                                <!-- /.panel-default -->
                            </div>
                            <!--end of /.panel-group-->
                        </div>

                        <div class="col-sm-6 col-md-6 accordion_one">
                            <h4>FAQs for teachers</h4>
                            <div class="panel-group" id="accordionFourLeft">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion_oneLeft"
                                                href="#collapseFiveLeftonee" aria-expanded="false" class="collapsed">
                                                Why should I join Etcetra as an instructor?.
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseFiveLeftonee" class="panel-collapse collapse" aria-expanded="false"
                                        role="tablist" style="height: 0px;">
                                        <div class="panel-body">
                                            <div class="img-accordion">
                                                <img src="https://img.icons8.com/color/81/000000/person-female.png"
                                                    alt="">
                                            </div>
                                            <div class="text-accordion">
                                                <p>
                                                    Etcetra is a great place to share your passion with others, by teaching
                                                    them.
                                                    Keep learning and growing as a teacher and get paid well for it.

                                                </p>
                                            </div>
                                        </div>
                                        <!-- end of panel-body -->
                                    </div>
                                </div>
                                <!-- /.panel-default -->
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion_oneLeft"
                                                href="#collapseFiveLeftTwoo" aria-expanded="false">
                                                How will students contact
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseFiveLeftTwoo" class="panel-collapse collapse" aria-expanded="false"
                                        role="tablist" style="height: 0px;">
                                        <div class="panel-body">
                                            <div class="img-accordion">
                                                <img src="https://img.icons8.com/color/81/000000/person-female.png"
                                                    alt="">
                                            </div>
                                            <div class="text-accordion">
                                                <p>
                                                    .
                                                </p>
                                            </div>
                                        </div>
                                        <!-- end of panel-body -->
                                    </div>
                                </div>
                                <!-- /.panel-default -->
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion_oneLeft"
                                                href="#collapseFiveLeftThreee" aria-expanded="false"
                                                style="border: none">
                                                How do I get paid from Etcetra?
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseFiveLeftThreee" class="panel-collapse collapse"
                                        aria-expanded="false" role="tablist">
                                        <div class="panel-body">
                                            <div class="img-accordion">
                                                <img src="https://img.icons8.com/color/81/000000/person-female.png"
                                                    alt="">
                                            </div>
                                            <div class="text-accordion">
                                                <p>
                                                    Payments are done at the end of every month. You must have earned a
                                                    minimum of INR 2000/- to receive the money. Your balance will be
                                                    accumulated till you reach this threshold, and once it happens, the
                                                    amount would be transferred to your account at the end of that month.
                                                </p>
                                            </div>
                                        </div>
                                        <!-- end of panel-body -->
                                    </div>
                                </div>
                                <!-- /.panel-default -->
                            </div>
                            <!--end of /.panel-group-->

                        </div>
                    </div>
                </div>

            </div>
        @endif

    @endsection
