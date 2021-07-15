<?php
use App\Models\Age;
?>
@extends('admin.layouts.main')
@section('title', 'Age - Admin | EDit')
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header"></div>
			<div class="card-body card-block">
				<form method="POST" action="" enctype="multipart/form-data">
                	@csrf
                	<div class="form-group">
						<label for="full_name">Age:</label>
						<input type="text" class="form-control" id="age" name="age" value="{{ old( 'age', $age->age) }}">
						@if ($errors->has('age'))
                        	<div class="error">{{ $errors->first('age') }}</div>
                    	@endif
					</div>	
					<div class="form-group">
						<label for="state_id">State:</label>
						<select class="form-control" name="state_id" value="{{ old( 'state_id')}}">
							<option disabled>Select State...</option>
							@foreach(Age::getStateOptions() as $key => $state)
							    <option value="{{ $key }}" {{ $key == old('state_id', $age->state_id) ? 'selected' : '' }}>{{ $state }}</option>
							@endforeach
						</select>
						@if ($errors->has('state_id'))
                        	<div class="error">{{ $errors->first('state_id') }}</div>
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

@section('after_footer')
    <script type="text/javascript">
    CKEDITOR.replace('description');
    </script>
@endsection

