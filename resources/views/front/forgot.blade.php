@extends('front.layouts.app')



@section('content')

			<!-- ============================================================== -->

			<section class="bg-forgot">

			<!-- ============================ Login Wrap ================================== -->

			<section>

				<div class="container">

					<div class="row justify-content-center">

					

						<div class="col-xl-7 col-lg-8 col-md-12 col-sm-12">

							<form>

								<div class="crs_log_wrap">

									<div class="crs_log__thumb">

										<img src="{{ asset('front/assets/img/forgot_password.png') }}" class="img-fluid" alt="" />

									</div>

									<div class="crs_log__caption">

										<div class="rcs_log_123">

											<div class="rcs_ico"><i class="fas fa-lock"></i></div>

										</div>

										

										<div class="rcs_log_124">

											<div class="Lpo09"><h4>Forgot password</h4></div>

											<div class="form-group">

												<label>Enter Email</label>

												<input type="text" class="form-control" placeholder="mail@mail.com" />

											</div>

											<div class="form-group">

												<button type="button" class="btn full-width btn-md theme-bg text-white">Forgot password</button>

											</div>

										</div>

									</div>

									<div class="crs_log__footer d-flex justify-content-between">

										<div class="fhg_45"><p class="musrt">New user ? <a href="/signup" class="theme-cl">Sign Up</a></p></div>

												<div class="fhg_45"><p class="musrt">Existing user ? <a href="/login" class="theme-cl">Sign In</a></p></div>

									</div>

								</div>

							</form>

						</div>



					</div>

				</div>

			</section>

			<!-- ============================ Login Wrap ================================== -->

		</section>

			<!-- ============================ Footer Start ================================== -->

@endsection