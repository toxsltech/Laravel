<?php
use App\Models\User;
use Illuminate\Support\Facades\URL;
?>
@extends('admin.layouts.main') 
@section('title', 'User Add - Admin')
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
    		<div class="card-header">
    			<strong>Add</strong> User
    		</div>
			<div class="card-body card-block">
            	<form method="POST" action="" enctype="multipart/form-data">
                	@csrf
                	<div class="form-group">
						<label for="first_name">First Name:</label>
						<input type="text" class="form-control" id="first_name" name="first_name" value="{{ old( 'first_name') }}">
						@if ($errors->has('first_name'))
                        	<div class="error">{{ $errors->first('first_name') }}</div>
                    	@endif
					</div>
					<div class="form-group">
						<label for="last_name">Last Name:</label>
						<input type="text" class="form-control" id="last_name" name="last_name" value="{{ old( 'last_name') }}">
						@if ($errors->has('last_name'))
                        	<div class="error">{{ $errors->first('last_name') }}</div>
                    	@endif
					</div>
					<div class="form-group">
						<label for="email">Email:</label>
						<input type="text" class="form-control" id="email" name="email" value="{{ old( 'email') }}">
						@if ($errors->has('email'))
                        	<div class="error">{{ $errors->first('email') }}</div>
                    	@endif
					</div>
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
                		<label for="profile_file">Image:</label>
                		<input type="file" class="form-control" id="profile_file" name="profile_file">
                		@if ($errors->has('profile_file'))
                            <div class="error">{{ $errors->first('profile_file') }}</div>
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

