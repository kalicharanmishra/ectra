@extends('front.layouts.app')



@section('content')
<style type="text/css">
    .password-toggle-icon {
    position: absolute;
    top: 50%;
    width: 10%;
    right: 0px;
    transform: translateY(-50%);
    cursor: pointer;
    z-index: 99999999;
    height: 100%;
    border-top-right-radius: 3px;
    border-bottom-right-radius: 3px;
}
.form-control {
    display: block;
    width: 100%;
    /*padding: 0.5rem 2rem!important;*/
    /* font-size: 1rem; */
    line-height: 1.25;
    color: #495057;
    background-color: #fff;
    background-image: none;
    background-clip: padding-box;
    border: 1px solid rgba(0, 0, 0, .15);
    border-radius: .25rem;
    /* transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s; */
}

.password-toggle-icon i {
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
/*.password-confirm-toggle-icon {
  position: absolute;
  top: 50%;
  right: 35px;
  transform: translateY(-50%);
  cursor: pointer;
}

.password-confirm-toggle-icon i {
  font-size: 18px;
  line-height: 1;
  color: #333;
  transition: color 0.3s ease-in-out;
  margin-bottom: 20px;
}*/
</style>
    <!-- ============================================================== -->



    <!-- ============================ Login Wrap ================================== -->

    <section style="background: #FFFBEB">

        <div class="container">

            <div class="row justify-content-center">


                <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12">
                    <div class="crs_log_wrap">


                        <div class="crs_log__thumb">

                            <img src="{{ asset('front/assets/img/login.jpg') }}" class="img-fluid" alt="" />

                        </div>
                        <div class="crs_log__caption">


                            <form id="loginForm">
                                <div class="rcs_log_124 ">
                                @csrf
                                <div class="Lpo09">
                                    <h4>Sign In</h4>
                                    <p>(Existing users)</p>

                                </div>


                                {{-- <div class="crs_log__caption">

                                            <div class="rcs_log_123">

                                                <div class="rcs_ico"><i class="fas fa-lock"></i></div>

                                            </div>
                                        </div> --}}
                        <div class="form-group row mb-0">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">

                                    <label>Registered 10 digit mobile number/email</label>

                                    <div class="input-with-icon">

                                        <input type="text" class="form-control" name="email" placeholder="email/phone"
                                            autocomplete="off" required  oninvalid="this.setCustomValidity('This is a mandatory field, please fill this up')">

                                        <i class="ti-user"></i>

                                    </div>

                                </div>
                                
                               
                                <div class="form-group">

                                    <label>login type</label>

                                    <div class="input-with-icon">
                                        
                                        <input type="radio" id="student" class="form-controls" name="type" value="student" required  oninvalid="this.setCustomValidity('This is a mandatory field, please fill this up')">
                                        <label for="student">Student</label>
                                        <input type="radio" id="teacher" class="form-controls" name="type" value="tutor" required  oninvalid="this.setCustomValidity('This is a mandatory field, please fill this up')">
                                        <label for="teacher">Teacher</label>

                                    </div>

                                </div>
                            
                            </div>


                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">

                                    <label>Password</label>

                                    <div class="input-with-icon">

                                        <input type="password"  id="password" class="form-control" name="password" placeholder="*******"
                                            autocomplete="off" required  oninvalid="this.setCustomValidity('This is a mandatory field, please fill this up')">

                                        <i class="ti-unlock"></i>
                                        <span class="password-toggle-icon" onclick="password(this)">
                                            <i class="fas fa-eye"></i>
                                            </span>

                                    </div>
                                    <input id="remember" type="checkbox" 
                                            name="remember" autocomplete="off">
                                         <label for="remember">Remember password for future login.</label>
                                         @error('remember')
                                                <span class="invalid-feedback" role="alert">
                                                {{ $message }}
                                                </span>
                                                @enderror

                                </div>
                            </div>

                        </div>
                                <div class="form-group text-center">

                                    <button type="submit" class="btn btn-md full-width theme-bg text-white register-btn">Login</button>

                                </div>

							</div>

                            </form>

                            <div class="crs_log__footer d-flex justify-content-between mt-0">

                                <div class="fhg_45">
                                    <p class="musrt">New user? <a href="/signup" class="theme-cl">SignUp</a></p>
                                </div>

                                <div class="fhg_45">
                                    <p class="musrt"><a href="/forgot" class="text-danger">Forgot password?</a></p>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>



                <!-- <div class="col-xl-7 col-lg-8 col-md-12 col-sm-12">

               <form method="POST" action="{{ route('login') }}">

                                        @csrf

                <div class="crs_log_wrap">

                 <div class="crs_log__thumb">

                  <img src="{{ asset('front/assets/img/login.jpg') }}" class="img-fluid" alt="" />

                 </div>

                 <div class="crs_log__caption">

                  {{-- <div class="rcs_log_123">

											<div class="rcs_ico"><i class="fas fa-lock"></i></div>

										</div> --}}

                  

                                                

                  <div class="rcs_log_124">

                   <div class="Lpo09">
                    <h4>Sign In</h4>
                    <p>(Existing users)</p>
                     
                   </div>
                   <div class="form-group">

                    <label>User Name</label>

                    <input id="email" type="email"

                                                            class="form-control @error('email') is-invalid @enderror" name="email"

                                                            value="{{ old('email') }}" required autocomplete="email" autofocus>



                                                        @error('email')
        <span class="invalid-feedback" role="alert">

                                                                        <strong>{{ $message }}</strong>

                                                                    </span>
    @enderror

                   </div>

                   <div class="form-group">

                    <label>Password</label>

                    <input id="password" type="password"

                                                            class="form-control @error('password') is-invalid @enderror" name="password"

                                                            required autocomplete="current-password">

                                                        @error('password')
        <span class="invalid-feedback" role="alert">

                                                                        <strong>{{ $message }}</strong>

                                                                    </span>
    @enderror

                   </div>

                   

                   <div class="form-group">

                    <button type="submit" class="btn full-width btn-md theme-bg text-white">Login</button>

                   </div>

                  </div>

                  

                 </div>

                 <div class="crs_log__footer d-flex justify-content-between">

                  <div class="fhg_45"><p class="musrt">New user? <a href="/signup" class="theme-cl">Sign Up</a></p></div>

                  <div class="fhg_45"><p class="musrt"><a href="/forgot" class="text-danger">Forgot password?</a></p></div>

                 </div>

                </div>

               </form>

              </div> -->



            </div>

        </div>

    </section>

    <!-- ============================ Login Wrap ================================== -->



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
    </script>
@endsection
