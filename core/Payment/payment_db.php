<?php

trait PaymentTables
{
    public function savePayment()
    {
        ////  INSERT PAYMENT INTO DB
        $data = "INSERT INTO payments (user_id, booking_id, amount_paid, payment_date) VALUES (:user_id, :booking_id, :amount_paid, :payment_date)";
        return $data;
    }

    public function fetchPayments()
    {
        ////  FETCH ALL PAYMENTS FROM DB
        $data = "SELECT * FROM payments";
        return $data;
    }

    public function updatePayment()
    {
        /// UPDATE PAYMENT BY ID
        $data = 'UPDATE payments SET user_id = :user_id, booking_id = :booking_id, amount_paid = :amount_paid, payment_date = :payment_date WHERE id = :id';
        return $data;
    }

    public function singlePayment()
    {
        //// FETCH SINGLE PAYMENT BY ID FROM DB
        $data = 'SELECT *  FROM payments WHERE id = :id';
        return $data;
    }

    public function deletePayment()
    {
        /// DELETE PAYMENT FROM DB BY ID
        $data = 'DELETE FROM payments WHERE id = :id';
        return $data;
    }

    public function CheckUserId($user_id)
    {
        ///// CHECK IF USER ID EXIST
        $checkUser = "SELECT * FROM users WHERE id = ?";
        $test = $this->conn->prepare($checkUser);
        //$test->execute([$this->user_id]);
        $test->execute([$user_id]);
        $result = $test->rowCount();

        if (!$result > 0)
        {
            echo json_encode([
                'status' => false,
                'message' => 'User With The ID of ' . $this->user_id . ' Does Not Exist!... '
            ]); die();
        }
    }

    public function checkBookingId()
    {
        /// CHECK IF BOOKING ID EXIST
        $checkBooking = "SELECT * FROM bookings WHERE id = ?";
        $testBooking = $this->conn->prepare($checkBooking);
        $testBooking->execute([$this->booking_id]);
        $countBooking = $testBooking->rowCount();

        if (!$countBooking > 0)
        {
            echo json_encode([
                'status' => false,
                'message' => 'Booking With The ID of ' . $this->booking_id . ' Does Not Exist!... '
            ]); die();
        }
    }

    public function checkPaymentId()
    {
        ////// CHECK IF PAYMENT ID EXIST
        $checkPayment = "SELECT * FROM payments WHERE id = ?";
        $testPayment = $this->conn->prepare($checkPayment);
        $testPayment->execute([$this->id]);
        $countPayment = $testPayment->rowCount();

        if(!$countPayment > 0)
        {
            echo json_encode([
                'status' => false,
                'message' => 'Payment With The ID Of ' . $this->id . ' Does Not Exist... '
            ]); die();
        }
    }
}
