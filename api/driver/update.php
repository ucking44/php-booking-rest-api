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

$driver->id = isset($_GET['id']) ? $_GET['id'] : die();

/// GET RAW DRIVER DATA
//$data = json_decode(file_get_contents("php://input"));
$data = json_decode(file_get_contents("php://input"));

$driver->user_id            = $data->user_id;
$driver->driver_name        = $data->driver_name;
$driver->driver_contact     = $data->driver_contact;

/// VALIDATE DRIVER DATA
if ($driver->user_id === "" || $driver->user_id === null)
{
    echo json_encode([
        "message" => "User ID Can Not Be Empty"
    ]);
}
elseif ($driver->driver_name === "" || $driver->driver_name === null)
{
    echo json_encode([
        "message" => "Driver Name Number Can Not Be Empty"
    ]);
}
elseif ($driver->driver_contact === "" || $driver->driver_contact === null)
{
    echo json_encode([
        "message" => "Driver Contact Can Not Be Empty"
    ]);
}
/// UPDATE DRIVER
else
{
    $driver->update();

    echo json_encode([
        'status'  => true,
        'message' => 'Driver Was Updated Successfully!',
        'data'    => $driver
    ]);
}

