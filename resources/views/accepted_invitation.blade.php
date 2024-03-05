<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Diligent Dollar</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
</head>
<body style="background-color: #f5f5f5;">
	<table style="width:500px; border-radius: 12px; margin: 30px auto; padding: 0 50px; background: #fff; font-family: Arial, Helvetica, sans-serif" border="0" cellpadding="0" cellspacing="0">

		<tr style="text-align: center; margin-top: 30px;">
			<p style="color: #0d0d0d; font-size: 45px; line-height: 84px; margin: 0; text-align: center; font-weight: bold;">Diligent Dollar</p>	
		</tr>

		<tr>
			<td>
                <div class="text-center">
                    <div class="email-icon">
                        <span class="star"></span>
                        <span class="check"></span>
                    </div>
                </div>
				<p style="color: #666670; font-size: 16px; line-height: 22px; margin: 0; padding: 28px 0 2px 0; text-align: center;">

	                <p style="color: #666670; font-size: 26px; line-height: 22px; margin: 0; padding: 38px 0 28px 0; text-align: center; color: #050300;">
	                    {{ $message }}
	                </p>

	                <p style="color: #666670; font-size: 14px; line-height: 22px; margin: 0; padding: 0px 0 15px 0; text-align: center; color: #BFC9CA;">
	                    Please login to your profile
	                </p>
                    <p style="text-align: center;">
                        <a href="{{$application_url}}" style="color: #ffffff; background: #6495ED; font-size: 13px; width: 160px; display: inline-block; border-radius: 4px; text-decoration: none; padding: 10px 0;">
                            Click here to login
                        </a>
                    </p> 
                </p>
			</td>
		</tr>
	</table>
    <div>
    </div>
    <script src="{{asset('/js/jquery-3.3.1.slim.min.js')}}"></script>
    <script src="{{asset('/js/popper.min.js')}}"></script>
    <script src="{{asset('/js/bootstrap.min.js')}}"></script>
</body>
</html>