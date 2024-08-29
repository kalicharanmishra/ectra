@extends('front.layouts.app')
@section('content')
@php
$courses = \App\Models\Course::where(['visibility' => 'Public']);
if (isset(request()->category) && request()->category != '') {
$courses = $courses->whereHas('cat_data', function ($q) {
$q->where('name', '=', request()->category);
});
}

if (isset(request()->instructor)) {
$courses = $courses->whereIn('user_id', request()->instructor);
}

if(empty(request()->skill_level)){
}else if (in_array('All',request()->skill_level)) {
} else{
if (isset(request()->skill_level)) {
$courses = $courses->whereIn('skill_level', request()->skill_level);
}
}

if (isset(request()->price)) {
if (request()->price == 'All') {
} else {
$courses = $courses->where('price', request()->price);
}
}

$courses = $courses
->withCount('course_enroll_student')
->withCount('circullum_topic')
->with('course_owner')
->paginate(15);
@endphp
<style>
   .crs_lt_103 {
   padding: 0px 0px;
   }
   .bts {
   /* width: 200px;
   height: 90px; */
   padding: 8px;
   color: #fff;
   background-color: #a30a0a;
   border-radius: 4px;
   }
   .bts:hover {
   color: #fff;
   }
   .s {
   margin-bottom: 3%;
   box-shadow: 0 0 20px 0 rgb(00 00 00 / 30%);
   padding: 5px;
   }
   .couress_detail_inner {
   display: flex;
   align-items: center;
   width: 100%;
   margin: 5px 10px 6px 0;
   }
   .course_names {
   color: #a30a0a;
   font-size: 14px;
   width: 20%;
   font-weight: 600
   }
   .course_deatils {
   margin-left: 12px;
   width: 80%
   }
   .course_enroll_btn {
   display: flex;
   align-items: center;
   justify-content: space-between;
   }
   .couress_outer {
   margin-bottom: 0px;
   padding: 0px 10px
   }
   @media screen and (max-width: 767px) {
   .couress_outer {
   padding: 0px 0px
   }
   .course_enroll_btn {
   display: block;
   }
   .course_enroll_btn span{
   text-align: end;
   }
   }
