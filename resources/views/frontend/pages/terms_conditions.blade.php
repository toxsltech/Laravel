<?php
use Illuminate\Support\Facades\Auth;
$user=Auth::user();
?>
@extends('frontend.layouts.main')
@section('title', 'Terms & Condition')
@section('content')
<div id="main-wrapper" class="bg-gray section-ptb">
  <div class="space_content">
    <div class="container">
      <div class="row">
        <div class="col-12">
         @if($term)
          {!! $term->description !!}
           @else
          <div class="col-md-12 text-center"><h4>Terms and Conditions Not Available</h4  ></div>
        @endif  
        </div>
      </div>
    </div>
  </div>
</div>
@endsection