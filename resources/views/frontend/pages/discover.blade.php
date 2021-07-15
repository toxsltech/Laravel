@extends('frontend.layouts.main')
@section('title', 'Tour Experience-Discover')
@section('content')
<div id="main-wrapper" class="bg-gray section-ptb">
  <div class="hr-line hr-heading">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h5 class="text-uppercase">Discover</h5>
          <hr>
        </div>
      </div>
    </div>
  </div>
  <div class="discover_main section-pt">
   <div id="login_form"></div>
    <div class="container">
      <div class="row">
      @if(!$postData->isEmpty())
        @foreach($postData as $post)    
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
        @foreach(@$SaveCounterData as $val)
        @if($val->location_id == $post->id)
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
          {{ $postData->links()}}
     </div> 
    </div>
  </div>
</div>
@endsection
@section('after_footer')
<div id='map'></div>
<script src='https://cdnjs.cloudflare.com/ajax/libs/mapbox-gl/0.53.1/mapbox-gl.js'></script>
 <link href='https://cdnjs.cloudflare.com/ajax/libs/mapbox-gl/0.53.1/mapbox-gl.css' rel='stylesheet' />
    <script>
    var get_location = function() {
    var geolocation = null;
    var current_position = null;

    if (window.navigator && window.navigator.geolocation) {
        geolocation = window.navigator.geolocation;

        var positionOptions = {
            enableHighAccuracy: true,
            timeout: 10 * 1000, // 10 seconds
            maximumAge: 30 * 1000 // 30 seconds
        };

        function success(position) {
            current_position = position.coords;            
            var latitude = current_position.latitude;
            var longitude = current_position.longitude;
               $.ajax({
                  url: 'updateLatLog',
                  type: 'post',
                  data: {"_token": "{{ csrf_token() }}",latitude,longitude},
                  success: function(response){
                  }
                });
    
            mapboxgl.accessToken = '{{ env('MAPBOX_TOKEN') }}'; //  put your token here 
            if (!mapboxgl.supported()) {
                alert('Your browser does not support Mapbox GL');
            } else {
                var map = new mapboxgl.Map({
                    container: 'map', // container id
                    style: 'mapbox://styles/mapbox/streets-v11',  
                    center: [current_position.longitude, current_position.latitude], 
                    zoom: 12 // starting zoom
                });
            }
        }
        function error(positionError) {
            $('#login_form').prepend('<div class="container"><div class="alert alert-info"><strong>Info!</strong> Please allow your current location for better experience.</div></div>').animate( { "opacity": "hide"} , 3000 );
        }

        if (geolocation) {
            geolocation.getCurrentPosition(success, error, positionOptions);
        }

    } else {
        alert("Getting Geolocation is prevented on your browser");
    }

    return current_position;
}

 var current_pos = get_location();

//Bookmark Travel Exprience
       $(document).on('click','.wishlist',function() {
        var id = $(this).attr('getencryptId');
        var getid = $(this).attr('getId');
        $('#list_'+getid).hide();
        $(this).removeClass("wishlist");
        $(this).addClass("discover-loderiocn");
        $(this).append('<img src="{!!asset("/public/frontend/imgs/loading.gif")!!}" alt="aery" class="loader">');
            $.ajax({
                url: 'bookmark-card',
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