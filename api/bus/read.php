<?php

//// HEADER
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

/// INITIALIZING OUR API
include_once('../../core/initialise.php');

/// INSTANTIATE BUS

$bus = new Bus($db);

///BLOG BUS QUERY
$result = $bus->read();
///GET THE ROW COUNT
$num = $result->rowCount();

if($num > 0)
{
    $bus_arr = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC))
    {
        extract($row);

        $bus_prop = [
            'id'                => $id,
            'user_id'           => $user_id,
            'user_name'         => $user_name,
            'bus_number'        => $bus_number,
            'bus_plate_number'  => $bus_plate_number,
            'bus_type'          => $bus_type,
            'capacity'          => $capacity
        ];
        
        array_push($bus_arr, $bus_prop);
    }
    //// CONVERT TO JSON AND OUTPUT
    echo json_encode([
        'status'  => true,
        'data'    => $bus_arr
    ]);
}
else 
{
    echo json_encode([
        'status'  => true,
        'message' => 'No Bus Record Was Found'
    ]);
}
