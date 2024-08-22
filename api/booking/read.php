<?php

//// HEADER
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

/// INITIALIZING OUR API
include_once('../../core/initialise.php');

/// INSTANTIATE BOOKING
$booking = new Booking($db);

///BLOG BOOKING QUERY
$result = $booking->read();
///GET THE ROW COUNT
$num = $result->rowCount();

if($num > 0)
{
    $booking_arr = array();
    // $booking_arr['data'] = [];

    while($row = $result->fetch(PDO::FETCH_ASSOC))
    {
        extract($row);

        $booking_prop = [
            'id'              => $id,
            'user_id'         => $user_id,
            'schedule_id'     => $schedule_id,
            'customer_id'     => $customer_id,
            'number_of_seats' => $number_of_seats,
            'fare_amount'     => $fare_amount,
            'total_amount'    => $total_amount,
            'date_of_booking' => $date_of_booking,
            'booking_status'  => $booking_status
        ];
        
        //array_push($booking_arr['data'], $booking_prop);
        array_push($booking_arr, $booking_prop);
    }
    ////CONVERT TO JSON AND OUTPUT
    echo json_encode([
        'status'  => true,
        'data'    => $booking_arr
    ]);
}
else 
{
    echo json_encode([
        'status'  => true,
        'message' => 'No Booking Record Was Found'
    ]);
}

