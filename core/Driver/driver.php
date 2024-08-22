<?php

class Driver extends Clean
{
    use DriverTables;
    private $conn;
    private $table = "drivers";

    public $id;
    public $user_id;
    public $driver_name;
    public $driver_contact;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function save()
    {
        try 
        {
            /// CHECK IF USER ID EXIST
            $this->CheckUserId();
            /// CHECK IF DRIVER ALREADY EXIST
            $this->checkIfDriverAlreadyExist();
                
            ///// PREPARE STATEMENT AND INSERT DRIVER INTO DB
            $stmt = $this->conn->prepare($this->saveDriver());
            ///// INSTANTIATE STRING CLEAN UP
            $cleanUp = new Clean();

            $stmt->execute([
                'user_id'        => $cleanUp->clean_input($this->user_id),
                'driver_name'    => $cleanUp->clean_input($this->driver_name),
                'driver_contact' => $cleanUp->clean_input($this->driver_contact)
            ]);

            return true;
        } 
        catch (PDOException $e) 
        {
            $e->getMessage();
        }
    }

    public function read()
    {    
        try 
        {
            /// PREPARE STATEMENT AND FETCH ALL DRIVERS FROM DATABASE
            $stmt = $this->conn->prepare($this->getAllDrivers());
            /// EXECUTE QUERY
            $stmt->execute();

            return $stmt;
        } 
        catch (\Throwable $th) 
        {
            echo $th;
        }
    }

    public function update()
    {
        try 
        {
            /// CHECK IF USER ID EXIST
            $this->CheckUserId();
                
            /// CHECH IF DRIVER WITH THE ID EXIST
            $this->checkIfDriverIdExist();
            /////  UPDATE DRIVER
            $stmt = $this->conn->prepare($this->updateDriver());
            ///// INSTANTIATE STRING CLEAN UP
            $cleanUp = new Clean();

            $stmt->execute([
                'user_id'        => $cleanUp->clean_input($this->user_id),
                'driver_name'    => $cleanUp->clean_input($this->driver_name),
                'driver_contact' => $cleanUp->clean_input($this->driver_contact),
                'id'             => $this->id
            ]);

            return true;
        } 
        catch (PDOException $e) 
        {
            $e->getMessage();
        }
    }

    public function single()
    {
        try 
        {
            /// CHECK IF DRIVER WITH THE ID EXIST
            $this->checkIfDriverIdExist();
            
            /// PREPARE STATEMENT AND FETCH SINGLE DRIVER BY ID FROM DB
            $stmt = $this->conn->prepare($this->getSingleDriver());
            ///BINDING PARAM
            $stmt->bindParam(1, $this->id);
            //// EXECUTE THE QUERY
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->user_id        = $row['user_id'];
            $this->driver_name    = $row['driver_name'];
            $this->driver_contact = $row['driver_contact'];
        } 
        catch (PDOException $e)
        {
            $e->getMessage();
        }
    }

    public function delete()
    {
        try 
        {
            /// CHECK IF DRIVER WITH THE ID EXIST
            $this->checkIfDriverIdExist();
            
            // PREPARE STATEMENT AND DELETE DRIVER FROM DATABASE
            $stmt = $this->conn->prepare($this->destroyDriver());
            $stmt->execute(['id' => $this->id]);

            return true;
        } 
        catch (\Throwable $th) 
        {
            throw $th;
        }
    }
}

