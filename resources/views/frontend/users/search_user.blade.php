<?php 
use App\Models\Post;
use App\Models\Follower;
use App\Models\PostLocation;
use App\Models\SaveCounters;
use Illuminate\Support\Facades\Auth;
?>
@if(!$user->isEmpty())
        @foreach(@$user as $key=>$value)
         <div class="row align-items-center">
          <div class="col-md-2 col-lg-2 mb-3 mb-md-0">
            <div class="profile_bg">
              <div class="small-12 medium-2 large-2 columns">
                <div class="circle">                 
                   @if(str_replace(url('/') . '/public/uploads/',"",@$value->profile_file)) 
                    <img src="{!!asset(@$value->profile_file)!!}" class="profile-pic" style="height: 344px;" alt="aery">
                  @else
                    <img src="{!!asset('public/frontend/imgs/banners/avatar.png')!!}" class="css-class profile-pic" style="height: 344px;" alt="aery">
                  @endif
                  </div>
              </div>
            </div>
          </div>
          <div class="col-md-10 col-lg-10">
            <div class="d-flex flex-wrap align-items-center">
              <h5 class="mr-auto"><a href="{{url('view-travel/user_profile/'.encrypt($value->id))}}" class="username">{{ @$value->first_name }} {{ @$value->last_name }}</a></h5>
              <?php
                $getFollower = Follower::where('follower_id', Auth::id())->get();
                $Follow = 'Follow';
                $url = 'user-follow';
                ?>
                @foreach($getFollower as $val)
                @if($val->following_id == $value->id)
                <?php
                $Follow = 'Unfollow';
                $url = 'user-unfollow';
                ?>
              @endif
                @endforeach
                @if($value->id != Auth::id())
              <a class="butn butn-bg buth-round-border" href="{{url($url.'/'.encrypt($value->id))}}">{{ @$Follow }}</a>
              @else
                <a class="butn butn-bg buth-round-border mb-3" href="{{url('view-travel/user_profile/'.encrypt(@$value->id))}}">View Profile</a>
                @endif
            </div>
            <div class="d-flex mt-3">
              <div class="text-center px-2">
                <p class="font_500 color">Followers</p>
                <h4>{{ $value->getfollower_count }}</h4>
              </div>
              <div class="text-center px-2">
                <p class="font_500">Experience Shared</p>
                <h4><?php echo Post::where('created_by_id', $value->id)->where('state_id', Post::STATE_ACTIVE)->count() ?></h4>
              </div>
              <div class="text-center px-2">
                <p class="font_500">Countries</p>
                <?php 
                $postdata =  Post::where('created_by_id', $value->id)->where('state_id', Post::STATE_ACTIVE)->with('getLocationData')->get();
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
          <div class="pagination-box" getdata="user">
               {!! @$user->links() !!}
         </div> 
        @else
          <div class="col-md-12 text-center"><h4>No Details found. Try to search again !</h4  ></div>
        @endif 