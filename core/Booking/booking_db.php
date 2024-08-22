<?php

trait BookingTable
{
    public function saveBooking()
    {
        $query = 'INSERT INTO bookings (user_id, schedule_id, customer_id, number_of_seats, fare_amount, total_amount, date_of_booking, booking_status) VALUES (:user_id, :schedule_id, :customer_id, :number_of_seats, :fare_amount, :total_amount, :date_of_booking, :booking_status)';
        return $query;
    }

    public function getAllBooings()
    {
        ///// QUERY DB TO FETCH ALL BOOKINGS
        $query = "SELECT * FROM bookings";
        return $query;
    }

    public function updateBookng()
    {
        $query = 'UPDATE bookings SET user_id = :user_id, schedule_id = :schedule_id, customer_id = :customer_id, number_of_seats = :number_of_seats, fare_amount = :fare_amount, total_amount = :total_amount, date_of_booking = :date_of_booking, booking_status = :booking_status WHERE id = :id';
        return $query;
    }

    public function singleBooking()
    {
        ////  QUERY DB TO FETCH SINGLE BOOKING
        $query = 'SELECT *  FROM bookings WHERE id = :id';
        return $query;
    }

    public function deleteBooking()
    {
        ////// DELETE BOOKING FROM DB
        $delete = 'DELETE FROM bookings WHERE id = :id';
        return $delete;
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

    public function checkScheduleId()
    {
        /// CHECK IF SCHEDULE ALREADY EXIST
        $checkSchedule = "SELECT * FROM schedules WHERE id = ?";
        $testSchedule = $this->conn->prepare($checkSchedule);
        $testSchedule->execute([$this->schedule_id]);
        $countSchedule = $testSchedule->rowCount();

        if(!$countSchedule > 0)
        {
            echo json_encode([
                'status' => false,
                'message' => 'Schedule With The ID Of ' . $this->schedule_id . ' Does Not Exist... '
            ]); die();
        }
    }

    public function checkCustomerId()
    {
        /// CHECK IF CUSTOMER ALREADY EXIST
        $checkCustomer = "SELECT * FROM customers WHERE id = ?";
        $testCustomer = $this->conn->prepare($checkCustomer);
        $testCustomer->execute([$this->customer_id]);
        $countCustomer = $testCustomer->rowCount();

        if(!$countCustomer > 0)
        {
            echo json_encode([
                'status' => false,
                'message' => 'Customer With The ID Of ' . $this->customer_id . ' Does Not Exist... '
            ]); die();
        }
    }

    public function checkIFBookingExist()
    {
        ////// CHECK IF BOOKING ID EXIST
        $checkBooking = "SELECT * FROM bookings WHERE id = ?";
        $testBooking = $this->conn->prepare($checkBooking);
        $testBooking->execute([$this->id]);
        $countBooking = $testBooking->rowCount();

        if(!$countBooking > 0)
        {
            echo json_encode([
                'status' => false,
                'message' => 'Booking With The ID Of ' . $this->id . ' Does Not Exist... '
            ]); die();
        }
    }
}

