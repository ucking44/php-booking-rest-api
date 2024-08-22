<?php

//// HEADER
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Origin: Access-Control-Allow-Origin, Access-Control-Allow-Method, Content-Type, Authorization, X-Requested-With');

/// INITIALIZING OUR API
include_once('../../core/initialise.php');

/// INSTANTIATE USER
$user = new User($db);

/// GET RAW USER DATA
$data = json_decode(file_get_contents("php://input"));

$user->full_name        = $data->full_name;
$user->email_address    = $data->email_address;
$user->contact_no       = $data->contact_no;
$user->username         = $data->username;
$user->userpassword     = $data->userpassword;
$user->account_status   = $data->account_status;
$user->account_category = $data->account_category;

/// VALIDATE DATA BEFORE SUBMITTING
if ($user->full_name === "" || $user->full_name === null)
{
    echo json_encode([
        "message" => "Name Can Not Be Empty"
    ]);
}
elseif ($user->email_address === "" || $user->email_address === null)
{
    echo json_encode([
        "message" => "Email Can Not Be Empty"
    ]);
}
elseif ($user->contact_no === "" || $user->contact_no === null)
{
    echo json_encode([
        "message" => "Phone Can Not Be Empty"
    ]);
}
// CREATE USER
else
{
    $user->save();

    echo json_encode([
        'status'  => true,
        'message' => 'User Was Created Successfully!',
        'data'    => $user
    ]);
}

