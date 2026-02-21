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

    <p>Hi {{ $name }} ✈</p>

    <p>Payment for your flight was successful.</p>

    <p>Please find attached your e-ticket for reservation details.</p>

    <p>Safe travel,<br>
    <strong>Airpeace Team</strong></p>

</body>
</html>
