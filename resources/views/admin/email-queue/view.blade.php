<?php
use Illuminate\Support\Facades\URL;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
?>

@extends('admin.layouts.main')
@section('title', 'Email Queue - Admin | View')
@section('content')

<div class="page-header">
	<div class="row pt-3 pb-3">
		<div class="col-md-8">
			<div class="page-title ">
				<h3>{{ ucfirst($email->to_email) }}</h3>
				<span class="text-center label label-success">{{ $email->getState() }}</span>
			</div>
		</div>
		<div class="col-md-4 d-flex justify-content-end align-items-center">
	 		<div class="row">
        		<div class="col-md-12">
        			<a href="{{url('admin/email-queue')}}" class="btn btn-warning" title="Back"><i class="fa fa-arrow-left"></i> </a>
        			<form method="post" class="trash" action="{{url('admin/email-queue/delete')}}">
						@csrf                       				
        				<input type="hidden" name="id" value ="{{ $email->id}}">
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
    									<td>{{$email->id}} </td>
    									<th scope="row">Subject:</th>
    									<td>{{ $email->subject }} </td>
    								</tr>
    								<tr>
    									<th scope="row">To Email:</th>
    									<td>{{$email->to_email}} </td>
    									<th scope="row">From Email:</th>
    									<td>{{$email->from_email}} </td>
    								</tr>
    								<tr>
    									<th scope="row">Date Sent:</th>
    									<td>{{$email->date_sent}} </td>
    									<th scope="row">Attempts:</th>
    									<td>{{$email->attempts}} </td>
    								</tr>
    								@if(!$email->message)
    								<tr>
    									<th>Message:</th>    
    									<td>{{$email->message}} </td>   									 									
    								</tr>
    								@endif
    							</tbody>
    						</table>
                        </div>
    					</div>
    				</div>
    			</div>
    		</div>
    		<div class="card">
    			<div class="card-body">
        			<div class="row">
        				<div class="col-md-12">
        					<iframe class="message_frame" src="{{ url('admin/email-queue/show/'.$email->id) }}"></iframe>
        				</div>
        			</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>
@endsection