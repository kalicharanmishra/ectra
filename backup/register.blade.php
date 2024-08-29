{{-- @extends('layouts.app') --}}



@extends('front.layouts.app')







@section('content')
    <!-- ============================================================== -->



    <section class="signup-bg">



        <!-- ============================ Signup Wrap ================================== -->



        <section style="padding: 0px">



            <div class="container">



                <div class="row justify-content-center">







                    <div class="col-xl-7 col-lg-8 col-md-12 col-sm-12">







                        <div class="crs_log_wrap">



                            <div class="crs_log__thumb">



                                <img src="{{ asset('front/assets/img/sign_up.jpg') }}" class="img-fluid" alt=""
                                    style="object-fit: cover" />



                            </div>



                            <div class="crs_log__caption">



                                <form method="POST" action="{{ route('register') }}">

                                    @csrf

                                    <div class="rcs_log_124">



                                        <div class="Lpo09">
                                            <h4>Sign Up</h4>
                                            <p>(New users)</p>

                                        </div>



                                        <div class="form-group row mb-0">



                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">



                                                <div class="form-group">



                                                    <label>Name</label>

                                                    {{-- {{ old('name') }} --}}

                                                    <input id="name" type="text"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        name="name" value="" required autocomplete="off" autofocus>
                                                    {{-- </div> --}}

                                                    @error('name')
                                                        <span class="invalid-feedback" role="alert">

                                                            <strong>{{ $message }}</strong>

                                                        </span>
                                                    @enderror

                                                </div>





                                            </div>

                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">

                                                <div class="form-group">



                                                    <label>Email</label>

                                                    {{-- {{ old('email') }} --}}

                                                    <input id="email" type="email"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        name="email" required autocomplete="off">



                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">

                                                            <strong>{{ $message }}</strong>

                                                        </span>
                                                    @enderror



                                                </div>

                                            </div>
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">

                                                <div class="form-group">

                                                    <label>Mobile number</label>

                                                    <input id="number" type="phone"
                                                        class="form-control"
                                                        name="number" required autocomplete="off">
                                                </div>

                                            </div>

                                           
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">

                                                <div class="form-group">

                                                    <label>Password</label>

                                                    <input id="password" type="password"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        name="password" required autocomplete="off">

                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">

                                                            <strong>{{ $message }}</strong>

                                                        </span>
                                                    @enderror



                                                </div>

                                            </div>

                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                                <div class="form-group">
                                                    <label>Confirm password</label>

                                                    <input id="password-confirm" type="password" class="form-control"
                                                        name="password_confirmation" required autocomplete="off">
                                                </div>

                                            </div>

                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">

                                                <div class="form-group">

                                                    <button type="submit"
                                                        class="btn full-width btn-md theme-bg text-white">

                                                        {{ __('Register') }}

                                                    </button>



                                                </div>

                                            </div>



                                        </div>



                                </form>






                            </div>



                            <div class="crs_log__footer d-flex justify-content-between">



                                <div class="fhg_45">
                                    <p class="musrt">Existing user? <a href="/login" class="theme-cl">Sign In</a>
                                    </p>
                                </div>



                                <div class="fhg_45">
                                    <p class="musrt"><a href="{{ route('front.forgot') }}" class="text-danger">Forgot
                                            password?</a></p>
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
@endsection
