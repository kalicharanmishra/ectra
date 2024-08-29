@extends('front.layouts.app')

@section('content')
@auth

<?php

$auid = Auth::user()->id;
$enrolled = DB::table('course_enroll')->where('course_id', $course->id)->where('user_id', $auid)->first();

?>
@endauth

<!-- ============================================================== -->

<link rel="stylesheet" href="{{ asset('front/assets/calendar/fonts/icomoon/style.css')}}">
<link href="{{ asset('front/assets/calendar/fullcalendar/packages/core/main.css')}}" rel='stylesheet' />
<link href="{{ asset('front/assets/calendar/fullcalendar/packages/daygrid/main.css')}}" rel='stylesheet' />

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="{{ asset('front/assets/calendar/css/bootstrap.min.css')}}">

<!-- Style -->
<link rel="stylesheet" href="{{ asset('front/assets/calendar/css/style.css')}}">

<style>
	.fc-day-top{
		font-size: 20px;
		text-align: right;
		border: 1px solid #8e8e8e !important;
	}
	.fc-ltr .fc-dayGrid-view .fc-day-top .fc-day-number{
		float: inherit;
	}
	.fc-row{
		height: 70px !important;
	}
	.fc-scroller{
		height: auto !important;
	}
	.courser_header_table table, tr, td{
		border: none !important
	}
	.fc-unthemed th{
		border-color: #1f1f1f;
		font-size: 20px
	}
</style>

<!-- ============================ Page Title Start================================== -->

<div class="ed_detail_head " style="background-color:#fff;" data-overlay="8">
	<div class="container">
		<div class="row align-items-center">


			<div class="col-lg-3 col-md-3">
				<div class="ed_detail_wrap light">

					<!--@foreach(json_decode($course->hashtags) as $key_hashtags=>$item)<div class="crs_cates cl_{{$key_hashtags}}"><span>{{$item}}</span></div>@endforeach-->

					<div class="ed_header_caption">

						<h2 class="ed_title">{{$course->course_name}}</h2>

						<!--<ul>-->
						<!--	<li><i class="ti-calendar"></i>{{$course->is_certification}}</li>-->
						<!--	<li><i class="ti-control-forward"></i>{{$course->total_class}} Session</li>-->
						<!--	<li><i class="ti-user"></i>{{$course->course_enroll_student_count}} Student Enrolled</li>-->
						<!--</ul>-->
					</div>

					<!--<div class="ed_header_short">-->
					<!--	<p class="course_short_desc">{{$course->short_desc}}</p>-->
					<!--</div>-->


					<!--<div class="ed_rate_info">-->
					<!--	<div class="star_info">-->

					<!--		@for($i=0; $i<5; $i++) <i class="fas  fa-star @if($course->retting > $i+1) filled @elseif($course->retting >= $i+0.5)filled fa-star-half-alt  @endif"></i>-->

					<!--			@endfor-->
					<!--	</div>-->

					<!--	<div class="review_counter">-->
					<!--		<strong class="high">{{$course->retting}}</strong> {{count($course->course_comments)}} Comment or Review-->
					<!--	</div>-->
					<!--</div>-->
				</div>
			</div>


			<div class="col-lg-5 col-md-5">
				<div class="ed_view_price pl-4">
					

					@if($course->id)
					@foreach(\App\Models\class_course::where('course_id',$course->id)->get() as $key=>$item)

					@endforeach
					@endif

					<?php
					
					date_default_timezone_set('Asia/Kolkata');
					
					$cdattime = date('Y-m-d H:i:s', strtotime(($item->start_date . ' ' . $item->time)));
					$st_time = strtotime($cdattime) + 3600;

					
					if ($st_time <= time()) {
					?>
						<a href="https://meet.google.com/?pli=1" target="_blank" class="btn btn-block theme-bg enroll-btn" style="color:#fff;">Click to join the class</a>
					<?php } else {  ?>
						<a href="https://meet.google.com/?pli=1" target="_blank" class="btn btn-block theme-bg enroll-btn" style="color:#fff; display: none;">Join Class<i class="ti-angle-right"></i></a>
					<?php }
					//} 
					?>

				</div>
			</div>
		</div>
	</div>
</div>

<!-- ============================ Page Title End ================================== -->



<section style="background-color:#FFFBEB;">
	<!-- class="all-bg-course-det" -->
	<!-- ============================ Course Detail ================================== -->

	<section class=" pt-3">

		<div class="container-fluid">
			<div class="row">
				<div class="card-body pl-1 pr-1 col-lg-12 col-md-12">

					<div id='calendar' style="width:100%;"></div>

					<script src="{{ asset('front/assets/calendar/js/jquery-3.3.1.min.js')}}"></script>
					<script src="{{ asset('front/assets/calendar/js/popper.min.js')}}"></script>
					<script src="{{ asset('front/assets/calendar/js/bootstrap.min.js')}}"></script>
					<script src="{{ asset('front/assets/calendar/fullcalendar/packages/core/main.js')}}"></script>
					<script src="{{ asset('front/assets/calendar/fullcalendar/packages/interaction/main.js')}}"></script>
					<script src="{{ asset('front/assets/calendar/fullcalendar/packages/daygrid/main.js')}}"></script>

					<script>
						document.addEventListener('DOMContentLoaded', function() {
							var calendarEl = document.getElementById('calendar');

							var calendar = new FullCalendar.Calendar(calendarEl, {
								plugins: ['interaction', 'dayGrid'],
								defaultDate: '<?php echo \Carbon\Carbon::now()->format('Y-m-d') ?>',
								editable: false,
								eventLimit: true, // allow "more" link when too many events

								events: [

									<?php
									if ($course->id) {
										foreach (\App\Models\class_course::where('course_id', $course->id)->get() as $key => $item) { ?>

											{
												title: '{{$item->course_name}}',
												<?php $date = \Carbon\Carbon::createFromFormat('Y-m-d', $item->start_date);  ?>
												start: '<?php echo $date; ?>',
												url: 'http://google.com/',
												end: '<?php echo $date; ?>'
											},
									<?php }
									} ?>
								]
							});
							calendar.render();
						});
					</script>
					<script src="{{ asset('front/assets/calendar/js/main.js')}}"></script>
				</div>
			</div>
		</div>
	</section>
	
</section>
@endsection