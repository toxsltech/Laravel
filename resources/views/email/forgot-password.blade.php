<?php
use App\Models\User;
use Illuminate\Support\Facades\URL;
?>
@include('email.layouts.header')

<tr>
	<td align="left" style="font-family: Lato, sans-serif; padding-top: 30px; padding-bottom: 0; color: #333333;">
		<h3 style="margin: 0; font-weight: 500; font-size: 19px;">
			<p>Hello {{ $data['user']->first_name }} {{ $data['user']->last_name }},</p>
		</h3>
	</td>
</tr>
<tr>
	<td align="left">
		<p>Follow the link below to reset your password</p>
		<p><a href="{{ Url::to('password-reset/'.$data['user']->password_reset_token) }}">Click Here</a></p>
	</td>
</tr>

@include('email.layouts.footer')
