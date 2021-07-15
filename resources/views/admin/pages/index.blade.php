<?php
use Illuminate\Support\Facades\URL;
use App\Models\Page;
?>
@extends('admin.layouts.main') 
@section('title', 'Static Pages - Admin')
@section('content')
<div class="breadcrumbs">
	<div class="col-sm-12">
		<div class="page-header float-left">
			<div class="page-title">
				<h1>Pages</h1>
			</div>
		</div>
	</div>
</div>
<div class="content mt-3">
	<div class="animated fadeIn">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<strong class="card-title">Page List</strong> <a
							href="{{url('admin/page/add')}}"
							class="btn btn-primary pull-right"><i class="fa fa-plus"></i>
							Create</a>
					</div>
					<div class="card-body">
						<form action="">
							<div class="table-responsive">
								<table id="property_table"
									class="table table-striped table-bordered">
									<thead>
										<tr>
											<th>Id</th>
											<th>Title</th>
											<th>Type</th>
											<th>State</th>
											<th>Create By</th>
											<th>Created On</th>
											<th>Action</th>
										</tr>
										<tr>
											<th style="width: 6%"><input type="text" name="id"
												class="form-control search_bar" value="{{ $id }}"></th>
											<th><input type="text" name="title"
												class="form-control search_bar" value="{{ $title }}"></th>
											<th><select class="form-control search_bar_dropdown"
												name="type_id" id="type">
													<option value=""></option>
                    							<?php $types = Page::getTypeOptions();
                                                foreach ($types as $key => $type) { ?>
                    							   <option value="{{ $key }}" {{ $typeid==$key ? 'selected' : '' }}>{{ $type }}</option>
                    							<?php } ?>
                    						</select></th>
											<th><select class="form-control search_bar_dropdown"
												name="state_id" id="state">
													<option value=""></option>
                        						<?php $states = Page::getStateOptions();
                                                foreach ($states as $key => $state) {  ?>
                    							<option value="{{ $key }}" {{ $stateid==$key ? 'selected' : '' }}>{{ $state }}</option>
                    						<?php } ?>
                    					</select></th>
											<th></th>
											<th></th>
											<th></th>
										</tr>
									</thead>
									</form>
									<tbody>
										@if(!$pages->isEmpty()) 
										@foreach ($pages as $page)
										<tr>
											<td>{{ $page->id }}</td>
											<td>{{$page->title}}</td>
											<td>{{$page->getType() }}</td>
											<td>{{$page->getState() }}</td>
											<td>{{$page->created_by_id}}</td>
											<td>{{$page->created_at}}</td>
											<td><a href="{{url('/admin/page/view/'.$page->id)}}"
												class="btn btn-success"><i class="fa fa-eye"></i></a> &nbsp;
												<a href="{{url('/admin/page/edit/'.$page->id)}}"
												class="btn btn-primary"><i class="fa fa-edit"></i></a>
												&nbsp;
												<form method="post" action="{{url('admin/page/delete')}}">
													@csrf <input type="hidden" name="id" value="{{ $page->id}}">
													<button type="submit" class="btn btn-danger" id="deleted"
														onclick="return confirm('Are you sure? You want to delete it.')">
														<i class="fa fa-trash"></i>
													</button>
												</form></td>
										</tr>
										@endforeach
									</tbody>
									@else
									<td colspan="7" class="text-center"><h4>No Pages Found</h4></td>
									@endif
								</table>
							</div>
					
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection @section('after_footer')

<script>
jQuery(function($){

	$(document).on('blur', '.search_bar', function(e){
		$(this).closest('form').submit()
    })
    
	$(document).on('keypress', '.search_bar', function(e){
		if(e.which == 13) {
			$(this).closest('form').submit()
		}
    })

	$(document).on('change', '.search_bar_dropdown', function(e){
		$(this).closest('form').submit()
	 })
})

</script>

@endsection


