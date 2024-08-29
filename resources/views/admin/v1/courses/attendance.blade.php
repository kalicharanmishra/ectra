@extends('admin.v1.templates.main')
@section('content')

<div class="app-content content">
	<div class="content-wrapper">
		<div class="content-wrapper-before"></div>
		<div class="content-header row">
		</div>

		<!-- Multi-column ordering table -->

		<div class="content-body manage_cource_main">
			<section id="multi-column">
				<div class="row">
					<div class="col-lg-12 col-md-12">
						<h4 class='breadcrumbs'> Manage courses / My Courses / Students</h4>
					</div>

					<div class="col-lg-12 col-md-12">
						<div class="card">
							<div class="card-header" style="padding-bottom: 0; padding:30px">
								<div class="row">
									<div class="col-6">
										<h4 class="card-title">@if (Auth::user()->can('course_add')) Students @else Courses list @endif</h4>

                                        <div class="">
                                            <ul class="list-inline mb-0">

                                                @if (Auth::user()->can('course_add'))

                                                @php
                                                $course = DB::table('courses')->where('id', $id)->first();
                                                $class = DB::table('class_course')->where('course_id', $id)->count();                                       
                                                @endphp

                                                <li><span class="card-title"> Course name :- </span> <?= $course->title; ?> <br> <span class="card-title">  Total no. of classes :- </span> <?= $class; ?>    </li>
                                                <br>
                                                @endif

                                                
                                            </ul>
                                        </div>
									</div>
									<div class="col-6">
										<div class="d-flex justify-content-end">
											<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
											

											<div >

												<a data-action="expand"><i class="ft-maximize"></i></a>
											</div>
										</div>
										
									</div>
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
													<!-- <th>Course name</th> -->
													@endif

													<th>Sr. no.</th>
													<th>Student's name</th>
													<!--<th>Total no. of classes</th>-->
													<th>Class dates</th>
													<th>Classes attended</th>
													<th>Classes remaining </th>
													<th>View </th>

													@if(auth()->user()->hasRole('super admin') || auth()->user()->hasRole('admin') )

													@else
													@endif
												</tr>

											</thead>
											<tbody>
												
												@foreach ($categories as $category)
												
												<tr role="row" class="odd">
													<td class="sorting_1">{{ $category->id }}</td>
													@php 
													$totclass = DB::table('class_course')->count();  
													$usernam= DB::table('users')->where('id', $category->user_id)->first();
													@endphp
													<td>{{ $usernam->name }}</td> 
													<!--<td>{{ $totclass }}</td>-->

													@php $users = DB::table('attendence')->where('class_id', $id)->count(); @endphp
													<td>{{$category->created_at}}</td>
													<td>{{ $users }}</td>
													<td>{{ $totclass-$users }}</td>
													<td> <a href="" class="btn btn-secondary btn-sm Block">
														Attendence
													</a>
													<a href="" class="btn btn-secondary btn-sm Block">
														Payment details
													</a>
												</td>
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