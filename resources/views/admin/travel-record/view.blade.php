<?php
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
?>

@extends('admin.layouts.main')
@section('title', 'Travel Experience-View Record')
 @section('content')

<div class="page-header">
	<div class="row pt-3 pb-3">
		<div class="col-md-8">
			<div class="page-title ">
				<h3>{{ ucfirst($record->title) }}</h3>
				<span class="text-center label label-success">{{ Post::getState($record->state_id) }}</span>
			</div>
		</div>
		<div class="col-md-4 d-flex justify-content-end align-items-center">
            <div class="row">
              <div class="col-md-12 btnbox">
                 <a href="{{url('admin/travel-record')}}" class="btn btn-warning" title="Back"><i class="fa fa-arrow-left"></i></a>
                <form method="post" action="{{url('admin/travel-record/delete')}}">
                @csrf
    				<input type="hidden" class="trash" name="id" value ="{{ $record->id}}">    				
    				<button type="submit" class="btn btn-danger" id="view-delete" onclick="return confirm('Are you sure? You want to delete it.')"><i class="fa fa-trash"></i></button>			       
			  </form> 
             </div>
         </div>
     </div>
 </div>
</div>
<div class="row">
    <div class="content mt-3">
    	<div class="animated fadeIn">
    		<div class="card">
    			<div class="card-body">
    				<div class="row">
    					<div class="col-lg-2 text-center position-relative">
    						@if(str_replace(url('/') . '/public/uploads/card_image',"",$record->card_image)) 
                         		<img src="{!!asset('public/uploads/card_image/'. $record->card_image)!!}" class="profile_file">
                         	@else
                         		<img src="{!!asset('public/img/default.png')!!}" class="css-class profile_file" alt="alt text">
                         	@endif                         
                            <input type="hidden" id="current_user" value="{{ $record->id }}">
                   </div>
                   <div class="col-lg-10">
                    <div class="table-responsive">
                      <table class="table table-striped table-bordered">
                         <tbody>
                            <tr>
                               <th scope="row">Title:</th>
                               <td>{{$record->title}}</td>
                           </tr>
                           <tr>
                               <th scope="row">Created By Name:</th>
                               <td>{{$record->getUser->first_name}} {{$record->getUser->last_name}}</td>
                           </tr>   
                           <tr>
                               <th scope="row">Created On:</th>
                               <td>{{$record->created_at}}</td>
                           </tr>  
                           <?php $count = 1; ?>
                           @foreach($record->getLocationData as $value)   
                            <th><h5>Location - {{$count}}</h5></th>                           
                            <tr>
                               <th scope="row">Country:</th>
                               <td>{{$value->country}}</td>
                           </tr>
                           <tr>
                               <th scope="row">Location Name:</th>
                               <td>{{$value->location}}</td>
                           </tr>                            
                           <tr>
                               <th scope="row">Location Latitude:</th>
                               <td>{{$value->latitude}}</td>
                           </tr> 
                           <tr>
                               <th scope="row">Location Longitude:</th>
                               <td>{{$value->longitude}}</td>
                           </tr>                               
                           <tr>
                               <th scope="row">Description:</th>
                               <td>{!! nl2br($value->description) !!}</td>
                           </tr>
                            <?php $count++ ?>
                           @endforeach                           
                       </tbody>
                   </table>
               </div>
               </div>
           </div>
       </div>
    </div>
 </div>
<!-- .animated -->
</div>
</div>
<div class="location_pictures">
    @if(!$imageData->isEmpty())
       @foreach ($imageData as  $location)   
        <div class="lp_main location-imgbox">
             @if(str_replace(url('/') . '/public/uploads/card_image',"",$location->location_image)) 
                <a class="thumbnail fancybox" rel="ligthbox" href="{!!asset('public/uploads/card_image/'. $location->location_image)!!}">
         	    <img src="{!!asset('public/uploads/card_image/'. $location->location_image)!!}" class="Card_Image cmnimg" alt="aery"></a>
         	@else
         		<img src="{!!asset('public/frontend/imgs/banners/1.jpg')!!}" class="Card_Image cmnimg" alt="aery">
            @endif               
    </div>
   @endforeach
  @endif   
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
<script src="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
<script>
     $(".fancybox").fancybox({
        openEffect: "none",
        closeEffect: "none"
      });
</script>
@endsection
