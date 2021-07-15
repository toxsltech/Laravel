<?php 
use Illuminate\Routing\UrlGenerator; 
use Illuminate\Support\Facades\URL;
use App\Models\PostLocation;
?>
@extends('frontend.layouts.main')
@section('title', 'Discover Travel Details-View')
@section('content')

<div id="main-wrapper" class="bg-gray section-ptb">

  <div class="close_view">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="text-right">            
               <a class="font-28" href="{{URL::previous()}}"><i class="fal fa-times-circle"></i></a>               
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="creat_main_view">
    <div class="container">
      <div class="row">
        <div class="col-lg-5">
          <div class="space_content">
          <div class="previewbookmark">          
            <h4>{{strtoupper($location->title)}}</h4>   
            @if($location->created_by_id != Auth::id())   
                <button class="butn butn-bg buth-round-border mb-3 userviewprp BookmarkPost" id="ButtonChange" getencryptId="{{ encrypt($location->id) }}">
                @if($bookmark)
                    Un-Bookmark
                @else
                    Bookmark
                @endif 
                </button>   
            @endif         
            </div>
            
            </br>
            @if(!$locationData->isEmpty())
             @foreach($locationData as $locations) 
             <h3 class="hd fit" getlng="{{ $locations->longitude }}" getlat="{{ $locations->latitude }}"><b>{{$locations->location}}</b></h3>
             <p>{!! nl2br($locations->description) !!}</p>
             @endforeach
            @endif   
          </div>
        </div>
        <div class="col-lg-2 d-none d-lg-block">
          <div class="mid-line">
          </div>
        </div>
        <div class="col-lg-5">
        @if($location->getUser->id != Auth::id())
        <div class="userprofile-prpbox">
          <a href="{{url('view-travel/user_profile/'.encrypt($location->created_by_id))}}">
            <div class="user-profile-imgbox">               
                  @if(str_replace(url('/') . '/public/uploads/card_image',"",$location->getUser->profile_file)) 
                    <img src="{!!asset($location->getUser->profile_file)!!}" class="profile_file" alt="aery">
                  @else
                    <img src="{!!asset('public/frontend/imgs/banners/avatar.png')!!}" class="css-class profile_file" alt="aery">
                  @endif
            	<div class="user-name"><h4>{{$location->getUser->first_name}} {{$location->getUser->last_name}}</h4></div>            	
        	</div></a>        	
            <button class="butn butn-bg buth-round-border mb-3 userviewprp FollowPost" id="FollowButton" getencryptId="{{ encrypt($location->getUser->id) }}">
            @if(!$getFollower->isEmpty())
                Un-Follow
            @else
                Follow
            @endif 
            </button>  
        </div>
        @endif  
        <div class="mapbox-prp">      
            <div class= "map132f erwr123" id="map" style='width: 100%; height:400px;'>
            </div>
           </div>
        </div>
      </div>
      <div class="col-md-12 locationimg-box discove-travel-view-post mt-5">
          <div class="location_pictures">
           @if(!$locationData->isEmpty())
            @foreach ($locationData as $key => $location)       
            @foreach($location->getLocationImage as $image)   
            <div class="lp_main location-imgbox">
                 @if(str_replace(url('/') . '/public/uploads/card_image',"",$image->location_image)) 
                    <a class="thumbnail fancybox" rel="ligthbox" href="{!!asset('public/uploads/card_image/'. $image->location_image)!!}">
             	    <img src="{!!asset('public/uploads/card_image/'. $image->location_image)!!}" class="Card_Image cmnimg" alt="aery"></a>
             	@else
             		<img src="{!!asset('public/frontend/imgs/banners/1.jpg')!!}" class="css-class profile_file" alt="aery">
             	@endif               
            </div>
           @endforeach
           @endforeach
          @endif   
          </div>
        </div>      
    </div>
  </div>  
</div>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src='https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.js'></script>
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.5.1/mapbox-gl-geocoder.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.auto.min.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
<script src="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
<script>
$(".fancybox").fancybox({
        openEffect: "none",
        closeEffect: "none"
    });
    
    
//Bookmark/Un-Bookmark Travel Exprience
   $('.BookmarkPost').click(function(){
    var id = $(this).attr('getencryptId');
     $.ajax({
            type: 'GET',
            url: "{{ url('bookmark-card') }}",            
            data: {id},
            success: function(data)            
            {
               if(data.status == "Added"){                   
                $('#ButtonChange').empty().html('Un-Bookmark');
                }
                if(data.status == 'removed'){
                $('#ButtonChange').empty().html('Bookmark');
              }      
            }
        });    
   });  
   
   //Follow/Un-Follow User
   $('.FollowPost').click(function(){
    var id = $(this).attr('getencryptId');
     $.ajax({
            type: 'GET',
            url: "{{ url('user-post/follow') }}",            
            data: {id},
            success: function(data)            
            {
               if(data.status == "Added"){
                $('#FollowButton').empty().html('Un-Follow');
                }
                if(data.status == 'removed'){
                $('#FollowButton').empty().html('Follow');
              }      
            }
        });    
   });  
 
// mapbox
var lngLat = <?php echo json_encode($lngLat); ?>;
fitmap =[];
  features =[];
  for (var [key, value] of Object.entries(lngLat)) {
    features.push ({
              'type': 'Feature',
              'properties': {
                'description':value.description
						},
              'geometry': {
              'type': 'Point',
              'coordinates': [key,value.latitude]
            }
            })
           fitmap.push([key,value.latitude]);
              } 
mapboxgl.accessToken = '{{ env('MAPBOX_TOKEN') }}';
var map = new mapboxgl.Map({
container: 'map',
style: 'mapbox://styles/mapbox/streets-v11',
center: [key, value.latitude],
zoom: {{PostLocation::MAP_ZOOM}}
});
 
map.on('load', function () {
map.loadImage(
'https://docs.mapbox.com/mapbox-gl-js/assets/custom_marker.png',
// Add an image to use as a custom marker
function (error, image) {
if (error) throw error;
map.addImage('custom-marker', image);
 
map.addSource('places', {
'type': 'geojson',
'data': {
'type': 'FeatureCollection',
'features': features
}
});
 
// Add a layer showing the places.
map.addLayer({
'id': 'places',
'type': 'symbol',
'source': 'places',
'layout': {
'icon-image': 'custom-marker',
'icon-allow-overlap': true
}
});
}
);
 
// Create a popup, but don't add it to the map yet.
var popup = new mapboxgl.Popup({
closeButton: false,
closeOnClick: false
});
 
map.on('mouseenter', 'places', function (e) {
// Change the cursor style as a UI indicator.
map.getCanvas().style.cursor = 'pointer';
 
var coordinates = e.features[0].geometry.coordinates.slice();
var description = e.features[0].properties.description;
 
// Ensure that if the map is zoomed out such that multiple
// copies of the feature are visible, the popup appears
// over the copy being pointed to.
while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
fitmap = coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
}
 
// Populate the popup and set its coordinates
// based on the feature found.
popup.setLngLat(coordinates).setHTML(description).addTo(map);
});
 
map.on('mouseleave', 'places', function () {
map.getCanvas().style.cursor = '';
popup.remove();
});
map.fitBounds(
fitmap, {
    padding: 40
});        
});
 
</script>
@endsection

