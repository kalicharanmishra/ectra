@extends('front.layouts.app')



@section('content')

    @auth

        <?php
        
        $auid = Auth::user()->id;
        
        $enrolled = DB::table('course_enroll')
            ->where('course_id', $course->id)
            ->where('user_id', $auid)
            ->first();
        
        ?>

    @endauth

    <!-- ============================================================== -->
    <style>
       

        .an {
            color: #000 !important;
        }

        .show>.nav-pills .nav-link {
            color: #fff !important;
            background-color: #a30a0a;
        }

        .bts {
            padding: 9px;
            color: #fff;
            background-color: #a30a0a ;
            border-radius: 4px;
        }

        .bts:hover {
            color: #fff;
        }

        .nav-pills .nav-link.active,
        .show>.nav-pills .nav-link {
            color: #fff !important;
        }


        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            text-transform: unset !important;
        }

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

        .list-single-main-item {
            padding: 0px 10px !important;
            margin-bottom: 0px !important;
        }

        .edu_wraper {
            padding: 0px 10px !important;
            margin-bottom: 0px !important;
        }

        .single_instructor {
            margin-bottom: 0px;
            padding: 0px 10px
        }

        .single_instructor_thumb {
            height: auto;
        }

        .reach h4 {
            font-size: 20px;
        }

        .theme-cl {
            color: #a30a0a !important;
        }
    </style>


    <!-- ============================ Page Title Start================================== -->
