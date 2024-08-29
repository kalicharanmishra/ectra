<!DOCTYPE html>

<html lang="zxx">



<head>

	<meta charset="utf-8" />

	<meta name="author" content="Themezhub" />

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Etcetra - Online Learning Platform</title>



	<!-- Custom CSS -->

	<link href="{{asset('front/assets/css/styles.css') }}" rel="stylesheet">


	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Comic+Neue:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&family=Poppins:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">




<!-- Owl Carousel CSS and JavaScript files -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"> -->
	<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>



<body>



	<!-- ============================================================== -->

	<!-- Main wrapper - style you can find in pages.scss -->

	<!-- ============================================================== -->

	<div id="main-wrapper">





		@include('front.includes.header')



		@yield('content')



		@include('front.includes.footer')

		@include('front.includes.modal')





		<a id="back2Top" class="top-scroll" title="Back to top" href="#"><i class="ti-arrow-up"></i></a>





	</div>

	<!-- ============================================================== -->

	<!-- End Wrapper -->

	<!-- ============================================================== -->



	<!-- ============================================================== -->
	
	<!-- All Jquery -->

	<!-- ============================================================== -->

	<script src="{{asset('front/assets/js/jquery.min.js') }}"></script>

	<script src="{{asset('front/assets/js/popper.min.js') }}"></script>

	<script src="{{asset('front/assets/js/bootstrap.min.js') }}"></script>

	<script src="{{asset('front/assets/js/select2.min.js') }}"></script>

	<script src="{{asset('front/assets/js/slick.js') }}"></script>

	<script src="{{asset('front/assets/js/moment.min.js') }}"></script>

	<script src="{{asset('front/assets/js/daterangepicker.js') }}"></script>

	<script src="{{asset('front/assets/js/summernote.min.js') }}"></script>

	<script src="{{asset('front/assets/js/metisMenu.min.js') }}"></script>

	<script src="{{asset('front/assets/js/custom.js') }}"></script>

	<script src="{{asset('front/assets/js/custom-script.js') }}"></script>

	<!-- ============================================================== -->

	<!-- This page plugins -->

	<!-- ============================================================== -->

	<!-- 
	General
	The core Firebase JS SDK is always required and must be listed first -->

	<script src="https://www.gstatic.com/firebasejs/7.18.0/firebase-app.js"></script>

	{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
	
	<!-- 	For Messaging
	TODO: Add SDKs for Firebase products that you want to use

	Do not copy below code as it is,values will be different for your app.


     https://firebase.google.com/docs/web/setup#available-libraries -->


	<script src="https://www.gstatic.com/firebasejs/7.18.0/firebase-messaging.js"></script>

	<script>

		// Your web app's Firebase configuration

		var firebaseConfig = {

			apiKey: "AIzaSyBGKvAZf4WoHWkqmWCHSle1R0fyX-BG_uw",

			authDomain: "mohita-972b6.firebaseapp.com",

			projectId: "mohita-972b6",

			storageBucket: "mohita-972b6.appspot.com",

			messagingSenderId: "323477864459",

			appId: "1:323477864459:web:6344f2d1d916238ec4070e"

		};





		// Initialize Firebase

		firebase.initializeApp(firebaseConfig);

		const messaging = firebase.messaging();

		//Custom function made to run firebase service 

		getStartToken();

		//This code recieve message from server /your app and print message to console if same tab is opened as of project in browser 

		messaging.onMessage(function(payload) {

			console.log("on Message", payload);

		});


		function getStartToken() {

			messaging.getToken().then((currentToken) => {

				if (currentToken) {

					sendTokenToServer(currentToken);

				} else {

					// Show permission request.

					RequestPermission();

					setTokenSentToServer(false);

				}

			}).catch((err) => {

				setTokenSentToServer(false);

			});

		}



		function RequestPermission() {

			messaging.requestPermission()

				.then(function(permission) {

				

						if (permission === 'granted') {

							console.log("have Permission");

							//calls method again and to sent token to server

							getStartToken();

						} else {

							console.log("Permission Denied");

						}

						// .catch(function(err) {

						// 	console.log(err);

						// })



					})

				}



					function sendTokenToServer(token) {

					    console.log(token)

						$.ajax({

							cache: false,

							type: "GET",

							async: false,

							url: "/api/notificationUpdate/"+token,

							data: token,

							contentType: "application/json; charset=ytf-8",

							dataType: "json",

							processData: true,

							success: function (result) {

								// alert("data");

							},

							error: function (xhr, textStatus, errorThrown) {

								//  alert(textStatus + ':' + errorThrown);

								 }

						});

					}



					function isTokensendTokenToServer() {

						return window.localStorage.getItem('sendTokenToServer') === '1';

					}



					function setTokenSentToServer(sent) {

						window.localStorage.setItem('sendTokenToServer', sent ? '1' : '0');

					}

	</script>


</body>

</html>