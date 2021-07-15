<?php
use Illuminate\Support\Facades\URL;
use App\Models\User;
?>
@extends('admin.layouts.main')
@section('title', 'Email Queue - Admin')
@section('content')

<div class="breadcrumbs">
	<div class="col-sm-12">
		<div class="page-header float-left">
			<div class="page-title">
				<h1>Email Queue</h1>
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
						<strong class="card-title">Email Queue</strong>
					</div>
					<div class="card-body">
						@if(!$emails->isEmpty())
						<div class="table-responsive">
							<table class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>Id</th>
										<th>From Email</th>
										<th>To Email</th>
										<th>Subject</th>
										<th>Date Sent</th>
										<th>State</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($emails as $email)
									<tr>
										<td>{{ $email->id}}</td>
										<td>{{ $email->from_email }}</td>
										<td>{{ $email->to_email }}</td>
										<td>{{ $email->subject }}</td>
										<td>{{ $email->date_sent}}</td>
										<td>{{ $email->getState() }}</td>
										<td><a href="{{url('/admin/email-queue/'.$email->id)}}"
											class="btn btn-success"><i class="fa fa-eye"></i></a> &nbsp;
											<form method="post"
												action="{{url('admin/email-queue/delete')}}">
												@csrf <input type="hidden" name="id" value="{{ $email->id}}">
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
						{{ $emails->links()}} @else
						</div>
						<h4 class="text-center">No emails sent</h4>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
