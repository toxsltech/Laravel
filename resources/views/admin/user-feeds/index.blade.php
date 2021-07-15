<?php
use Illuminate\Support\Facades\URL;
use App\Models\User;
use App\Models\Feed;
?>
@extends('admin.layouts.main') 
@section('title', 'User Feeds-Record')
@section('content')

<div class="breadcrumbs">
	<div class="col-sm-12">
		<div class="page-header float-left">
			<div class="page-title">
				<h1>Users Activities</h1>
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
					<div class="col-lg-10"><strong class="card-title">User Activities</strong>	</div>					
					</div>
					<div class="card-body">		
						 <form action="">									
                            <div class="table-responsive">
                              <table class="table table-striped table-bordered">
                                 <thead>
                                    <tr>
                                       <th>Id</th>
                                       <th>title</th>                                       
                                       <th>User Agent</th>
                                       <th>User Ip</th>
                                       <th>User Name</th>
                                       <th>Created On</th>
                                       <th>Action</th>
                                   </tr>   
                                   <tr>
                                     <th style="width: 6%"><input type="text" name="id" class="form-control search_bar" value="{{ $id }}"></th>
                                     <th><input type="text" name="content" class="form-control search_bar" value="{{ $title }}"></th>
                                     <th><input type="text" name="user_agent" class="form-control search_bar" value="{{ $userAgent }}"></th>
                                     <th><input type="text" name="user_ip" class="form-control search_bar" value="{{ $userIp }}"></th> 
                                     <th><input type="text" name="name" class="form-control search_bar" value="{{ $userName }}"></th>                                       
                                     <th><input type="text" name="created_at" class="form-control search_bar" value="{{ $created }}"></th>
                                     <th></th>
                                   </tr>                               
                            </thead>
                             </form> 
                            <tbody>
                            @if(!$feedData->isEmpty())
    							@foreach ($feedData as $row)
    							<tr>
    								<td>{{ $row->id }}</td>
    							    <td>{{ $row->content}}</td>
    							    <td>{{ $row->user_agent}}</td>
    							    <td>{{$row->user_ip}}</td>
    							    <td>{{$row->getUser->first_name}} {{$row->getUser->last_name}}</td>
    								<td>{{ $row->created_at}}</td>
    								<td><a href="{{url('/admin/user-feeds/'.$row->id)}}" class="btn btn-success"><i class="fa fa-eye"></i></a> &nbsp;
    									<form method="post" action="{{url('admin/user-feeds/delete')}}">
    										@csrf 
    										<input type="hidden" name="id" value="{{ $row->id}}">
    										<button type="submit" class="btn btn-danger" id="deleted"
    											onclick="return confirm('Are you sure? You want to delete it.')">
    											<i class="fa fa-trash"></i>
    										</button>
    									</form></td>
    							</tr>
    							@endforeach
						  @else
                          <td colspan="7" class="text-center"><h4>No Found User Activities</h4	></td>
                          @endif			
						</tbody>						
                  </table>
                  <div class="pagination-box">
                  {{$feedData->appends(request()->input())->links()}}
                </div>
              </div>             					
          </div>
      </div>
    </div>
</div>
</div>
</div>

@endsection

@section('after_footer')

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