</style>
<!-- ============================================================== -->
<section style="background-color: #FFFBEB;">
   <!-- ============================ Page Title Start================================== -->
   <div class="">
      <div class="container">
         <div class="row">
            <div class="col-lg-12 col-md-12">
               <div class="breadcrumbs-wrap">
                  <nav aria-label="breadcrumb">
                     <ol class="breadcrumbb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Courses</a></li>
                        @if (isset(request()->category) && request()->category != '' && parentCat(parentCat(request()->category)["parent_cat_data"]["name"])["parent_cat_data"] != '')
                        <?php $parent1 = parentCat(parentCat(request()->category)["parent_cat_data"]["name"])["parent_cat_data"]["name"] ;?>
                        <?php $parent2 = parentCat(request()->category)["parent_cat_data"]["name"] ;?>
                        <?php $parent3 = request()->category ;?>
                        <li class="breadcrumb-item">
                           <a
                              href="{{ url('/category?category='.$parent1) }}">
                           {{ parentCat(parentCat(request()->category)['parent_cat_data']['name'])['parent_cat_data']['name'] }}</a>
                        </li>
                        <li class="breadcrumb-item"><a
                           href="{{ url('/category?category='.$parent2) }}">
                           {{ parentCat(request()->category)['parent_cat_data']['name'] }}</a>
                        </li>
                        <li class="breadcrumb-item"><a style="color: #a30a0a !important"
                           href="{{ url('/course?category='.$parent3) }}">{{ request()->category }}</a></li>
                        @else
                        <li class="breadcrumb-item active theme-cl" aria-current="page">Courses</li>
                        @endif
                     </ol>
                  </nav>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- ============================ Page Title End ================================== -->
   <!-- ============================ All Cources ================================== -->
   <section class="grayy">
      <div class="container">
      <div class="row">
         <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
            <div class="page-sidebar p-0">
               <a class="filter_links" data-toggle="collapse" href="#fltbox" role="button"
                  aria-expanded="false" aria-controls="fltbox">Open advance filter<i
                  class="fa fa-sliders-h ml-2"></i></a>
               <div class="collapse" id="fltbox">
                  <!-- Find New Property -->
                  <div class="sidebar-widgets p-4">
                     <!-- <div class="form-group">
                        <div class="input-with-icon">
                        
                         <input type="text" class="form-control" placeholder="Search Your Cources">
                        
                         <i class="ti-search"></i>
                        
                        </div>
                        
                        </div> -->
                     @php
                     $cat_arr = \App\Models\Categories::where('parent', '!=', null)
                     ->withCount('courses')
                     ->get()
                     ->toArray();
                     $instructors = \App\Models\User::whereHas('roles', function ($q) {
                     $q->where('id', 4);
                     })
                     ->withCount('courses')
                     ->orderBy('courses_count', 'DESC')
                     ->get();
                     @endphp
                     <form method="GET">
                        <div class="form-group">
                           <div class="simple-input">
                              <select id="cates" class="form-control" name="category">
                                 <option value="">Select Category</option>
                                 @if ($cat_arr)
                                 @foreach ($cat_arr as $category)
                                 <option value="{{ $category['name'] }}"
                                 @if (isset(request()->category) && request()->category == $category['name']) selected @endif>
                                 {{ $category['name'] }}
                                 </option>
                                 @endforeach
                                 @endif
                              </select>
                           </div>
                        </div>
                        <div class="form-group">
                           <h6>Skill Level</h6>
                           <ul class="no-ul-list mb-3">
                              <li>
                                 <input id="l0" class="checkbox-custom" name="skill_level[]"
                                 type="checkbox" value="All"
                                 @if (isset(request()->skill_level) && in_array('All', request()->skill_level)) checked @endif>
                                 <label for="l0" class="checkbox-custom-label">All levels</label>
                              </li>
                              <li>
                                 <input id="l1" class="checkbox-custom" name="skill_level[]"
                                 type="checkbox" value="Beginner"
                                 @if (isset(request()->skill_level) && in_array('Beginner', request()->skill_level)) checked @endif>
                                 <label for="l1" class="checkbox-custom-label">Beginner</label>
                              </li>
                              <li>
                                 <input id="l3" class="checkbox-custom" name="skill_level[]"
                                 type="checkbox" value="Intermediate"
                                 @if (isset(request()->skill_level) && in_array('Intermediate', request()->skill_level)) checked @endif>
                                 <label for="l3" class="checkbox-custom-label">Intermediate
                                 </label>
                              </li>
                              <li>
                                 <input id="l4" class="checkbox-custom" name="skill_level[]"
                                 type="checkbox" value="Advanced"
                                 @if (isset(request()->skill_level) && in_array('Advanced', request()->skill_level)) checked @endif>
                                 <label for="l4" class="checkbox-custom-label">Advanced</label>
                              </li>
                           </ul>
                        </div>
                        {{-- 
                        <div class="form-group">
                           <h6>Price</h6>
                           <ul class="no-ul-list mb-3">
                              <li>
                                 <input id="p1" class="checkbox-custom" name="price"
                                 type="radio" value="All"
                                 @if (isset(request()->price) && request()->price == 'All') checked @endif>
                                 <label for="p1" class="checkbox-custom-label">All</label>
                              </li>
                              <li>
                                 <input id="p2" class="checkbox-custom" name="price"
                                 type="radio" value="Free"
                                 @if (isset(request()->price) && request()->price == 'Free') checked @endif>
                                 <label for="p2" class="checkbox-custom-label">Free</label>
                              </li>
                              <li>
                                 <input id="p3" class="checkbox-custom" name="price"
                                 type="radio" value="Paid"
                                 @if (isset(request()->price) && request()->price == 'Paid') checked @endif>
                                 <label for="p3" class="checkbox-custom-label">Paid</label>
                              </li>
                           </ul>
                        </div>
                        --}}
                        <div class="row">
                           <div class="col-lg-12 col-md-12 col-sm-12 pt-4">
                              <button type="submit" class="btn theme-bg rounded full-width">Apply
                              filter</button>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
            <!-- Sidebar End -->
         </div>
         <!-- Content -->
         <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12">
            <div class="row">
               <div class="col-lg-12 col-md-12 col-sm-12">
                  <div class="short_wraping">
                     <div class="row m-0 align-items-center justify-content-between">
                        <div class="col-lg-4 col-md-5 col-sm-12  col-sm-6">
                           <div class="shorting_pagination_laft">
                              <h6 class="m-0">Showing
                                 {{ $courses->perPage() * ($courses->currentPage() - 1) }}- @if ($courses->total() < $courses->perPage() * $courses->currentPage())
                                 {{ $courses->total() }}
                                 @else
                                 {{ $courses->perPage() * $courses->currentPage() }}
                                 @endif of {{ $courses->total() }}
                              </h6>
                           </div>
                        </div>
                        <div class="col-lg-8 col-md-7 col-sm-12 col-sm-6">
                           <div class="dlks_152">
                              <div class="shorting-right mr-2">
                                 <label>Sort By:</label>
                                 <div class="dropdown show">
                                    <a class="btn btn-filter dropdown-toggle" href="#"
                                       data-toggle="dropdown" aria-haspopup="true"
                                       aria-expanded="false">
                                    <span class="selection">Most
                                    Viewd</span>
                                    </a>
                                    <div class="drp-select dropdown-menu">
                                       {{-- <a class="dropdown-item" href="JavaScript:Void(0);">Most
                                       Rated</a> --}}
                                       <a class="dropdown-item" href="JavaScript:Void(0);">Most
                                       Viewd</a>
                                       <a class="dropdown-item" href="JavaScript:Void(0);">News
                                       Listings</a>
                                       {{-- <a class="dropdown-item" href="JavaScript:Void(0);">High
                                       Rated</a> --}}
                                    </div>
                                 </div>
                              </div>
                              {{-- 
                              <div class="lmk_485">
                                 <ul class="shorting_grid">
                                    <li class="list-inline-item"><a href="#"
                                       class="active"><span class="ti-layout-grid2"></span></a>
                                    </li>
                                    <li class="list-inline-item"><a href="#"
                                       class="active"><span class="ti-view-list"></span></a></li>
                                 </ul>
                              </div>
                              --}}
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- <div class="row justify-content-center"> -->
               <br>
               <!-- Single Grid -->
               @foreach ($courses as $course)
               <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                  <div
                     style="border: 1px solid #a30a0a4d;margin-bottom: 7%;box-shadow: 0 0 20px 0 rgb(164 20 71 / 74%);">
                     <div class="crs_lt_2" style="">
                        <div class="crs_lt_boxes" style="padding: 10px 5px;">
                           <div class="crs_grid_list_thumb">
                              <a href="{{ route('front.course_detail', $course->slug) }}"><img
                                 src="{{ Storage::url($course->image) }}" class="img-fluid rounded"
                                 alt=""
                                 onerror="this.src='thrill/v1/icon/online-tutorior.webp'"></a>
                           </div>
                           <div class="crs_grid_list_caption">
                              <div class="crs_lt_102">
                                 {{-- 
                                 <div class="crs_title">
                                    <h4><a href="{{ route('front.course_detail',$course->slug) }}" class="crs_title_link">{{ $course->title }}</a></h4>
                                 </div>
                                 --}}
                                 {{-- 
                                 <a href="{{ route('front.course_detail',$course->slug) }}">
                                    <div class="ed_header_short">{{ $course->short_desc }}</div>
                                 </a>
                                 --}}
                                 {{-- <span class="crs_auth"><i>By </i>@if ($course->course_owner)<a href="{{route('front.instructor_detail',[\Crypt::encrypt($course->course_owner['id']),$course->course_owner['name']])}}" >{{ $course->course_owner?$course->course_owner['name']:'' }}</a>@endif</span> --}}
                              </div>
                              <div class="crs_lt_103">
                                 <div class="crs_info_detail">
                                    <div class="courses_boxes_table">
                                       <div class="row">
                                          <div class="col-lg-12">
                                             <div class="couress_outer">
                                                <div class="crs_title couress_detail_inner">
                                                   <span class="course_names">Course
                                                   name:</span>
                                                   <h4 class="course_deatils">
                                                      <a href="{{ route('front.course_detail', $course->slug) }}"
                                                         class="crs_title_link"
                                                         style="font-size: 22px; font-weight: 600;">{{ $course->title }}</a>
                                                   </h4>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="col-lg-12">
                                             <div class="couress_outer">
                                                <div class="crs_title couress_detail_inner">
                                                   <span class="course_names">Teacher's
                                                   name:</span>
                                                   <div class="course_deatils course_enroll_btn">
                                                      <h4 class=" ">
                                                         @if ($course->course_owner)
                                                         <a style="font-size: 22px; font-weight: 600;"
                                                            href="{{ route('front.instructor_detail', [\Crypt::encrypt($course->course_owner['id']), $course->course_owner['name']]) }}">{{ $course->course_owner ? $course->course_owner['name'] : '' }}</a>
                                                         @endif
                                                      </h4>
                                                      
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <br>
                                       <div class="row">
                                          <div class="col-lg-12">
                                            <div class="row crs_fl_first inline-block">
                                                <!-- <div class="crs_price"> -->
                                                   <div class="col-sm-4">
                                                        <div class="prv_li bts" data-toggle="modal"
                                                          data-target="#video_preview"
                                                          onclick="show_prev('{{ Storage::url($course->video) }}','{{ Storage::url($course->video_thumbnail) }}')">
                                                          <i class="fa fa-play text-success"></i>
                                                          demo video
                                                        </div>
                                                    </div>
                                                <!-- </div> -->
                                             <!-- </div> -->
                                            
                                             <!-- <div class="crs_fl_last " -->
                                                <!-- style="padding-bottom: 5px;"> -->
                                                <div class="col-sm-5 crs_linkview">
                                                    @if ($course->price_type == 'Paid')
                                                     <a href="{{ route('front.course_detail', $course->slug) }}" class="prv_li bts">Book trial class @ 50/-</a>
                                                    @endif
                                                </div>
                                                <!-- style="width:230px; height: 18px; background-color: #A30A0A; border-radius:6px;" -->
                                             <!-- </div> -->
                                             
                                                <div class="col-sm-3">
                                                 <div class="crs_fl_last"
                                                    style="padding-bottom: 5px;">
                                                    <span class="crs_linkview"><a
                                                       href="{{ route('front.course_detail', $course->slug) }}"
                                                       class="prv_li bts">Enroll
                                                    now</a></span>
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
                     <div style="padding: 0px 10px;">
                        <div class="courses_boxes_table">
                           <div class="row">
                              <div class="col-lg-6">
                                 <div class="couress_detail table-light d-flex justify-content-between s"
                                    style="background-color: #ffffff;">
                                    <span style="color: #a30a0a;">Teaching since</span>
                                    <span
                                       style="color: #a30a0a;">{{ $course->course_owner->teacher_profile->experence }}
                                    years</span>
                                 </div>
                                 <div class="couress_detail  d-flex justify-content-between s"
                                    style="background-color: #ffffff;">
                                    <span style="color:#a30a0a;">Course duration</span>
                                    <span style="color:#a30a0a;">
                                    <?php
                                       if ($course->duration >= 30) {
                                           $totmont = round($course->duration / 30);
                                           echo $totmont . ' Month';
                                       } elseif ($course->duration >= 365) {
                                           $totmont = round($course->duration / 365);
                                           echo $totmont . ' Years';
                                       } else {
                                           $totmont = round($course->duration);
                                           echo $totmont . ' Days';
                                       }
                                       ?>
                                    </span>
                                 </div>
                                 <div class="couress_detail table-light d-flex justify-content-between s"
                                    style="background-color: #ffffff;">
                                    <span style="color:#a30a0a;">Classes held on</span> <span
                                       style="color:#a30a0a;">{{ $course->class_held_on }}</span>
                                 </div>
                              </div>
                              <div class="col-lg-6">
                                 <div class="couress_detail d-flex justify-content-between s"
                                    style="background-color: #ffffff;">
                                    <span style="color:#a30a0a;">Skill level</span>
                                    <span
                                       style="color:#a30a0a;">{{ $course->skill_level }}</span>
                                 </div>
                                 @if ($course->id_trial == 1)
                                 <div
                                    class="couress_detail table-light d-flex justify-content-between s">
                                    <span style="color:#a30a0a;">Trial class fee</span> <span
                                       style="color:#a30a0a;">₹ 50</span>
                                 </div>
                                 @endif
                                 <div class="couress_detail table-light d-flex justify-content-between s"
                                    style="background-color: #ffffff;">
                                    <span style="color:#a30a0a;">Course fees</span> <span
                                       style="color:#a30a0a;">
                                    @if ($course->price_type == 'Paid')
                                    ₹ {{ $course->price }}
                                    @else
                                    Free
                                    @endif
                                    </span>
                                 </div>
                                 <div class="couress_detail d-flex justify-content-between s"
                                    style="background-color: #ffffff;">
                                    <span style="color:#a30a0a;">Course timing </span> <span
                                       style="color:#a30a0a;">{{ $course->timing }} </span>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               @endforeach
            </div>
         </div>
      </div>
      <!-- </div> -->
      <!-- </div> -->
      <!-- Pagination -->
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12">
            {{ $courses->links() }}
         </div>
      </div>
      <!-- </div>
         </div>
         </div> -->
   </section>
   <!-- ============================ All Cources ================================== -->
</section>
@endsection