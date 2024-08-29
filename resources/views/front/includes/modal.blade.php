			<!-- Log In Modal -->

			<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="loginmodal" aria-hidden="true">

				<div class="modal-dialog modal-xl login-pop-form" role="document">

					<div class="modal-content overli" id="loginmodal">

						<div class="modal-header">

							<h5 class="modal-title">Login Your Account</h5>

							<button type="button" class="close" data-dismiss="modal" aria-label="Close">

							  <span aria-hidden="true"><i class="fas fa-times-circle"></i></span>

							</button>

						  </div>

						<div class="modal-body">

							<div class="login-form">

								<form id="loginForm">

								@csrf

									<div class="form-group">

										<label>Email</label>

										<div class="input-with-icon">

											<input type="text" class="form-control" name="email" placeholder="email">

											<i class="ti-user"></i>

										</div>

									</div>

									

									<div class="form-group">

										<label>Password</label>

										<div class="input-with-icon">

											<input type="password" class="form-control" name="password" placeholder="*******">

											<i class="ti-unlock"></i>

										</div>

									</div>

									

								

									

									<div class="form-group">

										<button type="submit" class="btn btn-md full-width theme-bg text-white">Login</button>

									</div>

									

								

								

								</form>

							</div>

						</div>

						<div class="crs_log__footer d-flex justify-content-between mt-0">

							<div class="fhg_45"><p class="musrt">Don't have account? <a href="/signup" class="theme-cl">SignUp</a></p></div>

							<div class="fhg_45"><p class="musrt"><a href="/forgot" class="text-danger">Forgot password?</a></p></div>

						</div>

					</div>

				</div>

			</div>

			<!-- End Modal -->

            

            <!-- video_preview -->

            <div class="modal fade" id="video_preview" tabindex="-1" role="dialog" aria-labelledby="loginmodal" aria-hidden="true">

				<div class="modal-dialog modal-xl login-pop-form" role="document">

					<div class="modal-content overli" id="loginmodal">

						<div class="modal-header">

							<h5 class="modal-title">Preview</h5>

							<button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close">

							  <span aria-hidden="true"><i class="fas fa-times-circle"></i></span>

							</button>

						  </div>

						<div class="modal-body">

                        <video style="width:100%; height:auto;" id="video1" onended="videoEnd()" controls autoplay >

      <source src="" id="video_src" type="video/mp4">

</video>

						</div>

						

					</div>

				</div>

			</div>

