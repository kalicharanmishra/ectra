@extends('front.layouts.app')



@section('content')
<style>
/*	.justify-content-center{position: relative;}*/
	.alertbox {
    height: auto;
    position: absolute;
/*    z-index: 999;*/
    top: 16px;
    background: #fff;
    border: 1px solid #a30a0a;
/*    color: #a30a0a;*/
    font-size: large;
    font-weight: 600;
}
.alert {
    padding: .5rem 1.25rem!important;
    margin-bottom: 1rem;
    border-radius: .25rem;
    text-align: center;
}
.alertbox h4 {color:#a30a0a;font-size: 17px;}
</style>

			<!-- ============================================================== -->
<!-- style="padding: 20px 0 55px;" -->
			<section class="bg-forgot" >

			<!-- ============================ Login Wrap ================================== -->

			<!-- <section> -->

				<div class="container">

					<div class="row justify-content-center" @if (session('success') || session('error')) style="margin-top: 89px;" @endif>
						
					     @if (session('status'))
					     <div style="width: 55%; margin: auto;">
                        <div class="alertbox alert alert-success" role="alert">

                            {{ session('status') }}

                        </div>
                    </div>

                    @endif

					 @if (session('success'))
					 <div style="width: 55%; margin: auto;">
                        <div class="alertbox alert alert-success" role="alert">

                            <h4>@php echo session('success');@endphp</h4>

                        </div>
                        </div>
                    @endif
                

						<div class="col-xl-7 col-lg-8 col-md-12 col-sm-12">
							<!-- <div class="card"> -->

								
                    <!-- <div class="card-body"> -->

						   <form method="POST" action="{{ route('front.forgot.password') }}">

                        @csrf

								<div class="crs_log_wrap">

									<div class="crs_log__thumb">

										<img src="{{ asset('front/assets/img/forgot_password.jpg') }}" class="img-fluid" alt="" />

									</div>

									<div class="crs_log__caption">

										{{-- <div class="rcs_log_123">

											<div class="rcs_ico"><i class="fas fa-lock"></i></div>

										</div> --}}

										

										<div class="rcs_log_124">

											<div class="Lpo09"><h4>Forgot password</h4></div>

											<div class="form-group">

												<label>Enter mobile number / email</label>

											 <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>



                                @error('email')

                                    <span class="invalid-feedback" role="alert">

                                        <strong>{{ $message }}</strong>

                                    </span>

                                @enderror

											</div>

											<div class="form-group">

												<button type="submit" class="btn full-width btn-md theme-bg text-white">  {{ __('Send password reset link') }}</button>

											</div>

										</div>

									</div>

									<div class="crs_log__footer d-flex justify-content-between">

										<div class="fhg_45"><p class="musrt">New user? <a href="/signup" class="theme-cl">Sign Up</a></p></div>

												<div class="fhg_45"><p class="musrt">Existing user? <a href="/login" class="theme-cl">Sign In</a></p></div>

									</div>

								</div>

							</form>

						</div>

					<!-- </div> -->

					</div>

				</div>
			<!-- </div> -->
			<!-- </section> -->

			<!-- ============================ Login Wrap ================================== -->

		</section>

			<!-- ============================ Footer Start ================================== -->

@endsection





