<?php 
use App\Models\Post;
use App\Models\Follower;
use App\Models\PostLocation;
?>
@extends('frontend.layouts.main')
@section('title', 'Followers Details-View')
@section('content')
<div id="main-wrapper" class="section-ptb">
<div class="hr-line hr-heading mb-5">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h5 class="text-uppercase">Followers List</h5>
          <hr>
        </div>
      </div>
    </div>
  </div>
  <div class="profile_head view-followers">
    <div class="container"> 
      @if(!$follower->isEmpty())
        @foreach($follower as $followers)  
          <div class="row align-items-center">
            <div class="col-md-2 col-lg-2 mb-3 mb-md-0">
              <div class="profile_bg">
                <div class="small-12 medium-2 large-2 columns">
                  <div class="circle">                 
                   @if(str_replace(url('/') . '/public/uploads/',"",$followers->getProfileImage->profile_file)) 
                    <img src="{!!asset($followers->getProfileImage->profile_file)!!}" class="profile_file" alt="aery">
                  @else
                    <img src="{!!asset('public/frontend/imgs/banners/avatar.png')!!}" class="css-class profile_file" alt="aery">
                  @endif
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-10 col-lg-10">
              <div class="d-flex flex-wrap align-items-center">
                <h5 class="mr-auto mb-3 pr-3"><a href="{{url('view-travel/user_profile/'.encrypt($followers->getFollowerUser->id))}}" class="username">{{$followers->getFollowerUser->first_name}} {{$followers->getFollowerUser->last_name}}</a></h5>
                <?php
                $Follow = 'Follow';
                $url = 'user-follow';
                ?>
                @foreach($getFollower as $value)
                @if($value->following_id == $followers->follower_id)
                <?php
                $Follow = 'Unfollow';
                $url = 'user-unfollow';
                ?>
            	@endif 
                @endforeach
                @if($followers->getFollowerUser->id != Auth::id())
                <a class="butn butn-bg buth-round-border mb-3" href="{{url($url.'/'.encrypt($followers->getFollowerUser->id))}}">{{ $Follow }}</a>
                @else
                <a class="butn butn-bg buth-round-border mb-3" href="{{url('view-travel/user_profile/'.encrypt($followers->getFollowerUser->id))}}">View Profile</a>
                @endif
              </div>          
             <div class="d-flex mt-3">
              <div class="text-center px-2">
                <p class="font_500 color">Followers</p>
                <?php
                $followerCount =  Follower::where('following_id', $followers->getFollowerUser->id)->count();
                 ?>
                <h4>{{ $followerCount }}</h4>
              </div>
              <div class="text-center px-2">
                <p class="font_500">Experience Shared</p>
                <h4><?php echo Post::where('created_by_id', $followers->getFollowerUser->id)->where('state_id', Post::STATE_ACTIVE)->count() ?></h4>
              </div>
              <div class="text-center px-2">
                <p class="font_500">Countries</p>
                <?php 
                $postdata =  Post::where('created_by_id', $followers->getFollowerUser->id)->where('state_id', Post::STATE_ACTIVE)->with('getLocationData')->get();
                $uniques = array();
                foreach ($postdata as $locationData) {
                foreach ($locationData->getLocationData as $data) {
                $uniques[] = $data->country ;
                }
                }
                ?>             
                <h4>{{ count(array_unique(@$uniques)) }}</h4>
              </div>            
              </div>
            </div>
          </div>      
        @endforeach
           <div class="pagination-box">
           </div>   
          @else
          <div class="col-md-12 text-center"><h4>No any Followers users</h4  ></div>
        @endif   
    </div>
  </div>
 </div> 
@endsection
