<?php
use Illuminate\Support\Facades\Auth;
$user=Auth::user();
?>
@auth
    <header id="main-header" class="header">
    <div class="container-fluid">
      <nav class="navbar navbar-expand-xl">
        <a class="navbar-brand" href="{{url('discover')}}">
          <img src="{{ asset('public/frontend/imgs/logo/logo.png') }}" alt="aery">
        </a>
        <div class="hamburger hamburger--spring">
          <button class="navbar-toggler hamburger" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="hamburger-box">
              <span class="hamburger-inner"></span>
            </span>
          </button>
        </div>
         <div class="collapse navbar-collapse" id="navbarNav">
     
          <div class="text-center d-xl-none p-3">
            <a class="navbar-brand" href="{{('/discover')}}">
              <img src="{{ asset('public/frontend/imgs/logo/logo.png') }}" alt="aery">
            </a>
          </div>
          <ul class="navbar-nav nav-menus-main">
            <li class="nav-item {{ (Request::path()== 'discover') ? 'active' : '' }}">
              <a class="nav-link" href="{{url('discover')}}">Discover</a>
            </li>
            <li class="nav-item {{ (Request::path()== 'travel-board') ? 'active' : '' }}">
              <a class="nav-link" href="{{url('travel-board')}}">Travel Board</a>
            </li>
            <li class="nav-item {{ (Request::path()== 'create') ? 'active' : '' }}">
              <a class="nav-link" href="{{url('create')}}">Create</a>
            </li>
          </ul>
          <ul class="navbar-nav ml-auto nav-serch-profile">
            <li class="nav-item">
              <form class="header-rearch" action="{{ url('/search') }}" method="get" role="search">
                <div class="form-group mb-0">
                  <input type="text" class="form-control search_bar" name="text" value="{{ @$keyword }}" id="Search" aria-describedby="Search" placeholder="Search">
                  <i class="far fa-search"></i>
                </div>
              </form>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle mr-0 pr-0" href="#0" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 @if(str_replace(url('/') . '/public/uploads/',"",@$user->profile_file)) 
             		<img src="{!!asset(@$user->profile_file)!!}" class="profile_file" alt="aery">
             	@else
             		<img src="{!!asset('public/frontend/imgs/banners/avatar.png')!!}" class="css-class profile_file" alt="aery">
             	@endif
                {{ @$user->first_name}} {{ @$user->last_name}}
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{url('profile')}}">Profile</a>
                <a class="dropdown-item" href="{{url('notification')}}">Notifications</a>
                <a class="dropdown-item" href="{{url('setting')}}">Settings</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{url('logout')}}">Logout</a>
              </div>
            </li>
          </ul>
        </div>       
      </nav>
    </div>
  </header>
  @endauth
  @guest
  <header id="main-header" class="header">
    <div class="container-fluid">
      <nav class="navbar navbar-expand-xl">
        <a class="navbar-brand ml-auto" href="{{url('/')}}">
          <img src="{{ asset('public/frontend/imgs/logo/logo.png') }}" alt="aery">
        </a>
      </nav>
    </div>
  </header>
@endguest


