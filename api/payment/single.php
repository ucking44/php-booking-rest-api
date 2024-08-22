<?php

//// HEADER
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

/// INITIALIZING OUR API
include_once('../../core/initialise.php');

/// INSTANTIATE PAYMENT
$payment = new Payment($db);

///BLOG SINGLE PAYMENT QUERY
$payment->id = isset($_GET['id']) ? $_GET['id'] : die();

$payment->single();

echo json_encode([
    'status'  => true,
    'data'    => $payment
]);

