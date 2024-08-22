<?php

//// HEADER
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

/// INITIALIZING OUR API
include_once('../../core/initialise.php');

/// INSTANTIATE USER

$user = new User($db);

///BLOG SINGLE USER QUERY
$user->id = isset($_GET['id']) ? $_GET['id'] : die();
$user->single();

$user_arr = [
    'id'               => $user->id,
    'full_name'        => $user->full_name,
    'contact_no'       => $user->contact_no,
    'username'         => $user->username,
    'userpassword'     => $user->userpassword,
    'email_address'    => $user->email_address,
    'account_category' => $user->account_category,
    'account_status'   => $user->account_status
];

// MAKE A JSON
echo json_encode([
    'status'  => true,
    'data'    => $user_arr
]);

