<!DOCTYPE html>

<html class="loading" lang="en" data-textdirection="ltr">



<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

    <meta name="description" content="">

    <meta name="keywords" content="">

    <meta name="author" content="Sr Shorts">

    <title>Etcetra: {{ $title ?? 'Admin Panel' }}</title>

    <link rel="apple-touch-icon" href="{{ asset('thrill/v1/images/favicon.png') }}">

    <link rel="icon" type="image/x-icon" href="{{ asset('thrill/v1/images/favicon.png') }}">

    <link href="https://www.cssscript.com/demo/sticky.css" rel="stylesheet" type="text/css">

    <link

        href="https://fonts.googleapis.com/css?family=Muli:300,300i,400,400i,600,600i,700,700i%7CComfortaa:300,400,700"

        rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>

    @include('admin.v1.templates.parts.styles')

    {{-- cart js --}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js" charset="utf-8"></script>




<link rel="stylesheet" type="text/css" href="{{ url('clockpic/dist/jquery-clockpicker.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{ url('clockpic/assets/css/github.min.css')}}">
<style type="text/css">

.input-group {
	/* width: 110px; */
	margin-bottom: 10px;
}
.pull-center {
	/* margin-left: auto; */
	margin-right: auto;
}

.popover{
    top: 810px!important;
    left: 350px!important;
}
</style>


</head>



<body class="vertical-layout vertical-menu 2-columns fixed-navbar" data-open="click" data-menu="vertical-menu"

    data-color="bg-gradient-x-purple-blue" data-col="2-columns">

    @include('admin.v1.templates.parts.header')

    @include('admin.v1.templates.parts.sidebar')

    @yield('content')

    @include('admin.v1.templates.parts.footer')

    @include('admin.v1.templates.parts.scripts')

    <link rel="stylesheet" href="https://www.cssscript.com/demo/vertical-hierarchical-tree-x/style/core.css">

    <link rel="stylesheet" href="https://www.cssscript.com/demo/hierarchical-tree-radio-button/ninotree.css">

    <script src="https://www.cssscript.com/demo/vertical-hierarchical-tree-x/treex.js"></script>

    <!--<script src="https://www.cssscript.com/demo/hierarchical-tree-radio-button/ninotree.js"></script>-->


<script type="text/javascript" src="{{ url('clockpic/dist/jquery-clockpicker.min.js')}}"></script>
<script type="text/javascript">
$('.clockpicker').clockpicker()
	.find('input').change(function(){
		console.log(this.value);
	});
$('#single-input').clockpicker({
	placement: 'bottom',
	align: 'right',
	autoclose: true,
	'default': '20:48'
});
$('.clockpicker-with-callbacks').clockpicker({
		donetext: 'Done',
		init: function() { 
			console.log("colorpicker initiated");
		},
		beforeShow: function() {
			console.log("before show");
		},
		afterShow: function() {
			console.log("after show");
		},
		beforeHide: function() {
			console.log("before hide");
		},
		afterHide: function() {
			console.log("after hide");
		},
		beforeHourSelect: function() {
			console.log("before hour selected");
		},
		afterHourSelect: function() {
			console.log("after hour selected");
		},
		beforeDone: function() {
			console.log("before done");
		},
		afterDone: function() {
			console.log("after done");
		}
	})
	.find('input').change(function(){
		console.log(this.value);
	});
if (/Mobile/.test(navigator.userAgent)) {
	$('input').prop('readOnly', true);
}
</script>
<!-- <script type="text/javascript" src="{{ url('clockpic/assets/js/highlight.min.js') }}"></script> -->
<script type="text/javascript">
hljs.configure({tabReplace: '    '});
hljs.initHighlightingOnLoad();
</script>

</body>
</html>