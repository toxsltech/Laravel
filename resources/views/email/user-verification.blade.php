<?php
use App\Models\User;
use Illuminate\Support\Facades\URL;
$Link = $data['user']->getVerified();
?>
@include('email.layouts.header')


<tr>
	<td colspan="2" style="padding: 30px 0;">
		<p
			style="color: #1d2227; line-height: 28px; font-size: 25px; margin: 12px 10px 16px 10px; font-weight: 400;">Welcome
			to {{env('APP_COMPANY_NAME')}}</p>
		<p style="margin: 0 10px 10px 10px; padding: 0; font-size: 14px;">
			Thanks for signing up. To send your first
			{{env('APP_COMPANY_NAME')}}, please verify<br> 
		</p>
	
		 <p>Success:- Thanks For Register Here</p><br>
		<p>Thank You</p><br>
	</td>
</tr>

@include('email.layouts.footer')