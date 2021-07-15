<?php 
use App\Models\Post;
use App\Models\Follower;
use App\Models\PostLocation;
use App\Models\SaveCounters;
use Illuminate\Support\Facades\Auth;
?>
<style>
.marker {
cursor: pointer;
}
</style>
<div class="row">
  <div class="col-md-12">
        <div class= "map132f w-100" id="map" style='width: 100%; height: 500px;'></div>
      </div>
  @if(!$location->isEmpty())
  @foreach($location as $key=>$value)   
  <div class="col-xl-3 col-lg-4 col-md-6 mb-3" id="MarakBookData">
    <div class="discover_cards position-relative">
      <a href="{{url('discover/post-preview/'. encrypt($value->id))}}" class="">
        <p class="discover_content"><span>{{ @$value->title }}</span></p>
        <div class="">
          @if(str_replace(url('/') . '/public/uploads/card_image',"",@$value->card_image)) 
          <img src="{!!asset('public/uploads/card_image/'. @$value->card_image)!!}" class="Card_Image cmnimg" alt="aery">
          @else
          <img src="{!!asset('public/frontend/imgs/banners/1.jpg')!!}" class="Card_Image cmnimg" alt="aery">
          @endif
        </div>
      </a>
      <?php
      $SaveCounterData = SaveCounters::where('user_id','=', Auth::id())->get();
    $o = '';  
    ?>
  @foreach(@$SaveCounterData as $val)
  @if($val->post_id == $value->id)
      <?php
      $o = '-o';  
      ?>
      @endif  
   @endforeach  
     @if($value->created_by_id != Auth::id())
      <a getencryptId="{{ encrypt($value->id) }}" getId="{{ $value->id }}"  id="button" class="wishlist button_{{ $value->id }}">
    <i class="fas fa-bookmark{{ @$o }}" id="list_{{ $value->id }}"></i>
    </a>
    @endif
      </a>
    </div>
  </div>
  @endforeach
  <div class="pagination-box" getdata="location">
      {!! $location->links() !!}
 </div> 
@else
  <div class="col-md-12 text-center"><h4>No Details found. Try to search again !</h4  ></div>
@endif

<link href="https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src='https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.js'></script>
<script>
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
</script>