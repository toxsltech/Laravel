<?php
use App\Models\Page;
?>
@extends('admin.layouts.main')
@section('title', 'Static Pages - Admin | Edit')
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header"></div>
			<div class="card-body card-block">
				<form method="POST" action="" enctype="multipart/form-data">
                	@csrf
                	<div class="form-group">
						<label for="full_name">Title:</label>
						<input type="text" class="form-control" id="title" name="title" value="{{ old( 'title', $pages->title) }}">
						@if ($errors->has('title'))
                        	<div class="error">{{ $errors->first('title') }}</div>
                    	@endif
					</div>	
					<div class="form-group">
						<label for="description">Description:</label>
						<textarea rows="4" cols="50" class="form-control" id="description" name="description">{{ old( 'description', $pages->description) }}</textarea>
						@if ($errors->has('description'))
                        	<div class="error">{{ $errors->first('description') }}</div>
                    	@endif
					</div>					
					<div class="form-group">
						<label for="type_id">Type:</label>
						<select class="form-control" name="type_id" value="{{ old( 'type_id')}}">
							<option disabled>Select Type...</option>
							@foreach(Page::getTypeOptions() as $key => $type)
							    <option value="{{ $key }}" {{ $key == old('type_id', $pages->type_id) ? 'selected' : '' }}>{{ $type }}</option>
							@endforeach
						</select>
						@if ($errors->has('type_id'))
                        	<div class="error">{{ $errors->first('type_id') }}</div>
                    	@endif
					</div>			
					<div class="form-group">
						<label for="state_id">State:</label>
						<select class="form-control" name="state_id" value="{{ old( 'state_id')}}">
							<option disabled>Select State...</option>
							@foreach(Page::getStateOptions() as $key => $state)
							    <option value="{{ $key }}" {{ $key == old('state_id', $pages->state_id) ? 'selected' : '' }}>{{ $state }}</option>
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

