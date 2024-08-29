@extends('front.layouts.app')



@section('content')
<style>
    .password-confirm-toggle-icon {
        position: absolute;
        bottom: 16%;
        right: 43px;
        transform: translateY(-50%);
        cursor: pointer;
    }
    .password-toggle-icon {
        position: absolute;
        top: 55%;
        right: 43px;
        transform: translateY(-50%);
        cursor: pointer;
    }

    .justify-content-center{padding-bottom: 45px;position: relative;}
    .alertbox {
    height: auto;
    position: absolute;
/*    z-index: 999;*/
    top: 15px;
    left:3%;
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
.card-body {
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    padding: 1.25rem;
}
</style>
<section class="bg-forgot">
<div class="container">

    <div class="row justify-content-center"  @if (session('success') || session('error'))style="margin-top: 89px!important;"@endif>
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
        <div class="col-md-8">

            <!-- <div class="card" > -->
                
                <!-- <div class="card-body" > -->

                    <form method="POST" action="{{ route('forgot.password.update') }}">

                        @csrf

                        <div class="crs_log_wrap">

                                    <div class="crs_log__thumb">

                                        <img src="{{ asset('front/assets/img/forgot_password.jpg') }}" class="img-fluid" alt="" />

                                    </div>

                                    <div class="crs_log__caption">

                                        {{-- <div class="rcs_log_123">

                                            <div class="rcs_ico"><i class="fas fa-lock"></i></div>

                                        </div> --}}

                                        
                                        <input type="hidden" name="token" value="{{ $token }}">
                                        @error('token')

                                            <span class="invalid-feedback" role="alert">

                                                <strong>{{ $message }}</strong>

                                            </span>

                                        @enderror

                                        <div class="rcs_log_124">

                                            <div class="Lpo09"><h4>Forgot password reset</h4></div>

                                            <div class="form-group">

                                                <label>Email</label>

                                             <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="@if(!empty($userData)){{$userData->email}}@endif" readonly autocomplete="email" autofocus>



                                @error('email')

                                    <span class="invalid-feedback" role="alert">

                                        <strong>{{ $message }}</strong>

                                    </span>

                                @enderror

                                            </div>

                                            <div class="form-group">

                                                <label>New password</label>

                                             <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" value="{{old('password')}}"  required autocomplete="password" autofocus>

                                             <span class="password-toggle-icon" onclick="password(this)"><i class="fas fa-eye"></i></span>

                                @error('password')

                                    <span class="invalid-feedback" role="alert">

                                        <strong>{{ $message }}</strong>

                                    </span>

                                @enderror

                                            </div>

                                            <div class="form-group">

                                                <label>Confirm password</label>

                                             <input id="password-confirm" type="password" id="password-confirm" class="form-control @error('confirm_password') is-invalid @enderror" name="confirm_password" value="{{old('confirm_password')}}"  required autocomplete="confirm_password" autofocus>
                                             <span class="password-confirm-toggle-icon" onclick="passwordConfirm(this)"><i class="fas fa-eye"></i></span>


                                @error('confirm_password')

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

                                    
                        </div>

                    </form>

                <!-- </div> -->

            <!-- </div> -->

        </div>

    </div>

</div>
</section>
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
</script>
@endsection

