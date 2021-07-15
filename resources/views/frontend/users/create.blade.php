<?php
use App\Models\PostLocation;
?>
@extends('frontend.layouts.main')
@section('title', 'Tour Experience-Create')
@section('content')
<div id="main-wrapper" class="bg-gray section-ptb createDiv">
  <div class="hr-line hr-heading">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h5 class="text-uppercase">Create</h5>
          <hr>
        </div>
      </div>
    </div>
  </div>
  <div class="creat_main section-pt">
    <div class="container">
      <form class="row"  method="POST" action="{{url('tour-save')}}" id="form_data1" name="dataPost" enctype="multipart/form-data">
        @csrf
        <div class="col-md-4 col-xl-3">
          <div class="card-picture">
            <div class="black-box-title">            
              <textarea class="form-control" name="card_title" maxlength="50" id="cardtitle" placeholder="Card Title">{{ old('card_title') }}</textarea>
              @if($errors->has('card_title'))
              <div class="error">{{ $errors->first('card_title') }}</div>
              @endif
            </div>
            <div class="card-img cardImage cardTitleImage">
            </div>
            <div class="upload_picture">              

              <input type="file" value="" name="card_image" id="card_image" accept='image/*'>
              <label class="add-set" for="card_image"><i class="fal fa-plus-circle"></i> Select Card Picture</label>
            </div>
            @if ($errors->has('card_image'))
                    <div class="error">{{ $errors->first('card_image') }}</div>
                @endif
          </div>
          <div class="mt-4 max-80 incrementImg">
            <a class="butn butn-bg buth-round-border mb-3 w-100 showPreview">Preview</a>
            <button class="butn butn-bg buth-round-border mb-3 w-100" id="pulish-data" type="submit">Publish</button>
          </div>
        </div>
        <div class="col-md-8 col-xl-9">
              <div class= "map-div map132f map" id='map' style='width: 821px; height: 400px;'>
              </div>
          <div class="searchbox">
            <div class="form-group">
              <div id="geocoder" class="geocoder"></div>
            </div>
            <input type="hidden" name="showcountry" id="country">
            <div class="addbtn-box">
              <button type="button" class="butn butn-bg buth-round-border mb-3 w-100 alllocation addin">Add Location</button>
              @if ($errors->has('lati'))
                  <div class="error">{{ $errors->first('lati') }}</div>
              @endif
            </div> 
          </div>
          <div class="incrementyTr"></div>  
          <div class="locationboxtable">      
            <table class="table table-striped">             
              <tbody class="increment">                
                <tr class="tb-new">                                 
            <input type="hidden" name="showaddress" id="address">
                  <td colspan="2"><input type="text" name="title[]" class="form-control" id="title" placeholder="Location name"></td>
                </tr>
                <tr>                                  
                </tr>
              </tbody>
            </table>
          </div> 
          <input type="hidden" name="validtitle[]" id="validtitle">         
          <div class="col-md-12 locationimg-box mt-5">
              <div class="location_pictures" id="showLoctionImg">
              </div>
            </div>
          </div>
        </div>        
      </form>
    </div>
  </div>
</div>
<input type="hidden"  class="form-control" value="" id="longitude" name="address">
<input type="hidden"  class="form-control" value="" id="latitude" name="latitude">
<div style="display: none;" id="main-wrapper" class="bg-gray section-ptb previewDiv">
  <div class="close_view">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="text-right">
            <a class="font-28"><i class="fal fa-times-circle"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="creat_main_view">
    <div class="container">
      <div class="row">
        <div class="col-lg-5">
          <div class="space_content" id="previewData">
          </div>
          <div class="space_content" id="previewadd">
          </div>
        </div>
        <div class="col-lg-2 d-none d-lg-block">
          <div class="mid-line">

          </div>
        </div>
        <div class="col-lg-5">
          <div class="user-name" id="previewLocation"></div>
        <div class="mapbox-prp">
            <div class="mapboximg previewCardImage">
            </div>
           <div class= "map132f erwr123" id="map_pre" style='width: 100%; height:400px;'>
           </div>
           </div>
        </div>
        <div class="col-md-12 locationimg-box discove-travel-view-post mt-5">
         <div class="location_pictures" id="preview-img-section">                            
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="previewbtnsec">
    <div class="container">
    <div class="mt-4 max-80 publishpreview">
            <a class="butn butn-bg buth-round-border mb-3 w-100" id="closepreviewDiv">Close</a>
          </div>
    </div>
  </div>
