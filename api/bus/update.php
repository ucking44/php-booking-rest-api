<?php

//// HEADER
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Origin: Access-Control-Allow-Origin, Access-Control-Allow-Method, Content-Type, Authorization, X-Requested-With');

/// INITIALIZING OUR API
include_once('../../core/initialise.php');

/// INSTANTIATE BUS
$bus = new Bus($db);

$bus->id = isset($_GET['id']) ? $_GET['id'] : die();

/// GET RAW BUS DATA
$data = json_decode(file_get_contents("php://input"));

$bus->user_id           = $data->user_id;
$bus->bus_number        = $data->bus_number;
$bus->bus_plate_number  = $data->bus_plate_number;
$bus->bus_type          = $data->bus_type;
$bus->capacity          = $data->capacity;

/// VALIDATE BUS DATA
if ($bus->bus_number === "" || $bus->bus_number === null)
{
    echo json_encode([
        "message" => "Bus Number Can Not Be Empty"
    ]);
}
elseif ($bus->bus_plate_number === "" || $bus->bus_plate_number === null)
{
    echo json_encode([
        "message" => "Bus Plate Number Can Not Be Empty"
    ]);
}
elseif ($bus->bus_type === "" || $bus->bus_type === null)
{
    echo json_encode([
        "message" => "Bus Type Can Not Be Empty"
    ]);
}
elseif ($bus->capacity === "" || $bus->capacity === null)
{
    echo json_encode([
        "message" => "Bus Capacity Can Not Be Empty"
    ]);
}
//// UPDATE BUS
else
{
    $bus->update();

    echo json_encode([
        'status'  => true,
        'message' => 'Bus Was Updated Successfully!',
        'data'    => $bus
    ]);
}

