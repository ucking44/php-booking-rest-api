<?php

trait BusTables
{
    public function saveBus()
    {
        ///// SAVE BUS INTO DB
        $sql = 'INSERT INTO buses (user_id, bus_number, bus_plate_number, bus_type, capacity) VALUES (:user_id, :bus_number, :bus_plate_number, :bus_type, :capacity)';
        return $sql;
    }

    public function getBuses()
    {
        //$query = 'SELECT * FROM ' . $this->table;
        //// FETCH ALL BUSES
        $query = 'SELECT
                    u.full_name as user_name,
                    b.id,
                    b.user_id,
                    b.bus_number,
                    b.bus_plate_number,
                    b.bus_type,
                    b.capacity
                    FROM
                    ' .$this->table . ' b
                    LEFT JOIN
                        users u ON b.user_id = u.id
                        ORDER BY b.created_at DESC';
        return $query;
    }

    public function updateBus()
    {
        /////  UPDATE SINGLE BUS BY ID
	    $sql = 'UPDATE buses SET user_id = :user_id, bus_number = :bus_number, bus_plate_number = :bus_plate_number, bus_type = :bus_type, capacity = :capacity WHERE id = :id';
        return $sql;
    }

    public function fetchSingleBus()
    {
        ///// GET SINGLE BUS BY ID
        //$query = 'SELECT * FROM ' . $this->table . ' WHERE id = ? LIMIT 1';
        $query = 'SELECT
                    u.full_name as user_name,
                    b.id,
                    b.user_id,
                    b.bus_number,
                    b.bus_plate_number,
                    b.bus_type,
                    b.capacity
                    FROM
                    ' .$this->table . ' b
                    LEFT JOIN
                        users u ON b.user_id = u.id
                        WHERE b.id = ? LIMIT 1';
        return $query;
    }

    public function destroyBus()
    {
        /// DELETE BUS FROM DB BY ID
	    $sql = 'DELETE FROM buses WHERE id = :id';
        return $sql;
    }

    public function CheckUserId()
    {
        ///// CHECH IF USER ID EXIST
        $checkUser = "SELECT * FROM users WHERE id = ?";
        $test = $this->conn->prepare($checkUser);
        $test->execute([$this->user_id]);
        //$test->execute([$user_id]);
        $result = $test->rowCount();

        if (!$result > 0)
        {
            echo json_encode([
                'status' => false,
                'message' => 'User With The ID of ' . $this->user_id . ' Does Not Exist!... '
            ]); die();
        }
    }

    public function checkIFBusExist()
    {
        ////// CHECK IF BUS ID EXIST
        $checkbus = "SELECT * FROM buses WHERE id = ?";
        $testbus = $this->conn->prepare($checkbus);
        $testbus->execute([$this->id]);
        $countbus = $testbus->rowCount();

        if(!$countbus > 0)
        {
            echo json_encode([
                'status' => false,
                'message' => 'Bus With The ID Of ' . $this->id . ' Does Not Exist... '
            ]); die();
        }
    }
}
