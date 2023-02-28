<?php // header('Clear-Site-Data: "cache"'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="refresh" content="{{ config('session.lifetime') * 60 }}">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, viewport-fit=cover, shrink-to-fit=no">
<meta name="description" content="LMS">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="theme-color" content="#179CF0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<title>LMS</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap" rel="stylesheet">
<link rel="icon" href="{{asset('images/lms-logo.png')}}">
<link rel="apple-touch-icon" href="{{asset('images/lms-logo.png')}}">
<link rel="apple-touch-icon" sizes="152x152" href="{{asset('images/lms-logo.png')}}">
<link rel="apple-touch-icon" sizes="167x167" href="{{asset('images/lms-logo.png')}}">
<link rel="apple-touch-icon" sizes="180x180" href="{{asset('images/lms-logo.png')}}">
<link rel="stylesheet" href="{{asset('app/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('app/css/animate.css')}}">
<link rel="stylesheet" href="{{asset('app/css/owl.carousel.min.css')}}">
<!-- <script src="https://kit.fontawesome.com/181da3f5e8.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.2.0/css/select.dataTables.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.standalone.min.css"> -->
<link rel="stylesheet" href="{{asset('quickadmin/css/font-awesome.min.css')}}">
<link rel="stylesheet" href="{{asset('app/css/jquery-ui.css')}}">
<link rel="stylesheet" href="{{asset('app/css/jquery-ui-timepicker-addon.min.css')}}"/>
<link rel="stylesheet" href="{{asset('app/css/bootstrap-datepicker.standalone.min.css')}}">
<link rel="stylesheet" href="{{asset('app/css/magnific-popup.css')}}">
<link rel="stylesheet" href="{{asset('app/lmsnew.css')}}">
<link rel="manifest" href="{{asset('app/manifest.json')}}">
<script src="{{asset('app/js/jquery.min.js')}}"></script>
</head>
<body>
@if(Route::is('home') || Route::current()->getName()=='homepage') 
<!-- <div class="lmsapp-loader">
<div class="lmsapp-loader-img"> 
<img height="188.8" width="188.8" class="img-fluid" src="{{asset('images/lms-logo.png')}}">
</div>
</div> -->
@else

@endif

<div class="pt-2"></div>
@include('lmsapp.layouts.header')
@include('layouts.toastr')

@include('front.layouts.selects')

@include('lmsapp.layouts.sidebar')

<div class="page-content-wrapper">
@yield('content')
</div>

<div class="py-3"></div>
@include('lmsapp.layouts.footer')
<script type="text/javascript">
$(window).on('load', function(){  
$('.lmsapp-loader').fadeOut();
});
</script>
<script src="{{asset('app/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('app/js/owl.carousel.min.js')}}"></script>
<script src="{{asset('app/js/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('app/js/dark-mode-switch.js')}}"></script>
<script src="{{asset('app/js/no-internet.js')}}"></script>
<script src="{{asset('app/js/active.js')}}"></script>
<script src="{{asset('app/js/pwa.js')}}"></script>
<script src="{{asset('app/js/jquery-ui.min.js')}}"></script>


<!-- <script src="{{ asset('quickadmin/js/main.js') }}"></script> -->

<script>
window._token = '{{ csrf_token() }}';
</script>
<script>
function regtogglePassword() {
var x = document.getElementById("regpassword");
if (x.type === "password") {
x.type = "text";
} else {
x.type = "password";
}
}

function logintogglePassword() {
var x = document.getElementById("logpassword");
if (x.type === "password") {
x.type = "text";
} else {
x.type = "password";
}

}
</script>


</body>
</html>