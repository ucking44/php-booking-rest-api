<?php

//// HEADER
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Origin: Access-Control-Allow-Origin, Access-Control-Allow-Method, Content-Type, Authorization, X-Requested-With');

/// INITIALIZING OUR API
include_once('../../core/initialise.php');

/// INSTANTIATE CUSTOMER
$customer = new Customer($db);

$customer->id = isset($_GET['id']) ? $_GET['id'] : die();

/// GET RAW CUSTOMER DATA
$data = json_decode(file_get_contents("php://input"));

$customer->user_id          = $data->user_id;
$customer->customer_name    = $data->customer_name;
$customer->customer_contact = $data->customer_contact;
$customer->customer_email   = $data->customer_email;
$customer->username         = $data->username;
$customer->password         = $data->password;
$customer->account_status   = $data->account_status;

////  VALIDATE DATE BEFOR SUBMITTING
if (!$customer->user_id)
{
    echo json_encode([
        "message" => "User ID Can Not Be Empty"
    ]);
}
elseif (!$customer->customer_name)
{
    echo json_encode([
        "message" => "Customer Name Can Not Be Empty"
    ]);
}
elseif (!$customer->customer_contact)
{
    echo json_encode([
        "message" => "Customer Contact Can Not Be Empty"
    ]);
}
elseif (!$customer->customer_email)
{
    echo json_encode([
        "message" => "Customer Email Not Be Empty"
    ]);
}
elseif ($customer->username === "" || $customer->username === null)
{
    echo json_encode([
        "message" => "Username Can Not Be Empty"
    ]);
}
elseif (!$customer->password)
{
    echo json_encode([
        "message" => "Password Can Not Be Empty"
    ]);
}

////// UPDATE CUSTOMER
else
{
    $customer->update();

    echo json_encode([
        'status'  => true,
        'message' => 'Customer Was Updated Successfully!',
        'data'    => $customer
    ]);
}

