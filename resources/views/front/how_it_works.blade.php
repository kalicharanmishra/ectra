@extends('front.layouts.app')



@section('content')
    <style>
        .qouter {
            border-bottom: 1px solid;
            margin-bottom: 3%;
            box-shadow: 0 0 20px 0 rgb(22 22 22 / 30%);
            border-radius: 5px;
            line-height: 25px;
            display: flex;
            height: 80px;
            background: #fff
        }

        .qnumber {
            color: #fff;
            padding: 15px;
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
            margin-right: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .qans {
            display: flex;
            align-items: center;
            padding-right: 5px
        }
        @media screen and (max-width: 776px) {
 .qouter {
            line-height: 22px;
            height: 120px;
        }
        .martop{
            margin-top: 40px
        }
}
    </style>
    <div style="background: #FFFBEB">

        <section>

            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="">

                            <h1 class="text-center" style="color: #a30a0a;">How It Works</h1>
                        </div>



                    </div>

                </div>

            </div>

        </section>


        <div class="container-fluid">
            <div class="row">
                <div>

                </div>
                <div class="col-md-1">&nbsp;</div>
                <div class="col-md-5">
                    <h4  class="mb-5 text-center">For the students</h4>
                   
                    
                    <span>
                        <div class="qouter"><span class="qnumber"
                                style="background: #a30a0a">1.</span> <span
                                class="qans"> Interested students to visit www.etcetra.in and look through the wide variety
                                of classes that we have to offer</span></div>
                        <div class="qouter"><span class="qnumber"
                            style="background: #a30a0a">2.</span> <span
                                class="qans"> Compare the various teachers' class timings, years of teaching experience,
                                fees, etc. and choose the teacher whose class best suits your time availability, budget,
                                etc.</span></div>
                        <div class="qouter"><span class="qnumber"
                            style="background: #a30a0a">3.</span> <span
                                class="qans"> Once a teacher is selected, click on the "Enroll now" button and go ahead
                                with creating an account by filling in a few basic details.</span></div>
                        <div class="qouter"><span class="qnumber"
                            style="background: #a30a0a">4.</span> <span
                                class="qans"> This is followed by the mobile number verification process where the student
                                has to key in the OTP received by him / her on the registered mobile number</span></div>
                        <div class="qouter"><span class="qnumber"
                            style="background: #a30a0a">5.</span> <span
                                class="qans"> Then you are automatically taken to the payments page where you need to make
                                the requisite payment for your chosen class</span></div>
                        <div class="qouter"><span class="qnumber"
                            style="background: #a30a0a">6.</span> <span
                                class="qans"> Join and enjoy your class as per the class schedule</span></div>
                    </span>

                </div>
                <div class="col-md-5">
                    <h4 class="mb-5 text-center martop">For the teachers</h4>
                   

                    <span>
                        <div class="qouter"><span class="qnumber"
                                style="background: #a30a0a">1.</span> <span
                                class="qans"> Interested teachers to visit www.etcetra.in and look through the wide
                                variety of classes that are available and choose the category under which he / she would
                                want to list his / her class.</span></div>
                        <div class="qouter"><span class="qnumber"
                            style="background: #a30a0a">2.</span> <span
                                class="qans"> Click on "Join as a teacher" to create your account by keying in few
                                personal and professional details as required in the form.</span></div>
                        <div class="qouter"><span class="qnumber"
                            style="background: #a30a0a">3.</span> <span
                                class="qans"> This is followed by the mobile number verification process where you need to
                                key in the OTP received by you on your registered mobile number</span></div>
                        <div class="qouter"><span class="qnumber"
                            style="background: #a30a0a">4.</span> <span
                                class="qans"> Login to your account and share your course related details. Try to
                                make this description interesting and include demo videos if possible - this helps convert
                                more enquiries into actual class bookings</span></div>
                        <div class="qouter"><span class="qnumber"
                            style="background: #a30a0a">5.</span> <span
                                class="qans"> Once all details are entered, you are now ready to “Go Live” with your
                                course</span></div>
                        <div class="qouter"><span class="qnumber"
                            style="background: #a30a0a">6.</span> <span
                                class="qans"> Tell your family, friends and followers to check out your courses at
                                www.etcetra.in</span></div>
                    </span>

                </div>
                <div class="col-md-1">&nbsp;</div>
                <div class="col-12 pt-5"></div>
            </div>
        </div>

    </div>
@endsection
