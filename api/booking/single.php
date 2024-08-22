<?php

//// HEADER
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

/// INITIALIZING OUR API
include_once('../../core/initialise.php');

/// INSTANTIATE BOOKING
$booking = new Booking($db);

///BLOG SINGLE BOOKING QUERY
// $data = json_decode(file_get_contents("php://input"));
$booking->id = isset($_GET['id']) ? $_GET['id'] : die();

$booking->single();

echo json_encode([
    'status'  => true,
    'data'    => $booking
]);

