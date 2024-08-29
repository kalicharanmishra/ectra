@extends('front.layouts.app')



@section('content')

    <style>

        /* .checkout-section{

            margin-top: 7%;

        } */

        /* .checkout-form .order-confirm-sheet {

            padding-left: 60px;

        } */

        .checkout-form .main-title {

            font-size: 32px;

            padding-bottom: 55px;

        }

        .checkout-form .order-confirm-sheet .order-review {

            border: 1px solid #e5e5e5;

            padding: 30px 20px;
            background: #fff;

        }

       .buy_table table,
       .buy_table tr,
       .buy_table td ,
       .buy_table th{
            
    border: 1px solid black;
}
.buy_table tr, 
.buy_table td ,
.buy_table th{
            padding: 10px !important;
            font-size: 20px
}

        .checkout-form .order-confirm-sheet .order-review .product-review tbody th span {

            font-family: 'gilroy-semibold';

            font-size: 18px;

            color: var(--text-dark);

            font-weight: normal;

        }

        .checkout-form .order-confirm-sheet .order-review .product-review tbody th, .checkout-form .order-confirm-sheet .order-review .product-review tbody td {

            padding-bottom: 25px;

        }

        .checkout-form .order-confirm-sheet .order-review .product-review tfoot td, .checkout-form .order-confirm-sheet .order-review .product-review tfoot th {

            border-top: 1px solid #e9e9e9;

            padding-top: 15px;

        }

        .checkout_boxradius {

            border: 1px solid #a1a1a1;

            border-radius: 6px;

            padding: 20px 20px 10px 20px;

            font-size: 12px;

            margin-bottom: 30px;

        }

        html, body, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, dfn, em, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td {

            vertical-align: baseline;

            text-decoration: none;

            margin: 0;

            padding: 0;

        }

        .shadow {

            box-shadow: 0 0 35px rgb(140 152 164 / 20%);

            padding: 2%;

        }

        .checkout-form .order-confirm-sheet .order-review .product-review {

            width: 100%;

        }

        .checkout-form .order-confirm-sheet .policy-text {

            font-size: 15px;

            line-height: 22px;

            padding: 25px 0 20px;

        }

        .checkout-form .order-confirm-sheet .agreement-checkbox label {

            position: relative;

            font-size: 16px;

            color: var(--text-dark);

            cursor: pointer;

            padding-left: 30px;

            margin-bottom: 35px;

        }

        /.checkout-form .order-confirm-sheet .agreement-checkbox input[type="checkbox"] {/

        /*    display: none;*/

        /}/

        input[type=checkbox], input[type=radio] {

            box-sizing: border-box;

            padding: 0;

        }



    </style>

    <style>



        .custom-control-input {

            position: relative;

            left: 0;



            width: 1rem;

            height: 1.25rem;

            opacity: 1;

            top: 4px;

            margin-right: 8px;

        }



        #guestform {

            display: none;

        }



        .checkout_boxradius {

            border: 1px solid #a1a1a1;

            border-radius: 6px;

            padding: 20px 20px 10px 20px;

            font-size: 12px;

            margin-bottom: 30px;

        }



        .checkout_boxradius .gift_option {

            font-size: 15px;

            color: #676767;

            font-weight: 600;

            height: 150px;

            display: table;

            vertical-align: middle;

            width: 100%;

        }



        .custom-control {

            position: relative;

            display: block;

            min-height: 1.5rem;

            padding-left: 1.5rem;

        }



        .gift_option {

            font-size: 13px;

            line-height: 20px;

            letter-spacing: 1px;

        }



        .custom-control-input {

            position: relative;

            left: 0;

            /z-index: -1;/

            width: 1rem;

            height: 1.25rem;

            opacity: 1;

        }



        .custom-control-label {

            position: relative;

            margin-bottom: 0;

            vertical-align: top;

            padding-left: 12px;

            padding-top: 0px;

        }

        .error{

            color: #da3f3f;

        }

        .checkout-form .other-note-area textarea {

            width: 100%;

            border: 1px solid #e5e5e5;

            padding: 15px;

            resize: none;

            height: 145px;

        }

        tr{

            display: table-row;

        }

        .form-control{

            margin: 10px;

        }

    </style>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <div class="checkout-section pt-5 pb-5" style="background-color: #FFFBEB;">

    <div class="container">

        @if ($errors->any())

            <div class="alert alert-danger">

                <strong>Opps!</strong> Something went wrong<br>

                <ul>

                    

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        <form action=" @if(!empty($trialdata)) {{ route('front.trialpay') }} @else {{ route('front.pay') }} @endif" method="post" class="checkout-form" id="formcheckout">

