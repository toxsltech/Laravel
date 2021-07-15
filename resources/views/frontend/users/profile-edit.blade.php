<?php
use App\Models\Post;
use App\Models\PostLocation;
use Illuminate\Support\Facades\Auth;
?>
@extends('frontend.layouts.main')
@section('title', 'User Profile-Edit')
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
        <div class="col-md-3 col-lg-3">
          <div class="profile_bg">
            <div class="small-12 medium-2 large-2 columns">
              <div class="circle user-profile-img">
                @if(str_replace(url('/') . '/public/uploads/card_image',"",$user->profile_file)) 
             		<img src="{!!asset($user->profile_file)!!}" class="profile_file" alt="aery">
             	@else
             		<img src="{!!asset('public/frontend/imgs/banners/avatar.png')!!}" class="css-class profile_file" alt="aery">
             	@endif
              </div>
              <div class="p-image">
                <label for="file-input">
                  <i class="fa fa-camera upload-button" id="profile-icon"></i>
                </label>
                <input id="file-input" name="profile_file" class="file-upload" type="file" hidden="hidden" accept='image/*'>
                <input type="hidden" id="current_user" value="{{ $user->id }}">
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-9 col-lg-9">
        <form action="profile-update" method="POST" enctype="multipart/form-data">
        @csrf
          <div class="d-flex flex-wrap align-items-center">
            <h3 class="mr-auto mb-3 pr-3"><b>{{$user->first_name}} {{$user->last_name}}</b></h3>
            <button type="submit" class="butn butn-bg buth-round-border mb-3" value="save">Save</button>
          </div>
          <div class="d-flex justify-content-between mt-3">
            <div class="text-center">
              <a href="{{url('follower-list/'. encrypt($user->id))}}">
              <p class="font_500 color">Followers</p>
              <h4>{{ @$followerCount }}</h4></a>
            </div>
            <div class="text-center">
              <p class="font_500">Experience Shared</p>
              <h4>{{ @count($postData) }}</h4>
            </div>
            <div class="text-center">
              <p class="font_500">Saved Counter</p>
              <h4>{{ @$saveCountersCount }}</h4>
            </div>
            <div class="text-center">
              <p class="font_500">Countries</p>
              <h4>{{ @$countryCount }}</h4>
            </div>
          </div>
          <br>
          <div class="profile_description mt-4">
              <div class="form-group">
                <textarea rows="4" cols="50" maxlength="50" class="form-control" id="about_me" name=about_me>{{ old( 'about_me ', $user->about_me ) }}</textarea>
    				 @if($errors->has('about_me'))
                <div class="error">{{ $errors->first('about_me') }}</div>
              @endif
              </div>             
          </div>
          </form>
        </div>
     </div>     
    </div>
  </div>
  <div class="profile_map section-pt">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class= "map132f w-100" id="map" style='width: 820; height: 500px;'></div>
        </div>
      </div>
    </div>
  </div>

  <div class="hr-line section-pt">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <hr>
        </div>
      </div>
    </div>
  </div>

  <div class="discover_main section-pt for_profile">
    <div class="container">
      <div class="row">
      @if(!$posts->isEmpty())
        @foreach($posts as $post)
        <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
          <div class="discover_cards position-relative">
            <a href="{{url('post-preview/'. encrypt($post->id))}}" class="">
              <p class="discover_content"><span>{{$post->title}}</span></p>
            	@if(str_replace(url('/') . '/public/uploads/card_image',"",$post->card_image)) 
             		<img src="{!!asset('public/uploads/card_image/'. $post->card_image)!!}" class="Card_Image cmnimg" alt="aery">
             	@else
             		<img src="{!!asset('public/frontend/imgs/banners/1.jpg')!!}" class="css-class profile_file" alt="aery">
             	@endif
             	
            </a>
            <div class="wishlist prpeditlist">
              <div class="dropdown wishlist_dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                   <a class="dropdown-item" onclick="return confirm('Are you sure you want to delete this ?');" href="{{url('tour-exprience/delete/'. encrypt($post->id))}}">Delete</a>                
                </div>
              </div>
            </div>
          </div>
        </div>
         @endforeach            
              @else
              <div class="col-md-12 text-center"><h4>Travel Experience Not Available</h4	></div>
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

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src='https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.js'></script>
<script src="{{ asset('public/assets/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript">
CKEDITOR.replace('about_me',{
removeButtons: 'Cut,Copy,Paste,Undo,Redo,Anchor,Link,Unlink,Image,Table,Maximize,Source,Strike,Subscript,Superscript,RemoveFormat,About,Blockquote,Styles,Format,Indent,NumberedList,BulletedList,Specialcharacter'
});
</script>
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
  var url = '{{ url("post-preview", "id") }}';
  url = url.replace('id', marker.properties.id);
  window.location.href = url;
});
 
// add marker to map
new mapboxgl.Marker(el)
.setLngLat(marker.geometry.coordinates)
.addTo(map);
});

    jQuery(function($){
    	$('#file-input').change(function () {
            if ($(this).val() != '') {
                upload(this);
            }
        });

    	function upload(img) {
            var form_data = new FormData();
            form_data.append('file', img.files[0]);
            form_data.append('_token', '{{csrf_token()}}');
            $('#loading').css('display', 'block');
            $.ajax({
                url: "{{url('user/update-file/')}}" + "/" + $('#current_user').val(),
                data: form_data,
                type: 'POST',
                contentType: false,
                processData: false,
                success: function (data) {
                    var arr = data;
                    $('.profile_file').attr('src', arr.file);
                },
                error: function (xhr, status, error) {
                    swal(xhr.responseText);
                }
            });
        }
    })
</script>
@endsection