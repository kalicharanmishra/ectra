@extends('front.layouts.app')



@section('content')

			<!-- ============================================================== -->

			<section class="bg-instr_detail">

			<!-- ============================ Page Title Start================================== -->

			<div class="ed_detail_head">

				<div class="container">

					<div class="row align-items-center mb-5">

						<div class="col-lg-3 col-md-12 col-sm-12">

							<div class="authi_125">

								<div class="authi_125_thumb" data-toggle="modal" data-target="#video_preview" onclick="show_prev('{{ Storage::url($teacher->teacher_profile['intro_video']) }}')">

									<img src="{{Storage::url($teacher->avtars)}}" class="img-fluid rounded" alt="" style="width:100%;max-height: 200px;" onerror="this.src='/thrill/v1/icon/teacher2.png'"/>

								</div>

								<a href="#" class="klio_45"><div class="lklo_45"><i class="fas fa-play"></i></div><h6>Preview</h6></a>

							</div>

						</div>

						

						<div class="col-lg-9 col-md-12 col-sm-12">

							<div class="dlkio_452">

								<div class="ed_detail_wrap">

								@foreach(json_decode($teacher->teacher_profile['tag']) as $key_hashtags=>$item)<div class="crs_cates cl_{{$key_hashtags}}"><span>{{$item}}</span></div>@endforeach

									<div class="ed_header_caption">

										<h2 class="ed_title">{{$teacher->name.' '.$teacher->name}}</h2>

										<ul>

											<li><i class="ti-video-camera"></i>{{count($teacher->courses)}}</li>

											<li><i class="ti-user"></i>Exp. {{$teacher->teacher_profile['experence']}} Year</li>

											<!-- <li><i class="ti-user"></i>502 Student Enrolled</li> -->

										</ul>

									</div>

									<div class="ed_header_short">

										<p class="course_short_desc">{{$teacher->teacher_profile['intro_text']}} </p>

									</div>

									

									<!-- <div class="ed_rate_info">

										<div class="star_info">

											<i class="fas fa-star filled"></i>

											<i class="fas fa-star filled"></i>

											<i class="fas fa-star filled"></i>

											<i class="fas fa-star filled"></i>

											<i class="fas fa-star"></i>

										</div>

										<div class="review_counter">

											<strong class="high">4.7</strong> 3572 Reviews

										</div>

									</div> -->

									

								</div>

								<!-- <div class="dlkio_last">

									<div class="ed_view_link">

										<a href="#" class="btn theme-bg enroll-btn">Get Membership<i class="ti-angle-right"></i></a>

										<a href="#" class="btn theme-border enroll-btn">Share<i class="fas fa-share"></i></a>

									</div>

								</div> -->

							</div>

						</div>

					</div>

				</div>

			</div>

			<!-- ============================ Page Title End ================================== -->

			

			<!-- ============================ Course Detail ================================== -->

			<section class="grayy">

				<div class="container">

					

					<div class="row justify-content-center">

					

						<!-- Single Grid -->

						@foreach($teacher->courses as $item)

						<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">

							

							<div class="crs_grid" >

								

								<div class="crs_grid_thumb">

									<div  class="crs_detail_link" >

									<a href="{{ route('front.course_detail',$item->slug) }}">

										<img src="{{Storage::url($item->video_thumbnail)}}" class="img-fluid rounded" style="width: 100%; max-height: 230px;" alt="" />

									</a>

</div>

									<div class="crs_video_ico" title="Preview" data-toggle="modal" data-target="#video_preview" onclick="show_prev('{{ Storage::url($item->video) }}')">

										<i class="fa fa-play"></i>

									</div>

									

									<div class="crs_locked_ico" >

										@if($item->start_date> \Carbon\Carbon::now())<i class="fa fa-lock " title="Session Not Start"></i> @else <i class="fa fa-lock-open text-success" title="Session Start"></i> @endif

									</div>

								</div>

								<div class="crs_grid_caption">

									<div class="crs_flex">

										<div class="crs_fl_first">

										@foreach(json_decode($item->hashtags) as $key_hashtags=>$item1)<div class="crs_cates cl_{{$key_hashtags}}"><span>{{$item1}}</span></div>@endforeach

										</div>

										<div class="crs_fl_last">

											<div class="crs_inrolled"><strong>{{$item->course_enroll_student_count}}</strong>Enrolled</div>

										</div>

									</div>

									

									<div class="crs_title"><h4><a href="{{ route('front.course_detail',$item->slug) }}" class="crs_title_link">{{$item->title}}</a></h4></div>

									<div class="crs_info_detail">

										<ul>

										<li><i class="fa fa-video text-success" ></i><span>{{$item->total_class}} Session</span></li>

										<li title="Certificate"><i class="fa fa-certificate"></i><span>@if($item->is_certification) Certificate Available @else No Certificate @endif</span></li>

											<li><i class="fa fa-signal text-warning"></i><span>{{$item->skill_level}}</span></li>

										</ul>

									</div>

								</div>

								<div class="crs_grid_foot">

									<div class="crs_flex">

										<div class="crs_fl_first">

											<div class="crs_tutor">

												<div class="crs_tutor_thumb">Price</div>

											</div>

										</div>

										<div class="crs_fl_last">

											<div class="crs_price"><h2><span class="currency">₹</span><span class="theme-cl">{{$item->price}}</span></h2></div>

										</div>

									</div>

								</div>

							</div>

							

						</div>

						@endforeach

						

					</div>

					

					<!-- <div class="row justify-content-center">

						<div class="col-lg-7 col-md-8 mt-2">

							<div class="text-center"><a href="grid-layout-with-sidebar.html" class="btn btn-md theme-bg-light theme-cl">Load More Cources</a></div>

						</div>

					</div> -->

					

				</div>

			</section>

			<!-- ============================ Course Detail ================================== -->

		</section>

			<!-- ============================ Call To Action ================================== -->

			@endsection