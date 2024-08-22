<?php

class Payment extends Clean
{
    use PaymentTables;

    private $conn;
    private $table = "payments";

    public $id;
    public $user_id;
    public $booking_id;
    public $amount_paid;
    public $payment_date;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create()
    {
        try 
        {
            ///// CHECH IF USER ID EXIST
            $this->CheckUserId($this->user_id);
            /// CHECK IF BOOKING ID EXIST
            $this->checkBookingId();
            ////  PROCESS AND SAVE DATA TO DB
            $stmt = $this->conn->prepare($this->savePayment());

            ///// INSTANTIATE STRING CLEAN UP
            $cleanUp = new Clean();

            $stmt->execute([
                'user_id'      => $cleanUp->clean_input($this->user_id),
                'booking_id'   => $cleanUp->clean_input($this->booking_id),
                'amount_paid'  => $cleanUp->clean_input($this->amount_paid),
                'payment_date' => $cleanUp->clean_input($this->payment_date)
            ]);

            return $stmt;
        } 
        catch (\Throwable $th) 
        {
            throw $th;
        }
    }

    public function read()
    {
        try 
        {
            //// PREPARE STATEMENT AND FETCHING OF ALL PAYMENTS FROM DB
            $stmt = $this->conn->prepare($this->fetchPayments());
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
            ////// CHECK IF PAYMENT ID EXIST
            $this->checkPaymentId();
            ///// CHECH IF USER ID EXIST
            $this->CheckUserId($this->user_id);
            /// CHECK IF BOOKING ID EXIST
            $this->checkBookingId();
            ////  PROCESS AND UPDATE PAYMENT BY ID
            $stmt = $this->conn->prepare($this->updatePayment());

            ///// INSTANTIATE STRING CLEAN UP
            $cleanUp = new Clean();

            $stmt->execute([
                'user_id'      => $cleanUp->clean_input($this->user_id),
                'booking_id'   => $cleanUp->clean_input($this->booking_id),
                'amount_paid'  => $cleanUp->clean_input($this->amount_paid),
                'payment_date' => $cleanUp->clean_input($this->payment_date),
                'id'           => $this->id
            ]);

            return $stmt;
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
            ////// CHECK IF PAYMENT ID EXIST
            $this->checkPaymentId();

            ////  QUERY DB TO FETCH SINGLE PAYMENT BY ID
            $stmt = $this->conn->prepare($this->singlePayment());
            ///BINDING PARAM
            $stmt->bindParam(1, $this->id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->user_id      = $row['user_id'];
            $this->booking_id   = $row['booking_id'];
            $this->amount_paid  = $row['amount_paid'];
            $this->payment_date = $row['payment_date'];

            return true;
        } 
        catch (\Throwable $th) 
        {
            //throw $th;
        }
    }

    public function delete()
    {
        try 
        {
            ////// CHECK IF PAYMENT ID EXIST
            $this->checkPaymentId();
            /// DELETE SINGLE PAYMENT FROM DB BY ID
            $stmt = $this->conn->prepare($this->deletePayment());
            $stmt->execute(['id' => $this->id]);

            return true;
        } 
        catch (\Throwable $th) 
        {
            //throw $th;
        }
    }
}

