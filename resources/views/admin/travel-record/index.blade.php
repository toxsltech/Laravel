<?php
use Illuminate\Support\Facades\URL;
use App\Models\User;
use App\Models\Post;
?>
@extends('admin.layouts.main') 
@section('title', 'Travel Experience-Record')
@section('content')

<div class="breadcrumbs">
	<div class="col-sm-12">
		<div class="page-header float-left">
			<div class="page-title">
				<h1>Travel Experience</h1>
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
					<div class="col-lg-10"><strong class="card-title">Travel Experience Record</strong>	</div>					
					<div class="col-lg-2"><a href="{{url('admin/records/download')}}" class="btn btn-primary pull-right"> <span class="fa fa-download"></span></a></div>					
					</div>
					<div class="card-body">						
						<form action="">
                            <div class="table-responsive">
                              <table class="table table-striped table-bordered">
                                 <thead>
                                    <tr>
                                       <th>Id</th>
                                       <th>Title</th>
                                       <th>Created By</th>                                      
                                       <th>Created On</th>
                                       <th>Action</th>
                                   </tr>
                                   <tr>                        		 	
                                       <th style="width: 6%"><input type="text" name="id" class="form-control search_bar" value="{{ $id }}"></th>
                                       <th><input type="text" name="title" class="form-control search_bar" value="{{ $title }}"></th>
                                        <th><input type="text" name="name" class="form-control search_bar" value="{{ $userid }}"></th>                                       
                                     <th><input type="text" name="created_at" class="form-control search_bar" value="{{ $created }}"></th>
                                    <th></th>
                                </tr>
                            </thead>
                            </form> 
                            <tbody>
                             @if(!$records->isEmpty())
                             @foreach ($records as $record)
                             <tr>
                               <td>{{ $record->id }}</td>
                               <td>{{ $record->title }}</td>
                               <td>{{ $record->getUser->first_name }} {{ $record->getUser->last_name }}</td>                            
                               <td>{{ $record->created_at}}</td>
                               <td>
                                  <a href="{{url('/admin/travel-record/'.encrypt($record->id))}}" class="btn btn-success"><i class="fa fa-eye"></i></a> &nbsp;
                                  <form method="post" action="{{url('admin/travel-record/delete')}}">
    									@csrf                       				
                        				<input type="hidden" name="id" value ="{{ $record->id}}">
                        				<button type="submit" class="btn btn-danger" id="deleted" onclick="return confirm('Are you sure? You want to delete it.')"><i class="fa fa-trash"></i></button>
                    			  </form>  &nbsp;
                                      @if($record->state_id==Post::STATE_ACTIVE)                                         
                                          <a onclick="return confirm('Are you sure? You want to Inactive it.')" href="{{url('/admin/travel-record/state/'.$record->id)}}" class="btn btn-primary btn-sm">Inactive</a>                                     
                                      @else
                                          <a onclick="return confirm('Are you sure? You want to Active it.')" href="{{url('/admin/travel-record/state/'.$record->id)}}" class="btn btn-info btn-sm">Active</a> 
                                      @endif
                              </td>                               
                          </tr>
                          @endforeach
                          @else
                          <td colspan="5" class="text-center"><h4>Travel Recods not available</h4></td>
                          @endif
                      </tbody>
                  </table>
                  <div class="pagination-box">
                     {{ $records->appends(request()->input())->links()}}
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
