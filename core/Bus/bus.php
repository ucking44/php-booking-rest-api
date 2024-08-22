<?php

    class Bus extends Clean
    {
        use BusTables;
        private $conn;
        private $table = "buses";

        public $id;
        public $user_id;
        public $user_name;
        public $bus_number;
        public $bus_plate_number;
        public $bus_type;
        public $capacity;

        public function __construct($db)
        {
            $this->conn = $db;
        }

        public function read()
        {
            /// PREPARE STATEMENT AND FETCH ALL BUSES
            $stmt = $this->conn->prepare($this->getBuses());
            /// EXECUTE QUERY
            $stmt->execute();

            return $stmt;
        }

        // IINSERT BUS INTO THE DATABASE
        public function save() 
        {
            try 
            {
                ///// CHECK IF USER ID EXIST
                $this->CheckUserId();
                ///// SAVE BUS INTO DB
                $stmt = $this->conn->prepare($this->saveBus());
                ///// INSTANTIATE STRING CLEAN UP
                $cleanUp = new Clean();
                
                $stmt->execute([
                    'user_id'           => $cleanUp->clean_input($this->user_id), 
                    'bus_number'        => $cleanUp->clean_input($this->bus_number), 
                    'bus_plate_number'  => $cleanUp->clean_input($this->bus_plate_number),
                    'bus_type'          => $cleanUp->clean_input($this->bus_type),
                    'capacity'          => $cleanUp->clean_input($this->capacity)
                ]);

                return true;
            }
            catch (PDOException $e)
            {
                $e->getMessage();
            }
        }

        ///// UPDATE BUS
        public function update()
        {
            try 
            {
                ////// CHECK IF BUS ID EXIST
                $this->checkIFBusExist();
                ///// CHECK IF USER ID EXIST
                $this->CheckUserId();
                /////  UPDATE SINGLE BUS BY ID
                $stmt = $this->conn->prepare($this->updateBus());
                ///// INSTANTIATE STRING CLEAN UP
                $cleanUp = new Clean();

                $stmt->execute([
                    'user_id'           => $cleanUp->clean_input($this->user_id), 
                    'bus_number'        => $cleanUp->clean_input($this->bus_number), 
                    'bus_plate_number'  => $cleanUp->clean_input($this->bus_plate_number),
                    'bus_type'          => $cleanUp->clean_input($this->bus_type),
                    'capacity'          => $cleanUp->clean_input($this->capacity),
                    'id'                => $this->id
                ]);

                return true;
            } 
            catch (\Throwable $th) 
            {
                throw $th;
            }
        }

        public function single()
        {
            try 
            {
                ////// CHECK IF BUS ID EXIST
                $this->checkIFBusExist();
                /// PREPARE STATEMENT AND GET SINGLE BUS BY ID
                $stmt = $this->conn->prepare($this->fetchSingleBus());
                ///BINDING PARAM
                $stmt->bindParam(1, $this->id);
                //// EXECUTE THE QUERY
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                $this->user_id                = $row['user_id'];
                $this->user_name              = $row['user_name'];
                $this->bus_number             = $row['bus_number'];
                $this->bus_plate_number       = $row['bus_plate_number'];
                $this->bus_type               = $row['bus_type'];
                $this->capacity               = $row['capacity'];

                return true;
            } 
            catch (PDOException $e)
            {
                //throw $th;
                $e->getMessage();
            }
        }

        // DELETE BUS FROM DATABASE
        public function delete($id) 
        {
            ////// CHECK IF BUS ID EXIST
            $this->checkIFBusExist();
            /// DELETE BUS FROM DB BY ID
            $stmt = $this->conn->prepare($this->destroyBus());
            $stmt->execute(['id' => $id]);

            return true;
        }
    }
