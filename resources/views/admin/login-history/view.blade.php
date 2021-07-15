<?php
use Illuminate\Support\Facades\URL;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
?>

@extends('admin.layouts.main')
@section('title', 'Login History - Admin | View')
@section('content')

<div class="page-header">
	<div class="row pt-3 pb-3">
		<div class="col-md-8">
			<div class="page-title ">
				<h3>{{ ucfirst($history->email) }}</h3>
				<span class="text-center label label-success">{{ $history->getState() }}</span>
			</div>
		</div>
		<div class="col-md-4 d-flex justify-content-end align-items-center">
	 		<div class="row">
        		<div class="col-md-12 d-flex">
        			<a href="{{url('admin/login-history')}}" class="btn btn-warning" title="Back"><i class="fa fa-arrow-left"></i> </a>
        			 <form method="post" class="trash" action="{{url('admin/login-history/delete')}}">
						@csrf                       				
        				<input type="hidden" name="id" value ="{{ $history->id}}">
        				<button type="submit" class="btn btn-danger" id="view-delete" onclick="return confirm('Are you sure? You want to delete it.')"><i class="fa fa-trash"></i></button>
    				</form>
        		</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
    <div class="content mt-3">
    	<div class="animated fadeIn">
    		<div class="card">
    			<div class="card-body">
    				<div class="row">
    					<div class="col-lg-12">
                            <div class="table-responsive">
    						<table class="table table-striped table-bordered">
    							<tbody>
    								<tr>
    									<th scope="row">ID:</th>
    									<td>{{$history->id}} </td>
    									<th scope="row">User:</th>
    									<td>{{ $history->getUser ? $history->getUser->first_name : '' }} {{ $history->getUser ? $history->getUser->last_name : '' }} </td>
    								</tr>
    								<tr>
    									<th scope="row">UserIP:</th>
    									<td>{{$history->user_ip}} </td>
    									<th scope="row">User Agent:</th>
    									<td>{{$history->user_agent}} </td>
    								</tr>
    								<tr>
    									<th scope="row">State:</th>
    									<td>{{$history->getState()}} </td>
    									<th scope="row">Type:</th>
    									<td>{{$history->getType()}} </td>
    								</tr>
    								<tr>
    									<th scope="row">email:</th>
    									<td>{{$history->email}} </td>
    									<th scope="row">Failure Reason:</th>
    									<td>{{$history->failure_reason}} </td>
    								</tr>
    								<tr>
    									<th scope="row">Link:</th>
    									<td>{{$history->link}} </td>
    									<th scope="row">Created On:</th>
    									<td>{{$history->created_at}} </td>
    								</tr>
    							</tbody>
    						</table>
                        </div>
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>
@endsection
