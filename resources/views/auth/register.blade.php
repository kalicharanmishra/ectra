{{-- @extends('layouts.app') --}}
@extends('front.layouts.app')
@section('content')
<style type="text/css">
    .password-toggle-icon {
  position: absolute;
  top: 49%;
  right: 25px;
  transform: translateY(-50%);
  cursor: pointer;
}

.password-toggle-icon i {
  font-size: 18px;
  line-height: 1;
  color: #333;
  transition: color 0.3s ease-in-out;
  margin-bottom: 20px;
}
.password-confirm-toggle-icon {
  position: absolute;
  top: 49%;
  right: 25px;
  transform: translateY(-50%);
  cursor: pointer;
}

.password-confirm-toggle-icon i {
  font-size: 18px;
  line-height: 1;
  color: #333;
  transition: color 0.3s ease-in-out;
  margin-bottom: 20px;
}
.invalid-feedback {
    display: none;
    margin-top: .25rem;
    font-size: 0.775rem!important;
    color: #dc3545;
}
</style>
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
                                   <h4>Sign Up</h4>
                                   <p>(New users)</p>
                                   </div>
                   <ul class="nav nav-pills" role="tablist">
                        <li class="nav-item mr-2">
                          <a class="nav-link active" data-toggle="pill" href="#student"><strong>Joining as a student</strong></a>
                        </li>
                        <li class="nav-item ml-2">
                          <a class="nav-link" data-toggle="pill" href="#teacher"><strong>Joining as a teacher</strong></a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div id="student" class="container tab-pane active">
                          <!-- <h3>HOME</h3>
                          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p> -->
                          <form method="POST" action="{{ route('front.signup.create') }}">
                            @csrf
                            <div class="rcs_log_124">
                                <!-- <div class="Lpo09">
                                   <h4>Sign Up</h4>
                                   <p>(New users)</p>
                                   </div> -->
                                   <input type="hidden" name="user_type" value="user">
                                <div class="form-group row mb-0">
                                   <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                      <div class="form-group">
                                         <label>Name</label>
                                         <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="" required oninvalid="this.setCustomValidity('This is a mandatory field, please fill this up')" autocomplete="off" autofocus>
                                         @error('name')
                                         <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                         </span>
                                         @enderror
                                      </div>
                                   </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                      <div class="form-group">
                                         <label>Date of birth</label>
                                         <input id="dob" type="date" class="form-control @error('dob') is-invalid @enderror" name="dob" value="" required oninvalid="this.setCustomValidity('This is a mandatory field, please fill this up')" autocomplete="off" autofocus>
                                         @error('dob')
                                         <span class="invalid-feedback" role="alert">
                                         {{ $message }}
                                         </span>
                                         @enderror
                                      </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                        <div class="row m-0 p-0">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 m-0 p-0">
                                                <div class="form-group" style="margin-bottom:0">
                                                    <label>Mobile number</label>
                                                    <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" required oninvalid="this.setCustomValidity('This is a mandatory field, please fill this up')" autocomplete="off">

                                                    @error('phone')
                                                    <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 m-0 p-0">
                                                <div class="form-group" style="margin-bottom: 0;">
                                                    <label>Email id</label>
                                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"  autocomplete="off">
                                                    @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                   {{ $message }}
                                                    </span>
                                                    @enderror
                                                 </div>
                                            </div>
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 m-0 p-0">
                                                <span class="text-danger" style="font-size:10px"><strong>Note - </strong>Mobile no. will be used as login id for all future logins</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                        <div class="row m-0 p-0">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 m-0 p-0">
                                                <div class="form-group">
                                                    <label>Gender</label>
                                                    <select id="gender" class="form-control @error('gender') is-invalid @enderror" name="gender" required oninvalid="this.setCustomValidity('This is a mandatory field, please fill this up')" autocomplete="off">
                                                       <option value="">Please select</option>
                                                       <option value="male">Male</option>
                                                       <option value="female">Female</option>
                                                       <option value="other">Other</option>
                                                    </select>
                                                    @error('gender')
                                                    <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 m-0 p-0">
                                                <div class="form-group">
                                                    <label>City</label>
                                                    {{--<select id="address" class="form-control" name="address" required oninvalid="this.setCustomValidity('This is a mandatory field, please fill this up')" autocomplete="off">
                                                        <option value="">Please select</option>
                                                       
                                                       @if($allCitiesArr && !empty($allCitiesArr))
                                                       
                                                       @foreach($allCitiesArr['data'] as $countries)
                                                          @php $country = $countries['country'];@endphp
                                                          @foreach($countries['cities'] as $city)
                                                          <option value="{{$city}}">{{$city}}</option>
                                                          @endforeach
                                                       @endforeach
                                                       @endif
                                                   </select>--}}
                                                   <input id="address" type="text" class="form-control @error('password') is-invalid @enderror" name="address" required oninvalid="this.setCustomValidity('This is a mandatory field, please fill this up')" autocomplete="off">
                                                   @error('address')
                                                    <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                    </span>
                                                    @enderror
                                                 </div>
                                          </div>
                                      </div>
                                   </div>
                                   <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                      <div class="form-group" style="margin-bottom:0.3rem;">
                                         <label>Password</label>
                                         <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required oninvalid="this.setCustomValidity('This is a mandatory field, please fill this up')" autocomplete="off">
                                         <span class="password-toggle-icon" onclick="password(this)"><i class="fas fa-eye"></i></span>
                                         @error('password')
                                         <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                         </span>
                                         @enderror
                                      </div>
                                      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12" style="padding-left:0px;">
                                      <div class="form-group" id="remember_password">
                                         <input id="remember" type="checkbox" 
                                            name="remember"  autocomplete="off">
                                         <label for="remember">Remember password for future login.</label>
                                         @error('remember')
                                                <span class="invalid-feedback" role="alert">
                                                {{ $message }}
                                                </span>
                                                @enderror
                                      </div>
                                   </div>
                                   </div>
                                   <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                      <div class="form-group">
                                         <label>Confirm password</label>
                                         <input id="password-confirm" type="password" class="form-control"
                                            name="password_confirmation" required oninvalid="this.setCustomValidity('This is a mandatory field, please fill this up')" autocomplete="off">

                                         <span class="password-confirm-toggle-icon" onclick="passwordConfirm(this)"><i class="fas fa-eye"></i></span>
                                      </div>
                                   </div>
                                   
                                   <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                      <div class="form-group text-center">
                                         <button type="submit" class="btn full-width btn-md theme-bg text-white register-btn">
                                         {{ __('Sign Up') }}
                                         </button>
                                      </div>
                                   </div>
                                </div>
                            </div>
                            </form>
                        </div>
                        <div id="teacher" class="container tab-pane fade">
                          <!-- <h3>Menu 1</h3> -->
                            <form method="POST" action="{{ route('front.signup.create') }}">
                            @csrf
                            <div class="rcs_log_124">
                                <!-- <div class="Lpo09">
                                   <h4>Sign Up</h4>
                                   <p>(New users)</p>
                                   </div> -->
                                   <input type="hidden" name="user_type" value="teacher">
                                <div class="form-group row mb-0">
                                   <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                      <div class="form-group">
                                         <label>Name</label>
                                         <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="" required oninvalid="this.setCustomValidity('This is a mandatory field, please fill this up')" autocomplete="off" autofocus>
                                         @error('name')
                                         <span class="invalid-feedback" role="alert">
                                         {{ $message }}
                                         </span>
                                         @enderror
                                      </div>
                                   </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                      <div class="form-group">
                                         <label>Date of birth</label>
                                         <input id="dob" type="date" class="form-control @error('dob') is-invalid @enderror" name="dob" value="" required oninvalid="this.setCustomValidity('This is a mandatory field, please fill this up')" autocomplete="off" autofocus>
                                         @error('dob')
                                         <span class="invalid-feedback" role="alert">
                                         {{ $message }}
                                         </span>
                                         @enderror
                                      </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                        <div class="row m-0 p-0">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 m-0 p-0">
                                                <div class="form-group" style="margin-bottom:0">
                                                    <label>Mobile number</label>
                                                    <input id="phone" type="text" class="form-control" name="phone" required oninvalid="this.setCustomValidity('This is a mandatory field, please fill this up')" autocomplete="off">
                                                    @error('phone')
                                                    <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 m-0 p-0">
                                                <div class="form-group" style="margin-bottom:0">
                                                    <label>Email id</label>
                                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" autocomplete="off">

                                                    @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                    </span>
                                                    @enderror
                                                 </div>
                                            </div>
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 m-0 p-0">
                                                <span class="text-danger" style="font-size:10px"><strong>Note - </strong>Mobile no. will be used as login id for all future logins</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                        <div class="row m-0 p-0">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 m-0 p-0">
                                                <div class="form-group">
                                                    <label>Gender</label>
                                                    <select id="gender" class="form-control @error('gender') is-invalid @enderror" name="gender" required oninvalid="this.setCustomValidity('This is a mandatory field, please fill this up')" autocomplete="off">
                                                       <option value="">Please select</option>
                                                       <option value="male">Male</option>
                                                       <option value="female">Female</option>
                                                       <option value="other">Other</option>
                                                    </select>
                                                    @error('gender')
                                                    <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 m-0 p-0">
                                                <div class="form-group">
                                                    <label>City</label>
                                                    {{--<select id="address" class="form-control" name="address" required oninvalid="this.setCustomValidity('This is a mandatory field, please fill this up')" autocomplete="off">
                                                        <option value="">Please select</option>
                                                       
                                                       @if($allCitiesArr && !empty($allCitiesArr))
                                                       
                                                       @foreach($allCitiesArr['data'] as $countries)
                                                          @php $country = $countries['country'];@endphp
                                                          @foreach($countries['cities'] as $city)
                                                          <option value="{{$city}}">{{$city}}</option>
                                                          @endforeach
                                                       @endforeach
                                                       @endif
                                                   </select>--}}
                                                   <input id="address" type="text" class="form-control @error('password') is-invalid @enderror" name="address" required oninvalid="this.setCustomValidity('This is a mandatory field, please fill this up')" autocomplete="off">
                                                   @error('address')
                                                    <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                    </span>
                                                    @enderror
                                                 </div>
                                          </div>
                                      </div>
                                   </div>
                                   <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                      <div class="form-group" style="margin-bottom:0.3rem;">
                                         <label>Password</label>
                                         <input id="passwordT" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required oninvalid="this.setCustomValidity('This is a mandatory field, please fill this up')" autocomplete="off">
                                         <span class="password-toggle-icon" onclick="passwordT(this)"><i class="fas fa-eye"></i></span>
                                         @error('password')
                                         <span class="invalid-feedback" role="alert">
                                         {{ $message }}
                                         </span>
                                         @enderror
                                      </div>
                                      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12" style="padding-left:0px;">
                                      <div class="form-group" id="remember_password">
                                         <input id="remember_tutor" type="checkbox" 
                                            name="remember"  autocomplete="off">
                                         <label for="remember_tutor">Remember password for future login.</label>
                                         @error('remember')
                                                <span class="invalid-feedback" role="alert">
                                               {{ $message }}
                                                </span>
                                                @enderror
                                      </div>
                                   </div>
                                   </div>
                                   <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                      <div class="form-group">
                                         <label>Confirm password</label>
                                         <input id="password-confirm-T" type="password" class="form-control"
                                            name="password_confirmation" required oninvalid="this.setCustomValidity('This is a mandatory field, please fill this up')" autocomplete="off">
                                            <span class="password-confirm-toggle-icon" onclick="passwordConfirmT(this)"><i class="fas fa-eye"></i></span>
                                      </div>
                                   </div>
                                   
                                   <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                      <div class="form-group text-center">
                                         <button type="submit" class="btn full-width btn-md theme-bg text-white register-btn">
                                         {{ __('Sign Up') }}
                                         </button>
                                      </div>
                                   </div>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                        
                  </div>
                  <div class="crs_log__footer d-flex justify-content-between">
                     <div class="fhg_45">
                        <p class="musrt">Existing user? <a href="/login" class="theme-cl">Sign In</a>
                        </p>
                     </div>
                     <div class="fhg_45">
                        <p class="musrt"><a href="{{ route('front.forgot') }}" class="text-danger">Forgot
                           password?</a>
                        </p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
   <!-- ============================ Signup Wrap ================================== -->
