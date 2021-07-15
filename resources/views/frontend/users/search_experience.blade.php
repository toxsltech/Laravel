<?php 
use App\Models\Post;
use App\Models\Follower;
use App\Models\PostLocation;
use App\Models\SaveCounters;
use Illuminate\Support\Facades\Auth;
?>
<div class="row">
@if(!$experience->isEmpty())
@foreach($experience as $key=>$value)
  <div class="col-xl-3 col-lg-4 col-md-6 mb-3" id="MarakBookData">
    <div class="discover_cards position-relative">
      <a href="{{url('discover/post-preview/'. encrypt($value->id))}}" class="">
        <p class="discover_content"><span>{{ $value->title }}</span></p>
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
  <div class="pagination-box" getdata="experience">
      {!! $experience->links() !!}
 </div> 
@else
  <div class="col-md-12 text-center"><h4>No Details found. Try to search again !</h4  ></div>
@endif