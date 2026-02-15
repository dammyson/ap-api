<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 6px; },
        th { background: #f2f2f2; }
        h2 { margin-bottom: 10px; }
    </style>
</head>
<body>

<img
    src="{{ public_path('images/airpeace-logo.png') }}" 
    style="width:100%; max-height:300px; display:block; margin:0 auto 10px auto;"
/>
<h2 style="margin-top:25px; margin-bottom:2px; color:#f54542; text-align:center">Airpeace Electronic Ticket Passenger Itinerary Receipt</h2>

<h3 style="margin-top:20px margin-bottom:2px; color:#0A3D62; text-align:center">Booking Information</h3>
<div style="background-color:#4272f5; color:#FFFFFF; padding:5px ">
    <div><strong>Booking Id :</strong> <span>{{$bookingId}}</span></div>
    <div><strong>Booking Reference :</strong> <span>{{$bookingReference}}</span></div>
</div>
{{-- FLIGHT SEGMENTS --}}
@foreach($bookOriginDestinationOptionList as $index => $segment)

@php
$flight = $segment['bookFlightSegmentList']['flightSegment'];
$fareInfo = $segment['bookFlightSegmentList']['fareInfo'];

 if (!function_exists('getFlightHours')) {
    function getFlightHours($flightDuration) {
        $hours = 0;
        $minutes = 0;

        if (preg_match('/PT(\d+H)?(\d+M)?/', $flightDuration, $matches)) {
            if (!empty($matches[1])) {
                $hours = (int) rtrim($matches[1], 'H');
            }
            if (!empty($matches[2])) {
                $minutes = (int) rtrim($matches[2], 'M');
            }
        }

        return $hours + ($minutes / 60);
    }
}
@endphp

<h3 style="margin-top:25px; margin-bottom:2px; color:#0A3D62; text-align:center"> Flight {{ $index + 1 }}</h3>

<table>
    <tr>
        <th>From</th>
        <th>To</th>
        <th>Flight Number</th>
        <th>Departure</th>
        <th>Arrival</th>
    </tr>
    <tr>
        <td style="text-align: center">{{ $flight['departureAirport']['cityInfo']['city']['locationName'] }}</td>
        <td style="text-align: center">{{ $flight['arrivalAirport']['cityInfo']['city']['locationName'] }}</td>
        <td style="text-align: center" >{{ $flight['flightNumber'] ?? '-' }}</td>
        <td style="text-align: center">{{ $flight['departureDateTime'] }}</td>
        <td style="text-align: center">{{ $flight['arrivalDateTime'] }}</td>
    </tr>
</table>

<h3 style="margin-top:25px; margin-bottom:2px; color:#0A3D62; text-align:center" >Flight {{ $index + 1 }} fare Info Details</h3>
<table> 
    <tr> 
        <th>fareGroupName</th> 
        <th>fareReferenceCode</th> 
        <!-- <th>fareReferenceID</th>  -->
        <th>fareReferenceName</th> 
        <th>sector</th> 
        <th>distance</th> 
        <th>journeyDuration(hours)</th> 
    </tr> 
    <tr> 
        <td style="text-align: center">{{$fareInfo['fareGroupName']}}</td> 
        <td style="text-align: center">{{$fareInfo['fareReferenceCode']}}</td> 
        <td style="text-align: center">{{$fareInfo['fareReferenceName']}}</td> 
        <td style="text-align: center">{{$flight['sector']}}</td>
        <td style="text-align: center">{{$flight['distance']}}</td> 
        <td style="text-align: center">{{getFlightHours($flight['journeyDuration'])}}</td>
    </tr> 
</table>
@endforeach




@foreach($ticketItemList as $ticketItem)

@php
$pricing = $ticketItem['pricingOverview'];
$airTraveler = $ticketItem['airTraveler'];
$contactPerson = $airTraveler['contactPerson'];
$couponInfoList = $ticketItem['couponInfoList'] ?? [];
@endphp

<h3 style="margin-top:25px; margin-bottom:2px; color:#0A3D62; text-align:center">Passenger Info</h3>
<div style="background-color:#4272f5; color:#FFFFFF; padding:5px">
    <div> <strong>Name</strong>  : {{$airTraveler['personName']['givenName']}} {{$airTraveler['personName']['surname']}} </div>
    <div> <strong>Gender</strong> : {{$airTraveler['gender']}}</div>
    <div> <strong>Nationality </strong> : {{$airTraveler['nationality']['locationCode']}}</div>
    <div> <strong>Passenger Type </strong>: {{$airTraveler['passengerTypeCode']}}</div>
    {{-- @foreach($couponInfoList as $index => $couponInfo) 
        <div> <strong>Departure Airport ({{$index + 1}})</strong> : {{$couponInfo['couponFlightSegment']['flightSegment']['departureAirport']['locationName']}}</div>
        <div> <strong> Arrival Airport  ({{$index + 1}})</strong> : {{$couponInfo['couponFlightSegment']['flightSegment']['arrivalAirport']['locationName']}}</div>
    @endforeach    --}}
</div>



{{-- PRICE OVERVIEW --}}
<h3 style="margin-top:10px; margin-bottom:2px; color:#0A3D62; text-align:center">Passenger Price Overview</h3>

<table>    
    <tr>
        <th>Total Amount</th>
        <td>
            {{ $pricing['totalAmount']['currency']['code'] }}
            {{ $pricing['totalAmount']['value'] }}
        </td>
    </tr>

    <tr>
        <th>Base Fare</th>
        <td>
            {{ $pricing['totalBaseFare']['currency']['code'] }}
            {{ $pricing['totalBaseFare']['value'] }}
        </td>
    </tr>

    <tr>
        <th>Total Tax</th>
        <td>
            {{ $pricing['totalTax']['currency']['code'] ?? '' }}
            {{ $pricing['totalTax']['value'] ?? '' }}
        </td>
    </tr>
    <tr>
        <th>Total Transaction Fee</th>
        <td>
            {{ $pricing['totalTransactionFee']['currency']['code'] ?? '' }}
            {{ $pricing['totalTransactionFee']['value'] ?? '' }}
        </td>
    </tr>
    <tr>
        <th>Ticket Number</th>
        <td>
            {{ $ticketItem['ticketDocumentNbr'] ?? '' }}
        </td>
    </tr>
    <tr>
        <th>Status</th>
        <td>
            {{ $ticketItem['status'] ?? '' }}
        </td>
    </tr>
    <tr>
        <th>Refundable</th>
        <td>
            {{ $ticketItem['refundable'] ?? '' }}
        </td>
    </tr>
    <tr>
        <th>Ticket Type</th>
        <td>
            {{ $ticketItem['type'] ?? '' }}
        </td>
    </tr>
    <tr>
        <th>Voidable</th>
        <td>
            {{ $ticketItem['voidable'] ?? '' }}
        </td>
    </tr>
</table>

@endforeach

</body>
</html>
