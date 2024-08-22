<?php

//// HEADER
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

/// INITIALIZING OUR API
include_once('../../core/initialise.php');

/// INSTANTIATE PAYMENT
$payment = new Payment($db);

///BLOG PAYMENT QUERY
$result = $payment->read();
///GET THE ROW COUNT
$num = $result->rowCount();

if($num > 0)
{
    $payment_arr = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC))
    {
        extract($row);

        $payment_prop = [
            'id'           => $id,
            'user_id'      => $user_id,
            'booking_id'   => $booking_id,
            'amount_paid'  => $amount_paid,
            'payment_date' => $payment_date
        ];
        
        array_push($payment_arr, $payment_prop);
    }
    ////CONVERT TO JSON AND OUTPUT
    echo json_encode([
        'status'  => true,
        'data'    => $payment_arr
    ]);
}
else 
{
    echo json_encode([
        'status'  => true,
        'message' => 'No Payment Record Was Found'
    ]);
}
