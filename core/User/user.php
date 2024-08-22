<?php

    class User extends Clean
    {
        use UserTables;
        private $conn;
        private $table = "users";

        public $full_name;
        public $username;
        public $contact_no;
        public $userpassword;
        public $email_address;
        public $account_status;
        public $account_category;

        public function __construct($db)
        {
            $this->conn = $db;
        }

        // INSERT USER INTO DB
        public function save() 
        {
            try 
            {
                // HASH PASSWORD
                $hashPassword = password_hash($this->userpassword, PASSWORD_DEFAULT);
                ///PREAPARE STATEMENT AND INSERT USER INTO DB
                $stmt = $this->conn->prepare($this->saveUser());
            
                ///// INSTANTIATE STRING CLEAN UP
                $cleanUp = new Clean();

                $stmt->execute([
                    'full_name'        => $cleanUp->clean_input($this->full_name), 
                    'email_address'    => $cleanUp->clean_input($this->email_address), 
                    'contact_no'       => $cleanUp->clean_input($this->contact_no),
                    'username'         => $cleanUp->clean_input($this->username),
                    'userpassword'     => $cleanUp->clean_input($hashPassword),
                    'account_status'   => $cleanUp->clean_input($this->account_status),
                    'account_category' => $cleanUp->clean_input($this->account_category)
                ]);

                return true;
            } 
            catch (\Throwable $th)
            {
                throw $th;
            }
        }

        /// FETCH ALL USERS FROM DB
        public function read()
        {
            try 
            {
                /// PREPARE STATEMENT AND FETCH ALL USERS FROM DB
                $stmt = $this->conn->prepare($this->getAllUsers());
                /// EXECUTE QUERY
                $stmt->execute();

                return $stmt;
            } 
            catch (\Throwable $th) 
            {
                throw $th;
            }
        }

        // UPDATE SINGLE USER BY ID
        public function update()
        {
            try 
            {
                ///// CHECK IF USER ID EXIST
                $this->CheckUserId();
                // HASH PASSWORD
                $hashPassword = password_hash($this->userpassword, PASSWORD_DEFAULT);
                /// PREPARE STATEMENT AND UPDATE USER BY ID
                $stmt = $this->conn->prepare($this->updateUser());

                ///// INSTANTIATE STRING CLEAN UP
                $cleanUp = new Clean();

                $stmt->execute([
                    'full_name'        => $cleanUp->clean_input($this->full_name), 
                    'email_address'    => $cleanUp->clean_input($this->email_address), 
                    'contact_no'       => $cleanUp->clean_input($this->contact_no),
                    'username'         => $cleanUp->clean_input($this->username),
                    'userpassword'     => $cleanUp->clean_input($hashPassword),
                    'account_status'   => $cleanUp->clean_input($this->account_status),
                    'account_category' => $cleanUp->clean_input($this->account_category),
                    'id'               => $this->id
                ]);

                return true;
            } 
            catch (\Throwable $th) 
            {
                echo $th;
            }
        }

        /// FETCH SINGLE USER FROM DB
        public function single()
        {
            try 
            {
                ///// CHECK IF USER ID EXIST
                $this->CheckUserId();
                /// PREPARE STATEMENT AND FETCH SINGLE USER FROM DB BY ID
                $stmt = $this->conn->prepare($this->getSingleUser());
                ///BINDING PARAM
                $stmt->bindParam(1, $this->id);
                //// EXECUTE THE QUERY
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                $this->full_name        = $row['full_name'];
                $this->email_address    = $row['email_address'];
                $this->contact_no       = $row['contact_no'];
                $this->username         = $row['username'];
                $this->userpassword     = $row['userpassword'];
                $this->account_status   = $row['account_status'];
                $this->account_category = $row['account_category'];
            } 
            catch (PDOException $e)
            {
                //throw $th;
                $e->getMessage();
            }
        }

        // DELETE SINGLE USER FROM DB
        public function delete() 
        {
            try 
            {
                ///// CHECK IF USER ID EXIST
                $this->CheckUserId();
                // PREPARE STATEMENT AND DELETE USER FROM DB BY ID
                $stmt = $this->conn->prepare($this->destroyUser());
                /// EXECUTE THE QUERY
                $stmt->execute(['id' => $this->id]);

                return true;
            } 
            catch (\Throwable $th) 
            {
                echo $th;
            }
        }
    }

