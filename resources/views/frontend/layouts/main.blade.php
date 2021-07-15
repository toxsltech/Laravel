<?php
use Illuminate\Routing\Route;
?>
<!DOCTYPE html>
<html>

<head>
  <!-- Metas -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
 <meta name="author" content="@toxsl">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Title  -->
  <title>@yield('title') | {{ config('app.name') }}</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="{{ asset('public/frontend/imgs/logo/fav.png') }}">
  <!-- Plugins -->
  <link rel="stylesheet" href="{{ asset('public/frontend/css/plugins.css') }}">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
 
  <!-- Style Css -->
  <link rel="stylesheet" href="{{ asset('public/frontend/css/style.css') }}">
  <!-- responsive Css -->
  <link rel="stylesheet" href="{{ asset('public/frontend/css/responsive.css') }}">
  <!-- fontawesome Css -->
  <link rel="stylesheet" href="{{ asset('public/frontend/css/fontawesome/css/all.css') }}">
  
  <link href="{{ asset('public/assets/css/toastr.min.css') }}" rel="stylesheet" />
  
  <link href='https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.css' rel='stylesheet' />  
  <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.5.1/mapbox-gl-geocoder.css" type="text/css"/> 
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
  
  
</head>
<body>
    @include('frontend.layouts.header')
    @include('flash-message')
    @yield('content')
     <footer style="display: none;">
        <div class="text-center">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}  | All Rights Reserved | Developed by <a target="_blank" href="http://toxsl.com/">ToXSL Technologies Pvt. Ltd.</a></p>
        </div>
    </footer>
     @include('frontend.layouts.footer')  
     
    @yield('after_footer')
</body>
</html>