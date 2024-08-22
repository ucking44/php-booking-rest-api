<?php

//// HEADER
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

/// INITIALIZING OUR API
include_once('../../core/initialise.php');

/// INSTANTIATE CUSTOMER
$customer = new Customer($db);

///BLOG CUSTOMER QUERY
$result = $customer->read();
///GET THE ROW COUNT
$num = $result->rowCount();

if($num > 0)
{
    $customer_arr = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC))
    {
        extract($row);

        $customer_prop = [
            'id'                => $id,
            'user_id'           => $user_id,
            'customer_name'     => $customer_name,
            'customer_contact'  => $customer_contact,
            'customer_email'    => $customer_email,
            'username'          => $username,
            'password'          => $password,
            'account_status'    => $account_status
        ];
        
        array_push($customer_arr, $customer_prop);
    }
    ////CONVERT TO JSON AND OUTPUT
    echo json_encode([
        'status'  => true,
        'data'    => $customer_arr
    ]);
}
else 
{
    echo json_encode([
        'status'  => true,
        'message' => 'No Customer Record Was Found'
    ]);
}

