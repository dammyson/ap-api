<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Airpeace admin temporary password</title>
</head>
<body>
    {{-- <div>
        Hello {{ $toName }}, {{ $message }}
    </div> --}}

    <div> Hello <strong>{{ $toName }}</strong> Welcome to the airpeace admin team. below is the temporary password to your account . Pls do well to change this password once you log in</div> 

    <div> email : {{ $toEmail }}</div>
    <div> Password : {{ $temporaryPassword }}</div>

    <div>Please do well to change this password once you log in </div>
</body>
</html>