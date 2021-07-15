<?php
use App\Models\Age;
?>
@extends('admin.layouts.main')
@section('title', 'Age - Admin | Add')
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<strong>Add</strong> Age
			</div>
			<div class="card-body card-block">
				<form method="POST" action="" enctype="multipart/form-data">
					@csrf
					<div class="form-group"
						style="margin: 0 auto; width: 50%; text-align: left">
						<div class="form-group">
							<label for="title"> Age:</label> 
							<input type="text"class="form-control" id="title" name="age" value="{{old('age')}}">
							@if ($errors->has('age'))
							<div class="error">{{ $errors->first('age') }}</div>
							@endif
						</div>						
					
						<div class="form-group">
							<label for="type">State:</label> <select class="form-control"name="state_id">
								<option value="" disabled>Select State...</option>
    							@foreach(Age::getStateOptions() as $key => $state)
    							    <option value="{{ $key }}" {{ $key==old('state_id') ? 'selected' : '' }}>{{
									$state }}</option>
                                @endforeach
    						</select> 
    						@if ($errors->has('state_id'))
							<div class="error">{{ $errors->first('state_id') }}</div>
							@endif
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-success" value="save">SAVE</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection 
