@extends('admin.v1.templates.main')

@section('content')
use Carbon\Carbon;
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
                            <h4 class='breadcrumbs'> Manage Courses / My Course</h4>
                 </div>

                    <!-- <div class="col-lg-12 col-md-12">
                           @if (Auth::user()->can('course_add')) <h4 class='breadcrumbs'>This section lists down all the different courses that you have posted on this website this now.</h4>
                           @endif
                 </div> -->

                        <div class="col-lg-12 col-md-12">

                            <div class="card">

                                <div class="card-header">

                                    {{--<h4 class="card-title">@if (Auth::user()->can('course_add')) My Courses @else Courses list @endif</h4>--}}

                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                                    <div class="heading-elements">

                                        <ul class="list-inline mb-0">

                                        @if (Auth::user()->can('course_add'))

                                        <li><a class="btn btn-light" href="{{ route('admin.v1.course.add') }}">@if (auth()->user()->can('course_add')) Add course @else Add @endif</a></li>

                                        @endif

                                            <li><a class="btn btn-light" data-action="expand">Expand</a></li>

                                        </ul>

                                    </div>

                                </div>



                                <div class="card-content collapse show">


                                    <div class="card-body card-dashboard">

                                        <div class="table-responsive">

                                            <!-- modal ends -->

                                            <table class="table table-striped table-bordered file-export">

                                                <thead>

                                                    <tr>

                                                        @if (auth()->user()->roles->pluck('name')[0] == "super admin" || auth()->user()->roles->pluck('name')[0] == "admin") 

                                                        <th>ID</th>

                                                        <th>Added By</th>

                                                        @endif
                                                        <th>S.no.</th>
                                                        <th>Registration date</th>

                                                        <th>Course listed</th>

                                                        <th>Course duration</th>
                                                        <th>Course fees</th>
                                                        <!-- <th>Video preview</th> -->

                                                        <!--<th>Filter</th>-->

                                                        <!--<th>Language</th>-->

                                                        <!-- <th>Sub category</th> -->

                                                        <!--<th>Hashtags</th>-->

                                                        <!-- <th>Visibility</th> -->

                                                        <!-- <th>Description</th> -->

                                                        <!-- <th>Posting date</th> -->

                                                        <th>No. of students</th>

                                                        @if(auth()->user()->hasRole('super admin') || auth()->user()->hasRole('admin') )

                                                        @else

                                                        <th>Action</th>

                                                        @endif

                                                      

                                                       

                                                    </tr>

                                                </thead>

                                                <tbody>
                                                    @php $i = 1;@endphp
                                                    @foreach ($courses as $course)

                                                  

                                                        <tr role="row" class="odd">
                                                            <td>{{$i++}}</td>
                                                           @if (auth()->user()->roles->pluck('name')[0] == "super admin" || auth()->user()->roles->pluck('name')[0] == "admin") 

                                                            <td class="sorting_1">{{ $course->id }}</td>

                                                            <td>{{ $course->course_owner?$course->course_owner['name']:'' }}</td>

                                                        @endif
                                                        <td>@php
                                                            echo date('d-M-Y',strtotime($course->created_at));
                                                                @endphp</td>
                                                            <td>{{ $course->title }}</td>
<td></td>
                                                            <td>

                                                                {{--<a target="_blank"

                                                                    href="{{ Storage::url($course->video) }}">

                                                                   <img src="{{Storage::url($course->video_thumbnail)}}" width="40" height="40">

                                                                </a>--}}
                                                                {{$course->price}}

                                                            </td>

                                                           {{-- <td>

                                                              

                                                               {{isset($course->categorydata) ? $course->categorydata['name'] : ''}}

                                                            </td>

                                                            <td>{{ $course->visibility }}</td>--}}

                                                            {{--<td>{{ $course->created_at->diffForhumans() }}</td>--}}

                                                            <td>{{$course->course_enroll_student_count}}</td>

                                                            @if(auth()->user()->hasRole('super admin') || auth()->user()->hasRole('admin') )

                                                            @else

                                                                @if (Auth::user()->can('course_block') || Auth::user()->can('course_edit') || Auth::user()->can('course_view') || Auth::user()->can('course_delete'))

                                                                    <td>

                                                                    @if (Auth::user()->can('course_edit'))

                                                                    @if(auth()->user()->hasRole('super admin') || auth()->user()->hasRole('admin') || auth()->user()->id == $course->user_id)

                                                                        <a href="{{ route('admin.v1.course.edit', ['id' => $course->id]) }}" class="btn btn-secondary btn-sm Block">

                                                                        Edit

                                                                        </a>

                                                                        @endif

                                                                @endif






                                                                @if (Auth::user()->can('course_edit'))

                                                                    @if(auth()->user()->hasRole('super admin') || auth()->user()->hasRole('admin') || auth()->user()->id == $course->user_id)

                                                                        <a href="{{ route('admin.v1.course.opclas' , ['id' => $course->id])}}" class="btn btn-secondary btn-sm Block">

                                                                        Class schedule

                                                                        </a>

                                                                        @endif

                                                                @endif

                                                                        <!-- @if (Auth::user()->can('course_view'))

                                                                            <br>

                                                                            <a href="{{ route('admin.v1.course.comments', ['id' => $course->id]) }}"

                                                                                class="btn btn-info btn-sm Block">

                                                                                Comments

                                                                            </a>

                                                                        @endif -->

                                                                    

                                                                

                                                                @if (Auth::user()->can('course_delete'))

                                                                    

                                                                        <a onclick="return confirm('Are you sure want to delete this course {{ $course->name }}.?')"

                                                                            href={{ route('admin.v1.course.delete', ['id' => $course->id]) }}

                                                                            class="btn btn-danger btn-sm Delete">

                                                                            <span class="text-warning" >Delete</span>

                                                                        </a>

                                                                    

                                                                @endif



                                                                @if (Auth::user()->can('course_edit'))

                                                                    @if(auth()->user()->hasRole('super admin') || auth()->user()->hasRole('admin') || auth()->user()->id == $course->user_id)

                                                                        <a href="{{ route('admin.v1.circullum.list', ['id' => $course->id]) }}" class="btn btn-secondary btn-sm Block">

                                                                        Curricullum

                                                                        </a>

                                                                        @endif

                                                                @endif


                                                                @if (Auth::user()->can('course_edit'))

                                                                @if(auth()->user()->hasRole('super admin') || auth()->user()->hasRole('admin') || auth()->user()->id == $course->user_id)

                                                                    <a href="{{ route('admin.v1.courses.trial_pay', ['id' => $course->id]) }}" class="btn btn-secondary btn-sm Block">Trial Pay student</a>

                                                                   

                                                                    @endif

                                                                @endif



                                                                @if (Auth::user()->can('course_edit'))

                                                                    @if(auth()->user()->hasRole('super admin') || auth()->user()->hasRole('admin') || auth()->user()->id == $course->user_id)

                                                                        <a href="{{ route('admin.v1.course.attendance' , ['id' => $course->id])}}" class="btn btn-secondary btn-sm Block">
                                                                            Students
                                                                        </a>

                                                                        @endif

                                                                @endif

    
                                            
                                                            </td>

                                                            @endif

                                                            @endif

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

