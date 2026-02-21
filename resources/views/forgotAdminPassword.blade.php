<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Airpeace Forgot Password mail</title>
</head>
<body>
    <img
        src="{{ asset('images/airpeace-logo.png') }}"
        style="width:100%; max-height:300px; display:block; margin:0 auto 10px auto;"
    />
    <div> Hello {{ $adminName}} ✈</div>
    <div> Your otp is {{ $otp }}</div>
    <div> Please note this otp expires after 10 minutes</div>
    <div> Safe travel,<br>
    <strong>Airpeace Team</strong></div>
</body>
</html>