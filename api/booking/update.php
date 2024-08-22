<?php

//// HEADER
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Origin: Access-Control-Allow-Origin, Access-Control-Allow-Method, Content-Type, Authorization, X-Requested-With');

/// INITIALIZING OUR API
include_once('../../core/initialise.php');

/// INSTANTIATE BOOKING
$booking = new Booking($db);

$booking->id = isset($_GET['id']) ? $_GET['id'] : die();

/// GET RAW BOOKING DATA
$data = json_decode(file_get_contents("php://input"));

$booking->user_id          = $data->user_id;
$booking->schedule_id      = $data->schedule_id;
$booking->customer_id      = $data->customer_id;
$booking->number_of_seats  = $data->number_of_seats;
$booking->fare_amount      = $data->fare_amount;
$booking->total_amount     = $data->total_amount;
$booking->date_of_booking  = $data->date_of_booking;
$booking->booking_status   = $data->booking_status;

////  VALIDATE DATE BEFOR SUBMITTING
if (!$booking->user_id)
{
    echo json_encode([
        "message" => "User ID Can Not Be Empty"
    ]);
}
elseif (!$booking->schedule_id)
{
    echo json_encode([
        "message" => "Schedule ID Can Not Be Empty"
    ]);
}
elseif (!$booking->customer_id)
{
    echo json_encode([
        "message" => "Customer ID Can Not Be Empty"
    ]);
}
elseif (!$booking->number_of_seats)
{
    echo json_encode([
        "message" => "Number Of Seat Not Be Empty"
    ]);
}
elseif ($booking->fare_amount === "" || $booking->fare_amount === null)
{
    echo json_encode([
        "message" => "Fare Amount Can Not Be Empty"
    ]);
}
elseif (!$booking->total_amount)
{
    echo json_encode([
        "message" => "Total Amount Can Not Be Empty"
    ]);
}

////// UPDATE BOOKING
else
{
    $booking->update();

    echo json_encode([
        'status'  => true,
        'message' => 'Booking Was Updated Successfully!',
        'data'    => $booking
    ]);
}

