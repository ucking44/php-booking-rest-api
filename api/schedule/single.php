<?php

//// HEADER
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

/// INITIALIZING OUR API
include_once('../../core/initialise.php');

/// INSTANTIATE SCHEDULE
$schedule = new Schedule($db);

///BLOG SINGLE SCHEDULE QUERY
$schedule->id = isset($_GET['id']) ? $_GET['id'] : die();
$schedule->single();

$schedule_arr = [
    'id'                     => $schedule->id,
    'user_id'                => $schedule->user_id,
    'bus_id'                 => $schedule->bus_id,
    'driver_id'              => $schedule->driver_id,
    'starting_point'         => $schedule->starting_point,
    'destination'            => $schedule->destination,
    'schedule_date'          => $schedule->schedule_date,
    'departure_time'         => $schedule->departure_time,
    'estimated_arrival_time' => $schedule->estimated_arrival_time,
    'fare_amount'            => $schedule->fare_amount,
    'remarks'                => $schedule->remarks
];

// MAKE A JSON
echo json_encode([
    'status'  => true,
    'data'    => $schedule_arr
]);

