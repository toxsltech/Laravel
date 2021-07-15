<?php
use Illuminate\Support\Facades\Auth;
$user=Auth::user();
?>
@extends('frontend.layouts.main')
@section('title', 'Contact Us - Form')
@section('content')
<div id="main-wrapper" class="bg-gray section-ptb">
  <div class="hr-line hr-heading">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h5 class="text-uppercase">Contact Us</h5>
          <hr>
        </div>
      </div>
    </div>
  </div>
  <div class="discover_main section-pt">
    <div class="container">
      <div class="row">
         <form class="contact-us-form" method="post">  
          @csrf                                                      
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                    <div class="form-group">
                        <label class="sr-only control-label" for="name">name<span class=" "> </span></label>
                        <input id="name" name="name" value="{{old('name')}}" maxlength="60" type="text" placeholder="Name" class="form-control input-md">
                        @if ($errors->has('name'))
				             <div class="error">{{ $errors->first('name') }}</div>
				         @endif
                    </div>
                </div>                               
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                    <div class="form-group">
                        <label class="sr-only control-label" for="email">Email<span class=" "> </span></label>
                        <input id="email" name="email" value="{{old('email')}}" maxlength="60" type="text" placeholder="Email" class="form-control input-md">
                          @if ($errors->has('email'))
			                 <div class="error">{{ $errors->first('email') }}</div>
			              @endif
                    </div>                   
                </div>
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                    <div class="form-group">
                        <label class="sr-only control-label" for="phone">Phone<span class=" "> </span></label>
                        <input id="phone" name="phone" value="{{old('phone')}}" maxlength="20" type="text" placeholder="Phone" class="form-control input-md">
                     @if ($errors->has('phone'))
			             <div class="error">{{ $errors->first('phone') }}</div>
			         @endif 
                    </div>                   
                </div> 
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                    <div class="form-group">
                        <label class="sr-only control-label" for="phone">Address<span class=" "> </span></label>
                        <input id="phone" name="address" value="{{old('address')}}" type="text" placeholder="Address" class="form-control input-md">
                    @if ($errors->has('address'))
			             <div class="error">{{ $errors->first('address') }}</div>
			         @endif
                    </div>                     
                </div>                           
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="form-group">
                        <label class="control-label" for="message"> </label>
                        <textarea class="form-control" id="message" rows="7" name="message" placeholder="Message">{{old('message')}}</textarea>
                    @if ($errors->has('message'))
			             <div class="error">{{ $errors->first('message') }}</div>
			         @endif
                    </div>                     
                </div>                          
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center pt-3">
                    <button type="submit" name="submit" class="butn butn-bg buth-round-border mb-3 w-100">Submit</button>
                </div>
            </div>                                   
        </form>
      </div>
    </div>
  </div>
</div>
@endsection