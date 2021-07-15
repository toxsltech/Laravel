<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@yield('title') | {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="@toxsl">
    <link rel="apple-touch-icon" href="">
    <link rel="shortcut icon" href="{{ asset('public/frontend/imgs/logo/fav.png') }}">
    <link rel="stylesheet" href="{{asset('public/admin/assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/admin/assets/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/admin/assets/css/style.css')}}">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{asset('public/admin/assets/css/jquery.dataTables.min.css')}}">
    <link href="{{ asset('public/assets/css/toastr.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('public/admin/assets/css/admin-app.css')}}">   
</head>
<body>
    @include('admin.layouts.sidebar')
    @include('admin.layouts.header')
    <section class="content">
        @include('flash-message')
        @yield('content')
    </section>
    <footer style="display: none;">
        <div class="text-center">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}  | All Rights Reserved | Developed by <a target="_blank" href="http://toxsl.com/">ToXSL Technologies Pvt. Ltd.</a></p>
        </div>
    </footer>
    
    <script src="{{ asset('public/frontend/js/popper.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/jquery.min.js') }}"></script>    
    <script src="{{asset('public/admin/assets/js/plugins.js')}}"></script>
    <script src="{{asset('public/admin/assets/js/main.js')}}"></script>
    <script src="{{asset('public/admin/assets/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('public/assets/js/toastr.min.js') }}"></script>
    <script src="{{ asset('public/assets/ckeditor/ckeditor.js') }}"></script>
    
    
    @yield('after_footer')
</body>
</html>