</div>

 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src='https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.js'></script>
  <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.5.1/mapbox-gl-geocoder.min.js"></script>
  <!-- Promise polyfill script required to use Mapbox GL Geocoder in IE 11 -->
<script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.auto.min.js"></script>

<script>
var titleData =[];
var descriptionData =[];
var addressData =[];
var getlngData=[];
var getlatData=[];
var countryData=[];
var getlocImgData=[];
var description=[];
var getlocImgId=[];
getlat = '{{ PostLocation::LATITUDE }}';
getlng = '{{ PostLocation::LONGITUDE }}';
$("#title").prop('disabled', true);
$('#pulish-data').on('click', function(){ 
   $("#form_data1").validate({  
    rules: {    
        card_title : {
        required: true
        },
        card_image: {
        required: true
        },
    },
    messages: {
        card_title: {
        required: "Card Title is required"
        },
        card_image: {
        required: "Card Image is required"
        },
    },    
    submitHandler: function(form) {   
      // form.submit();
      var _token='{{csrf_token()}}';
      var card_title = $('#cardtitle').val();
      var card_image = cardImgData;
          longitude = getlngData;
          latitude = getlatData;
          country = countryData;
          address = addressData;
          $("textarea[name='description[]']").each(function(){            
          description.push($(this).val());
            });
      var uploadLoctionImg = getlocImgData;
      var lati =$("input[name='lati']").val();
      $('.incrementImg').html('<button class="butn butn-bg buth-round-border mb-3 w-100" id="pulish-data" disabled>Loading...</button>');
       $.ajax({
            url: form.action,
            type: form.method,
            data: {_token, card_title, card_image, latitude, longitude, address, country, uploadLoctionImg, getlocImgId, lati, description},
            success: function(response) {
              if(response.status == 'Added'){
                  location.href = "{{ url('/profile') }}"
                  return false;
              }
              $('.incrementyTr').empty().prepend('<div class="alert alert-danger"><strong>ERROR!</strong>'+response.status+'!</div>');
          $(".alert-danger").animate( { "opacity": "hide"} , 5000 );
          $('.incrementImg').html('<a class="butn butn-bg buth-round-border mb-3 w-100 showPreview">Preview</a><button class="butn butn-bg buth-round-border mb-3 w-100" id="pulish-data" type="submit">Publish</button>');
            }          
           
        });
    }
  });  
});

$('#pulish-data').on('click', function(){
  var addressValid = true;
$("input[name='validtitle[]']").each(function(){
    if ($(this).val() == ''){
        addressValid = false;
    }
});
if (addressValid){
 var descriptionValid = true;
$("textarea[name='description[]']").each(function(){
    if ($(this).val() == ''){
        descriptionValid = false;
    }
});
if (descriptionValid){
  // send data
} else {
  $('.incrementyTr').prepend('<div class="alert alert-danger">Please enter experience Description</div>');
          $(".alert-danger").animate( { "opacity": "hide"} , 5000 );
           return false;
}
} else {
  $('.incrementyTr').prepend('<div class="alert alert-danger">Please Add location</div>');
          $(".alert-danger").animate( { "opacity": "hide"} , 5000 );
           return false;
}
});  
//mapbox
mapboxgl.accessToken = '{{ env('MAPBOX_TOKEN') }}';
getlat = '{{ PostLocation::LATITUDE }}';
getlng = '{{ PostLocation::LONGITUDE }}';
var map = new mapboxgl.Map({
container: 'map',
style: 'mapbox://styles/mapbox/streets-v11',
center: [getlng, getlat],
zoom: 1 
});

