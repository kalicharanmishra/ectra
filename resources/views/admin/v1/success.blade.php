@extends('front.layouts.app')
@section('content')
<style type="text/css">
    .otp-card.border {
    padding: 20px;
    border-radius: 8px;
    border: 1px solid #7cacd58f;
    max-width: 60%;
    margin: auto;
    box-shadow: 2px 1px 20px 0px #7cacd58f;
}


.otp-card img {
    max-width: 90px;
    margin: auto;
    display: block;
}

.otp-card a{text-decoration: none;margin: 5px auto}

.otp-card h2{margin: 10px 0px}
.otp-card p {
    margin: 20px 0; 
    text-align: left;
    color: #555;

}
.otp-card .btn {
    border: 0;
/*    background: var(--Grediyent, linear-gradient(92deg, #D0FE1D 10.68%, #008F7A 86.06%));*/
background: #a30a0a;
    border-radius: 50px;
    padding: 9px 30px;
    font-size: 20px;
    color: #fff;
    text-transform: uppercase;
    font-weight: 600;
    margin: auto;
    display: block;
    max-width: calc(100% - 50px);
    text-align: center;
    cursor: pointer;
    width: 100%;
    transition: all .3s;
    margin: auto;
}
.otp-card a.btn:hover {
/*    background: var(--Grediyent, linear-gradient(62deg, #D0FE1D 20.68%, #008F7A 86.06%));*/
}
.otp-container {
/*    position: absolute;*/
/*    top: 50%;*/
/*    transform: translate(-50%, -50%);*/
/*    left: 50%;*/
/*    width: 100%;*/
    margin: 60px;
}

.text-center{text-align: center !important;}
.d-block {
    display: block;

}
/* NOT VERIFIED CSS  */
.otp-not-verif .btn.otp-body {
    background: #da4352;
    border-color: #da4352;
}
.otp-card a.verif-link {
    margin-top: 17px;
    font-size: 18px;
    color: #da4352;
    text-decoration: underline;
}
.otp-body {
    background: #a30a0a;
    border: 1px solid #a30a0a;
    color: #fff;
    border-radius: 3px;
}
.teacher_credentials {
    font-size: 12px;
    color: #a30a0a!important;
    margin: auto 15px;
}
.teacher_credentials span {font-weight:500;}
</style>
     
        @if(Session::has('data') == false)
            <script>window.location = "{{route('front.signup')}}";</script>
        @else
            @php $data = Session::get('data');  @endphp
        @endif
   
<div class="otp-verif otp-container" style="display: block;">
    <div class="otp-card border text-center">
        <!-- <img src="{{asset('/images/otp_verify2.png')}}" alt=""> -->
            <h2>Welcome to the enriching world of Etcetra !!!</h2>
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <input type="hidden" name="name" value="@if(isset($data)){{$data['name']}}@endif">
                <input type="hidden" name="dob" value="@if(isset($data)){{$data['dob']}}@endif">
                <input type="hidden" name="email" value="@if(isset($data)){{$data['email']}}@endif">
                <input type="hidden" name="phone" value="@if(isset($data)){{$data['phone']}}@endif">
                <input type="hidden" name="gender" value="@if(isset($data)){{$data['gender']}}@endif">
                <input type="hidden" name="address" value="@if(isset($data)){{$data['address']}}@endif">
                <input type="hidden" name="user_type" value="@if(isset($data)){{$data['user_type']}}@endif">
                <input type="hidden" name="password" value="@if(isset($data)){{$data['password']}}@endif">
                <span>Click</span>
                
            <button type="submit" class="otp-body">here</button><span> to go to your @if(isset($data) && $data['user_type'] == 'user'){{'Student'}}@else{{'Teacher'}}@endif dashboard @if(isset($data) && $data['user_type'] == 'teacher')<br/> to complete your Sign Up @endif.</span>
            <p class="teacher_credentials"><span>Note:-</span>This is your user id : "{{@$data['phone']}}" and password : "{{@$data['password']}}".<br/> You will be required to use them everytime you login to your account, to attend your class, to make payment, etc.</p>
            
            </form>
             <!-- <a href="javascript:void(0)" class="btn otp-body">Okay</a> -->
    </div>
</div>
@endsection