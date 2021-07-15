@extends('frontend.layouts.main')
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

    <div class="login_form">
      <form class="formtheme" action="" method="post">
      @csrf
        <h3 class="hd">Add Admin</h3>        
        <div class="form-group">
         <input type="text" name="first_name" value="{{ old('first_name') }}" placeholder="First Name" class="form-control">
        	<span class="font-weight-bold text-danger">
            	@if($errors->has('first_name'))
            		{{ $errors->first('first_name') }}
            	@endif
            </span>        
           </div>
        <div class="form-group">
         <input type="text" name="last_name" value="{{ old('last_name') }}" placeholder="Last Name" class="form-control">
        	<span class="font-weight-bold text-danger">
            	@if($errors->has('last_name'))
            		{{ $errors->first('last_name') }}
            	@endif
           </span>        
        </div>   
         
        <div class="form-group">
       <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" class="form-control">
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
                </span>       
             </div>
        <div class="form-group">
         <input type="password" name="confirm_password" value="{{ old('confirm_password') }}" placeholder="Confirm Password" class="form-control">
        	<span class="font-weight-bold text-danger">
            	@if($errors->has('confirm_password'))
            		{{ $errors->first('confirm_password') }}
            	@endif
            </span>        
         </div>
         <input type="submit" name="submit" value="Register" class="butn butn-bg w-100 mt-3">
      </form>
    </div>
  </div>
</div>
@endsection