var geocoder = new MapboxGeocoder({
accessToken: mapboxgl.accessToken,
mapboxgl: mapboxgl,
placeholder: 'Search for experience Location'
});

geocoder.on('result', function(e) {
for (let value of Object.values(e)) {
    for (let val of Object.values(value.context)) {

      if(val.id.indexOf('country') >= {{ PostLocation::STATIC_LNG }}) {
        country = val.text;
        $('#country').val(country);
      }
    }
  $('#longitude').val(value.center[0]);  
  $('#latitude').val(value.center[1]);
  getlngLat =[];
  getlngLat[value.center[0]] = value.center[1]; 
  $('#address').val(value.place_name);
  $('#title').val(value.place_name);
  getlngLat = e.result.center
    $("#title").prop('disabled', false);
}
  geocoder.clear();
 marker = new mapboxgl.Marker({ 
    draggable: true, 
    color: "pink",
  })
    .setLngLat(e.result.center)
    .addTo(map)
marker.on('dragend', () => {
getlngLat = marker.getLngLat();
$('#longitude').val(getlngLat.lng);  
$('#latitude').val(getlngLat.lat);
});
});
document.getElementById('geocoder').appendChild(geocoder.onAdd(map));

 // card Image file click by div
$(".cardTitleImage").on('click', function() {
       $("#card_image").click();
    });

// show card Image
$(function() {
  $("#card_image").on('change', function() {
    if (this.files && this.files[0]) {
      for (var i = 0; i < this.files.length; i++) {
        var reader = new FileReader();
        reader.onload = cardImg;
        reader.readAsDataURL(this.files[i]);
      }
    }
  });
});
function cardImg(e) {
  $('.cardImage').empty().append('<img src="' + e.target.result + '" alt="aery">');
  cardImgData = e.target.result;
};

//hide preview div
  $('.font-28').on('click', function() {
    $(".createDiv").show();
    $(".previewDiv").hide();
});

$('#closepreviewDiv').on('click', function() {
    $(".createDiv").show();
    $(".previewDiv").hide();
});

