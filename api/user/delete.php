<?php

//// HEADER
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: DELETE');
header('Access-Control-Allow-Origin: Access-Control-Allow-Origin, Access-Control-Allow-Method, Content-Type, Authorization, X-Requested-With');

/// INITIALIZING OUR API
include_once('../../core/initialise.php');

/// INSTANTIATE User
$user = new User($db);

/// GET RAW USER DATA
$user->id = isset($_GET['id']) ? $_GET['id'] : die();

/// DELETE USER
$user->delete();

echo json_encode([
    'status'  => true,
    'message' => 'User Was Deleted Successfully!'
]);

