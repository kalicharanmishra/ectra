@extends('front.layouts.app')



@section('content')

@auth

<?php

$auid = Auth::user()->id;

$enrolled = DB::table('course_enroll')->where('course_id',$course->id)->where('user_id', $auid)->first();



?>

@endauth

<!-- ============================================================== -->



<!-- ============================ Page Title Start================================== -->

<div class="ed_detail_head bg-cover" style="background:white url({{ asset('front/assets/img/course_backimg.png') }})" data-overlay="8">

	<div class="container">

		<div class="row align-items-center">

			

			<div class="col-lg-8 col-md-8">

				<div class="ed_detail_wrap light">

					@foreach(json_decode($course->hashtags) as $key_hashtags=>$item)<div class="crs_cates cl_{{$key_hashtags}}"><span>{{$item}}</span></div>@endforeach

					<div class="ed_header_caption">

						<h2 class="ed_title">{{$course->title}}</h2>

						<ul>

							<li><i class="ti-calendar"></i>{{$course->is_certification}}</li>

							<li><i class="ti-control-forward"></i>{{$course->total_class}} Session</li>

							<li><i class="ti-user"></i>{{$course->course_enroll_student_count}} Student Enrolled</li>

						</ul>

					</div>

					{{-- <div class="ed_header_short">

						<p class="course_short_desc">{{$course->short_desc}}</p>

					</div> --}}

					

					<div class="ed_rate_info">

						<div class="star_info">

							@for($i=0; $i<5; $i++)

							<i class="fas  fa-star @if($course->retting > $i+1) filled @elseif($course->retting >= $i+0.5)filled fa-star-half-alt  @endif"></i>

							

							@endfor

						</div>

						<div class="review_counter">

							<strong class="high">{{$course->retting}}</strong> {{count($course->course_comments)}} Comment or Review

						</div>

					</div>

					

				</div>

			</div>
			<!-- Sidebar -->

			<div class="col-lg-4 col-md-12  order-lg-last">

				

				<!-- Course info -->

				<div class="ed_view_box style_3 ovrlio stick_top">

					

					{{-- <div class="property_video sm">

						<div class="thumb">

							<img class="pro_img img-fluid w100" src="{{ Storage::url($course->video_thumbnail) }}" alt="7.jpg">

							<div class="overlay_icon">

								<div class="bb-video-box">

									<div class="bb-video-box-inner">

										<div class="bb-video-box-innerup">

											<div data-toggle="modal" data-target="#video_preview" onclick="show_prev('{{ Storage::url($course->video) }}','{{ Storage::url($course->video_thumbnail) }}')" class="theme-cl"><i class="ti-control-play"></i></div>

										</div>

									</div>

								</div>

							</div>

						</div>

					</div> --}}
					<div class="courses_boxes_table">
						<table>
							<tbody>
								<tr>
									<td>Teaching since</td>
									<td>30 Years</td>
								</tr>
								<tr>
									<td>Classes held on</td>
									<td>Mon, Wed, Fri</td>
								</tr>
								<tr>
									<td>Class timings</td>
									<td>4 pm to 5 pm</td>
								</tr>
								<tr>
									<td>Course duration</td>
									<td>1 month</td>
								</tr>
								<tr>
									<td>Course fees</td>
									<td>Rs. 6000/-</td>
								</tr>
								<tr>
									<td>Trial class fees</td>
									<td>Rs. 50/-</td>
								</tr>
							</tbody>

						</table>
					</div>
					

					{{-- <div class="ed_view_price pl-4">

						<span>Acctual Price</span>

						<h2 class="theme-cl"> {{$course->price_type == 'Free'?'Free':'₹ '. $course->price}}</h2>

					</div> --}}

					

					<div class="ed_view_short pl-4 pr-4 pb-2">

						<!--<p>Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore.</p>-->

					</div>

					

					<div class="ed_view_features half_list pl-4 pr-3">

						<!--<span>Course Features</span>-->

						<ul>

							<!--<li><i class="ti-user"></i>3k Students View</li>-->

							<!--<li><i class="ti-time"></i>2 hour 30 min</li>-->

							<!--<li><i class="ti-bar-chart-alt"></i>Principiante</li>-->

							<!--<li><i class="ti-cup"></i>04 Certified</li>-->

						</ul>

					</div>

					<div class="ed_view_link">



						<!--<a href="#" class="btn theme-light enroll-btn">Get Membership<i class="ti-angle-right"></i></a>-->

						@auth

						@if( !DB::table('course_enroll')->where('course_id',$course->id)->where('user_id', Auth::user()->id)->first() )

						<a href="/course/{{ $course->title }}/enroll" target="_blank" class="btn theme-bg enroll-btn">Enroll Now<i class="ti-angle-right"></i></a>

						

						@else

						<a href="/course/{{$course->slug}}/circullum" class="btn theme-bg enroll-btn">Check Subscription<i class="ti-angle-right"></i></a>

						

						@endif

						@else

						<a href="#" class="btn theme-light enroll-btn" data-toggle="modal" data-target="#login">

							<i class="fas fa-sign-in-alt mr-1"></i><span class="dn-lg">Sign In For Enroll</span>

						</a>

						@endauth

					</div>

					

				</div>

			</div>

		</div>

	</div>