//append location title and loction discription
$(document).ready(function() {  
        var count = 0;   
      $(".addin").click(function(){
        if($('#title').val() == ''){
          $('.incrementyTr').prepend('<div class="alert alert-danger">Please enter experience Location</div>');
          $(".alert-danger").animate( { "opacity": "hide"} , 5000 );
           return false;
        }
          var title = $('#title').val();
          var description = $('#description').val();
          var add = $('#title').val();
          var long = $('#longitude').val();
          var lati = $('#latitude').val();
          var country = $('#country').val();
          $(".increment").append('<tr class="tr_'+count+'"><td>'+ title +'</td><td><a class="remove" tdData = "'+ title +'" desData="'+description+'"  data="'+count+'" addData="'+add+'" longData="'+long+'" latiDtat="'+lati+'" countData ="'+country+'"><i class="fal fa-times-circle"></i></a></td></tr><tr class="tr_'+count+'"><td><textarea class="form-control disGetValue" disGet="'+count+'" id="sufy53hsvad" name="description[]" placeholder="Enter Description"></textarea><input type="hidden" name="country[]" value="'+country+'"><input type="hidden" name="address[]" value="'+add+'"><input type="hidden" name="latitude[]" value="'+lati+'"><input type="hidden" name="lati" value="'+lati+'"><input type="hidden" name="longitude[]" value="'+long+'"><input type="hidden" name="savedescription[]" value="'+description+'"></td><td><input type="file" name="uploadLoctionImg[]" class="uploadLoctionImg" id="uploadLoctionImg_'+count+'" datGetCount="'+count+'" multiple accept="image/*"><label class="getcout" for="uploadLoctionImg_'+count+'"><i class="fas fa-camera"></i></label></td></tr>');
          $("#title").prop('disabled', true);
            marker.remove();
            marker = new mapboxgl.Marker({ 
              draggable: false, 
              color: 'Green'
            })
              .setLngLat(getlngLat)
              .addTo(map)
            $('#validtitle').val(title);
            titleData.push($('#title').val());
            descriptionData.push($('#description').val());
            addressData.push($('#title').val());
            getlngData.push($('#longitude').val());
            getlatData.push($('#latitude').val());
            countryData.push($('#country').val());
            getlocImgId.push(count);
          $('#title').val('');
          $('#description').val('');
          $("#previewadd").append('<h3 class="hd fit" id="dis_'+count+'"><b>'+add+'</b></h3><p class="dis_'+count+' fitdesc"></p>');
          $(document).on('change', '.disGetValue', function(){
              var disGet = $(this).attr('disGet');
              var disData = $(this).val().replace(/\n/g, "<br>");
              $(".dis_"+disGet).empty().append(disData);
             });
          $('#uploadLoctionImg_'+count).on("change", function(){
            var datGetCount = $(this).attr('datGetCount'); 
                var leng=this.files.length;      
            for(i=0; i<leng;i++)
            {
                var c = Math.floor((Math.random() * 856) + 8);
                var reader=new FileReader();
                reader.onload=function(e)
                {
                  $('#showLoctionImg').append('<div class="lp_main location-imgbox img-div_'+ datGetCount +'"><img src="' + e.target.result + '" class="Card_Image cmnimg" alt="aery"><a imgData="img_live_'+datGetCount+c+'" class="removeImg" getcountData="'+datGetCount+'" getImgId = "'+datGetCount+c+'"><i class="fal fa-times-circle"></i></a></div>');
                  $('#preview-img-section').append('<div class="lp_main location-imgbox Card_Image cmnimg preview-img-div_'+ datGetCount +'" id = "preview-img-div_'+ datGetCount+c+'"><a class="thumbnail fancybox" rel="ligthbox" href="' +e.target.result + '"><img src="' +e.target.result + '" class="Card_Image cmnimg" alt="aery"></a></div>');
                  getlocImgData.push({img:e.target.result, imgId:datGetCount, imgData:'img_live_'+datGetCount+c});
                c++;
                }
                reader.readAsDataURL(this.files[i]);
            }
            for(var i=0,len=datGetCount.length; i < len ;i++) {
              if(datGetCount[i] != datGetCount){  
                getlocImgId.push(datGetCount);
              }
           }
          });
      count++
          }); 
    });

//remove function for title and description
$(document).on('click', ".remove",function(){
  var getcount = $(this).attr('data');
  var tdData = $(this).attr('tdData');
  var addData = $(this).attr('addData');
  var longData = $(this).attr('longData');
  var latiDtat = $(this).attr('latiDtat');
  var countData = $(this).attr('countData');
  var desData = $(this).attr('desData');
  var imgData = $(this).attr('imgData');

var index = titleData.indexOf(tdData);
if (index >= 0) {
  titleData.splice( index, 1 );
}
var index1 = descriptionData.indexOf(desData);
if (index1 >= 0) {
  descriptionData.splice( index1, 1 );
}
var index2 = addressData.indexOf(addData);
if (index2 >= 0) {
  addressData.splice( index2, 1 );
}
var index3 = getlngData.indexOf(longData);
if (index3 >= 0) {
  getlngData.splice( index3, 1 );
}
var index4 = getlatData.indexOf(latiDtat);
if (index4 >= 0) {
  getlatData.splice( index4, 1 );
}
var index5 = countryData.indexOf(countData);
if (index5 >= 0) {
  countryData.splice( index5, 1 );
}
getlocImgId = $.grep(getlocImgId, function(value) {
  return value != getcount;
});

 var final = removeFromArr(getlocImgData,"imgId",getcount);
 getlocImgData = final;
$('.mapboxgl-marker').remove();
for(var i=0,len=getlngData.length; i < len ;i++) {
 // obj[getlngData[i]] = getlngData[i][i];
 marker = new mapboxgl.Marker({ 
              draggable: false, 
              color: 'Green',
            })
              .setLngLat([getlngData[i],getlatData[i]])
              .addTo(map)
} 
  $(".tr_"+getcount).remove();
  $("#dis_"+getcount).remove();
  $(".dis_"+getcount).remove();
  $(".img-div_"+getcount).remove();
  $(".preview-img-div_"+getcount).remove();
  if(addressData.length === 0){
    $('#validtitle').val('');
  }
});
function removeFromArr (parray,ptag,pstring){
 var b =[];
var count = 0;
for (var i =0;i<parray.length;i++){
 if(pstring != parray[i][ptag]){
 b[count] = parray[i];
 count++;
 }
}
 return b;
}

