@extends('admin.v1.templates.main')

@section('content')

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
                            <h4 class='breadcrumbs'> Manage Courses / My Course / List
                                
                            </h4>
                 </div>
                    
                    <div class="col-lg-12 col-md-12">

                 </div>

                        <div class="col-lg-12 col-md-12">

                            <div class="card">

                                <div class="card-header">

                                    <h4 class="card-title">@if (Auth::user()->can('course_add')) Add new Classes @else Courses list @endif</h4>

                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                                    <div class="heading-elements">

                                        <ul class="list-inline mb-0">

                                        

                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>

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

                                                      

                                                        <!-- <th>ID</th> -->

                                                        <!-- <th>Course Id</th> -->

                                           

                                                        <th>Course Name</th>

                                                        <th>time</th>

                                                        <!--<th>Filter</th>-->

                                                        <!--<th>Language</th>-->

                                                        <th>URL</th>

                                                        <!--<th>Hashtags</th>-->

                                                        <th>start_date</th>


                                                        @if(auth()->user()->hasRole('super admin') || auth()->user()->hasRole('admin') )

                                                        @else

                                                        <th>Action</th>

                                                        @endif

                                                    </tr>

                                                </thead>

                                                <tbody>

                                                <a href="{{ route('admin.v1.course.opedit' , $id )}}" class="btn btn-success">Add Class</a>
                                                    
                                                   @foreach ($course as $course)

                                                        <tr role="row" class="odd">

                                                            <!-- <td class="sorting_1">{{ $course->id }}</td> -->
                                                            <td>{{ $course->course_name }}</td>                                                        
                                                            <td> {{isset($course->time) ? $course->time : ''}} </td>
                                                            <td>{{ $course->url }}</td>
                                                            <td>{{ $course->start_date }}</td>

                                                            <?php
                                                            $courr=date("Y-m-d");
                                                        
                                                             if($course->start_date <= $courr){ ?>
                                                                <td><a href="{{ route('admin.v1.course.coursedel' ,  $course->id )}}" class="btn btn-danger" style="display: none;">Delete</a></td>
                                                            <?php } else{ ?>
                                                                <td><a href="{{ route('admin.v1.course.coursedel' ,  $course->id )}}" class="btn btn-danger">Delete</a></td>
                                                            <?php } ?>
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