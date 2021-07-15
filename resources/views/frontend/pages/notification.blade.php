<?php 
use Carbon\Carbon;
use App\Models\Notification;
?>
@extends('frontend.layouts.main')
@section('title', 'Notification Add/Update')
@section('content')
<div id="main-wrapper" class="section-ptb">
  <div class="profile_head view-followers notificationsec">
    <div class="container">    
          <h5 class="text-uppercase">Notification</h5>
          <hr> 
     @if(!$notificationData->isEmpty())     
     @foreach($notificationData as $value)
      <?php
      if(@$value->model_type == 'Post'){
        $url = 'discover/post-preview/';
        $modelName = 'has shared a new experience';
      }
      if(@$value->model_type == 'User'){
        $url = 'view-travel/user_profile/';
        $modelName = 'Update Profile';
      }
      if(@$value->model_type == 'Follow'){
          $url = 'view-travel/user_profile/';
          $modelName = 'is now following you';          
      }
      if(@$value->model_type == 'Bookmark'){
          $url = 'discover/post-preview/';
          $modelName = 'has saved your experience';
      }
      ?>  
      
      <div class="row align-items-center">
        <div class="col-md-2 col-lg-2 mb-3 mb-md-0">
          <div class="profile_bg">
            <div class="small-12 medium-2 large-2 columns">
              <div class="circle">
                 @if(str_replace(url('/') . '/public/uploads/card_image',"",$value->getUser->profile_file)) 
                    <img src="{!!asset($value->getUser->profile_file)!!}" class="profile-pic" alt="aery">
                  @else
                    <img src="{!!asset('public/frontend/imgs/banners/avatar.png')!!}" class="profile-pic" alt="aery">
                  @endif
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-10 col-lg-10">
         <div class="d-flex flex-wrap align-items-center justify-content-between">           
            <a href="{{ url(@$url. encrypt($value->model_id)) }}" class="username"> <h5 class="mr-auto">{{$value->getUser->first_name}} {{$value->getUser->last_name}} <span>{{$modelName}}</span></h5></a>            
            @if($value->created_at >= $currentWeek)
             <h6>{{ $value->created_at->diffForHumans() }}</h6>
            @else
             <h6>{{ $value->created_at->format('d-m-yy') }}</h6>
            @endif
          </div>                  
        </div>
      </div>  
       @endforeach
      <div class="pagination-box">
          {{ $notificationData->links()}}
     </div>    
     @else
      <div class="col-md-12 text-center"><h4>Notifications Not Found</h4  ></div>
    @endif 
    </div>
  </div>
  </div> 
@endsection