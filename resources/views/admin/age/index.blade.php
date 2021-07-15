<?php
use Illuminate\Support\Facades\URL;
use App\Models\Age;
?>
@extends('admin.layouts.main') 
@section('title', 'Age - Admin')
@section('content')
<div class="breadcrumbs">
	<div class="col-sm-12">
		<div class="age-header float-left">
			<div class="age-title">
				<h1>ages</h1>
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
					
						<strong class="card-title">Age List</strong> 
						@if($ages->isEmpty())
						<a href="{{url('admin/age/add')}}"class="btn btn-primary pull-right"><i class="fa fa-plus"></i>Create</a>
						@endif
					</div>
					<div class="card-body">
							<div class="table-responsive">
								<table id="property_table"
									class="table table-striped table-bordered">
									<thead>
										<tr>
											<th>Id</th>
											<th>Age</th>
											<th>State</th>
											<th>Created On</th>
											<th>Action</th>
										</tr>										
									</thead>
									<tbody>
									@if(!$ages->isEmpty()) 
										@foreach ($ages as $age)
										<tr>
											<td>{{$age->id }}</td>	
											<td>{{$age->age}}</td>
											<td>{{$age->getState() }}</td>
											<td>{{$age->created_at}}</td>
											<td><a href="{{url('/admin/age/view/'.$age->id)}}"
												class="btn btn-success"><i class="fa fa-eye"></i></a> &nbsp;
												<a href="{{url('/admin/age/edit/'.$age->id)}}"
												class="btn btn-primary"><i class="fa fa-edit"></i></a>
												&nbsp;
												<form method="post" action="{{url('admin/age/delete')}}">
													@csrf <input type="hidden" name="id" value="{{ $age->id}}">
													<button type="submit" class="btn btn-danger" id="deleted"
														onclick="return confirm('Are you sure? You want to delete it.')">
														<i class="fa fa-trash"></i>
													</button>
												</form></td>
										</tr>
										@endforeach
									</tbody>
									@else
									<td colspan="5" class="text-center"><h4>No Age Found</h4></td>
									@endif
								</table>
							</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection 