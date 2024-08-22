<?php

trait DriverTables
{
    public function saveDriver()
    {
        ///// INSERT DRIVER INTO DB
        $sql = 'INSERT INTO drivers (user_id, driver_name, driver_contact) VALUES (:user_id, :driver_name, :driver_contact)';
        return $sql;
    }

    public function getAllDrivers()
    {
        /////   FETCH ALL DRIVERS FROM DATABASE
        $query = 'SELECT
                u.full_name as user_name,
                d.id,
                d.user_id,
                d.driver_name,
                d.driver_contact
                FROM
                ' .$this->table . ' d
                LEFT JOIN
                    users u ON d.user_id = u.id
                    ORDER BY d.created_at DESC';
        
        return $query;
    }

    public function updateDriver()
    {
        /////  UPDATE DRIVER
        $sql = 'UPDATE drivers SET user_id = :user_id, driver_name = :driver_name, driver_contact = :driver_contact WHERE id = :id';
        return $sql;
    }

    public function getSingleDriver()
    {
        //////  FETCH SINGLE DRIVER BY ID FROM DB
        $query = 'SELECT
                u.full_name as user_name,
                d.id,
                d.user_id,
                d.driver_name,
                d.driver_contact
                FROM
                ' .$this->table . ' d
                LEFT JOIN
                    users u ON d.user_id = u.id
                    WHERE d.id = ? LIMIT 1';

        return $query;
    }

    public function destroyDriver()
    {
        /////  DELETE DRIVER FROM DATABASE
        $sql = 'DELETE FROM drivers WHERE id = :id';
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
                'message' => 'User With The ID of ' . $this->user_id . ' Does Not Exist!... '
            ]); die();
        }
    }

    public function checkIfDriverAlreadyExist()
    {
        $checkDriverName = "SELECT * FROM drivers WHERE driver_name = ? OR driver_contact = ?";
        $testing = $this->conn->prepare($checkDriverName);
        $testing->execute([$this->driver_name, $this->driver_contact]);
        $countDriver = $testing->rowCount();

        if($countDriver > 0)
        {
            echo json_encode([
                'status' => false,
                'message' => 'Driver With The Name ' . $this->driver_name . ' Or Contact ' . $this->driver_contact . ' Already Exist!... '
            ]); die();
        }
    }

    public function checkIfDriverIdExist()
    {
        /// CHECK IF DRIVER WITH THE ID EXIST
        $checkDriverName = "SELECT * FROM drivers WHERE id = ?";
        $testing = $this->conn->prepare($checkDriverName);
        $testing->execute([$this->id]);
        $countDriver = $testing->rowCount();

        if(!$countDriver > 0)
        {
            echo json_encode([
                'status' => false,
                'message' => 'Driver With The ID of ' . $this->id . ' Does Not Exist!... '
            ]); die();
        }
    }
}
