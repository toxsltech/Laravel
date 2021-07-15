@extends('admin.layouts.main')
@section('title', 'Static Pages - Admin | View') 
@section('content')

<div class="page-header">
	<div class="row pt-3 pb-3">
		<div class="col-md-8">
			<div class="page-title ">
				<h3>{{ ucfirst($pages->title) }}</h3>
				<span class="text-center label label-success">{{ $pages->getState() }}</span>
			</div>
		</div>
		<div class="col-md-4 d-flex justify-content-end align-items-center">
	 		<div class="row">
        		<div class="col-md-12 ">
        			<a href="{{url('admin/page')}}" class="btn btn-warning" title="Back"><i class="fa fa-arrow-left"></i></a>
        			<a href="{{url('admin/page/edit/'.$pages->id)}}" class="btn btn-warning" title="Update"><i class="fa fa-edit"></i> </a>
        			<form method="post" class="trash" action="{{url('admin/page/delete')}}">
    					@csrf                       				
        				<input type="hidden" name="id" value ="{{ $pages->id}}">
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
    					<div class="col-lg-10">
                            <div class="table-responsive">
    						<table class="table">
    							<tbody>
    								<tr>
    									<th scope="row">Title:</th>
    									<td>{{$pages->title}}</td>
    								</tr>
    								<tr>
    									<th scope="row">Type:</th>
    									<td>{{ $pages->getType() }}</td>
    								</tr>
    								<tr>
    									<th scope="row">State:</th>
    									<td>{{ $pages->getState() }}</td>
    								</tr>
    								<tr>
    									<th scope="row">Created By:</th>
    									<td>{{$pages->created_by_id}}</td>
    								</tr>   								
    								<tr>
    									<th scope="row">Description:</th>
    									<td>{!! $pages->description !!}</td>
    								</tr>   					
    								<tr>
    									<th scope="row">Created On:</th>
    									<td>{{$pages->created_at}}</td>
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
