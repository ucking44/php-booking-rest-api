<?php

//// HEADER
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

/// INITIALIZING OUR API
include_once('../../core/initialise.php');

/// INSTANTIATE DRIVER

$driver = new Driver($db);

///BLOG DRIVER QUERY
$result = $driver->read();
///GET THE ROW COUNT
$num = $result->rowCount();

if($num > 0)
{
    $driver_arr = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC))
    {
        extract($row);

        $driver_prop = [
            'id'                => $id,
            'user_id'           => $user_id,
            'driver_name'         => $driver_name,
            'driver_contact'        => $driver_contact
        ];
        
        array_push($driver_arr, $driver_prop);
    }
    ////CONVERT TO JSON AND OUTPUT
    echo json_encode([
        'status'  => true,
        'data'    => $driver_arr
    ]);
}
else 
{
    echo json_encode([
        'status'  => true,
        'message' => 'No Driver Record Was Found'
    ]);
}
