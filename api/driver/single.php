<?php

//// HEADER
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

/// INITIALIZING OUR API
include_once('../../core/initialise.php');

/// INSTANTIATE DRIVER
$driver = new Driver($db);

///BLOG SINGLE DRIVER QUERY
// $data = json_decode(file_get_contents("php://input"));
$driver->id = isset($_GET['id']) ? $_GET['id'] : die();
$driver->single();

$driver_arr = [
    'id'                    => $driver->id,
    'user_id'               => $driver->user_id,
    'driver_name'           => $driver->driver_name,
    'driver_contact'        => $driver->driver_contact
];

// MAKE A JSON
print_r (json_encode([
    'status'  => false,
    'data'    => $driver_arr
]));

