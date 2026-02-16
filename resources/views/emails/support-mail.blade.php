<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body style="font-family: Arial, sans-serif;">

    <h2>Customer complaint</p>

    <h3>Issue Details</h3>
    <div>
        <div>
            <span style="font-size:16px; font-weight:bold">email : </span> <span style="color:#FFFFFF">{{$details['email'] ?? "Not Provided"}}</span>
        </div>
        <div>
            <span style="font-size:16px; font-weight:bold">booking ref : </span>{{$details['booking_reference'] ?? "Not Provided"}}
        </div>
        <div>
            <span style="font-size:16px; font-weight:bold">description :</span> {{$details['date_of_occurence'] ?? "Not Provided"}}
        </div>
        <div>
           <span style="font-size:16px; font-weight:bold"> category : </span> {{$details['category'] ?? "Not Provided"}}
        </div>
    </div>

</body>
</html>
