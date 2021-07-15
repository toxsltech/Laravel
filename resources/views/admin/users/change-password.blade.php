<?php
use App\Models\User;
use Illuminate\Support\Facades\URL;
?>
@extends('admin.layouts.main') 
@section('title', 'Change Password - Admin')
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
    		<div class="card-header">
    			<strong>Change Password</strong>
    		</div>
			<div class="card-body card-block">
            	<form method="POST" action="">
                	@csrf
					<div class="form-group">
						<label for="password">Password:</label>
						<input type="password" class="form-control" id="password" name="password" value="{{ old( 'password') }}">
						@if ($errors->has('password'))
                        	<div class="error">{{ $errors->first('password') }}</div>
                    	@endif
					</div>
					<div class="form-group">
						<label for="confirm_password">Confirm Password:</label>
						<input type="password" class="form-control" id="confirm_password" name="confirm_password" value="{{ old( 'confirm_password') }}">
						@if ($errors->has('confirm_password'))
                        	<div class="error">{{ $errors->first('confirm_password') }}</div>
                    	@endif
					</div>
                	<div class="form-group">
                         <button type="submit" class="btn btn-success" value="save">SAVE</button>
                    </div>
            	</form>
            </div>
		</div>
	</div>
</div>



@endsection

