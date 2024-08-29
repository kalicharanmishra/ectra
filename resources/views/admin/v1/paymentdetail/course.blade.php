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
                            <h4 class='breadcrumbs'>Payment Details / Course Wise</h4>

                    </div>

                        <div class="col-lg-12 col-md-12">

                            <div class="card">

                                <div class="card-header">

                                    <h4 class="card-title">Course Details</h4>

                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                                    <div class="heading-elements">

                                        <ul class="list-inline mb-0">

                                            <li><a class="btn btn-light" data-action="expand">Expand</a></li>

                                        </ul>

                                    </div>

                                </div>


                                @if(auth()->user()->can('course_add'))

                                <div class="card-content collapse show">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                           
                                            <table class="table table-striped table-bordered file-export">

                                                <thead>
                                                    <tr>
                                                        <th>S.no</th>
                                                        <th>Classification</th>
                                                        <th>Category</th>
                                                        <th>Sub category</th>
                                                        <!-- <th>Student</th> -->
                                                        <th>Total no. of student</th>
                                                        <th>Total fees</th>
                                                        <th>Total recieved on</th>
                                                        
                                                        <!-- <th>Balance Payment due</th>
                                                        <th>Next Due On</th> -->
                                                        
                                                        <!-- <th>Fees Recieved</th>
                                                        <th>Commision</th>
                                                        
                                                        <th>Payment Date</th>
                                                        <th>Total Earning</th> -->
                                                    </tr>
                                                </thead>

                                                <tbody>

                                                    @foreach ($trnx as $keyvv=>$trnxs)

                                                        <tr role="row" class="odd">
                                                          
                                                            <td class="sorting_1">{{ $keyvv+1 }}</td>
                                                            <td>{{ $trnxs->course->getCatAttribute->name }}</td>
                                                            <td>{{ $trnxs->course->title }}</td>
                                                            @php 
                                                                $sub_cat= DB::table('categories')->where('id', $trnxs->course->category)->first();
                                                                $totclass = DB::table('class_course')->where('course_id', $trnxs->course->id)->count();
                                                            @endphp
                                                            <td>{{ $sub_cat->name }}</td>
                                                           {{-- <td>{{ $trnxs->usered->name }}</td>--}}


                                                        

                                                            @php $countstu = DB::table('transaction')->select('course_id')->where('subscriber_id', $teacher_id)->count(); @endphp
                                                            <td>{{$countstu}}</td>
                                                            
                                                            <td>{{ $trnxs->course->price }}</td>

                                                            
                                                            @php $totpric = $sum = DB::table('transaction')->where('subscriber_id', $teacher_id)->sum('teacher_commission'); @endphp
                                                            <td>{{ $totpric }}</td>

                                                            {{-- @php $value = $trnxs->course->price - $trnxs->teacher_profile->admin_commission; @endphp
                                                            <td>{{ $value }}    </td>   
                                                            <td>{{$trnxs->created_at}}</td> --}}   
                                                            <!-- <td></td>   
                                                            <td></td>    -->
                                                            

                                                            {{--<td>{{ $trnxs->course->price }}</td>
                                                            <td>{{ $trnxs->teacher_profile->admin_commission }}</td>
                                                       
                                                            <td>{{ Carbon\Carbon::parse($trnxs->created_at)->format('Y-m-d') }}</td>
                                                            <td>{{ $value }}</td>--}}

                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                    @php $totc=$keyvv+1 @endphp
                                               {{-- <tfoot>
                                                    <tr>
                                                    <th id="total" colspan="7"> </th>
                                                    <td>Total - {{$value*$totc}}</td>
                                                    </tr>
                                                </tfoot>--}}

                                            </table>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection