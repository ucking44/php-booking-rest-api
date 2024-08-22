<?php

class Customer extends Clean
{
    use CustomerTables;
    private $conn;
    private $table = "customers";

    public $id;
    public $user_id;
    public $customer_name;
    public $customer_contact;
    public $customer_email;
    public $username;
    public $password;
    public $account_status;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function save()
    {
        try 
        {
            ////  HASH PASSWORD
            $hashPassword = password_hash($this->password, PASSWORD_DEFAULT);
            ///// CHECH IF USER ID EXIST
            $this->CheckUserId();
            //// CHECK IF EMAIL ALREADY EXIST
            $this->checkIfCustomerEmailExist();
            /////  SAVE CUSTOMER TO DATABASE
            $stmt = $this->conn->prepare($this->saveCustomer());

            ///// INSTANTIATE STRING CLEAN UP
            $cleanUp = new Clean();

            $stmt->execute([
                "user_id"          => $cleanUp->clean_input($this->user_id),
                "customer_name"    => $cleanUp->clean_input($this->customer_name),
                "customer_contact" => $cleanUp->clean_input($this->customer_contact),
                "customer_email"   => $cleanUp->clean_input($this->customer_email),
                "username"         => $cleanUp->clean_input($this->username),
                "password"         => $cleanUp->clean_input($hashPassword),
                "account_status"   => $cleanUp->clean_input($this->account_status)
            ]);

            return true;
        } 
        catch (\Throwable $th) 
        {
            //throw $th;
            echo $th;
        }
    }

    public function read()
    {
        try 
        {
            /// PREPARE STATEMENT AND FETCH ALL CUSTOMERS FROM DB
            $stmt = $this->conn->prepare($this->getAllCustomers());
             /// EXECUTE QUERY
            if($stmt->execute())
            {
                return $stmt;
            }
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
            /////  CHECK IF CUSTOMER ID EXIST
            $this->checkIfCustomerExist();
            ////  HASH PASSWORD
            $hashPassword = password_hash($this->password, PASSWORD_DEFAULT);
            ///// CHECK IF USER ID EXIST
            $this->CheckUserId();
            //// CHECK IF EMAIL ALREADY EXIST
            //$this->checkIfCustomerEmailExist();
            //////  UPDATE CUSTOMER BY ID
            $stmt = $this->conn->prepare($this->updateCustomer());
            ///// INSTANTIATE STRING CLEAN UP
            $cleanUp = new Clean();

            $stmt->execute([
                "user_id"          => $cleanUp->clean_input($this->user_id),
                "customer_name"    => $cleanUp->clean_input($this->customer_name),
                "customer_contact" => $cleanUp->clean_input($this->customer_contact),
                "customer_email"   => $cleanUp->clean_input($this->customer_email),
                "username"         => $cleanUp->clean_input($this->username),
                "password"         => $cleanUp->clean_input($hashPassword),
                "account_status"   => $cleanUp->clean_input($this->account_status),
                "id"               => $this->id
            ]);

            return true;
        } 
        catch (\Throwable $th) 
        {
            //throw $th;
            echo $th;
        }
    }

    public function single()
    {
        try 
        {
            /////  CHECK IF CUSTOMER ID EXIST
            $this->checkIfCustomerExist();
            /////  FETCH SINGLE CUSTOMER BY ID
            $stmt = $this->conn->prepare($this->fetchSingleCustomer());

            ///BINDING PARAM
            $stmt->bindParam(1, $this->id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            //$row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->user_id          = $row['user_id'];
            $this->customer_name    = $row['customer_name'];
            $this->customer_contact = $row['customer_contact'];
            $this->customer_email   = $row['customer_email'];
            $this->username         = $row['username'];
            $this->password         = $row['password'];
            $this->account_status   = $row['account_status'];

            return true;
        }
        catch (\Throwable $th) 
        {
            echo $th;
        }
    }

    public function delete()
    {
        try 
        {
           /////  CHECK IF CUSTOMER ID EXIST
           $this->checkIfCustomerExist();
            //// DELETE CUSTOMER BY ID
            $stmt = $this->conn->prepare($this->destroyCustomer());
            $stmt->execute([$this->id]);

            return true;
        } 
        catch (\Throwable $th) 
        {
            echo $th;
        }
    }
}