//remove function for img
$(document).on('click', ".removeImg",function(){
var getImgId = $(this).attr('getImgId');
var getcountData = $(this).attr('getcountData');
var imgData = $(this).attr('imgData');
$(this).parent().remove();
$("#preview-img-div_"+getImgId).remove();
var final = removeFromArr(getlocImgData,"imgData",imgData);
 getlocImgData = final;
 $('#uploadLoctionImg_'+getcountData)[0].value = '';
});


//show preview div with data
$(document).ready(function() {
  $(".showPreview").click(function(){
    if($('#card_image').val() == ''){
      $('.incrementImg').prepend('<div class="alert alert-danger">Please Select Card Picture </div>');
      $(".alert-danger").animate( { "opacity": "hide"} , 5000 );
      return false;
    }
    if($('#address').val() == ''){
      $('.incrementyTr').prepend('<div class="alert alert-danger">Please enter experience Location</div>');
      $(".alert-danger").animate( { "opacity": "hide"} , 5000 );
      return false;
    }
    $(".createDiv").hide();
    $(".previewDiv").show();
    var title = $('#cardtitle').val();
    var address = $('#title').val();
    var descriptionData = $('#sufy53hsvad').val();        
    var title = $('#cardtitle').val();
    var description = $('#description').val();
    $("#previewData").empty().append('<h4>'+title+'</h4>');
    features =[];
    for(var i=0,len=getlngData.length; i < len ;i++) {
      features.push ({
        'type': 'Feature',
        'geometry': {
        'type': 'Point',
        'coordinates': [getlngData[i],getlatData[i]]
      }
    })
    }
    mapboxgl.accessToken = '{{ env('MAPBOX_TOKEN') }}';
    var map = new mapboxgl.Map({
      container: 'map_pre',
      style: 'mapbox://styles/mapbox/streets-v11',
      center: [getlng, getlat],
      zoom: {{PostLocation::MAP_ZOOM}}
    });
    map.on('load', function () {
    // Add an image to use as a custom marker
    map.loadImage(
      'https://docs.mapbox.com/mapbox-gl-js/assets/custom_marker.png',
      function (error, image) {
        if (error) throw error;
        map.addImage('custom-marker', image);
        map.addSource('points', {
          'type': 'geojson',
          'data': {
            'type': 'FeatureCollection',
            'features':features
          }
        });
        // Add a symbol layer
        map.addLayer({
          'id': 'points',
          'type': 'symbol',
          'source': 'points',
          'layout': {
            'icon-image': 'custom-marker',
            // get the title name from the source's "title" property
            'text-field': ['get', 'title'],
            'text-font': [
            'Open Sans Semibold',
            'Arial Unicode MS Bold'
            ],
            'text-offset': [0, 1.25],
            'text-anchor': 'top'
          }
        });
      });
      });
  });
});
</script>
@endsection
