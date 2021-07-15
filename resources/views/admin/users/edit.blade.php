<?php
use App\Models\User;
use Illuminate\Support\Facades\URL;
?>
@extends('admin.layouts.main')
@section('title', 'User Details - Admin | Edit')
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header"></div>
			<div class="card-body card-block">
				<form method="POST" action="">
					@csrf
					<div class="form-group">
						<label for="first_name">First Name:</label>
						<input type="text" class="form-control" id="first_name" name="first_name" value="{{ old( 'first_name', $user->first_name) }}">
						@if ($errors->has('first_name'))
                        	<div class="error">{{ $errors->first('first_name') }}</div>
                    	@endif
					</div>
					<div class="form-group">
						<label for="last_name">Last Name:</label>
						<input type="text" class="form-control" id="last_name" name="last_name" value="{{ old( 'last_name', $user->last_name) }}">
						@if ($errors->has('last_name'))
                        	<div class="error">{{ $errors->first('last_name') }}</div>
                    	@endif
					</div>
					<div class="form-group">
						<label for="email">Email:</label>
						<input type="text" class="form-control" id="email" name="" value="{{ old( 'email', $user->email) }}" disabled>
						@if ($errors->has('email'))
                        	<div class="error">{{ $errors->first('email') }}</div>
                    	@endif
					</div>								
					<div class="form-group">
						<button type="submit" class="btn btn-success" value="save">UPDATE</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
