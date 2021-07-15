@extends('frontend.layouts.main')
@section('title', 'User Setting')
@section('content')
<div id="main-wrapper" class="section-ptb">
  <div class="profile_head view-followers notificationsec">
    <div class="container">    
          <h5 class="text-uppercase">User Setting</h5>
          <hr> 
      <div class="row align-items-center">        
        <div class="col-md-10 col-lg-10">
         <div class="d-flex flex-wrap align-items-center justify-content-between">           
            <h5 class="mr-auto">Change Password</h5>
             <a class="butn butn-bg buth-round-border mb-3" href="{{url('changePassword/'. encrypt($user->id))}}">Click Here</a>
          </div>                  
        </div>
      </div> 
    </div>
  </div>
  </div> 
@endsection