
@extends('frontend.layouts.main')
@section('title', 'SignUp - New User')
@section('content')
<div id="main-wrapper" class="bg-gray">
  <div class="position-relative login_main">
    <div class="home_login signup">
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
     <form class="formtheme" action="" method="post">
      @csrf
        <h3 class="hd">Sign up with</h3>
        <ul class="social_signup">
          <li><a href="{{url('auth/facebook')}}" ><i class="fab fa-facebook-square"></i> Login with Facebook</a></li>
          <li><a href="{{ url('auth/google') }}" ><i class="fab fa-google-plus-g"></i> Login with Google</a></li>
        </ul>
        <div class="or-login">
          <p> <span>OR</span></p>
        </div>
        <div class="form-group">
         <input type="text" name="first_name" value="{{ old('first_name') }}" maxlength="30" placeholder="First Name" class="form-control">
        	<span class="font-weight-bold text-danger">
            	@if($errors->has('first_name'))
            		{{ $errors->first('first_name') }}
            	@endif
            </span>        
           </div>
        <div class="form-group">
         <input type="text" name="last_name" value="{{ old('last_name') }}" maxlength="30" placeholder="Last Name" class="form-control">
        	<span class="font-weight-bold text-danger">
            	@if($errors->has('last_name'))
            		{{ $errors->first('last_name') }}
            	@endif
           </span>        
        </div> 
        <div class="form-group">
         <input type="text" name="date_of_birth" id="id_dateOfBirth" onfocus="(this.type='date')" value="{{ old('date_of_birth') }}" placeholder="Date of Birth" class="form-control">
        	<span class="font-weight-bold text-danger">
            	@if($errors->has('date_of_birth'))
            		{{ $errors->first('date_of_birth') }}
            	@endif
            	@if(session()->has('age_error'))
                     <span class="errMsg">{{ session()->get('age_error') }}</span>
                @endif
           </span>        
        </div>   
         
        <div class="form-group">
       <input type="text" name="email" value="{{ old('email') }}" placeholder="Email" class="form-control">
        	<span class="font-weight-bold text-danger">
            	@if($errors->has('email'))
            		{{ $errors->first('email') }}
            	@endif
            </span>        </div>
        <div class="form-group">
        <input type="password" name="password" value="{{ old('password') }}" placeholder="Password" class="form-control">
            	<span class="font-weight-bold text-danger">
                	@if($errors->has('password'))
                		{{ $errors->first('password') }}
                	@endif
                </span>        </div>
        <div class="form-group">
         <input type="password" name="confirm_password" value="{{ old('confirm_password') }}" placeholder="Confirm Password" class="form-control">
                	<span class="font-weight-bold text-danger">
                    	@if($errors->has('confirm_password'))
                    		{{ $errors->first('confirm_password') }}
                    	@endif
                    </span>
        </div>
        <div class="d-flex flex-wrap mt-4">
          <div class="custom-control custom-checkbox mb-3 mr-auto">
            <input type="checkbox" class="custom-control-input" id="customCheck" name="terms_condition">           
            <label class="custom-control-label" for="customCheck"><span>I agree to <a href="{{url('term-condition')}}"><b>Terms and Conditions</b></a></span></label>
         	</div>
         	<span class="font-weight-bold text-danger">
            	@if($errors->has('terms_condition'))
            		{{ $errors->first('terms_condition') }}
            	@endif
            </span>
        </div>
         <input type="submit" name="submit" value="Register" class="butn butn-bg w-100 mt-3">
        <div class="register text-center pt-4">Already a part of Aery? <a href="{{url('/')}}">Click here</a> for Login</div>
      </form>
    </div>
  </div>
  <div class="login_content pt-20 pb-100">
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