</div>

<!-- ============================ Page Title End ================================== -->



<section class="all-bg-course-det">

	<!-- ============================ Course Detail ================================== -->

	<section class=" pt-3">

		<div class="container">

			<div class="row justify-content-between">

				

				<div class="col-lg-12 col-md-12 order-lg-first">

					

					<!-- All Info Show in Tab -->

					<div class="tab_box_info mt-4">

						<ul class="nav nav-pills mb-3 light" id="pills-tab" role="tablist">

							<li class="nav-item">

								<a class="nav-link active" id="overview-tab" data-toggle="pill" href="#overview" role="tab" aria-controls="overview" aria-selected="true">Overview</a>

							</li>

							<li class="nav-item">

								<a class="nav-link" id="curriculum-tab" data-toggle="pill" href="#curriculum" role="tab" aria-controls="curriculum" aria-selected="false">Curriculum</a>

							</li>

							<li class="nav-item">

								<a class="nav-link" id="instructors-tab" data-toggle="pill" href="#instructors" role="tab" aria-controls="instructors" aria-selected="false">Instructor</a>

							</li>

							<li class="nav-item">

								<a class="nav-link" id="reviews-tab" data-toggle="pill" href="#reviews" role="tab" aria-controls="reviews" aria-selected="false">Reviews</a>

							</li>

							<li class="nav-item">

								<a class="nav-link" id="demo-video-tab" data-toggle="pill" href="#demo_video" role="tab" aria-controls="demo_video" aria-selected="false">Demo Video</a>

							</li>

						</ul>

						

						<div class="tab-content" id="pills-tabContent">

							

							<!-- Overview Detail -->

							<div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">

								<!-- Overview -->

								<div class="edu_wraper">

									<h4 class="edu_title">Course Overview</h4>

									<p class="course_short_desc">{!! $course->description !!}</p>

									

								</div>

								

										<!-- <div class="edu_wraper">

											<h4 class="edu_title">Certification</h4>

											<p>The ICC Training and Education programme was launched in 2021 and is designed to provide educational resources and training opportunities through ICC-certified pathways to develop more coaches, umpires, scorers and pitch curators around the world.



												In partnership with Members, the ICC is committed to delivering a full range of courses to those interested in starting or furthering their cricket journey.</p>

											</div> -->

											

											<!-- Overview -->

										<!-- <div class="edu_wraper">

											<h4 class="edu_title">What you'll learn</h4>

											<ul class="lists-3 row">

												<li class="col-xl-4 col-lg-6 col-md-6 m-0">At Batting </li>

												<li class="col-xl-4 col-lg-6 col-md-6 m-0">At bowling</li>

												<li class="col-xl-4 col-lg-6 col-md-6 m-0">At fielding </li>

												<li class="col-xl-4 col-lg-6 col-md-6 m-0">At catching</li>

												<li class="col-xl-4 col-lg-6 col-md-6 m-0">At keeping</li>

												<li class="col-xl-4 col-lg-6 col-md-6 m-0">At spin bowling</li>

												<li class="col-xl-4 col-lg-6 col-md-6 m-0">At fast bowling</li>

												

											</ul>

										</div> -->

									</div>

									

									<!-- Curriculum Detail -->

									<div class="tab-pane fade" id="curriculum" role="tabpanel" aria-labelledby="curriculum-tab">

										<div class="edu_wraper">

											<h4 class="edu_title">Course Circullum</h4>

											<div id="accordionExample" class="accordion shadow circullum">

												@if($course->id)

												@foreach(\App\Models\Circullum::where('course_id',$course->id)->with('circullum_topic')->get()->toArray() as $key=>$item)

												<!-- Part 1 -->

												<div class="card">

													

													<div id="heading{{$key}}" class="card-header bg-white shadow-sm border-0">

														<h6 class="mb-0 accordion_title"><a href="#" data-toggle="collapse" data-target="#collapse{{$key}}" @if($key == 0) aria-expanded="true" @else aria-expanded="false" @endif aria-controls="collapse{{$key}}" class="d-block position-relative  text-dark collapsible-link py-2">{{$item['title']}}</a></h6>

													</div>

													<div id="collapse{{$key}}" aria-labelledby="heading{{$key}}" data-parent="#accordionExample" class="collapse show">

														<div class="card-body pl-3 pr-3">

															<ul class="lectures_lists">

																@if($item['circullum_topic'])

																@foreach($item['circullum_topic'] as $circullum_topic)

																<li class="@if($circullum_topic['is_complete'] == 0) unview @elseif($circullum_topic['is_complete'] == 1) progressing @else complete @endif"><div class="lectures_lists_title">

																	<i class="fas @if($circullum_topic['is_complete'] == 0) fa-lock lock @elseif($circullum_topic['is_complete'] == 1) fa-play @else fa-check @endif dios"></i>

																</div>{{$circullum_topic['topic']}}<span class="cls_timing_date">{{$circullum_topic['cover_time']}}</span><span class="cls_timing">{{$circullum_topic['class_url']}}</span></li>

																@endforeach

																@endif

															</ul>

														</div>

													</div>

												</div>

												@endforeach

												@endif

												



											</div>

										</div>

									</div>

									

									<!-- Instructor Detail -->

									<div class="tab-pane fade" id="instructors" role="tabpanel" aria-labelledby="instructors-tab">

										<div class="single_instructor">

											<div class="single_instructor_thumb">

												<a href="{{route('front.instructor_detail',[\Crypt::encrypt($course->course_owner['id']),$course->course_owner['name']])}}"><img src="{{Storage::url($course->course_owner['avtars'])}}" class="img-fluid" alt=""  onerror="this.src='/thrill/v1/icon/teacher2.png'"></a>

											</div>

											

											<div class="single_instructor_caption">

												<h4><a href="{{route('front.instructor_detail',[\Crypt::encrypt($course->course_owner['id']),$course->course_owner['name']])}}">{{$course->course_owner['name']}}</a></h4>

												<ul class="instructor_info">

													<li><i class="ti-video-camera"></i>{{$course->course_owner['courses_count']? $course->course_owner['courses_count'] : 0}} Course</li>

													<li><i class="ti-control-forward"></i>{{$course->course_owner['teacher_sessions_count']? $course->course_owner['teacher_sessions_count'] : 0}} Session</li>

													<li><i class="ti-user"></i>Exp. {{$course->course_owner['teacher_profile']['experence']}} Year</li>

												</ul>

												<p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi.</p>

												<!-- <ul class="social_info">

													<li><a href="#"><i class="ti-facebook"></i></a></li>

													<li><a href="#"><i class="ti-twitter"></i></a></li>

													<li><a href="#"><i class="ti-linkedin"></i></a></li>

													<li><a href="#"><i class="ti-instagram"></i></a></li>

												</ul> -->

											</div>

										</div>

									</div>

									

									<!-- Reviews Detail -->

									<div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">

										

										<!-- Overall Reviews -->

										<!-- <div class="rating-overview">

											<div class="rating-overview-box">

												<span class="rating-overview-box-total">4.2</span>

												<span class="rating-overview-box-percent">out of 5.0</span>

												<div class="star-rating" data-rating="5"><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i>

												</div>

											</div>



											<div class="rating-bars">

												<div class="rating-bars-item">

													<span class="rating-bars-name">5 Star</span>

													<span class="rating-bars-inner">

														<span class="rating-bars-rating high" data-rating="4.7">

															<span class="rating-bars-rating-inner" style="width: 85%;"></span>

														</span>

														<strong>85%</strong>

													</span>

												</div>

												<div class="rating-bars-item">

													<span class="rating-bars-name">4 Star</span>

													<span class="rating-bars-inner">

														<span class="rating-bars-rating good" data-rating="3.9">

															<span class="rating-bars-rating-inner" style="width: 75%;"></span>

														</span>

														<strong>75%</strong>

													</span>

												</div>

												<div class="rating-bars-item">

													<span class="rating-bars-name">3 Star</span>

													<span class="rating-bars-inner">

														<span class="rating-bars-rating mid" data-rating="3.2">

															<span class="rating-bars-rating-inner" style="width: 52.2%;"></span>

														</span>

														<strong>53%</strong>

													</span>

												</div>

												<div class="rating-bars-item">

													<span class="rating-bars-name">1 Star</span>

													<span class="rating-bars-inner">

														<span class="rating-bars-rating poor" data-rating="2.0">

															<span class="rating-bars-rating-inner" style="width:20%;"></span>

														</span>

														<strong>20%</strong>

													</span>

												</div>

											</div>

										</div> -->

										

										<!-- Reviews -->

										<div class="list-single-main-item fl-wrap">

											<div class="list-single-main-item-title fl-wrap">

												<h3>Reviews -  <span> {{count($review)==0? 'No review':count($review)}} </span></h3>

											</div>

											<div class="reviews-comments-wrap">

												<!-- reviews-comments-item -->  

												@foreach($review as $reviews)

												

												<div class="reviews-comments-item">

													<div class="review-comments-avatar">

														<img src="{{Storage::url($reviews->use_name[0]['avtars'])}}" class="img-fluid" alt="" onerror="this.src='/thrill/v1/icon/teacher2.png'"> 

													</div>

													<div class="reviews-comments-item-text">

														<h4><a href="#">

															@foreach($reviews->use_name as $use_names)

															{{$use_names->name}}

															@endforeach

														</a><span class="reviews-comments-item-date"></span></h4>

														<div class="listing-rating">

															@for($i = 1; $i <= 5;$i++)

															<i class="fas fa-star  @if($reviews->rate >= $i) active @endif"></i>

															@endfor

														</div>

														

														<div class="listing-rating">{{ $reviews->created_at->format('d-m-Y') }}</div>

														<div class="clearfix"></div>

														<p>{{ $reviews->comment }}</p>

														<!-- <div class="pull-left reviews-reaction">

															<a href="#" class="comment-love active"><i class="ti-heart"></i> 07</a>

														</div> -->

													</div>

												</div>

												@endforeach

												<!--reviews-comments-item end-->  

												

												<!--reviews-comments-item end-->

												

											</div>

										</div>

										

										<!-- Submit Reviews -->

										<div class="edu_wraper">

											<h4 class="edu_title">Submit Reviews</h4>

											@auth

											<div class="review-form-box form-submit">

												<form action="{{ route('front.submitReview') }}" method="post" enctype="multipart/form-data">





													@csrf

													<div class="row">

														<input class="form-control" type="text" name="course_id" value="{{$course->id}}" style="display:none;">

														<input class="form-control" type="hiddn" name="id" value="{{Auth::user()->id}}" style="display:none;">

														

														

														<div class="col-lg-12 col-md-12 col-sm-12">

															<div class="form-group">

																<label>Name</label>

																<input class="form-control" type="text" name="name" placeholder="Your Name" require>

															</div>

														</div>

														

														

														

														<div class="col-lg-12 col-md-12 col-sm-12">

															<div class="form-group">

																<label>Review</label>

																<textarea class="form-control ht-140" name="review" placeholder="Review" require></textarea>

															</div>

														</div>

														<div class="col-lg-12 col-md-12 col-sm-12">

															<div class="form-group">

																<label>Rate</label>

																<br>

																<div class="form-check form-check-inline">

																	<input type="radio" class="btn-check"  id="option1" name="rate" value="1">

																	<label class="form-check-label" for="option1">1</label>

																</div>

																<div class="form-check form-check-inline">

																	<input type="radio" class="btn-check"  id="option2" name="rate" value="2">

																	<label class="form-check-label" for="option2">2</label>

																</div>

																<div class="form-check form-check-inline">

																	<input type="radio" class="btn-check"  id="option3" name="rate" value="3">

																	<label class="form-check-label" for="option3">3</label>

																</div>

																<div class="form-check form-check-inline">

																	<input type="radio" class="btn-check"  id="option4" name="rate" value="4">

																	<label class="form-check-label" for="option4">4</label>

																</div>

																<div class="form-check form-check-inline">

																	<input type="radio" class="btn-check"  id="option5" name="rate" value="5">

																	<label class="form-check-label" for="option5">5</label>

																</div>



															</div>

														</div>

														

														<div class="col-lg-12 col-md-12 col-sm-12">

															<div class="form-group">

																<button type="submit" class="btn theme-bg btn-md">Submit Review</button>

															</div>

														</div>

														

													</div>

												</form>

											</div>

											@else

											<p>you have to login first for add review. Please <a href="#" class="theme-light " data-toggle="modal" data-target="#login">login </a></p>

											@endauth

										</div>

										

									</div>

									

									<!-- demo video -->

									<div class="tab-pane fade" id="demo_video" role="tabpanel" aria-labelledby="demo-video-tab">

										<div class="single_instructor">

											<div class="property_video md">

												<div class="thumb">
													
													<img class="pro_img img-fluid w100" src="{{ Storage::url($course->video_thumbnail) }}" alt="7.jpg">
													
													<div class="overlay_icon">
														
														<div class="bb-video-box">
															
															<div class="bb-video-box-inner">
																
																<div class="bb-video-box-innerup">
																	
																	<div data-toggle="modal" data-target="#video_preview" onclick="show_prev('{{ Storage::url($course->video) }}','{{ Storage::url($course->video_thumbnail) }}')" class="theme-cl"><i class="ti-control-play"></i></div>
																	
																</div>
																
															</div>
															
														</div>
														
													</div>
													
												</div>
												
											</div>

										</div>

									</div>


								</div>

							</div>

							

						</div>

						

						
						

					</div>

				</div>

			</section>

			<!-- ============================ Course Detail ================================== -->

		</section>

		@endsection