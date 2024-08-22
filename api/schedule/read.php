<?php

//// HEADER
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

/// INITIALIZING OUR API
include_once('../../core/initialise.php');

/// INSTANTIATE SCHEDULE

$schedule = new Schedule($db);

///BLOG SCHEDULE QUERY
$result = $schedule->read();
///GET THE ROW COUNT
$num = $result->rowCount();

if($num > 0)
{
    $schedule_arr = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC))
    {
        extract($row);

        $schedule_prop = [
            'id'                     => $id,
            'user_id'                => $user_id,
            'bus_id'                 => $bus_id,
            'driver_id'              => $driver_id,
            'starting_point'         => $starting_point,
            'destination'            => $destination,
            'schedule_date'          => $schedule_date,
            'departure_time'         => $departure_time,
            'estimated_arrival_time' => $estimated_arrival_time,
            'fare_amount'            => $fare_amount,
            'remarks'                => $remarks,
        ];
        
        array_push($schedule_arr, $schedule_prop);
    }
    ////CONVERT TO JSON AND OUTPUT
    echo json_encode([
        'status'  => true,
        'data'    => $schedule_arr
    ]);
}
else 
{
    echo json_encode([
        'status'  => true,
        'message' => 'No Schedule Record Was Found!'
    ]);
}
