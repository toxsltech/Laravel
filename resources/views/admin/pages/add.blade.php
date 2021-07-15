<?php
use App\Models\Page;
?>
@extends('admin.layouts.main') 
@section('title', 'Static Pages - Admin | Add')
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<strong>Add</strong> Pages
			</div>
			<div class="card-body card-block">
				<form method="POST" action="" enctype="multipart/form-data">
					@csrf
					<div class="form-group"
						style="margin: 0 auto; width: 50%; text-align: left">
						<div class="form-group">
							<label for="title"> Title:</label> <input type="text"
								class="form-control" id="title" name="title"
								value="{{old('title')}}"> @if ($errors->has('title'))
							<div class="error">{{ $errors->first('title') }}</div>
							@endif
						</div>
						<div class="form-group">
							<label for="area"> Description:</label>
							<textarea class="form-control" id="description"
								name="description">{{old('description')}}</textarea>
							@if ($errors->has('description'))
							<div class="error">{{ $errors->first('description') }}</div>
							@endif
						</div>
						<div class="form-group">
							<label for="type">Type:</label> <select class="form-control"
								name="type_id">
								<option value="" disabled>Select Type...</option>
    							
                              @foreach(Page::getTypeOptions() as $key => $type)
							    <option value="{{ $key }}" {{ $key==old('type_id') ? 'selected' : '' }}>{{
								$type }}</option>
    						@endforeach
    						</select> @if ($errors->has('type_id'))
							<div class="error">{{ $errors->first('type_id') }}</div>
							@endif
						</div>
						<div class="form-group">
							<label for="type">State:</label> <select class="form-control"
								name="state_id">
								<option value="" disabled>Select State...</option>
    							@foreach(Page::getStateOptions() as $key => $state)
    							    <option value="{{ $key }}" {{ $key==old('state_id') ? 'selected' : '' }}>{{
									$state }}</option>
                                @endforeach
    						</select> @if ($errors->has('state_id'))
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
@section('after_footer')
    <script type="text/javascript">
    CKEDITOR.replace('description');
    </script>
@endsection
