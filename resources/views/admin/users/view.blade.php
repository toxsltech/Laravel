<?php
use App\Models\User;
use Illuminate\Support\Facades\Auth;
?>

@extends('admin.layouts.main')
@section('title', 'User Details - Admin | View')

 @section('content')

<div class="page-header">
	<div class="row pt-3 pb-3">
		<div class="col-md-8">
			<div class="page-title ">
				<h3>{{ ucfirst($user->first_name) }} {{ ucfirst($user->last_name) }}</h3>
				<span class="text-center label label-success">{{ User::getType($user->type_id) }}</span>
			</div>
		</div>
		<div class="col-md-4 d-flex justify-content-end align-items-center">
            <div class="row">
              <div class="col-md-12 btnbox">
                 <a href="{{url('admin/users')}}" class="btn btn-warning" title="Back"><i class="fa fa-arrow-left"></i></a>
                 <a href="{{url('admin/changePassword/'.$user->id)}}" class="btn btn-warning" title="ChangePassword"><i class="fa fa-lock"></i></a>
                 <a href="{{url('admin/user/edit/'.$user->id)}}" class="btn btn-warning" title="Update"><i class="fa fa-edit"></i> </a>
                <form method="post" action="{{url('admin/user/delete')}}">
					@csrf                       				
    				<input type="hidden" class="trash" name="id" value ="{{ $user->id}}">

    				<input type="hidden" name="id" value ="{{ $user->id}}">
    				 @if($user->id != Auth::id())

    				<button type="submit" class="btn btn-danger" id="view-delete" onclick="return confirm('Are you sure? You want to delete it.')"><i class="fa fa-trash"></i></button>
			         @endif
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
    					<div class="col-lg-2 text-center position-relative">
    					 <div class="prp-user">
    					    @if(str_replace(url('/') . '/public/uploads/',"",$user->profile_file)) 
                         		<img src="{!!asset($user->profile_file)!!}" class="profile_file">
                         	@else
                         		<img src="{!!asset('public/frontend/imgs/banners/avatar.png')!!}" class="css-class profile_file" alt="alt text">
                         	@endif
    					 </div>    						
                         <label for="file-input" class="editlbl">
                           <i class="fa fa-edit edit-icon-img" id="profile-icon"></i>
                       </label>
                       <input id="file-input" name="profile_file" type="file" hidden="hidden">
                       <input type="hidden" id="current_user" value="{{ $user->id }}">
                   </div>
                   <div class="col-lg-10">
                    <div class="table-responsive">
                      <table class="table table-striped table-bordered">
                         <tbody>
                            <tr>
                               <th scope="row">Full Name:</th>
                               <td>{{$user->first_name}} {{$user->last_name}} </td>
                           </tr>
                           <tr>
                               <th scope="row">Email:</th>
                               <td>{{$user->email}}</td>
                           </tr> 
                           @if($user->date_of_birth)                            
                           <tr>
                               <th scope="row">Date of Birth:</th>
                               <td>{{$user->date_of_birth}}</td>
                           </tr> 
                           @endif 
                           @if($user->contact_no)                            
                           <tr>
                               <th scope="row">Conatct No:</th>
                               <td>{{$user->contact_no}}</td>
                           </tr> 
                           @endif
                           @if($user->address) 
                           <tr>
                               <th scope="row">Address:</th>
                               <td>{{$user->address}}</td>
                           </tr>   
                           @endif    
                           @if($user->latitude )                            
                           <tr>
                               <th scope="row">Latitude:</th>
                               <td>{{$user->latitude}}</td>
                           </tr> 
                           @endif
                           @if($user->longitude )                            
                           <tr>
                               <th scope="row">Longitude:</th>
                               <td>{{$user->longitude }}</td>
                           </tr> 
                           @endif
                           @if($user->about_me)                            
                           <tr>
                               <th scope="row">About Me:</th>
                               <td>{!! $user->about_me !!}</td>
                           </tr> 
                           @endif   
                           <tr>
                               <th scope="row">Created On:</th>
                               <td>{{$user->created_at}}</td>
                           </tr>
                       </tbody>
                   </table>
               </div>
           </div>
       </div>
   </div>
</div>
</div>
<!-- .animated -->
</div>
</div>

@endsection
@section('after_footer')

<script>
    jQuery(function($){
    	$('#file-input').change(function () {
            if ($(this).val() != '') {
                upload(this);
            }
        });

    	function upload(img) {
            var form_data = new FormData();
            form_data.append('file', img.files[0]);
            form_data.append('_token', '{{csrf_token()}}');
            $('#loading').css('display', 'block');
            $.ajax({
                url: "{{url('admin/user/update-file/')}}" + "/" + $('#current_user').val(),
                data: form_data,
                type: 'POST',
                contentType: false,
                processData: false,
                success: function (data) {
                    var arr = data;
                    $('.profile_file').attr('src', arr.file);
                },
                error: function (xhr, status, error) {
                    swal(xhr.responseText);
                }
            });
        }
    })
</script>

@endsection
