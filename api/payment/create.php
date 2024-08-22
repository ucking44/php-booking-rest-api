<?php

//// HEADER
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Origin: Access-Control-Allow-Origin, Access-Control-Allow-Method, Content-Type, Authorization, X-Requested-With');

/// INITIALIZING OUR API
include_once('../../core/initialise.php');

/// INSTANTIATE PAYMENT
$payment = new Payment($db);

/// GET RAW PAYMENT DATA
$data = json_decode(file_get_contents("php://input"));

$payment->user_id       = $data->user_id;
$payment->booking_id    = $data->booking_id;
$payment->amount_paid   = $data->amount_paid;
$payment->payment_date  = $data->payment_date;

////  VALIDATE DATA BEFORE SUBMITTING
if (!$payment->user_id)
{
    echo json_encode([
        "status"  => false,
        "message" => "User ID Can Not Be Empty"
    ]);
}
elseif (!$payment->booking_id)
{
    echo json_encode([
        "status"  => false,
        "message" => "Booking ID Can Not Be Empty"
    ]);
}
elseif (!$payment->amount_paid)
{
    echo json_encode([
        "status"  => false,
        "message" => "Amount Paid Can Not Be Empty"
    ]);
}
elseif (!$payment->payment_date)
{
    echo json_encode([
        "status"  => false,
        "message" => "Payment Date Can Not Be Empty"
    ]);
}

////// CREATE PAYMENT
else
{
    $payment->create();

    echo json_encode([
        'status'  => true,
        'message' => 'Payment Was Created Successfully!',
        'data'    => $payment
    ]);
}