<section style="background-color:#FFFBEB;">

        <div class="">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12">

                        <div class="breadcrumbs-wrap">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumbb">
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Courses</a></li>
                                    @if ($course->categorydata)
                                        <li class="breadcrumb-item"><a
                                                href="{{ url('/category?category=' . $course->parentcategorydataparent->name) }}">{{ $course->parentcategorydataparent->name }}</a>
                                        </li>
                                        <li class="breadcrumb-item"><a
                                                href="{{ url('/category?category=' . $course->parentcategorydata->name) }}">{{ $course->parentcategorydata->name }}</a>
                                        </li>
                                        <li class="breadcrumb-item"><a
                                                href="{{ url('/course?category=' . $course->categorydata->name) }}">{{ $course->categorydata->name }}</a>
                                        </li>

                                        <li class="breadcrumb-item  theme-cl"><a style="color: #a30a0a !important"
                                                href="{{ url('/') }}">{{ $course->slug }}</a></li>
                                    @else
                                        <li class="breadcrumb-item theme-cl" aria-current="page">Courses</li>
                                    @endif

                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <section>
        <div class="container">



            <div class="row">

                <div class="col-lg-8 col-md-12">

                    @foreach (json_decode($course->hashtags) as $key_hashtags => $item)
                        <div class="crs_cates cl_{{ $key_hashtags }}"><span>{{ $item }}</span></div>
                    @endforeach
                    <div class="ed_header_caption">

                        <h2 class="ed_title" style="color: #a30a0a">{{ $course->title }}</h2>
                    </div>
                </div>

                <div class="col-lg-8 col-md-12 order-2 order-lg-1">

                  

                    <div>
                        <div>

                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-12  col-md-12 accordion_one">
                                        <div class="panel-group" id="accordionFourLeft">
                                            <!-- /.panel-default -->
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a data-toggle="collapse" data-parent="#accordion_oneLeft"
                                                            href="#collapseFiveLeftone" aria-expanded="false"
                                                            class="collapsed">
                                                            Overview
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseFiveLeftone" class="panel-collapse collapse"
                                                    aria-expanded="false" role="tablist" style="height: 0px;">
                                                    <div class="panel-body">
                                                        {{-- <div class="img-accordion">
                                                            <img src="https://img.icons8.com/color/81/000000/person-female.png"
                                                                alt="">
                                                        </div> --}}
                                                        <div class="text-accordion">
                                                            <p> {!! $course->description !!}</p>
                                                        </div>
                                                    </div>
                                                    <!-- end of panel-body -->
                                                </div>
                                            </div>

                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a class="collapsed" data-toggle="collapse"
                                                            data-parent="#accordion_oneLeft" href="#collapseFiveLeftTwo"
                                                            aria-expanded="false">
                                                            Requirments for the course
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseFiveLeftTwo" class="panel-collapse collapse"
                                                    aria-expanded="false" role="tablist" style="height: 0px;">
                                                    <div class="panel-body">

                                                        <div class="text-accordion">
                                                            <p>{!! $course->course_requirment_description !!}</p>
                                                        </div>
                                                    </div>
                                                    <!-- end of panel-body -->
                                                </div>
                                            </div>
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a class="collapsed" data-toggle="collapse"
                                                            data-parent="#accordion_oneLeft" href="#collapseFiveLeftThree"
                                                            aria-expanded="false">
                                                            Curriculum
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseFiveLeftThree" class="panel-collapse collapse"
                                                    aria-expanded="false" role="tablist">
                                                    <div class="panel-body">
                                                        <div class="edu_wraper">
                                                            <div id="accordionExample" class="accordion shadow circullum">

                                                                @if ($course->id)
                                                                    @foreach (\App\Models\Circullum::where('course_id', $course->id)->with('circullum_topic')->get()->toArray() as $key => $item)
                                                                        <!-- Part 1 -->

                                                                        <div class="card">
                                                                            <div id="heading{{ $key }}"
                                                                                class="card-header bg-white shadow-sm border-0">

                                                                                <h6 class="mb-0 accordion_title"><a
                                                                                        href="#"
                                                                                        data-toggle="collapse"
                                                                                        data-target="#collapse{{ $key }}"
                                                                                        @if ($key == 0) aria-expanded="true" @else aria-expanded="false" @endif
                                                                                        aria-controls="collapse{{ $key }}"
                                                                                        class="d-block position-relative  text-dark collapsible-link py-2"><b>{{ $item['title'] }}</b></a>
                                                                                </h6>

                                                                            </div>

                                                                            <div id="collapse{{ $key }}"
                                                                                aria-labelledby="heading{{ $key }}"
                                                                                data-parent="#accordionExample"
                                                                                class="collapse show">

                                                                                <div class="card-body pl-3 pr-3">
                                                                                    <ul class="lectures_lists">
                                                                                        @if ($item['circullum_topic'])
                                                                                            @foreach ($item['circullum_topic'] as $circullum_topic)
                                                                                                <li
                                                                                                    class="@if ($circullum_topic['is_complete'] == 0) unview @elseif($circullum_topic['is_complete'] == 1) progressing @else complete @endif">
                                                                                                    <div
                                                                                                        class="lectures_lists_title">

                                                                                                        <!--<i class="fas @if ($circullum_topic['is_complete'] == 0) fa-lock lock @elseif($circullum_topic['is_complete'] == 1) fa-play @else fa-check @endif dios"></i>-->
                                                                                                        <span
                                                                                                            class="">{{ $circullum_topic['topic'] }}</span>
                                                                                                    </div>
                                                                                                    <!--<span class="cls_timing_date">{{ $circullum_topic['cover_time'] }}</span>-->
                                                                                                    <span
                                                                                                        class="cls_timing"></span>
                                                                                                    <br>
                                                                                                    <!--<p>{{ $circullum_topic['description'] }}</p>-->
                                                                                                </li>
                                                                                            @endforeach
                                                                                        @endif

                                                                                    </ul>

                                                                                </div>

                                                                            </div>

                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <!-- end of panel-body -->
                                                </div>
                                            </div>
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a class="collapsed" data-toggle="collapse"
                                                            data-parent="#accordion_oneLeft"
                                                            href="#collapseFiveLeftThreeshare" aria-expanded="false">
                                                            Instructor
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseFiveLeftThreeshare" class="panel-collapse collapse"
                                                    aria-expanded="false" role="tablist">
                                                    <div class="panel-body">
                                                        <div class="single_instructor">
                                                            <div class="single_instructor_thumb">
                                                                <a
                                                                    href="{{ route('front.instructor_detail', [\Crypt::encrypt($course->course_owner['id']), $course->course_owner['name']]) }}"><img
                                                                        src="{{ Storage::url($course->course_owner['avtars']) }}"
                                                                        class="img-fluid" alt=""
                                                                        onerror="this.src='/thrill/v1/icon/teacher2.png'"></a>

                                                            </div>
                                                            <div class="single_instructor_caption">
                                                                <h4>
                                                                    <a
                                                                        href="{{ route('front.instructor_detail', [\Crypt::encrypt($course->course_owner['id']), $course->course_owner['name']]) }}">{{ $course->course_owner['name'] }}</a>
                                                                </h4>
                                                                <ul class="instructor_info">
                                                                    <li><i
                                                                            class="ti-video-camera"></i>{{ $course->course_owner['courses_count'] ? $course->course_owner['courses_count'] : 0 }}
                                                                        Course</li>

                                                                    <li><i
                                                                            class="ti-control-forward"></i>{{ $course->course_owner['teacher_sessions_count'] ? $course->course_owner['teacher_sessions_count'] : 0 }}
                                                                        Session</li>

                                                                    <li><i class="ti-user"></i>Exp.
                                                                        {{ $course->course_owner['teacher_profile']['experence'] }}
                                                                        Year</li>
                                                                </ul>

                                                                <p>At vero eos et accusamus et iusto odio dignissimos
                                                                    ducimus qui
                                                                    blanditiis praesentium voluptatum deleniti atque
                                                                    corrupti quos
                                                                    dolores et quas molestias excepturi.</p>

                                                            </div>

                                                        </div>
                                                    </div>
                                                    <!-- end of panel-body -->
                                                </div>
                                            </div>
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a class="collapsed" data-toggle="collapse"
                                                            data-parent="#accordion_oneLeft"
                                                            href="#collapseFiveLeftThreemaker" aria-expanded="false">
                                                            Reviews
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseFiveLeftThreemaker" class="panel-collapse collapse"
                                                    aria-expanded="false" role="tablist">
                                                    <div class="panel-body">
                                                        <div class="list-single-main-item fl-wrap">

                                                            <div class="list-single-main-item-title fl-wrap">

                                                                <h3 style="color:#000">Reviews - <span>
                                                                        {{ count($review) == 0 ? 'No review' : count($review) }}
                                                                    </span>
                                                                </h3>
                                                            </div>

                                                            <div class="reviews-comments-wrap">

                                                                <!-- reviews-comments-item -->
                                                                @foreach ($review as $reviews)
                                                                    <div class="reviews-comments-item">
                                                                        <div class="review-comments-avatar">
                                                                            <img src="{{ Storage::url($reviews->use_name[0]['avtars']) }}"
                                                                                class="img-fluid" alt=""
                                                                                onerror="this.src='/thrill/v1/icon/teacher2.png'">
                                                                        </div>
                                                                        <div class="reviews-comments-item-text">
                                                                            <h4><a href="#">
                                                                                    @foreach ($reviews->use_name as $use_names)
                                                                                        {{ $use_names->name }}
                                                                                    @endforeach
                                                                                </a><span
                                                                                    class="reviews-comments-item-date"></span>
                                                                            </h4>
                                                                            <div class="listing-rating">
                                                                                @for ($i = 1; $i <= 5; $i++)
                                                                                    <i
                                                                                        class="fas fa-star  @if ($reviews->rate >= $i) active @endif"></i>
                                                                                @endfor
                                                                            </div>

                                                                            <div class="listing-rating">
                                                                                {{ $reviews->created_at->format('d-m-Y') }}
                                                                            </div>
                                                                            <div class="clearfix"></div>
                                                                            <p>{{ $reviews->comment }}</p>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                        <!-- Submit Reviews -->

                                                        <div class="edu_wraper">
                                                            <h4 class="edu_title">Submit Reviews</h4>
                                                            @auth
                                                                <div class="review-form-box form-submit">
                                                                    <form action="{{ route('front.submitReview') }}"
                                                                        method="post" enctype="multipart/form-data">
                                                                        @csrf
                                                                        <div class="row">
                                                                            <input class="form-control" type="text"
                                                                                name="course_id" value="{{ $course->id }}"
                                                                                style="display:none;">
                                                                            <input class="form-control" type="hiddn"
                                                                                name="id" value="{{ Auth::user()->id }}"
                                                                                style="display:none;">
                                                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                                                <div class="form-group">
                                                                                    <label>Name</label>
                                                                                    <input class="form-control" type="text"
                                                                                        name="name" placeholder="Your Name"
                                                                                        require>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                                                <div class="form-group">
                                                                                    <label>Review</label>
                                                                                    <textarea class="form-control ht-140" name="review" placeholder="Review" require></textarea>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                                                <div class="form-group">
                                                                                    <label>Rate</label>
                                                                                    <br>
                                                                                    <div class="form-check form-check-inline">
                                                                                        <input type="radio"
                                                                                            class="btn-check" id="option1"
                                                                                            name="rate" value="1">
                                                                                        <label class="form-check-label"
                                                                                            for="option1">1</label>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline">
                                                                                        <input type="radio"
                                                                                            class="btn-check" id="option2"
                                                                                            name="rate" value="2">
                                                                                        <label class="form-check-label"
                                                                                            for="option2">2</label>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline">
                                                                                        <input type="radio"
                                                                                            class="btn-check" id="option3"
                                                                                            name="rate" value="3">
                                                                                        <label class="form-check-label"
                                                                                            for="option3">3</label>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline">
                                                                                        <input type="radio"
                                                                                            class="btn-check" id="option4"
                                                                                            name="rate" value="4">
                                                                                        <label class="form-check-label"
                                                                                            for="option4">4</label>
                                                                                    </div>

                                                                                    <div class="form-check form-check-inline">
                                                                                        <input type="radio"
                                                                                            class="btn-check" id="option5"
                                                                                            name="rate" value="5">
                                                                                        <label class="form-check-label"
                                                                                            for="option5">5</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                                                <div class="form-group">
                                                                                    <button type="submit"
                                                                                        class="btn theme-bg btn-md">Submit
                                                                                        Review</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            @else
                                                                <p>you have to login first for add review. Please <a
                                                                        href="#" class="theme-light "
                                                                        data-toggle="modal" data-target="#login">login </a>
                                                                </p>
                                                            @endauth
                                                        </div>
                                                    </div>
                                                    <!-- end of panel-body -->
                                                </div>
                                            </div>
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a class="collapsed" data-toggle="collapse"
                                                            data-parent="#accordion_oneLeft"
                                                            href="#collapseFiveLeftThreejoin" aria-expanded="false">
                                                            Demo video
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseFiveLeftThreejoin" class="panel-collapse collapse"
                                                    aria-expanded="false" role="tablist">
                                                    <div class="panel-body">
                                                        <div class="single_instructor">
                                                            <div class="property_video md w-100">
                                                                <div class="thumb">
                                                                    <img class="pro_img img-fluid w100"
                                                                        src="{{ Storage::url($course->video_thumbnail) }}"
                                                                        alt="7.jpg">

                                                                    <div class="overlay_icon">
                                                                        <div class="bb-video-box">
                                                                            <div class="bb-video-box-inner">
                                                                                <div class="bb-video-box-innerup">
                                                                                    <div data-toggle="modal"
                                                                                        data-target="#video_preview"
                                                                                        onclick="show_prev('{{ Storage::url($course->video) }}','{{ Storage::url($course->video_thumbnail) }}')"
                                                                                        class="theme-cl"><i
                                                                                            class="ti-control-play"></i>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <!-- end of panel-body -->
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <!-- Sidebar -->

                <div class="col-lg-4 col-md-12 order-1 order-lg-2">

                    <!-- Course info -->

                    <div class="ed_view_box style_3 ovrlio crs_lt_2 stick_top">
                        <div class="courses_boxes_table">
                            <table>
                                <tbody style="font-weight: 600;">
                                    <tr>
                                        <td>Teaching since</td>
                                        <td>{{ $course->course_owner['teacher_profile']['experence'] }} Years</td>
                                    </tr>
                                    <tr>
                                        <td>Classes held on</td>
                                        <td>{{ $course->class_held_on }}</td>
                                    </tr>
                                    <tr>
                                        <td>Class timings</td>
                                        <td> {{ $course->timing }} Hrs</td>
                                    </tr>
                                    <tr>
                                        <td>Course duration</td>
                                        <td> <?php
                                        if ($course->duration >= 30) {
                                            $totmont = round($course->duration / 30);
                                            echo $totmont . ' Month';
                                        } elseif ($course->duration >= 365) {
                                            $totmont = round($course->duration / 365);
                                            echo $totmont . ' Years';
                                        } else {
                                            $totmont = round($course->duration);
                                            echo $totmont . ' Days';
                                        }
                                        ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Course fees</td>
                                        @if ($course->price_type == 'Paid')
                                            <td>Rs. {{ $course->price }}/-</td>
                                        @else
                                            <td>Free</td>
                                        @endif
                                    </tr>

                                    <tr>
                                        <td>Skill level</td>
                                        <td>{{ $course->skill_level }}</td>
                                    </tr>

                                    @if ($course->price_type == 'Paid')
                                        <tr>
                                            <td>Trial Class</td>
                                            <td>Rs. 50/-




                                                @auth

                                                    @if (!DB::table('course_enroll')->where('course_id', $course->id)->where('user_id', Auth::user()->id)->first())
                                                        <a href="/course/{{ $course->title }}/trialenroll"
                                                            class="bts ml-1">Book trial class </a>
                                                </td>
                                            @else
                                                
                                        @endif
                                    @else
                                        <span class="bts ml-3" data-toggle="modal" data-target="#login">Book trial class </span>

                                    @endauth

                                    </tr>
                                @else
                                    @endif

                                    @if ($course->id_trial == 1)
                                        <tr>
                                            <td>Trial class fees</td>
                                            <td>Rs. 50/-</td>
                                        </tr>
                                    @endif
                                </tbody>

                            </table>
                        </div>




                        <div class="ed_view_link">

                            @auth

                                @if (!DB::table('course_enroll')->where('course_id', $course->id)->where('user_id', Auth::user()->id)->first())
                                    @if ($course->price_type == 'Paid')
                                        <a href="/course/{{ $course->title }}/enroll" target="_blank"
                                            class="btn theme-bg enroll-btn">Enroll Now<i class="ti-angle-right"></i></a>
                                    @else
                                        <a href="/course/{{ $course->slug }}/circullum" class="btn theme-bg enroll-btn">Check
                                            Free class<i class="ti-angle-right"></i></a>
                                    @endif
                                @else
                                    <a href="/course/{{ $course->slug }}/circullum" class="btn theme-bg enroll-btn">Check
                                        Subscription<i class="ti-angle-right"></i></a>
                                @endif
                            @else
                                <a href="#" class="btn theme-bg enroll-btn" data-toggle="modal"
                                    data-target="#login">
                                    <span class="dn-lg">Pay now</span>

                                </a>

                            @endauth

                        </div>



                    </div>

                </div>

            </div>

        </div>
    </section>

   
</section>

    <!-- ============================ Page Title End ================================== -->



@endsection
