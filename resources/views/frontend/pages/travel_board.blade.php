<?php 
use App\Models\PostLocation;
use Illuminate\Support\Facades\Auth;
?>
@extends('frontend.layouts.main')
@section('title', 'Travel Board')
@section('content')
<style>
.marker {
cursor: pointer;
}
</style>
<div id="main-wrapper" class="bg-gray section-ptb">

  <div class="hr-line hr-heading">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h5 class="text-uppercase">My Adventures</h5>
          <hr>
        </div>
      </div>
    </div>
  </div>

  <div class="profile_map section-pt">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class= "map132f w-100" id="map" style='width: 100%; height: 500px;'></div>
        </div>
      </div>
    </div>
  </div>

  <div class="discover_main section-pt">
    <div class="container">
      <div class="row" id="row">      
       @if(!$getLocationId->isEmpty())
         @foreach ($getLocationId as $locations)
        <div class="col-xl-3 col-lg-4 col-md-6 mb-3 text" id="cardNo_{{ @$locations->post_id }}">
          <div class="discover_cards position-relative">
            <a href="{{url('discover/post-preview/'. encrypt(@$locations->post_id))}}" class="">
              <p class="discover_content"><span>{{ @$locations->getSaveCounterCardImg->title }}</span></p>
                @if(str_replace(url('/') . '/public/uploads/card_image',"",@$locations->getSaveCounterCardImg->card_image)) 
                <img src="{!!asset('public/uploads/card_image/'. @$locations->getSaveCounterCardImg->card_image)!!}" class="Card_Image cmnimg" alt="aery">
                @else
                <img src="{!!asset('public/frontend/imgs/banners/1.jpg')!!}" class="css-class profile_file" alt="aery">
                @endif
            </a>
             <?php
            $o = '-o';  
            ?>
        @foreach(@$getLocationId as $val)                  
        @if($val->location_id == $locations->id)
            <?php
            $o = '';  
            ?>
            @endif  
           @endforeach
            <a getencryptId="{{ encrypt(@$locations->post_id) }}" getId="{{ @$locations->post_id }}"  id="button" class="wishlist button_{{ @$locations->post_id }}">
            <i class="fas fa-bookmark{{ $o }}"  id="list_{{ @$locations->post_id }} listData"></i>
            </a>  
            </a>
          </div>
        </div>  
     @endforeach
      @else
      <div class="col-md-12 text-center"><h4>Favorite Travel Experience Not Found</h4></div>    
       @endif
         
      </div>
        <div class="pagination-box">
             {{ $getLocationId->links()}}
        </div> 
    </div>
  </div>
</div>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<link href="https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src='https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.js'></script>
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


//Remove  bookmark-card
 $(document).on('click','.wishlist',function() {
    var id = $(this).attr('getencryptId');
    var getid = $(this).attr('getId');
    $('#list_'+getid).hide();
    $(this).removeClass("wishlist");
    $(this).addClass("discover-loderiocn");
    $(this).append('<img src="{!!asset("/public/frontend/imgs/loading.gif")!!}" alt="aery" class="loader">');
        $.ajax({
            url: 'bookmark-card/remove',
            type: 'GET',
            data: {id},
            success: function(data)
            {
              $('.marker').remove();
              $("#cardNo_"+data.id).remove();
              var imgurl = 'https://docs.mapbox.com/mapbox-gl-js/assets/custom_marker.png'
              featured =[];
              for (var [key, value] of Object.entries(data.lngLat)) {
                if(value.remove == 'allremoved'){
                  $('#row').append('<div class="col-md-12 text-center"><h4>Favorite Travel Experience Not Found</h4></div>');
                }
                featured.push ({
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

          var mapboxid = {
          'type': 'FeatureCollection',
          'features': featured
          };
          var map = new mapboxgl.Map({
              container: 'map',
              style: 'mapbox://styles/mapbox/streets-v11',
              center: [getlng, getlat],
              zoom: 1.2
              });  
              // add markers to map
              mapboxid.features.forEach(function (marker) {
              // create a DOM element for the marker

              var element = document.createElement('div');
              element.className = 'marker';
              element.style.backgroundImage =
              'url('+imgurl+
              ')';
              element.style.width = marker.properties.iconSize[0] + 'px';
              element.style.height = marker.properties.iconSize[1] + 'px';
               
              element.addEventListener('click', function () {
                var url = '{{ url("discover/post-preview", "id") }}';
                url = url.replace('id', marker.properties.id);
                window.location.href = url;
              });

              // add marker to map
              new mapboxgl.Marker(element)
              .setLngLat(marker.geometry.coordinates)
              .addTo(map); 
              });
            }                         
        });       
   });   
   
</script>
@endsection