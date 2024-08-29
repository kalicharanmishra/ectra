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
						<h4 class='breadcrumbs'> Manage courses / My Courses / Trial pay student</h4>
					</div>

					<div class="col-lg-12 col-md-12">
						<div class="card">
							<div class="card-header" style="padding-bottom: 0; padding:30px">
								<div class="row">
									<div class="col-6">
										<h4 class="card-title">@if (Auth::user()->can('course_add')) Students @else Courses list @endif</h4>

                                        <div class="">
                                            <ul class="list-inline mb-0">

                                              {{--  @if (Auth::user()->can('course_add'))

                                                @php
                                                $course = DB::table('courses')->where('id', $id)->first();
                                                $class = DB::table('class_course')->where('course_id', $id)->count();                                       
                                                @endphp

                                                <li><span class="card-title"> Course name :- </span> <?= $course->title; ?> <br> <span class="card-title">  Total no. of classes :- </span> <?= $class; ?>    </li>
                                                <br>
                                                @endif--}}
                                                
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
													

													<th>Sr. no.</th>
													<th>Student's name</th>
													<!--<th>Total no. of classes</th>-->
													<th>trial dates</th>
													<!-- <th>Classes attended</th>
													<th>Classes remaining </th>
													<th>View </th> -->

						
												</tr>

											</thead>
											<tbody>
                                                @if(!empty($users && $trial_payy))
												
												@foreach ($trial_payy as $trial_payy)
												
												<tr role="row" class="odd">
                                                    
                                                <td>{{ $trial_payy->id }}</td>
                                                <td>{{$users[0]->name}}</td>
												<td>{{$trial_payy->created_at}}</td>
												
											</tr>

											@endforeach
                                            @endif

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