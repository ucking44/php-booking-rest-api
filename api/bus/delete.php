<?php

//// HEADER
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: DELETE');
header('Access-Control-Allow-Origin: Access-Control-Allow-Origin, Access-Control-Allow-Method, Content-Type, Authorization, X-Requested-With');

/// INITIALIZING OUR API
include_once('../../core/initialise.php');

/// INSTANTIATE BUS

$bus = new Bus($db);

$bus->id = isset($_GET['id']) ? $_GET['id'] : die();

/// DELETE BUS
$bus->delete($bus->id);

echo json_encode([
    'status'  => true,
    'message' => 'Bus Was Deleted Successfully!'
]);

