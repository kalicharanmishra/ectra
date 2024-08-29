@extends('front.layouts.app')

@section('content')
			<!-- ============================================================== -->
			<section class="instructor-bg">
			<!-- ============================ Page Title Start================================== -->
			<section class="page-title">
				<div class="container">
					<div class="row">
						<div class="col-lg-12 col-md-12">
							
							<div class="breadcrumbs-wrap">
								<h1 class="breadcrumb-title">Instructor with Full Width</h1>
								<nav aria-label="breadcrumb">
									<ol class="breadcrumbb">
										<li class="breadcrumb-item"><a href="#">Home</a></li>
										<li class="breadcrumb-item active theme-cl" aria-current="page">Find Courses</li>
									</ol>
								</nav>
							</div>
							
						</div>
					</div>
				</div>
			</section>
			<!-- ============================ Page Title End ================================== -->
			
			<!-- ============================ Course Detail ================================== -->
			<section class="grayy">
				<div class="container">
					<div class="row">
					
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="short_wraping">
								<div class="row m-0 align-items-center justify-content-between">
								
									<div class="col-lg-4 col-md-5 col-sm-12  col-sm-6">
										<div class="shorting_pagination_laft">
											<h6 class="m-0">Showing 1-25 of 72</h6>
										</div>
									</div>
							
									<div class="col-lg-8 col-md-7 col-sm-12 col-sm-6">
										<div class="dlks_152">
											<div class="shorting-right mr-2">
												<label>Short By:</label>
												<div class="dropdown show">
													<a class="btn btn-filter dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
														<span class="selection">Most Rated</span>
													</a>
													<div class="drp-select dropdown-menu">
														<a class="dropdown-item" href="JavaScript:Void(0);">Most Rated</a>
														<a class="dropdown-item" href="JavaScript:Void(0);">Most Viewd</a>
														<a class="dropdown-item" href="JavaScript:Void(0);">News Listings</a>
														<a class="dropdown-item" href="JavaScript:Void(0);">High Rated</a>
													</div>
												</div>
											</div>
											<div class="lmk_485">
												<ul class="shorting_grid">
													<li class="list-inline-item"><a href=""><span class="ti-layout-grid2"></span></a></li>
													<li class="list-inline-item"><a href="" class="active"><span class="ti-view-list"></span></a></li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					
					</div>
					
					<div class="row justify-content-center">
						
						<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
							<div class="crs_grid_list">
								
								<div class="crs_grid_list_thumb">
									<a href="{{ route('front.course_detail') }}"><img src="{{asset('front/assets/img/instructor_img.png') }}" class="img-fluid rounded" alt=""></a>
								</div>
								
								<div class="crs_grid_list_caption">
									<div class="crs_lt_102">
										<h4 class="crs_tit"><a href="">Deepak Choudhary</a></h4>	
									</div>
									<div class="crs_lt_101">
										<span class="est st_6">Hindustani Classical</span>
										<span class="est st_2">Hindustani Classical</span>
										<span class="est st_3">Hindustani Classical</span>
										<span class="est st_4">Hindustani Classical</span>
									</div>
									<div>
										<p class="instr_desc">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Recusandae ipsa adipisci hic eum harum corrupti. Rerum, dolorum quo dolores distinctio ex tempore voluptatum, modi eum accusantium aliquid quos cupiditate ab!</p>
									</div>
									
								</div>
								
							</div>
						</div>
						<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
							<div class="crs_grid_list">
								
								<div class="crs_grid_list_thumb">
									<a href="{{ route('front.course_detail') }}"><img src="{{asset('front/assets/img/instructor_img.png') }}" class="img-fluid rounded" alt=""></a>
								</div>
								
								<div class="crs_grid_list_caption">
									
									<div class="crs_lt_102">
										<h4 class="crs_tit"><a href="">Akash Choudhary</a></h4>										
									</div>
									<div class="crs_lt_101">
										<span class="est st_6">Western Classical</span>
										<span class="est st_2">Bollywood Classical</span>
										<span class="est st_3">Bollywood Light</span>
										<span class="est st_4">Western Light</span>
								
									</div>
									<div>
										<p class="instr_desc">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Recusandae ipsa adipisci hic eum harum corrupti. Rerum, dolorum quo dolores distinctio ex tempore voluptatum, modi eum accusantium aliquid quos cupiditate ab!</p>
									</div>
									
								</div>
								
							</div>
						</div>
						
						<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
							<div class="crs_grid_list">
								
								<div class="crs_grid_list_thumb">
									<a href="{{ route('front.course_detail') }}"><img src="{{asset('front/assets/img/instructor_img.png') }}" class="img-fluid rounded" alt=""></a>
								</div>
								
								<div class="crs_grid_list_caption">
									
									<div class="crs_lt_102">
										<h4 class="crs_tit">Vishnu Mehta</h4>
										
									</div>
									<div class="crs_lt_101">
										<span class="est st_6">Carnatic Classical</span>
										<span class="est st_2">Chaturanga</span>
										<span class="est st_3">Ragasagar Classical</span>
										<span class="est st_4">Karnatak Classical</span>
									</div>
									<div>
										<p class="instr_desc">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Recusandae ipsa adipisci hic eum harum corrupti. Rerum, dolorum quo dolores distinctio ex tempore voluptatum, modi eum accusantium aliquid quos cupiditate ab!</p>
									</div>
								</div>
							</div>
						</div>
						
						<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
							<div class="crs_grid_list">
								
								<div class="crs_grid_list_thumb">
									<a href="{{ route('front.course_detail') }}"><img src="{{asset('front/assets/img/instructor_img.png') }}" class="img-fluid rounded" alt=""></a>
								</div>
								
								<div class="crs_grid_list_caption">
									
									<div class="crs_lt_102">
										<h4 class="crs_tit">Abhishek </h4>										
									</div>
									<div class="crs_lt_101">
										<span class="est st_6">Opera and Classical</span>
										<span class="est st_2">Khayal and Thumri</span>
										<span class="est st_3">Blues and Jazz</span>
										<span class="est st_4">Pop</span>
									</div>
									<div>
										<p class="instr_desc">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Recusandae ipsa adipisci hic eum harum corrupti. Rerum, dolorum quo dolores distinctio ex tempore voluptatum, modi eum accusantium aliquid quos cupiditate ab!</p>
									</div>
								</div>
								
							</div>
						</div>
						
						<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
							<div class="crs_grid_list">
								
								<div class="crs_grid_list_thumb">
									<a href="{{ route('front.course_detail') }}"><img src="{{asset('front/assets/img/instructor_img.png') }}" class="img-fluid rounded" alt=""></a>
								</div>
								
								<div class="crs_grid_list_caption">
									
									<div class="crs_lt_102">
										<h4 class="crs_tit">Aadil Khan</h4>
										
									</div>
									<div class="crs_lt_101">
										<span class="est st_6">Western Classical</span>
										<span class="est st_2">Bollywood Classical</span>
										<span class="est st_3">Hindustani Classical</span>
										<span class="est st_4">Hindustani Classical</span>
									</div>
									<div>
										<p class="instr_desc">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Recusandae ipsa adipisci hic eum harum corrupti. Rerum, dolorum quo dolores distinctio ex tempore voluptatum, modi eum accusantium aliquid quos cupiditate ab!</p>
									</div>
								</div>
								
							</div>
						</div>
						
						<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
							<div class="crs_grid_list">
								
								<div class="crs_grid_list_thumb">
									<a href="{{ route('front.course_detail') }}"><img src="{{asset('front/assets/img/instructor_img.png') }}" class="img-fluid rounded" alt=""></a>
								</div>
								
								<div class="crs_grid_list_caption">
									
									<div class="crs_lt_102">
										<h4 class="crs_tit">Sharwan Choudhary</h4>
										
									</div>
									<div class="crs_lt_101">
										<span class="est st_6">Western Classical</span>
										<span class="est st_2">Bollywood Classical</span>
										<span class="est st_3">Hindustani Classical</span>
										<span class="est st_4">Hindustani Classical</span>
									</div>
									<div>
										<p class="instr_desc">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Recusandae ipsa adipisci hic eum harum corrupti. Rerum, dolorum quo dolores distinctio ex tempore voluptatum, modi eum accusantium aliquid quos cupiditate ab!</p>
									</div>
								</div>
								
							</div>
						</div>
						
						<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
							<div class="crs_grid_list">
								
								<div class="crs_grid_list_thumb">
									<a href="{{ route('front.course_detail') }}"><img src="{{asset('front/assets/img/instructor_img.png') }}" class="img-fluid rounded" alt=""></a>
								</div>
								
								<div class="crs_grid_list_caption">
									
									<div class="crs_lt_102">
										<h4 class="crs_tit">Mahesh Mehta</h4>
										
									</div>
									<div class="crs_lt_101">
										<span class="est st_6">Western Classical</span>
										<span class="est st_2">Bollywood Classical</span>
										<span class="est st_3">Hindustani Classical</span>
										<span class="est st_4">Hindustani Classical</span>
									</div>
									<div>
										<p class="instr_desc">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Recusandae ipsa adipisci hic eum harum corrupti. Rerum, dolorum quo dolores distinctio ex tempore voluptatum, modi eum accusantium aliquid quos cupiditate ab!</p>
									</div>
								</div>
								
							</div>
						</div>
						<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
							<div class="crs_grid_list">
								
								<div class="crs_grid_list_thumb">
									<a href="{{ route('front.course_detail') }}"><img src="{{asset('front/assets/img/instructor_img.png') }}" class="img-fluid rounded" alt=""></a>
								</div>
								
								<div class="crs_grid_list_caption">
									
									<div class="crs_lt_102">
										<h4 class="crs_tit">Suraj Jat</h4>
										
									</div>
									<div class="crs_lt_101">
										<span class="est st_6">Western Classical</span>
										<span class="est st_2">Bollywood Classical</span>
										<span class="est st_3">Hindustani Classical</span>
										<span class="est st_4">Hindustani Classical</span>
									</div>
									<div>
										<p class="instr_desc">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Recusandae ipsa adipisci hic eum harum corrupti. Rerum, dolorum quo dolores distinctio ex tempore voluptatum, modi eum accusantium aliquid quos cupiditate ab!</p>
									</div>
								</div>
								
							</div>
						</div>
					
					</div>
			
					<!-- Pagination -->
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12">
							<ul class="pagination p-center">
								<li class="page-item">
								  <a class="page-link" href="#" aria-label="Previous">
									<span class="ti-arrow-left"></span>
									<span class="sr-only">Previous</span>
								  </a>
								</li>
								<li class="page-item active"><a class="page-link" href="#">1</a></li>
								<li class="page-item"><a class="page-link" href="#">2</a></li>
								<li class="page-item"><a class="page-link" href="#">3</a></li>
								<li class="page-item"><a class="page-link" href="#">...</a></li>
								<li class="page-item"><a class="page-link" href="#">18</a></li>
								<li class="page-item">
								  <a class="page-link" href="#" aria-label="Next">
									<span class="ti-arrow-right"></span>
									<span class="sr-only">Next</span>
								  </a>
								</li>
							</ul>
						</div>
					</div>
						
				</div>
			</section>
			<!-- ============================ Course Detail ================================== -->
		</section>
			@endsection