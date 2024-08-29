@extends('admin.v1.templates.main')

@section('content')

<style>

      td, th {

         border: 1px solid black;

         width: 40%;

         text-align:left;

         vertical-align: center;

      }

   </style>

    <div class="app-content content">

        <div class="content-wrapper">

            <div class="content-wrapper-before"></div>

            <div class="content-header row">

            </div>

            <!-- Multi-column ordering table -->

            <div class="content-body">

                <section id="multi-column">

                    <div class="row">

                    <div class="col-lg-12 col-md-12">
                            <h4 class='breadcrumbs'> My profile /</h4>
                 </div>

                        <div class="col-lg-12 col-md-12">

                            <div class="card">

                                <div class="card-header">

                                    <h4 class="card-title">Student Data</h4>

                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                                    <div class="heading-elements">

                                        <ul class="list-inline mb-0">

                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>

                                        </ul>

                                    </div>

                                    @if (Auth::user()->can('tutor_add'))

                                    <h6 class="mt-2"><a href="{{ route('admin.v1.tutor.add') }}">Create tutor</a>

                                    </h6>
 
                                    @else

                                    <h6 class="mt-2"><a href="{{ route('admin.v1.student.edit-submit',Auth::user()->id) }}">Edit Your Details</a>

                                    </h6>

                                    @endif

                                </div>

                                <div class="card-header">

                                    <h4 class="card-title">

                                    {{ $users->name }}  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  with us since {{ Carbon\Carbon::parse($users->created_at)->format('Y-m-d') }}   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Registration number {{ $users->id }}

                                    </h4>

                                    <br>

                                    <div class="row">

                                        <div class="col-md-12">

                                        <table style="margin-left:40px;width:90%;" border=1 >

                                            <tr >

                                                

                                                <th style="text-align:center;padding-top:10px;" ><h6>Personal Profile</h6></th>

                                                {{--<th style="text-align:center;padding-top:10px;" ><h6>Professional Profile</h6></th>--}}

                                            </tr>

                                            <tr>

                                                <td><ul>

                                                            <li><strong>Name</strong> : {{ $users->name }}</li>
                                                            <li><strong>DOB</strong> : {{ $users->dob }}</li>

                                                        

                                                            <li><strong>Age</strong>  : {{ Carbon\Carbon::parse($users->dob)->age }} Yrs.</li>

                                                            <li><strong>Bio</strong>  : {{ @$users->bio }}</li>

                                                            <li><strong>Email-id</strong> : {{ $users->email }}</li>

                                                            <li><strong>Mobile</strong> : {{ $users->phone }}</li>

                                                            <li><strong>Gender</strong> : {{ $users->gender }}</li>

                                                            <li><strong>Address</strong> : {{ $users->location }}</li>

                                                            {{--<li><strong>City</strong> : {{ @$users->usered->city }}</li>

                                                            <li><strong>Country</strong> : {{ @$users->usered->country }}</li>--}}



                                                        </ul></td>

                                                {{--<td><ul>

                                                            <li><strong>Degree Obtained</strong> : {{ @$users->usered->degree_obtained }}</li>

                                                            <li><strong>Degree Obtained From</strong> : {{ @$users->usered->degree_from }}</li>

                                                            <li><strong>Pass Out Year</strong> : {{ @$users->usered->passing_out }}</li>

                                                             <li><strong>Teaching Since</strong> : {{ Carbon\Carbon::parse($users->created_at)->format('Y-m-d') }}</li> 

                                                            <li><strong>Teaching Experience</strong> : {{ @$users->usered->experence }} Years</li>

                                                            <li><strong>Intro</strong>  : {{ @$users->usered->intro_text }}</li>

                                                            <li><strong>Profile Name</strong> : {{ @$users->usered->profile_name }}</li>

                                                            <li><strong>Demo Video</strong> : <a href="{{ aws_url(@$users->usered->intro_video) }}" target="_blank" > Click to view</a>

                                                            <!-- <div class="property_video sm">

                                                                <div class="thumb">

                                                                    <img class="pro_img img-fluid w100" src="{{ aws_url($users->avtars) }}" alt="7.jpg">

                                                                    <div class="overlay_icon">

                                                                        <div class="bb-video-box">

                                                                            <div class="bb-video-box-inner">

                                                                                <div class="bb-video-box-innerup">

                                                                                    <div data-toggle="modal" data-target="#video_preview" onclick="show_prev('{{ aws_url(@$users->usered->intro_video) }}','{{ aws_url($users->avtars) }}')" class="theme-cl"><i class="ti-control-play"></i></div>

                                                                                </div>

                                                                            </div>

                                                                        </div>

                                                                    </div>

                                                                </div>

                                                            </div> -->

                                                                    </li>



                                                        </ul></td>--}}

                                            </tr>

                                        </table> 

                                        </div>

                                                    

                                    </div>

                                </div>

                                <div class="card-content collapse show">

                                    <div class="card-body card-dashboard">

                                        <div class="table-responsive">

                                            <h4>Transaction of Course details</h4>

                                            <!-- modal ends -->

                                            <table class="table table-striped table-bordered file-export">

                                                <thead>

                                                    <tr>

                                                        <th>S.No</th>

                                                        <th>Course Name</th>

                                                        <th>Date of Registration</th>

                                                        <th>Course Duration</th>

                                                        <th>Course Fees</th>

                                                       {{--<th>Commision </th>

                                                        <th>My payment</th>--}}

                                                    </tr>

                                                </thead>

                                                <tbody>

                                                    @foreach ($trnx as $key=>$courses)

                                                        <tr role="row" class="odd">

                                                            <td class="sorting_1">{{ $key+1 }}</td>                                                           

                                                            <td>{{ $courses->course->title }}</td>

                                                            <td>{{ Carbon\Carbon::parse($courses->created_at)->format('Y-m-d') }}</td>

                                                            <td>{{ $courses->circullum_topic->count() }} classes</td>

                                                            <td>{{ $courses->price }}</td>


                                                           
                                                            {{--<td>10% </td>

                                                            @php  $tech_prof=DB::table('usered')->Where('user_id', $courses->user_id)->first();
                                                            $value = $courses->price - $tech_prof->admin_commission; @endphp
                                                            <td>{{$value}}</td>--}}

                                                        </tr>

                                                    @endforeach

                                                </tbody>

                                            </table>

                                        </div>

                                    </div>

                                </div>

                                <div class="card-content collapse show">

                                    <div class="card-body card-dashboard">

                                        <div class="table-responsive">

                                            <h4>Attendence Details</h4>

                                            <!-- modal ends -->

                                            <table class="table table-striped table-bordered file-export">

                                                <thead>

                                                    <tr>

                                                        <th>S.No</th>

                                                        <th>Course Name</th>

                                                        <th>Date of Registration</th>

                                                        <th>Course Duration</th>

                                                        <th>Course Fees</th>

                                                        <th>view</th>

                                                    </tr>

                                                </thead>

                                                <tbody>

                                                    @foreach ($course as $key=>$courses)

                                                        <tr role="row" class="odd">

                                                            <td class="sorting_1">{{ $key+1 }}</td>                                                           

                                                            <td>{{ $courses->title }}</td>

                                                            <td>{{ Carbon\Carbon::parse($courses->created_at)->format('Y-m-d') }}</td>

                                                            <td>{{ $courses->circullum_topic->count() }} classes</td>

                                                            <td>{{ $courses->price }}</td>

                                                            <td> @if (Auth::user()->can('course_edit'))

                                                                        <a href="{{ route('admin.v1.circullum.list', ['id' => $courses->id]) }}" class="btn btn-secondary btn-sm Block">

                                                                        Attendence

                                                                        </a>

                                                                @endif</td>

                                                        </tr>

                                                    @endforeach

                                                </tbody>

                                            </table>

                                        </div>

                                    </div>

                                </div>

                      

                            </div>

                        </div>

                    </div>

                </section>

            </div>



        </div>

    </div>

@endsection





{{-- ALTER TABLE `permissions` CHANGE `view_videos` `video_view` TINYINT(1) NOT NULL DEFAULT '0', CHANGE `delete_videos` `video_delete` TINYINT(1) NOT NULL DEFAULT '0', CHANGE `view_user` `appuser_view` TINYINT(1) NOT NULL DEFAULT '0', CHANGE `delete_user` `appuser_delete` TINYINT(1) NOT NULL DEFAULT '0', CHANGE `block_user` `appuser_block` TINYINT(1) NOT NULL DEFAULT '0', CHANGE `view_comment` `comments_view` TINYINT(1) NOT NULL DEFAULT '0', CHANGE `delete_comment` `comments_delete` TINYINT(1) NOT NULL DEFAULT '0';



resources\views\admin\v1\tutor\access.blade.php

app\Http\Controllers\Admin\V1\tutorsController.php

app\Models\Permission.php --}}

