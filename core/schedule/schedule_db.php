<?php

trait ScheduleTables
{
    public function saveSchedule()
    {
        /// INSERT SCHEDULE INTO DB
        $sql = 'INSERT INTO schedules (user_id, bus_id, driver_id, starting_point, destination, schedule_date, departure_time, estimated_arrival_time, fare_amount, remarks) VALUES (:user_id, :bus_id, :driver_id, :starting_point, :destination, :schedule_date, :departure_time, :estimated_arrival_time, :fare_amount, :remarks)';
        return $sql;
    }

    public function getAllSchedules()
    {
        ///  FETCH ALL SCHEDULES FROM DB
        $query = 'SELECT * FROM schedules';
        return $query;
    }

    public function updateSchedule()
    {
        /// UPDATE SCHEDULE BY ID
        $sql = 'UPDATE schedules SET user_id = :user_id, bus_id = :bus_id, driver_id = :driver_id, starting_point = :starting_point, destination = :destination, schedule_date = :schedule_date, departure_time = :departure_time, estimated_arrival_time = :estimated_arrival_time, fare_amount = :fare_amount, remarks = :remarks WHERE id = :id';
        return $sql;
    }

    public function getSingleSchedule()
    {
        // FETCH SINGLE SCHEDULE BY ID
        $query = 'SELECT * FROM schedules WHERE id = ? LIMIT 1';
        return $query;
    }

    public function destroySchedule()
    {
        // DELETE SCHEDULE FROM DB BY ID
        $sql = 'DELETE FROM schedules WHERE id = :id';
        return $sql;
    }

    public function CheckUserId()
    {
        ///// CHECK IF USER ID EXIST
        $checkUser = "SELECT * FROM users WHERE id = ?";
        $test = $this->conn->prepare($checkUser);
        $test->execute([$this->user_id]);
        $result = $test->rowCount();

        if (!$result > 0)
        {
            echo json_encode([
                'status' => false,
                'message' => 'User With The ID Of ' . $this->user_id . ' Does Not Exist!... '
            ]); die();
        }
    }

    public function checkIfBusIdExist()
    {
        /// CHECK IF BUS ALREADY EXIST
        $checkBus = "SELECT * FROM buses WHERE id = ?";
        $testBus = $this->conn->prepare($checkBus);
        $testBus->execute([$this->bus_id]);
        $countBus = $testBus->rowCount();

        if(!$countBus > 0)
        {
            echo json_encode([
                'status' => false,
                'message' => 'Bus With The ID Of ' . $this->bus_id . ' Does Not Exist!... '
            ]); die();
        }
    }

    public function checkIfDriverIdExist()
    {
        /// CHECK IF DRIVER ALREADY EXIST
        $checkDriver = "SELECT * FROM drivers WHERE id = ?";
        $testing = $this->conn->prepare($checkDriver);
        $testing->execute([$this->driver_id]);
        $countDriver = $testing->rowCount();

        if(!$countDriver > 0)
        {
            echo json_encode([
                'status' => false,
                'message' => 'Driver With The ID Of ' . $this->driver_id . ' Does Not Exist!... '
            ]); die();
        }
    }

    public function checkIfScheduleIdExist()
    {
        /// CHECK IF SCHEDULE ID EXIST
        $checkSchedule = "SELECT * FROM schedules WHERE id = ?";
        $testing = $this->conn->prepare($checkSchedule);
        $testing->execute([$this->id]);
        $countSchedule = $testing->rowCount();

        if(!$countSchedule > 0)
        {
            echo json_encode([
                'status' => false,
                'message' => 'Schedule With The ID Of ' . $this->id . ' Does Not Exist!... '
            ]); die();
        }
    }
}

