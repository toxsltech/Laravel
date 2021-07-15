<?php 
use App\Models\Post;
use App\Models\Follower;
use App\Models\PostLocation;
use App\Models\SaveCounters;
use Illuminate\Support\Facades\Auth;
?>
@extends('frontend.layouts.main')
@section('title', 'Search Details-View')
@section('content')
<div id="main-wrapper" class="section-ptb">
  <div class="profile_head view-followers hr-line searchingsec">
    <div class="container"> 
      <div class="tabbox d-flex"> 
        <div class="tabbox-title">  
          <h5 class="text-uppercase">Search Results</h5>
        </div>
        <div class="searchtab">
          <ul class="nav nav-tabs usersec" id="myTab" role="tablist">
          
          <li class="nav-item">              
              <a class="nav-link  active" id="userClick"  href="#">User</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="experienceClick" href="#">Experience</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="locationClick" href="#">Location</a>
            </li>
          </ul>
        </div>
      </div>
      <hr>     
    <div class="tab-pane" id="user">
      @include('frontend.users.search_user')
      </div>

      <div class="tab-pane" id="experience">
      </div>

      <div class="tab-pane" id="location">
      </div>
       
  </div>
</div>
</div>
<link href="https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src='https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.js'></script>
<script type="text/javascript">
$("#experience").hide();
$("#location").hide();
$('#userClick').on('click', function(){
    $('#experience').hide();
    $('#location').hide()
    $('#user').show();
    $('#userClick').addClass('active');
    $('#locationClick').removeClass('active');
    $('#experienceClick').removeClass('active');
  });

$('#experienceClick').on('click', function(){
  var text = $("#Search").val();
  $.ajax({
  type: 'GET',
  url: "{{ url('search/experience') }}",            
  data: {text},
   success:function(data)
   {
    $('#user').hide();
    $('#location').hide()
    $('#experience').show();
    $('#experienceClick').addClass('active');
    $('#userClick').removeClass('active');
    $('#locationClick').removeClass('active');
    $('#experience').html(data.html);
   }
  });
  });

$('#locationClick').on('click', function(){
  var text = $("#Search").val();
  $.ajax({
  type: 'GET',
  url: "{{ url('search/location') }}",            
  data: {text},
   success:function(data)
   {
    $('#user').hide();
    $('#experience').hide()
    $('#location').show();
    $('#locationClick').addClass('active');
    $('#userClick').removeClass('active');
    $('#experienceClick').removeClass('active');
    $('#location').html(data.html);
   }
  });
  });

//for pagination
 $(document).on('click', '.pagination-box a', function(event){
  event.preventDefault(); 
  var page = $(this).attr('href').split('page=')[1];
  var getdata = $(this).parent().closest('.pagination-box').attr('getdata');
  fetch_data(page, getdata);
 });

 function fetch_data(page, getdata)
 {
  var text = $("#Search").val();
  if(getdata == 'experience'){
    var dataurl = '{{url("search/experience?page=")}}'+page;
  }
  if(getdata == 'location'){
    var dataurl = '{{url("search/location?page=")}}'+page;
  }
  if(getdata == 'user'){
    var dataurl = '{{url("search?page=")}}'+page;
  }
  $.ajax({
  type: 'GET',
  url:dataurl,
  data: {text},
  success:function(data)
  {
    $('#'+getdata).html(data.html);
  }
  });
}

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