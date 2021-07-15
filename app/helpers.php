<?php

use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

function getNotification(){
	$getNotificationdata = Notification::where('to_user_id',Auth::id())->where('is_read',Notification::UN_READ)->get();
	return $getNotificationdata;
}