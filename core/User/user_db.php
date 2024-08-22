<?php

trait UserTables
{
    public function saveUser()
    {
        // INSERT USER INTO DB
        $sql = 'INSERT INTO users (full_name, email_address, contact_no, username, userpassword, account_status, account_category) VALUES (:full_name, :email_address, :contact_no, :username, :userpassword, :account_status, :account_category)';
        return $sql;
    }

    public function getAllUsers()
    {
        // FETCH ALL USERS FROM DB
        $query = 'SELECT * FROM ' . $this->table;
        return $query;
    }

    public function updateUser()
    {
        /// UPDATE USER BY ID
        $sql = 'UPDATE users SET full_name = :full_name, email_address = :email_address, contact_no = :contact_no, username = :username, userpassword = :userpassword, account_status = :account_status, account_category = :account_category WHERE id = :id';
	    return $sql;
    }

    public function getSingleUser()
    {
        // FETCH SINGLE USER FROM DB BY ID
        $query = 'SELECT * FROM ' . $this->table . ' WHERE id = ? LIMIT 1';
        return $query;
    }

    public function destroyUser()
    {
        // DELETE USER FROM DB BY ID
        $sql = 'DELETE FROM users WHERE id = :id';
        return $sql;
    }

    public function CheckUserId()
    {
        ///// CHECK IF USER ID EXIST
        $checkUser = "SELECT * FROM users WHERE id = ?";
        $test = $this->conn->prepare($checkUser);
        $test->execute([$this->id]);
        $result = $test->rowCount();

        if (!$result > 0)
        {
            echo json_encode([
                'status' => false,
                'message' => 'User With The ID Of ' . $this->id . ' Does Not Exist!... '
            ]); die();
        }
    }
}
