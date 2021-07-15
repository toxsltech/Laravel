<?php
use Illuminate\Support\Facades\Session;
?>
@extends('frontend.layouts.main')
@section('title', ' Login - User')
@section('content')
<div id="main-wrapper" class="bg-gray">
  <div class="position-relative login_main">
    <div class="home_login">
      <div class="owl-carousel owl-theme">
        <div class="item">
          <img src="{{ asset('public/frontend/imgs/banners/1.jpg') }}" alt="aery">
        </div>
        <div class="item">
          <img src="{{ asset('public/frontend/imgs/banners/2.jpg') }}" alt="aery">
        </div>
        <div class="item">
          <img src="{{ asset('public/frontend/imgs/banners/3.jpg') }}" alt="aery">
        </div>
        <div class="item">
          <img src="{{ asset('public/frontend/imgs/banners/4.jpg') }}" alt="aery">
        </div>
        <div class="item">
          <img src="{{ asset('public/frontend/imgs/banners/5.jpg') }}" alt="aery">
        </div>
        <div class="item">
          <img src="{{ asset('public/frontend/imgs/banners/6.jpg') }}" alt="aery">
        </div>
      </div>
    </div>

    <div class="login_form" id="login_form">
      <form method="POST" action="{{url('login')}}" class="formtheme">
      @csrf
        <h3 class="hd">Sign in with</h3>
        <ul class="social_signup">
          <li><a href="{{url('auth/facebook')}}" ><i class="fab fa-facebook-square"></i> Login with Facebook</a></li>
          <li><a href="{{ url('auth/google') }}" ><i class="fab fa-google-plus-g"></i> Login with Google</a></li>
        </ul>
        <div class="or-login">
          <p> <span>OR</span></p>
        </div>
        <div class="form-group">
          <input class="form-control unicase-form-control" type="text" name="email" placeholder="Email" value="{{ old('email') }}">
				<span class="font-weight-bold text-danger">
    					@if($errors->has('email'))
                    		{{ $errors->first('email') }}
                    	@endif   
                    	 @if(session()->has('errore'))
                                      <span class="errMsg">{{ session()->get('errore') }}</span>
                        @endif
                </span>
         </div>
        <div class="form-group">
         <input class="form-control unicase-form-control" type="password" name="password" placeholder="Password" value="{{ old('password') }}" >
			<span class="font-weight-bold text-danger">
					<span class="font-weight-bold text-danger">
					@if($errors->has('password'))
                		{{ $errors->first('password') }}
                	@endif
                	@if(session()->has('errorp'))
                                      <span class="errMsg">{{ session()->get('errorp') }}</span>
                     @endif                		
           </span>      
       </div>
        <div class="d-flex flex-wrap mt-4">
          <div class="custom-control custom-checkbox mb-3 mr-auto">
       
            <input type="checkbox" class="custom-control-input" id="customCheck" name="remember_me">
            <label class="custom-control-label" for="customCheck">Stay signed in</label>
          </div>
          <div class="">
            <a href="{{url('forgot-password')}}" >Forgot password?</a>
          </div>
        </div>
        <button type="submit" name="submit" class="butn butn-bg w-100 mt-3" >Sign in</button>       

        <div class="register text-center pt-4">Not a member yet? <a href="{{url('signup')}}">Register</a></div>
      </form>
    </div>
  </div>
  <div class="login_content pt-50 pb-100">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="space_content">
            <h3 class="text-uppercase mb-3">Your travel community</h3>
            <p>For adventure seekers looking for of the beaten path experiences across the world, the only travel planning site you will ever need. Do not rely on closed social media groups, travel agencies, guides and blogs anymore, Aery has everything you will ever need for your next trip and to make sure you create the perfect itinerary.</p>
            <p>Travellers just like you create hiking, city, lifestyle, culinary, cultural experiences and share them on the app. You can then check out our unique experience library and save them to your vision board, your very own personalized trip planner.</p>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection
