<?php
use Illuminate\Support\Facades\URL;
use App\Models\User;
?>
@extends('admin.layouts.main') 
@section('title', 'All User Racord- Admin')
@section('content')

<div class="breadcrumbs">
	<div class="col-sm-12">
		<div class="page-header float-left">
			<div class="page-title">
				<h1>Users</h1>
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
						<strong class="card-title">Users</strong> 
						<a href="{{url('admin/user/add')}}" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Create</a>
						<a href="{{url('admin/download')}}" class="btn btn-primary pull-right"><span class="fa fa-download"></span></a>	 					
					</div>
					<div class="card-body">						
						<form action="">
                            <div class="table-responsive">
                              <table class="table table-striped table-bordered">
                                 <thead>
                                    <tr>
                                       <th>Id</th>
                                       <th>First Name</th>
                                       <th>Last Name</th>
                                       <th>Email</th>                                      
                                       <th>Type</th>
                                       <th>Created On</th>
                                       <th>Action</th>
                                   </tr>
                                   <tr>                        		 	
                                       <th style="width: 6%"><input type="text" name="id" class="form-control search_bar" value="{{ $id }}"></th>
                                       <th><input type="text" name="first_name" class="form-control search_bar" value="{{ $first_name }}"></th>
                                        <th><input type="text" name="last_name" class="form-control search_bar" value="{{ $last_name }}"></th>
                                       <th><input type="text" name="email" class="form-control search_bar" value="{{ $email }}"></th>
                                       <th>                                           
                                          <select class="form-control search_bar_dropdown" name="type_id" id="type">
                                             <option value=""></option>
                                             <?php
                                             $types = User::getType();                                            
                                             foreach ($types as $key => $type) { ?>
                                                <option value="{{ $key }}" {{ $typeid == $key ? 'selected' : '' }}>{{ $type }}</option>
                                            <?php } ?>
                                        </select>
                                    </th>
                                     <th><input type="text" name="created_at" class="form-control search_bar" value="{{ $create }}"></th>
                                    <th></th>
                                </tr>
                            </thead>
                            </form> 
                            <tbody>
                             @if(!$users->isEmpty())
                             @foreach ($users as $user)
                             <tr>
                               <td>{{ $user->id }}</td>
                               <td>{{ $user->first_name }}</td>
                               <td>{{ $user->last_name }}</td>
                               <td>{{ $user->email }}</td>                            
                               <td>{{ User::getType($user->type_id) }}</td>
                               <td>{{ $user->created_at}}</td>
                               <td>
                                  <a href="{{url('/admin/user/'.$user->id)}}" class="btn btn-success"><i class="fa fa-eye"></i></a> &nbsp;
                                  <a href="{{url('/admin/user/edit/'.$user->id)}}" class="btn btn-primary"><i class="fa fa-edit"></i></a> &nbsp;
                                  <form method="post" action="{{url('admin/user/delete')}}">
    									@csrf                       				
                        				<input type="hidden" name="id" value ="{{ $user->id}}">
                        				<button type="submit" class="btn btn-danger" id="deleted" onclick="return confirm('Are you sure? You want to delete it.')"><i class="fa fa-trash"></i></button>
                    			  </form>
                        			@if($user->type_id==User::TYPE_BLOCK)
                                        <a onclick="return confirm('Are you sure? You want to Un-Block it.')" href="{{url('/admin/user/type/'.$user->id)}}" class="btn btn-primary btn-sm">Un-Block</a>                                      
                                    @else
                                        <a onclick="return confirm('Are you sure? You want to Block it.')" href="{{url('/admin/user/type/'.$user->id)}}" class="btn btn-info btn-sm">Block</a>
                                    @endif  
                              </td>
                          </tr>
                          @endforeach                        
                          @else
                          <td colspan="7" class="text-center"><h4>No users registered</h4	></td>
                          @endif
                      </tbody>
                  </table>
                <div class="pagination-box">
                  {{ $users->appends(request()->input())->links()}}
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
