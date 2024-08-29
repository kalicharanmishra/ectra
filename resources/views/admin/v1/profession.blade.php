@extends('front.layouts.app')
@section('content')
<!-- ============================================================== -->
<section class="signup-bg">
   <!-- ============================ Signup Wrap ================================== -->
   <section style="padding: 0px">
      <div class="container">
         <div class="row justify-content-center">
            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12">
               <div class="crs_log_wrap">
                  <div class="crs_log__thumb">
                     <img src="{{ asset('front/assets/img/sign_up.jpg') }}" class="img-fluid" alt=""
                        style="object-fit: cover" />
                  </div>
                  <div class="crs_log__caption mt-2">
                     <div class="Lpo09">
                        <h4>Tutor profession</h4>
                        <!-- <p>(Tutor profession)</p> -->
                     </div>
                     <!-- Tab panes -->
                     <form method="POST" action="{{ route('tutor.profession.store') }}"  enctype="multipart/form-data">
                        @csrf
                        <div class="rcs_log_124">
                           <!-- <div class="Lpo09">
                              <h4>Sign Up</h4>
                              <p>(New users)</p>
                              </div> -->
                           <input type="hidden" name="user_id" value="{{auth()->user()->id}}">
                           <div class="form-group row mb-0">
                              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                 <div class="form-group">
                                    <label>Name of the degree obtained:</label>
                                    <input id="degree" type="text" class="form-control @error('degree') is-invalid @enderror" name="degree" value="" required oninvalid="this.setCustomValidity('This is a mandatory field, please fill this up')" autocomplete="off" autofocus>
                                    @error('degree')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                 </div>
                              </div>
                              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                 <div class="form-group">
                                    <label>Degree / diploma / certificate obtained from:</label>
                                    <input id="institute" type="text" class="form-control @error('institute') is-invalid @enderror" name="institute" value="" required oninvalid="this.setCustomValidity('This is a mandatory field, please fill this up')" autocomplete="off" autofocus>
                                    @error('institute')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                 </div>
                              </div>
                              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                 <div class="row m-0 p-0">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 m-0 p-0">
                                       <div class="form-group">
                                          <label>Year of passing out:</label>
                                          <select id="passing_out" class="form-control @error('passing_out') is-invalid @enderror" name="passing_out" required oninvalid="this.setCustomValidity('This is a mandatory field, please fill this up')" autocomplete="off">
                                            <option value="">Please Select</option>
                                            @php
                                                $last= date('Y')-120;
                                                $now= date('Y');
                                            @endphp
                                            @for ($i = $now; $i >= $last; $i--)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                          </select>
                                          @error('passing_out')
                                          <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                          </span>
                                          @enderror
                                       </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 m-0 p-0">
                                       <div class="form-group">
                                          <label>Teaching since:</label>
                                          <select id="since" class="form-control @error('since') is-invalid @enderror" name="since" required oninvalid="this.setCustomValidity('This is a mandatory field, please fill this up')" autocomplete="off" onchange="experience_calculate()">
                                            <option value="">Please Select</option>
                                            @php
                                                $last= date('Y')-120;
                                                $now= date('Y');
                                            @endphp
                                            @for ($i = $now; $i >= $last; $i--)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                          </select>
                                          @error('since')
                                          <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                          </span>
                                          @enderror
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                 <div class="form-group">
                                    <label>Teaching experience:</label>
                                    <input id="experience" readonly type="text" class="form-control @error('experience') is-invalid @enderror" name="experience" value="" required oninvalid="this.setCustomValidity('This is a mandatory field, please fill this up')" autocomplete="off" autofocus>
                                      @error('experience')
                                      <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                      </span>
                                      @enderror
                                 </div>
                              </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                       <div class="row m-0 p-0">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 m-0 p-0">
                                         <div class="form-group">
                                            <label>Intro video:</label>
                                            <input id="demo_video" type="file" class="form-control @error('demo_video') is-invalid @enderror" name="demo_video" required oninvalid="this.setCustomValidity('This is a mandatory field, please fill this up')" autocomplete="off">
                                            @error('demo_video')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                         </div>
                                     </div>
                                     <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12m-0 p-0">
                                         <div class="form-group">
                                            <label>Profile:</label>
                                            <input id="profile" type="file" class="form-control @error('profile') is-invalid @enderror" name="profile" required oninvalid="this.setCustomValidity('This is a mandatory field, please fill this up')" autocomplete="off">
                                            @error('profile')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                         </div>
                                     </div>
                                  </div>
                               </div>
                               @php 
                                $data = DB::table('categories')->orderBy('id', 'asc')->get();//dd($data);
                               @endphp
                               <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                       <div class="form-group">
                                          <label>Expertise in:</label>
                                          <select id="expertise" class="js-example-basic-multiple form-control @error('expertise') is-invalid @enderror" name="expertise" required oninvalid="this.setCustomValidity('This is a mandatory field, please fill this up')" autocomplete="off" >
                                            <option value="">Please Select</option>
                                            @foreach(DB::table('categories')->where('parent', '')->orWhereNull('parent')->orderBy('indexing', 'asc')->get() as $category)
                                                <optgroup label="{{$category->name}}">                    
                                                     @foreach(DB::table('categories')->where('parent', $category->id)->orderBy('indexing', 'asc')->get() as $subCategory)
                                                        <option value="{{$subCategory->name}}" {{--@if(isset($user->teacher_profile['tag']) && in_array($item->code,old('teacher_profile')?old('teacher_profile'):json_decode($user->teacher_profile['tag']))) ) selected @endif --}}>{{$subCategory->name}}</option>
                                                    @endforeach
                                                </optgroup>
                                                @endforeach
                                          </select>
                                          @error('expertise')
                                          <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                          </span>
                                          @enderror
                                       </div>
                                    </div>
                              
                                 <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                       <div class="form-group">
                                          <label>Introduction of the teacher:</label>
                                          <textarea id="introduction" class="form-control @error('introduction') is-invalid @enderror" cols="3" rows="6" name="introduction" required oninvalid="this.setCustomValidity('This is a mandatory field, please fill this up')" autocomplete="off"></textarea>
                                          @error('introduction')
                                          <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                          </span>
                                          @enderror
                                       </div>
                                 </div>
                              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                 <div class="form-group text-center">
                                    <button type="submit" class="btn full-width btn-md theme-bg text-white register-btn">
                                    {{ __('Continue') }}
                                    </button>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
   <!-- ============================ Signup Wrap ================================== -->
</section>
<script>
    function experience_calculate()
    {
        var since = document.getElementById('since').value;
        var d = new Date();
        var year = d.getFullYear();
        var experience = year - since;
        document.getElementById('experience').value = experience;
    }
    /*$(document).ready(function() {
       $('.js-example-basic-multiple').select2();
   });*/
</script>
<!-- ============================ Footer Start ================================== -->
@endsection