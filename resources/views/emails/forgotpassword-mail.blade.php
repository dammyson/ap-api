<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body style="font-family: Arial, sans-serif;">
    <img
        src="{{ asset('images/airpeace-logo.png') }}"
        style="width:50%; max-height:400px; display:block; margin:0 auto 10px auto;"
    />

    <h2 style="font-size:24px; font-weight:bold; text-align:center"> Forgot Password</h2>
    <div>Hello   <span style="font-size:16px; font-weight:bold">{{$details['first_name']}}</span></div>
    <div>Your otp  is :  <span style="font-size:16px; font-weight:bold">{{$details['otp'] }}</span></p>
    <div>If this wasn’t you, please contact the customer support immediately to keep your account secure.</div>
    <div style="font-size:18px; font-weight:bold">Airpeace Team</div>
    

</body>
</html>
