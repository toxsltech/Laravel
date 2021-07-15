<?php
use Illuminate\Support\Facades\Auth;
$user=Auth::user();
?>
@extends('frontend.layouts.main')
@section('title', 'Privacy Policy')
@section('content')
<div id="main-wrapper" class="bg-gray section-ptb">
  <div class="space_content">
    <div class="container">
      <div class="row">
        <div class="col-12">
        @if($policy)        
          <h1>{{$policy->title}}</h1>
          {!! $policy->description !!}
        @else
          <div class="col-md-12 text-center"><h4>Privacy Policy Not Available</h4  ></div>
        @endif   
        </div>
      </div>
    </div>
  </div>
</div>
@endsection