</section>
<!-- ============================ Footer Start ================================== -->
<script type="text/javascript">
    function password(e) {
      let x = document.getElementById("password");
      let togglePassword = e.querySelector(".password-toggle-icon i");
      if (x.type === "password") {
        x.type = "text";
        togglePassword.classList.remove("fa-eye");
        togglePassword.classList.add("fa-eye-slash");
      } else {
        x.type = "password";
        togglePassword.classList.remove("fa-eye-slash");
        togglePassword.classList.add("fa-eye");
      }
    }
    function passwordConfirm(e) {
      let x = document.getElementById("password-confirm");
      let togglePasswordConfirm = e.querySelector(".password-confirm-toggle-icon i");
      if (x.type === "password") {
        x.type = "text";
        togglePasswordConfirm.classList.remove("fa-eye");
        togglePasswordConfirm.classList.add("fa-eye-slash");
      } else {
        x.type = "password";
        togglePasswordConfirm.classList.remove("fa-eye-slash");
        togglePasswordConfirm.classList.add("fa-eye");
      }
    }
    function passwordT(e) {
      let x = document.getElementById("passwordT");
      let togglePassword = e.querySelector(".password-toggle-icon i");
      if (x.type === "password") {
        x.type = "text";
        togglePassword.classList.remove("fa-eye");
        togglePassword.classList.add("fa-eye-slash");
      } else {
        x.type = "password";
        togglePassword.classList.remove("fa-eye-slash");
        togglePassword.classList.add("fa-eye");
      }
    }
    function passwordConfirmT(e) {
      let x = document.getElementById("password-confirm-T");
      let togglePasswordConfirm = e.querySelector(".password-confirm-toggle-icon i");
      if (x.type === "password") {
        x.type = "text";
        togglePasswordConfirm.classList.remove("fa-eye");
        togglePasswordConfirm.classList.add("fa-eye-slash");
      } else {
        x.type = "password";
        togglePasswordConfirm.classList.remove("fa-eye-slash");
        togglePasswordConfirm.classList.add("fa-eye");
      }
    }
</script>
@endsection