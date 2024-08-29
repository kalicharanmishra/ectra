@extends('front.layouts.app')



@section('content')

	<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" rel="stylesheet">

	<link href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">

	



<?php 

	$aid = Auth::user()->id;

	$enroll = App\Models\Course_enroll::where('user_id',$aid)->with('course','transaction')->get();

?>





<section class="gray pt-4">

				<div class="container-fluid">

										

					<div class="row">

					

						<div class="col-lg-3 col-md-3">

							<div class="dashboard-navbar">

								

								<div class="d-user-avater">

									<img src="/wepik-photo-mode-20221022-151229.png" class="img-fluid avater" alt="">

									<h4>{{Auth::user()->name}}</h4>

									<!-- <span>Senior Designer</span> -->

									

								</div>

								

								<div class="d-navigation">

										<ul id="side-menu">

											<li @if(request()->route()->getName() == "dashboard") class="active" @endif><a href="{{ route('dashboard') }}"><i class="fas fa-th"></i>Dashboard</a></li>

										<li @if(request()->route()->getName() == "front.profile") class="active" @endif><a href="{{ route('front.profile') }}"><i class="fas fa-address-card" ></i>My Profile</a></li>

										<li @if(request()->route()->getName() == "front.manage_courses") class="active" @endif><a href="{{ route('front.manage_courses') }}" ><i class="fas fa-shopping-basket"></i>My courses</a></li>





									

										<li class="dropdown">

											<!-- <li  @if(request()->route()->getName() == "front.my_transection") class="active" @endif><a  href="{{ route('front.my_transection') }}"><i class="fas fa-gem"></i>My Transections</a></li> -->

										

										</li>

									

									</ul>

								</div>

								

							</div>

						</div>

						

						<div class="col-lg-9 col-md-9 col-sm-12">

							

							<!-- Row -->

							<!-- <div class="row justify-content-between">

								<div class="col-lg-12 col-md-12 col-sm-12 pb-4">

									<div class="dashboard_wrap d-flex align-items-center justify-content-between">

										<div class="arion">

											<nav class="transparent">

												<ol class="breadcrumb">

													<li class="breadcrumb-item"><a href="#">Home</a></li>

													<li class="breadcrumb-item active" aria-current="page">Manage Courses</li>

												</ol>

											</nav>

										</div>

									</div>

								</div>

							</div> -->

							<!-- /Row -->

							

							<div class="row">

								<div class="col-xl-12 col-lg-12 col-md-12">

									<div class="dashboard_wrap">

										

										<div class="row">

											<div class="col-xl-12 col-lg-12 col-md-12 mb-4">

												<!--<h6 class="m-0">My Courses</h6>-->

											</div>

										</div>

										

										<!--<div class="row align-items-end mb-5">-->

										<!--	<div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">-->

										<!--		<div class="form-group">-->

										<!--			<label>Categories</label>-->

										<!--			<div class="smalls">-->

										<!--				<select id="cates" class="form-control">-->

										<!--					<option value="">&nbsp;</option>-->

										<!--					<option value="1">IT & Software</option>-->

										<!--					<option value="2">Banking</option>-->

										<!--					<option value="3">Medical</option>-->

										<!--					<option value="4">Insurence</option>-->

										<!--					<option value="5">Finance & Accounting</option>-->

										<!--				</select>-->

										<!--			</div>-->

										<!--		</div>-->

										<!--	</div>-->

										<!--	<div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">-->

										<!--		<div class="form-group">-->

										<!--			<label>Instructor</label>-->

										<!--			<div class="smalls">-->

										<!--				<select id="ins" class="form-control">-->

										<!--					<option value="">&nbsp;</option>-->

										<!--					<option value="1">Summer D. Friedel</option>-->

										<!--					<option value="2">Daniel D. Richards</option>-->

										<!--					<option value="3">Rosemary K. Delisle</option>-->

										<!--					<option value="4">Joseph S. Whetstone</option>-->

										<!--					<option value="5">Roger M. Gragg</option>-->

										<!--				</select>-->

										<!--			</div>-->

										<!--		</div>-->

										<!--	</div>-->

										<!--	<div class="col-xl-2 col-lg-4 col-md-6 col-sm-6">-->

										<!--		<div class="form-group">-->

										<!--			<label>Status</label>-->

										<!--			<div class="smalls">-->

										<!--				<select id="sts" class="form-control">-->

										<!--					<option value="">&nbsp;</option>-->

										<!--					<option value="1">Active</option>-->

										<!--					<option value="2">Incoming</option>-->

										<!--					<option value="3">Expired</option>-->

										<!--				</select>-->

										<!--			</div>-->

										<!--		</div>-->

										<!--	</div>-->

										<!--	<div class="col-xl-2 col-lg-4 col-md-6 col-sm-6">-->

										<!--		<div class="form-group">-->

										<!--			<label>Price</label>-->

										<!--			<div class="smalls">-->

										<!--				<select id="prc" class="form-control">-->

										<!--					<option value="">&nbsp;</option>-->

										<!--					<option value="1">All</option>-->

										<!--					<option value="2">Free</option>-->

										<!--					<option value="3">Paid</option>-->

										<!--				</select>-->

										<!--			</div>-->

										<!--		</div>-->

										<!--	</div>-->

										<!--	<div class="col-xl-2 col-lg-4 col-md-6 col-sm-6">-->

										<!--		<div class="form-group">-->

										<!--			<button type="button" class="btn text-white full-width theme-bg">Filter</button>-->

										<!--		</div>-->

										<!--	</div>-->

										<!--</div>-->

										

							

										

										<div class="row">

											<div class="col-xl-12 col-lg-12 col-md-12 mb-2">

												<div class="table-responsive">

													<table class="table " id="">

														<thead>

															<tr>

																<th scope="col">#</th>
																
																<th scope="col">Title</th>

																<th scope="col">Category</th>

																<th scope="col">Lectures</th>

																<th scope="col">Enrolled</th>

																<th scope="col">Status</th>

																<th scope="col">Fees</th>

																<th scope="col">Action</th>

															</tr>

														</thead>

														<tbody>
															@php $i=1; @endphp
                                                            @foreach($enroll as $enrolls)

															<tr>

																<td scope="row">{{$i}}</td>

                                                      

																<td><h6>{{ $enrolls->course->title }}</h6>

                                                                <p>Instructor:<span>{{ $enrolls->course->slug }}</span></p></td>





                                                                <?php $category = App\Models\Categories::where('id',$enrolls->course->category)->first(); ?>

																

																<td><div class="dhs_tags">{{$category->name}}</div></td>



																<?php 	$councirc = App\Models\Circullum::where('course_id',$enrolls->course_id)->count(); ?>

																<td><div class="smalls">{{ $councirc }} Lectures</div></td>



																<?php 	$coun = App\Models\Course_enroll::where('course_id',$enrolls->course_id)->count(); ?>

																<td><span class="smalls">Total: {{ $coun }}</span></td>



																<td><span class="trip theme-cl theme-bg-light">Active</span></td>

                                                                

																<td><span class="trip theme-cl theme-bg-light">{{ $enrolls->course->price }}</span></td>

                                                                

																<td>

																    	<a class="dropdown-item" href="{{ route('front.course_cir_detail',$enrolls->course->slug) }}">View</a>

																	<!--<div class="dropdown show">-->

																	<!--	<a class="btn btn-action" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->

																	<!--		<i class="fas fa-ellipsis-h"></i>-->

																	<!--	</a>-->

																	<!--	<div class="drp-select dropdown-menu">-->

																	<!--		<a class="dropdown-item" href="{{ route('front.course_cir_detail',$enrolls->course->slug) }}">View</a>-->

																	<!--		<a class="dropdown-item" href="JavaScript:Void(0);">Edit</a>-->

																	<!--		<a class="dropdown-item" href="JavaScript:Void(0);">Delete</a>-->

																	<!--	</div>-->

																	<!--</div>-->

																</td>

															</tr>
															@php $i++; @endphp
                                                            @endforeach
															
														</tbody>

													</table>

												</div>

											</div>

										</div>

										

										<!--<div class="row align-items-center justify-content-between">-->

										<!--	<div class="col-xl-6 col-lg-6 col-md-12">-->

										<!--		<p class="p-0" style="background-color:#fff">Showing 1 to 15 of 15 entire</p>-->

										<!--	</div>-->

										<!--	<div class="col-xl-6 col-lg-6 col-md-12">-->

										<!--		<nav class="float-right">-->

										<!--			 <ul class="pagination smalls m-0">-->

										<!--				<li class="page-item disabled">-->

										<!--				  <a class="page-link" href="#" tabindex="-1"><i class="fas fa-arrow-circle-left"></i></a>-->

										<!--				</li>-->

										<!--				<li class="page-item"><a class="page-link" href="#">1</a></li>-->

										<!--				<li class="page-item active">-->

										<!--				  <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>-->

										<!--				</li>-->

										<!--				<li class="page-item"><a class="page-link" href="#">3</a></li>-->

										<!--				<li class="page-item">-->

										<!--				  <a class="page-link" href="#"><i class="fas fa-arrow-circle-right"></i></a>-->

										<!--				</li>-->

										<!--			</ul>-->

										<!--		</nav>-->

										<!--	</div>-->

										<!--</div>-->

										

									</div>

								</div>

							</div>

							
						</div>

					
					</div>

				</div>

			</section>




	<script src="https://code.jquery.com/jquery-3.5.1.js" type="text/javascript"></script>

	<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js" type="text/javascript"></script>

	<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>

	<script>

	  $(document).ready(function () {

	        $.noConflict();

    $('#example').DataTable({

       

    });

});

	</script>

@endsection