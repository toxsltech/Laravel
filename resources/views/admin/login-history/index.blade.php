<?php
use Illuminate\Support\Facades\URL;
use App\Models\User;
?>
@extends('admin.layouts.main')
@section('title', 'Login History - Admin')
@section('content')

<div class="breadcrumbs">
	<div class="col-sm-12">
		<div class="page-header float-left">
			<div class="page-title">
				<h1>Login History</h1>
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
						<strong class="card-title">Login History</strong>
					</div>
					<div class="card-body">
						@if(!$history->isEmpty())
						<div class="table-responsive">
							<table class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>Id</th>
										<th>First name</th>
										<th>Last name</th>
										<th>Email</th>
										<th>User IP</th>
										<th>User Agent</th>
										<th>State</th>
										<th>Created On</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($history as $row)
									<tr>
										<td>{{ $row->id}}</td>
										<td>{{ $row->getUser ? $row->getUser->first_name : '-' }}</td>
										<td>{{ $row->getUser ? $row->getUser->last_name : '-' }}</td>
										<td>{{ $row->email }}</td>
										<td>{{ $row->user_ip }}</td>
										<td>{{ $row->user_agent}}</td>
										<td>{{ $row->getState() }}</td>
										<td>{{ $row->created_at}}</td>
										<td><a href="{{url('/admin/login-history/'.$row->id)}}"
											class="btn btn-success"><i class="fa fa-eye"></i></a> &nbsp;
											<form method="post"
												action="{{url('admin/login-history/delete')}}">
												@csrf <input type="hidden" name="id" value="{{ $row->id}}">
												<button type="submit" class="btn btn-danger" id="deleted"
													onclick="return confirm('Are you sure? You want to delete it.')">
													<i class="fa fa-trash"></i>
												</button>
											</form></td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
						<div class="pagination-box">
						{{ $history->links()}} 
						</div>						
						@else
						<h4 class="text-center">No login history available</h4>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
