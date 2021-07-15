<?php
use Illuminate\Support\Facades\URL;
use App\Models\User;
use App\Models\Feed;
use Illuminate\Support\Facades\Auth;
?>

@extends('admin.layouts.main')
@section('title', 'Login feedData - Admin | View')
@section('content')

<div class="page-header">
	<div class="row pt-3 pb-3">
		<div class="col-md-8">
			<div class="page-title ">
				<h3>{{ ucfirst($feedData->content) }}</h3>				
			</div>
		</div>
		<div class="col-md-4 d-flex justify-content-end align-items-center">
	 		<div class="row">
        		<div class="col-md-12 d-flex">
        			<a href="{{url('admin/user-feeds')}}" class="btn btn-warning" title="Back"><i class="fa fa-arrow-left"></i> </a>
        			 <form method="post" class="trash" action="{{url('admin/user-feeds/delete')}}">
						@csrf                       				
        				<input type="hidden" name="id" value ="{{ $feedData->id}}">
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
    									<td>{{$feedData->id}} </td>
    									<th scope="row">User:</th>
    									<td>{{ $feedData->getUser ? $feedData->getUser->first_name : '' }} {{ $feedData->getUser ? $feedData->getUser->last_name : '' }} </td>
    								</tr>
    									<tr>
    									<th scope="row">Type Content:</th>
    									<td>{{$feedData->content}} </td>
    									<th scope="row">User Agent:</th>
    									<td>{{$feedData->user_agent}} </td>
    								</tr>
    								<tr>
    									<th scope="row">UserIP:</th>
    									<td>{{$feedData->user_ip}} </td>
    									<th scope="row">Created On:</th>
    									<td>{{$feedData->created_at}} </td>
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
