<?php

//// HEADER
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Origin: Access-Control-Allow-Origin, Access-Control-Allow-Method, Content-Type, Authorization, X-Requested-With');

/// INITIALIZING OUR API
include_once('../../core/initialise.php');

/// INSTANTIATE SCHEDULE
$schedule = new Schedule($db);

/// GET RAW SCHEDULE DATA
$data = json_decode(file_get_contents("php://input"));

$schedule->user_id                = $data->user_id;
$schedule->bus_id                 = $data->bus_id;
$schedule->driver_id              = $data->driver_id;
$schedule->starting_point         = $data->starting_point;
$schedule->destination            = $data->destination;
$schedule->schedule_date          = $data->schedule_date;
$schedule->departure_time         = $data->departure_time;
$schedule->estimated_arrival_time = $data->estimated_arrival_time;
$schedule->fare_amount            = $data->fare_amount;
$schedule->remarks                = $data->remarks;

////  VALIDATE DATE BEFOR SUBMITTING
if (!$schedule->user_id)
{
    echo json_encode([
        "message" => "User ID Can Not Be Empty"
    ]);
}
elseif (!$schedule->bus_id)
{
    echo json_encode([
        "message" => "Bus ID Can Not Be Empty"
    ]);
}
elseif (!$schedule->driver_id)
{
    echo json_encode([
        "message" => "Driver ID Can Not Be Empty"
    ]);
}
elseif (!$schedule->starting_point)
{
    echo json_encode([
        "message" => "Starting Point Can Not Be Empty"
    ]);
}
elseif ($schedule->destination === "" || $schedule->destination === null)
{
    echo json_encode([
        "message" => "Destination Can Not Be Empty"
    ]);
}
elseif (!$schedule->fare_amount)
{
    echo json_encode([
        "message" => "Fare Amount Can Not Be Empty"
    ]);
}

////// CREATE SCHEDULE
else
{
    $schedule->create();

    echo json_encode([
        'status'  => true,
        'message' => 'Schedule Was Created Successfully!',
        'data'    => $schedule
    ]);
}

