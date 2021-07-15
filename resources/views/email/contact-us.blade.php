<?php
use App\Models\User;
use Illuminate\Support\Facades\URL;

?>
@include('email.layouts.header')



<tr>
	<td align="left" style="font-family: Lato, sans-serif; padding-top: 30px; padding-bottom: 0; color: #1d2227;">
		<h3 style="margin: 0; font-weight: 500; font-size: 19px;">Hello,</h3>
	</td>
</tr>
<tr>
	<td align="left">
		<p>Success:- Thanks For contact us</p><br>
		<p>Thank You</p><br>
	</td>	
</tr>




@include('email.layouts.footer')
