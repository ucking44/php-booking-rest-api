<?php

//// HEADER
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: DELETE');
header('Access-Control-Allow-Origin: Access-Control-Allow-Origin, Access-Control-Allow-Method, Content-Type, Authorization, X-Requested-With');

/// INITIALIZING OUR API
include_once('../../core/initialise.php');

/// INSTANTIATE DRIVER
$driver = new Driver($db);

///// GET RAW DRIVER DATA
$driver->id = isset($_GET['id']) ? $_GET['id'] : die();

/// DELETE DRIVER
$driver->delete();

echo json_encode([
    'status'  => true,
    'message' => 'Driver Was Deleted Successfully!'
]);

