<!DOCTYPE html>
<html lang="en">
<head>
	<style>
		body {
			font-family: "Lato", sans-serif;
		}
		p {
			line-height: 25px;
			margin: 0;
		}
		.border-radius {
			border-radius: 4px;
		}
		.table_head {
			border-bottom-left-radius: 0 !important;
			border-bottom-right-radius: 0 !important;
			border-radius: 4px;
			padding: 5px 13px 3px;
		}
	</style>
</head>
<body>
	<table border="0" width="100%" cellpadding="0" cellspacing="0">
		<tr>
			<td align="center" valign="top">
				<table class="border-radius" width="630px" cellpadding="15" cellspacing="0" style="border: 1px solid #eee;">
					<thead>
						<tr>
							<th align="left" bgcolor="#3FE0D0" class="table_head">

								<h3 style="font-size: 16px; font-weight: 400; color: #fff;">{{ config('app.name') }}</h3>
							</th>
						</tr>
					</thead>
					<tbody>
