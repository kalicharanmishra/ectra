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

										<li @if(request()->route()->getName() == "dashboard") class="active" @endif><a href="{{ route('dashboard') }}"><i class="fas fa-th"></i>My dashboard</a></li>

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

													<li class="breadcrumb-item active" aria-current="page">Dashboard</li>

												</ol>

											</nav>

										</div>

									</div>

								</div>

							</div> -->

							<!-- /Row -->

							
                            
							<div class="row">

								<!--<div class="col-lg-4 col-md-4 col-sm-4">-->
        <!--                            <div class="card">-->
        <!--                                <div class="card-header p-1">-->
        <!--                                    <h5 class="card-title float-left" style="text-align:center ;">Total transactions-->
        <!--                                    </h5>-->
        <!--                                </div>-->
        <!--                                                {{-- @dd(auth()->user()->id); --}}-->

        <!--                                <div class="col-md-3 col-12 border-right-blue-grey border-right-lighten-5 text-center">-->
        <!--                                    <p class="font-medium-5 text-bold-400">{{ DB::table('transaction')->where('subscriber_id', auth()->user()->id)->count();  }}</p>-->
        <!--                                </div>-->

        <!--                            </div>-->
        <!--                        </div>-->



                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <div class="card">
                                        <div class="card-header p-1">
                                            <h5 class="card-title float-left">Total courses</h5>
                                        </div>

                                        <div class="col-md-3 col-12 border-right-blue-grey border-right-lighten-5 text-center">
                                            <p class="font-medium-5 text-bold-400">{{ DB::table('course_enroll')->where('user_id', auth()->user()->id)->count();  }}</p>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <div class="card">
                                        <div class="card-header p-1">
                                            <h5 class="card-title float-left">Total Attendance</h5>
                                        </div>

                                        <div class="col-md-3 col-12 border-right-blue-grey border-right-lighten-5 text-center">
                                            <p class="font-medium-5 text-bold-400">{{ DB::table('attendence')->where('user_id', auth()->user()->id)->count();  }}</p>
                                        </div>
                                    </div>
                                </div>

								

										<!-- <div class="row">

											<div class="col-xl-6 col-lg-6 col-md-6 mb-4">

												<h6 class="m-0" style="text-align:center;">All transactions</h6>

											</div>

										

										

										

											<div class="col-xl-6 col-lg-6 col-md-6">

                                            <h6 class="m-0" style="text-align:center;"> All courses</h6>

											</div>


										

									</div> -->
									</div>

								</div>

								

								
							</div>
						</div>
					</div>
				</div>
			</section>
@endsection