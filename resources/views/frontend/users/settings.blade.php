@extends('frontend.layouts.main')
@section('title', 'Setting-Change Password')
@section('content')
<div id="main-wrapper" class="bg-gray section-ptb">

  <div class="hr-line hr-heading">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h5 class="text-uppercase">Settings</h5>
          <hr>
        </div>
      </div>
    </div>
  </div>

  <div class="Settigns section-pt">
    <div class="container">
      <div class="row">
        <form action ="{{url('update-password')}}" method ="POST" class="col-12 col-md-8 offset-md-2">
		@csrf
		  <div class="form-group">
            <label for="inputPassword4">Current Password</label>
            <input type="password" name="current_password" class="form-control" value="{{ old('current_password') }}" >
            <span class="font-weight-bold text-danger">
                @if ($errors->has('current_password'))
                	<div>{{ $errors->first('current_password')}}</div>
            	@endif
            	@if(session()->has('current_password_error'))
                     <span class="errMsg">{{ session()->get('current_password_error') }}</span>
                @endif   
            </span>     	
          </div>
          <div class="form-group">
            <label for="inputPassword4">Enter New Password</label>
            <input type="password" name="password" class="form-control" value="{{ old('password') }}" id="inputPassword4">
            <span class="font-weight-bold text-danger">
                @if ($errors->has('password'))
                	<div class="text-danger">{{ $errors->first('password') }}</div>
            	@endif
        	</span>
          </div>
          <div class="form-group">
            <label for="inputPassword4">Re-enter New Password</label>
            <input type="password" name="confirm_password" class="form-control" value="{{ old('confirm_password') }}" id="inputPassword4">
            <span class="font-weight-bold text-danger">
                @if ($errors->has('confirm_password'))
                	<div class="text-danger">{{ $errors->first('confirm_password') }}</div>
            	@endif
        	</span>
          </div>
         
          <button name="submit" type="submit" class="butn butn-bg mt-3">Update</button>
        </form>
      </div>
    </div>
  </div>

</div>

@endsection