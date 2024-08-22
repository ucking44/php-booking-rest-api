<?php

class Schedule extends Clean
{
    use ScheduleTables;
    private $conn;
    private $table = "schedules";

    public $id;
    public $user_id, $bus_id, $driver_id, $starting_point, $destination, $schedule_date, $departure_time, $estimated_arrival_time, $fare_amount, $remarks;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create()
    {
        try 
        {
            ///// CHECK IF USER ID EXIST
            $this->CheckUserId();
            
            /// CHECK IF BUS ALREADY EXIST
            $this->checkIfBusIdExist();
            
            /// CHECK IF DRIVER ALREADY EXIST
            $this->checkIfDriverIdExist();
                
            /// INSERT SCHEDULE INTO DB
            $stmt = $this->conn->prepare($this->saveSchedule());
            ///// INSTANTIATE STRING CLEAN UP
            $cleanUp = new Clean();

            $stmt->execute([
                'user_id'                => $cleanUp->clean_input($this->user_id),
                'bus_id'                 => $cleanUp->clean_input($this->bus_id),
                'driver_id'              => $cleanUp->clean_input($this->driver_id),
                'starting_point'         => $cleanUp->clean_input($this->starting_point),
                'destination'            => $cleanUp->clean_input($this->destination),
                'schedule_date'          => $cleanUp->clean_input($this->schedule_date),
                'departure_time'         => $cleanUp->clean_input($this->departure_time),
                'estimated_arrival_time' => $cleanUp->clean_input($this->estimated_arrival_time),
                'fare_amount'            => $cleanUp->clean_input($this->fare_amount),
                'remarks'                => $cleanUp->clean_input($this->remarks)
            ]);

            return true;
        }
        catch (\Throwable $th) 
        {
            echo $th;
        }
    }

    public function read()
    {
        try 
        {
            /// PREPARE STATEMENT AND FETCH ALL SCHEDULES FROM DB
            $stmt = $this->conn->prepare($this->getAllSchedules());
            /// EXECUTE QUERY
            $stmt->execute();

            return $stmt;
        } 
        catch (\Throwable $th) 
        {
            throw $th;
        }        
    }

    public function update()
    {
        try 
        {
            ///// CHECK IF SCHEDULE ID EXIST
            $this->checkIfScheduleIdExist();

            ///// CHECK IF USER ID EXIST
            $this->CheckUserId();
            
            /// CHECK IF BUS ALREADY EXIST
            $this->checkIfBusIdExist();
            
            /// CHECK IF DRIVER ALREADY EXIST
            $this->checkIfDriverIdExist();

            /// UPDATE SCHEDULE BY ID
            $stmt = $this->conn->prepare($this->updateSchedule());

            ///// INSTANTIATE STRING CLEAN UP
            $cleanUp = new Clean();

            $stmt->execute([
                'user_id'                => $cleanUp->clean_input($this->user_id),
                'bus_id'                 => $cleanUp->clean_input($this->bus_id),
                'driver_id'              => $cleanUp->clean_input($this->driver_id),
                'starting_point'         => $cleanUp->clean_input($this->starting_point),
                'destination'            => $cleanUp->clean_input($this->destination),
                'schedule_date'          => $cleanUp->clean_input($this->schedule_date),
                'departure_time'         => $cleanUp->clean_input($this->departure_time),
                'estimated_arrival_time' => $cleanUp->clean_input($this->estimated_arrival_time),
                'fare_amount'            => $cleanUp->clean_input($this->fare_amount),
                'remarks'                => $cleanUp->clean_input($this->remarks),
                'id'                     => $this->id
            ]);

            return true;
        } 
        catch (\Throwable $th) 
        {
            echo $th;
        }
    }

    public function single()
    {
        try 
        {
            ///// CHECK IF SCHEDULE ID EXIST
            $this->checkIfScheduleIdExist();
            // PREPARE STATEMENT AND FETCH SINGLE SCHEDULE BY ID
            $stmt = $this->conn->prepare($this->getSingleSchedule());
            ///BINDING PARAM
            $stmt->bindParam(1, $this->id);
            //// EXECUTE THE QUERY
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->user_id                = $row['user_id'];
            $this->bus_id                 = $row['bus_id'];
            $this->driver_id              = $row['driver_id'];
            $this->starting_point         = $row['starting_point'];
            $this->destination            = $row['destination'];
            $this->schedule_date          = $row['schedule_date'];
            $this->departure_time         = $row['departure_time'];
            $this->estimated_arrival_time = $row['estimated_arrival_time'];
            $this->fare_amount            = $row['fare_amount'];
            $this->remarks                = $row['remarks'];
        } 
        catch (\Throwable $th) 
        {
            throw $th;
        }
    }

    public function delete()
    {
        try 
        {
            ///// CHECK IF SCHEDULE ID EXIST
            $this->checkIfScheduleIdExist();

            // PREPARE STATEMENT AND DELETE SCHEDULE FROM DB BY ID
            $stmt = $this->conn->prepare($this->destroySchedule());
            $stmt->execute(['id' => $this->id]);

            return true;
        } 
        catch (\Throwable $th) 
        {
            echo $th;
        }
    }
}

