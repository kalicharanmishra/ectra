@extends('front.layouts.app')



@section('content')









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

										<li @if(request()->route()->getName() == "front.manage_courses") class="active" @endif><a href="{{ route('front.manage_courses') }}" ><i class="fas fa-shopping-basket"></i>My Courses</a></li>





									

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

													<li class="breadcrumb-item"><a href="index.html">Home</a></li>

													<li class="breadcrumb-item active" aria-current="page">My Profile</li>

												</ol>

											</nav>

										</div>

									</div>

								</div>

							</div> -->

							<!-- /Row -->

							

							<div class="row">

								<div class="col-xl-7 col-lg-6 col-md-12">

									<div class="dashboard_wrap">

										

										<div class="row">

											<div class="col-xl-12 col-lg-12 col-md-12 mb-4">

												<h6 class="m-0">Basic Detail</h6>

											</div>

										</div>

										

										<div class="row justify-content-center">

											<div class="col-xl-12 col-lg-12 col-md-12">

												<form method="post" action="{{ route('front.profileUpdate') }}" >

													@csrf

													<input type="hidden" name="id" id="id" class="form-control" value="{{auth()->user()->id}}" />

													<div class="form-group smalls">

														<label>First Name*</label>

														<input type="text" name="fname" id="fname" class="form-control" value="{{auth()->user()->name}}" />

													</div>

													<!-- <div class="form-group smalls">

														<label>Last Name</label>

														<input type="text" name="lname" id="lname" class="form-control" value="Singh" />

													</div> -->

													<div class="form-group smalls">

														<label>Email</label>

														<input type="email" name="email" id="email" class="form-control" value="{{auth()->user()->email}}" />

													</div>

													<div class="form-group smalls">

														<label>Phone</label>

														<input type="text" name="phone" id="phone" class="form-control" value="{{auth()->user()->phone}}" />

													</div>

													<!-- <div class="form-group smalls">

														<label>About Yourself in Short</label>

														<textarea class="form-control" name="short_bio" id="short_bio" value="{{auth()->user()->short_bio}}"></textarea>

													</div>

													<div class="form-group smalls">

														<label>Biography</label>

														<textarea class="form-control summernote" name="bio" id="bio" value="{{auth()->user()->bio}}" ></textarea>

													</div> -->

													

													<div class="form-group smalls">

														<button class="btn theme-bg text-white" type="submit">Save Change</button>

													</div>

												</form>

											</div>

										</div>

										

									</div>

								</div>

								

								<div class="col-xl-5 col-lg-6 col-md-12">

									<div class="dashboard_wrap">

										

										<div class="row justify-content-center">

											<div class="col-xl-12 col-lg-12 col-md-12">

												<form>

													<div class="form-group smalls">

														<label>Current Password</label>

														<input type="password" class="form-control" />

													</div>

													<div class="form-group smalls">

														<label>New Password</label>

														<input type="password" class="form-control" />

													</div>

													<div class="form-group smalls">

														<label>Confirm Password</label>

														<input type="password" class="form-control" />

													</div>

													<div class="form-group smalls">

														<button class="btn theme-bg text-white" type="button">Save Change</button>

													</div>

												</form>

											</div>

										</div>

										

									</div>

								</div>

								

							</div>

							

							

						</div>

					

					</div>

					

				</div>

			</section>











































@endsection

