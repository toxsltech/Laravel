<?php 
use App\Models\PostLocation;
use Illuminate\Support\Facades\Auth;
?>
@extends('frontend.layouts.main')
@section('title', 'User Profile')
@section('content')
<style>
.marker {
cursor: pointer;
}
</style>
<div id="main-wrapper" class="bg-gray section-ptb">
  <div class="profile_head">
    <div class="container">
      <div class="row">
        <div class="col-md-3 col-lg-3 mb-3 mb-md-0">
          <div class="profile_bg">
            <div class="small-12 medium-2 large-2 columns">
              <div class="circle user-profile-img">
                 @if(str_replace(url('/') . '/public/uploads/card_image',"",$user->profile_file)) 
                <img src="{!!asset($user->profile_file)!!}" class="profile_file" alt="aery">
              @else
                <img src="{!!asset('public/frontend/imgs/banners/avatar.png')!!}" class="css-class profile_file" alt="aery">
              @endif
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-9 col-lg-9">
          <div class="d-flex flex-wrap align-items-center">
            <h3 class="mr-auto mb-3 pr-3">{{$user->first_name}} {{$user->last_name}}</h3>           
              @if(!$getFollower->isEmpty())
                <a class="butn butn-bg buth-round-border mb-3" href="{{url('user-unfollow/'. encrypt($user->id))}}">Un-Follow</a>                                      
              @else
                 <a class="butn butn-bg buth-round-border mb-3" href="{{url('user-follow/'. encrypt($user->id))}}">Follow</a> 
              @endif          
          </div>
          <div class="d-flex justify-content-between mt-3">
            <div class="text-center px-2">
             <a href="{{url('follower-list/'. encrypt($user->id))}}">
              <p class="font_500 color">Followers</p>
              <h4>{{ @$followerCount }}</h4></a>
            </div>
            <div class="text-center px-2">
              <p class="font_500">Experience Shared</p>
              <h4>{{ count(@$postsCount) }}</h4>
            </div> 
             <div class="text-center px-2">
              <p class="font_500">Saved Counter </p>
              <h4>{{ @$countSavecounter }}</h4>
            </div>        
            <div class="text-center px-2">
              <p class="font_500">Countries</p>
              <h4>{{ @$countryCount }}</h4>
            </div>
          </div>
          <div class="profile_description mt-4">
            <p>{!! @$user->about_me !!}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="profile_map section-pt">
    <div class="container">
      <div class="row">
        <div id="map" style='width: 1110px; height: 500px;'></div>        
      </div>      
    </div>
  </div>  
    
  <div class="discover_main section-pt">
   <div id="login_form"></div>
    <div class="container">
      <div class="row">
      @if(!$posts->isEmpty())
        @foreach($posts as $post)    
        <div class="col-xl-3 col-lg-4 col-md-6 mb-3" id="MarakBookData">
          <div class="discover_cards position-relative">
            <a href="{{url('discover/post-preview/'. encrypt($post->id))}}" class="">
              <p class="discover_content"><span>{{$post->title}}</span></p>
              <div class="">
                @if(str_replace(url('/') . '/public/uploads/card_image',"",$post->card_image)) 
             		<img src="{!!asset('public/uploads/card_image/'. $post->card_image)!!}" class="Card_Image cmnimg" alt="aery">
             	@else
             		<img src="{!!asset('public/frontend/imgs/banners/1.jpg')!!}" class="css-class profile_file" alt="aery">
             	@endif
              </div>
            </a>
            <?php
            $o = '';  
            ?>
        @foreach($saveData as $val)
        @if($val->post_id == $post->id)
            <?php
            $o = '-o';  
            ?>
            @endif  
           @endforeach
           <a getencryptId="{{ encrypt($post->id) }}" getId="{{ $post->id }}"  id="button" class="wishlist button_{{ $post->id }}">
            <i class="fas fa-bookmark{{ $o }}" id="list_{{ $post->id }}"></i>
            </a>
          </div>
        </div>
           @endforeach
          @else
          <div class="col-md-12 text-center"><h4>Travel Experience Not Found</h4	></div>
        @endif                   
      </div>
      <div class="pagination-box">
          {{ $posts->links()}}
     </div> 
    </div>
  </div>
      

</div>

@endsection
@section('after_footer')
<script src="https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.js"></script>
<link href="https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.css" rel="stylesheet" />
<script type="text/javascript">
getlat = '{{ PostLocation::LATITUDE }}';
getlng = '{{ PostLocation::LONGITUDE }}';
   var lngLat = <?php echo json_encode($lngLat); ?>;
    var imgurl = 'https://docs.mapbox.com/mapbox-gl-js/assets/custom_marker.png'
  features =[];
  for (var [key, value] of Object.entries(lngLat)) {
    features.push ({
              'type': 'Feature',
              'properties': {
                'id': value.id,
                'iconSize': [32, 40]
                },
              'geometry': {
              'type': 'Point',
              'coordinates': [key,value.latitude]
            }
            })
              } 
  mapboxgl.accessToken = '{{ env('MAPBOX_TOKEN') }}';
  var geojson = {
'type': 'FeatureCollection',
'features': features
};
var map = new mapboxgl.Map({
container: 'map',
style: 'mapbox://styles/mapbox/streets-v11',
center: [getlng, getlat],
zoom: 1.2
});
 
// add markers to map
geojson.features.forEach(function (marker) {
// create a DOM element for the marker
var el = document.createElement('div');
el.className = 'marker';
el.style.backgroundImage =
'url('+imgurl+
')';
el.style.width = marker.properties.iconSize[0] + 'px';
el.style.height = marker.properties.iconSize[1] + 'px';
 
el.addEventListener('click', function () {
  var url = '{{ url("discover/post-preview", "id") }}';
  url = url.replace('id', marker.properties.id);
  window.location.href = url;
});
 
// add marker to map
new mapboxgl.Marker(el)
.setLngLat(marker.geometry.coordinates)
.addTo(map);
});

//Bookmark Travel Exprience
$(document).on('click','.wishlist',function() {   
var id = $(this).attr('getencryptId');
var getid = $(this).attr('getId');
$('#list_'+getid).hide();
$(this).removeClass("wishlist");
$(this).addClass("discover-loderiocn");
$(this).append('<img src="{!!asset("/public/frontend/imgs/loading.gif")!!}" alt="aery" class="loader">');
    $.ajax({
        url: "{{ url('bookmark-card') }}",
        type: 'GET',
        data: {id},
        success: function(data)
        {
            if(data.status == "Added"){
                $('a.button_'+data.id+' > img').remove();
                $('.button_'+data.id).removeClass("discover-loderiocn");
                $('#list_'+getid).show();
                $('.button_'+data.id).addClass("wishlist");
                $('#list_'+data.id).removeClass("fa-bookmark");
                $('#list_'+data.id).addClass("fa-bookmark-o");
            }
            if(data.status == 'removed'){
                $('a.button_'+data.id+' > img').remove();
                $('.button_'+data.id).removeClass("discover-loderiocn");
                $('#list_'+getid).show();
                $('.button_'+data.id).addClass("wishlist");
                $('#list_'+data.id).removeClass("fa-bookmark-o");
                $('#list_'+data.id).addClass("fa-bookmark");
            }
        }
    });
});    

</script>
@endsection