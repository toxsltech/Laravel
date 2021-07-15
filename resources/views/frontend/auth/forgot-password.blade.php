@extends('frontend.layouts.main')
@section('title', 'Forgot-Password')
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

    <div class="login_form">
      <form method="POST" action="{{url('/forgot-password')}}" class="formtheme">
      @csrf
        <h3 class="hd">Forgot Password</h3>     
        <div class="form-group">
         <label class="info-title" for="username">Email Address</label>
          <input class="form-control unicase-form-control" type="text" name="email" placeholder="Email" value="{{ old('email') }}">
				<span class="font-weight-bold text-danger">
    					@if($errors->has('email'))
                    		{{ $errors->first('email') }}
                    	@endif                      	 
                </span>
         </div> 
        <button type="submit" name="submit" class="butn butn-bg w-100 mt-3" >Reset Password</button>
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
