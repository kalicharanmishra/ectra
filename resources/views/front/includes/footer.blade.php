<!-- ============================ Call To Action ================================== -->

<?php

$category = App\Models\Categories::limit(6)->get();

?>
<!-- ============================ Footer Start ================================== -->

<style>
    .lefte {
        width: 50%;
    }

    .footer_widget p {
        margin-bottom: 0px;
        line-height: 20px;
        margin: 0px;
        text-align: center;
    }

    .footer_widget h2 {
        text-align: center
    }
	.sdfgh{
		display: flex;
		align-items: center;

	}
</style>
<footer class="dark-footer skin-dark-footer style-2">

    <div class="footer-middle">

        <div class="container">

            <div class="row">



                <div class="col-lg-6 col-md-6 col-sm-12">

                    <div class="footer_widget lefte">
                        <p class="mb-4">Welcome to the magical world of</p>

                        <a href="" >
                            <h2 style="color:#fff;" class="mb-3">ETCETRA</h2>
                        </a>

                        <p style="line-height: 25px;">
                            A "NO STUDIES" school for <br>
                            THE WHOLE FAMILY,<br>
                            where learning never ends,<br>
                            where the fun never stops !!!<br>
                        </p>



                    </div>

                </div>



                <div class="col-lg-6 col-md-6 col-sm-12">

                    <div class="row">



                        <div class="col-lg-12 col-md-12">

                            <div class="footer_widget">

                                <h4 class="widget_title">IMPORTANT LINKS</h4>

                                <ul class="footer-menu">

                                    {{-- <li><a href="{{ route('front.index') }}">Home</a></li> --}}

									<li><a href="{{ route('front.aboutus', 'FAQs') }}">FAQs</a></li>
                                    <li><a href="{{ route('front.about') }}">About us</a></li>

									<li><a href="{{ route('front.aboutus', 'contactus') }}">Contact us</a></li>
                                    <li><a href="{{ route('front.link') }}">Privacy policy</a></li>

                                    <li><a href="{{ route('front.aboutus', 'TermsConditions') }}">Terms & conditions</a></li>


									<div class="sdfgh">
										<li style="margin-top: 0px"><a href="">Our social presence -</a></li>
										<div class="d-flex">
                                            <a href="">
                                                <img src="{{ asset('front/assets/img/facebook.png') }}"class="img-fluid" width="35px"
                                                    alt="">
                                            </a>
                                            <a href="">
                                                <img src="{{ asset('front/assets/img/instagram.png') }}"class="img-fluid" width="35px"
                                                    alt="">
                                            </a>
                                            <a href="">
                                                <img src="{{ asset('front/assets/img/linkedin.png') }}"class="img-fluid" width="35px"
                                                    alt="">
                                            </a>
                                            {{-- <a href="">
                                                <img src="{{ asset('front/assets/img/twitter.png') }}"class="img-fluid"
                                                    alt="">
                                            </a> --}}
                                        </div>
									</div>

                                    <!-- <li><a href="{{ route('front.aboutus', 'latestblog') }}">Latest Blog</a></li> -->
                                </ul>

                            </div>


                        </div>

                    </div>










                </div>



            </div>

        </div>

    </div>

    </div>

    </div>



    <div class="footer-bottom">

        <div class="container">

            <div class="row align-items-center">

                <div class="col-lg-12 col-md-12 text-center">

                    <p class="mb-0">© 2023 Etcetra.</p>

                </div>

            </div>

        </div>

    </div>

</footer>

<!-- ============================ Footer End ================================== -->
