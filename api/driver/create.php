<?php

//// HEADER
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Origin: Access-Control-Allow-Origin, Access-Control-Allow-Method, Content-Type, Authorization, X-Requested-With');

/// INITIALIZING OUR API
include_once('../../core/initialise.php');

/// INSTANTIATE DRIVER
$driver = new Driver($db);

/// GET RAW DRIVER DATA
$data = json_decode(file_get_contents("php://input"));

$driver->user_id        = $data->user_id;
$driver->driver_name    = $data->driver_name;
$driver->driver_contact = $data->driver_contact;

////  VALIDATE DATE BEFOR SUBMITTING
if (!$driver->user_id)
{
    echo json_encode([
        "message" => "User ID Can Not Be Empty"
    ]);
}
elseif (!$driver->driver_name)
{
    echo json_encode([
        "message" => "Driver Name Can Not Be Empty"
    ]);
}
elseif ($driver->driver_contact === "" || $driver->driver_contact === null)
{
    echo json_encode([
        "message" => "Driver Contact Can Not Be Empty"
    ]);
}

///// CREATE DRIVER
else
{
    $driver->save();

    echo json_encode([
        'status'  => true,
        'message' => 'Driver Was Created Successfully!',
        'data'    => $driver
    ]);
}

