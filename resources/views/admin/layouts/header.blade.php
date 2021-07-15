<?php
use Illuminate\Support\Facades\Auth;
use App\models\User;
?>
<div id="right-panel" class="right-panel">
	<header id="header" class="header">
		<div class="header-menu">
			<div class="col-sm-7">
				<a id="menuToggle" class="menutoggle pull-left"><i class="fa fa fa-tasks"></i></a>
			</div>
			<div class="col-sm-5">
				<div class="user-area dropdown float-right">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    {{Auth::user()->first_name}} {{Auth::user()->last_name}}&nbsp;&nbsp;<img class="user-avatar rounded-circle" src="{{ Auth::user()->profile_file != '' ? Auth::user()->profile_file : asset('public/frontend/imgs/banners/avatar.png') }}" alt="User Avatar">
					</a>
					<div class="user-menu dropdown-menu bg-light py-3">
						<a class="nav-link px-2 py-2" href="{{url('admin/profile')}}"><i class="fa fa-user text-secondary pr-3"></i>My Profile</a>
						<a class="nav-link px-2 py-2" href="{{ url('logout') }}"><i class="fa fa-power-off text-secondary pr-3"></i>Logout</a>
					</div>
				</div>
			</div>
		</div>
	</header>
	