@csrf

            <input type="hidden" name="id" value="{{Auth::user()->id}}">

            <input type="hidden" name="course_id" value="@if(!empty($trialdata)){{$trialdata->id}} @else {{$data->id}} @endif">

            <input type="hidden" name="paymentID" id="paymentID" >

            <input type="hidden" name="paymentDate" id="paymentDate" >

            <div class="row justify-content-center">

                



                <div class="col-lg-6">

                    <div class="order-confirm-sheet mb-3">  

                        <h2 class="main-title">Order Details</h2>

                        <div class="order-review buy_table">

                            <table class="product-review">

                                <tbody>



                                <tr>

                                    <th>

                                        <span>Subtotal</span>

                                    </th>

                                    <td><span>
                                        @if(!empty($trialdata)) {{50}} @else {{$data->price}} @endif
                                    </span></td>

                                </tr>

{{--                                <tr>--}}

{{--                                    <th>--}}

{{--                                        <span>Shipping</span>--}}

{{--                                    </th>--}}

{{--                                    <td><span>0</span></td>--}}

{{--                                </tr>--}}





                                </tbody>

                                <tfoot>

                                <tr>

                                    <th><span>Total</span></th>

                                    <td><span> 
                                        @if(!empty($trialdata)) {{50}} @else {{$data->price}} @endif
                                    </span></td>

                                </tr>

                                </tfoot>

                            </table> <!-- /.product-review -->





                            <p class="policy-text">Your personal data will be use for your order, support

                                your experience through this website &amp; for other purpose described in our

                                privacy policy</p>

                            <div class="agreement-checkbox">

                                <input type="checkbox" name="agreement" id="agreement" required="">

                                <label for="agreement">I have read and agree to the website <a href="" target="_blank">terms and

                                    conditions*</a></label>

                            </div> <!-- /.agreement-checkbox -->



                            <div class="pay">

                                <button class="btn btn-block btn-success  btn filled small" id="paybtn" type="button" style="visibility: visible; animation-name: fadeInLeft;">Pay</button>

                         

                            </div>



                        </div> <!-- /.order-review -->

                    </div> <!-- /.order-confirm-sheet -->

                </div>

            </div> <!-- /.row -->



        </form> <!-- /.checkout-form -->

    </div> <!-- /.container -->

</div>



    <!-- Modal -->

    

    <script>

        function padStart(str) {

            return ('0' + str).slice(-2)

        }



        function demoSuccessHandler(transaction) {

            // You can write success code here. If you want to store some data in database.

            $("#paymentDetail").removeAttr('style');

            $('#paymentID').val(transaction.razorpay_payment_id);

            var paymentDate = new Date();

            $('#paymentDate').val(

                padStart(paymentDate.getDate()) + '.' + padStart(paymentDate.getMonth() + 1) + '.' + paymentDate.getFullYear() + ' ' + padStart(paymentDate.getHours()) + ':' + padStart(paymentDate.getMinutes())

            );

            document.getElementById('formcheckout').submit();               

            

        }

    </script>

    <script>
        @if(!empty($data))
       var amount = '{{$data->price}}';
       @else
       var amount = "{{'50'}}";
       @endif

        var options = {

            key: "{{env('ROZERPAY_KEY')}}",

            amount: amount*100,

            name: '{{env('APP_NAME')}}',

            description: '{{env('APP_NAME')}} Subscription Payment',

            image: 'https://bebals.in/user/images/logo/logopurple.png',

            handler: demoSuccessHandler

        }

    </script>

    <script>

        window.r = new Razorpay(options);

        document.getElementById('paybtn').onclick = function () {

alert()

            if($('input[name=agreement]:checked').length > 0){

            // if($("#formcheckout").valid() == true) {

          

                r.open()

            }else{

                alert('select address and check T&C')

           

            }

        }

        

        function addNewAddress(e){

            

        }

    </script>

    <script>



 function addressshow(){

     if(document.getElementById('addresscheck').checked){

   document.getElementById('addresshide').style.display = 'none'

     }else{

         document.getElementById('addresshide').style.display = 'block'

     }

  };



</script>

@endsection