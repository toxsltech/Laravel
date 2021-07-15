@extends('frontend.layouts.main')
@section('title', 'Our Mission')
@section('content')
<div id="main-wrapper" class="bg-gray section-ptb">
  <div class="hr-line hr-heading mb-4">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h5 class="text-uppercase">Our Mission</h5>
          <hr>
        </div>
      </div>
    </div>
  </div>
  <div class="space_content">
    <div class="container">
      <div class="row">
        <div class="col-md-12 locationimg-box ourmissionimg-box mt-3">
          <div class="location_pictures">
            <div class="lp_main location-imgbox ourmission-imgbox">
              <img src="{{ asset('public/frontend/imgs/banners/1.jpg') }}" alt="aery">
               <div class="iconbox">                 
                  <i class="fas fa-bullseye-pointer"></i>
              </div>                  
            </div>
            <div class="lp_main location-imgbox ourmission-imgbox">
              <img src="{{ asset('public/frontend/imgs/banners/3.jpg') }}" alt="aery"> 
               <div class="iconbox">                 
                  <i class="fas fa-bullseye-pointer"></i>
              </div>                
            </div>
            <div class="lp_main location-imgbox ourmission-imgbox">
              <img src="{{ asset('public/frontend/imgs/banners/4.jpg') }}" alt="aery"> 
              <div class="iconbox">                 
                  <i class="fas fa-bullseye-pointer"></i>
              </div>
            </div>               
          </div>
        </div>
        <div class="col-md-12 mt-3">
        @if($mission)
          {!! $mission->description !!}
           @else
          	<div class="col-md-12 text-center"><h4>Our Mission Page Not Available</h4  ></div>
           @endif  
         </div>                    
      </div>
    </div>
  </div>
</div>
@endsection