<?php

//// HEADER
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

/// INITIALIZING OUR API
include_once('../../core/initialise.php');

/// INSTANTIATE USER

$user = new User($db);

///BLOG USER QUERY
$result = $user->read();
///GET THE ROW COUNT
$num = $result->rowCount();

if($num > 0)
{
    $user_arr = [];

    while($row = $result->fetch(PDO::FETCH_ASSOC))
    {
        extract($row);
        $user_item = [
            'id'               => $id,
            'full_name'        => $full_name,
            'contact_no'       => $contact_no,
            'username'         => $username,
            'userpassword'     => $userpassword,
            'email_address'    => $email_address,
            'account_category' => $account_category,
            'account_status'   => $account_status
        ];
        array_push($user_arr, $user_item);
    }
    ////CONVERT TO JSON AND OUTPUT
    echo json_encode([
        'status'  => true,
        'data'    => $user_arr
    ]);
}
else 
{
    echo json_encode([
        'status'  => true,
        'message' => 'No User Record Was Found!'
    ]);
}
