<?php

trait CustomerTables
{
    public function saveCustomer()
    {
        /////  SAVE CUSTOMER TO DATABASE
        $sql = "INSERT INTO customers (user_id, customer_name, customer_contact, customer_email, username, password, account_status) VALUES (:user_id, :customer_name, :customer_contact, :customer_email, :username, :password, :account_status)";
        return $sql;
    }

    public function getAllCustomers()
    {
        //// FETCH ALL CUSTOMERS FROM DB
        $query = 'SELECT * FROM customers';
        return $query;
    }

    public function updateCustomer()
    {
        //////  UPDATE CUSTOMER BY ID
        $sql = "UPDATE customers SET user_id = :user_id, customer_name = :customer_name, customer_contact = :customer_contact, customer_email = :customer_email, username = :username, password = :password, account_status = :account_status WHERE id = :id";
        return $sql;
    }

    public function fetchSingleCustomer()
    {
        /////  FETCH SINGLE CUSTOMER BY ID
        $query = 'SELECT * FROM customers WHERE id = ? LIMIT 1';
        return $query;
    }

    public function destroyCustomer()
    {
        //// DELETE CUSTOMER BY ID
        $delete = 'DELETE FROM customers WHERE id = :id';
        return $delete;
    }

    public function CheckUserId()
    {
        ///// CHECK IF USER ID EXIST
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

    public function checkIfCustomerExist()
    {
        /////  CHECK IF CUSTOMER ID EXIST
        $checkCustomer = "SELECT * FROM customers WHERE id = ?";
        $testing = $this->conn->prepare($checkCustomer);
        $testing->execute([$this->id]);
        $countCustomer = $testing->rowCount();

        if(!$countCustomer > 0)
        {
            echo json_encode([
                'status' => false,
                'message' => 'Customer With The ID Of ' . $this->id . ' Does Not Exist... '
            ]); die();
        }
    }

    public function checkIfCustomerEmailExist()
    {
        /////  CHECK IF CUSTOMER ID EXIST
        $checkCustomer = "SELECT * FROM customers WHERE customer_email = ?";
        $testing = $this->conn->prepare($checkCustomer);
        $testing->execute([$this->customer_email]);
        $countCustomer = $testing->rowCount();

        if($countCustomer > 1)
        {
            echo json_encode([
                'status' => false,
                'message' => 'Customer With The Email ' . $this->customer_email . ' Already Exist... '
            ]); die();
        }
    }

    // public function updateCheckIfCustomerEmailExist()
    // {
    //     /////  CHECK IF CUSTOMER ID EXIST
    //     $checkCustomer = "SELECT * FROM customers WHERE id = ? AND WHERE customer_email = ?";
    //     $testing = $this->conn->prepare($checkCustomer);
    //     $testing->execute([$this->id, $this->customer_email]);
    //     $countCustomer = $testing->rowCount();

    //     if($countCustomer > 1)
    //     {
    //         echo json_encode([
    //             'status' => false,
    //             'message' => 'Customer With The Email ' . $this->customer_email . ' Already Exist... '
    //         ]); die();
    //     }
    // }
}
