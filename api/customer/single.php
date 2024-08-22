<?php

//// HEADER
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

/// INITIALIZING OUR API
include_once('../../core/initialise.php');

/// INSTANTIATE CUSTOMER
$customer = new Customer($db);

///BLOG SINGLE CUSTOMER QUERY
$customer->id = isset($_GET['id']) ? $_GET['id'] : die();

$customer->single();

echo json_encode([
    'status'  => false,
    'data'    => $customer
]);

