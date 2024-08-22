<?php

//// HEADER
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

/// INITIALIZING OUR API
include_once('../../core/initialise.php');

/// INSTANTIATE BUS
$bus = new Bus($db);

///BLOG SINGLE BUS QUERY
//$data = json_decode(file_get_contents("php://input"));
$bus->id = isset($_GET['id']) ? $_GET['id'] : die();
$bus->single();

echo json_encode([
    'status'  => true,
    'data'    => $bus
]);

