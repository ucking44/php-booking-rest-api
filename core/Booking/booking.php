<?php

class Booking extends Clean
{
    use BookingTable;

    private $conn;
    private $table = "bookings";

    public $id;
    public $user_id;
    public $schedule_id;
    public $customer_id;
    public $number_of_seats;
    public $fare_amount;
    public $total_amount;
    public $date_of_booking;
    public $booking_status;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read()
    {
        try 
        {
            /// PREPARE STATEMENT AND QUERY DB TO FETCH ALL BOOKINGS
            $stmt = $this->conn->prepare($this->getAllBooings());
            /// EXECUTE QUERY
            if ($stmt->execute())
            {
                return $stmt;
            }
        } 
        catch (\Throwable $th) 
        {
            echo $th;
        }
    }

    public function create()
    {
        try 
        {
            ///// CHECH IF USER ID EXIST
            $this->CheckUserId($this->user_id);
            /// CHECK IF SCHEDULE ALREADY EXIST
            $this->checkScheduleId();

            /// CHECK IF SCHEDULE ALREADY EXIST
            $this->checkCustomerId();
            ////// SAVE BOOKING INTO DB
            $stmt = $this->conn->prepare($this->saveBooking());

            ///// INSTANTIATE STRING CLEAN UP
            $cleanUp = new Clean();

            $stmt->execute([
                'user_id'         => $cleanUp->clean_input($this->user_id),
                'schedule_id'     => $cleanUp->clean_input($this->schedule_id),
                'customer_id'     => $cleanUp->clean_input($this->customer_id),
                'number_of_seats' => $cleanUp->clean_input($this->number_of_seats),
                'fare_amount'     => $cleanUp->clean_input($this->fare_amount),
                'total_amount'    => $cleanUp->clean_input($this->total_amount),
                'date_of_booking' => $cleanUp->clean_input($this->date_of_booking),
                'booking_status'  => $cleanUp->clean_input($this->booking_status)
            ]);

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
            ////// CHECK IF BOOKING ID EXIST
            $this->checkIFBookingExist();
            ///// CHECH IF USER ID EXIST
            $this->CheckUserId($this->user_id);
            /// CHECK IF SCHEDULE ALREADY EXIST
            $this->checkScheduleId();

            /// CHECK IF SCHEDULE ALREADY EXIST
            $this->checkCustomerId();
            //////  UPDATE BOOKING INTO DB
            $stmt = $this->conn->prepare($this->updateBookng());

            ///// INSTANTIATE STRING CLEAN UP
            $cleanUp = new Clean();

            $stmt->execute([
                'user_id'         => $cleanUp->clean_input($this->user_id),
                'schedule_id'     => $cleanUp->clean_input($this->schedule_id),
                'customer_id'     => $cleanUp->clean_input($this->customer_id),
                'number_of_seats' => $cleanUp->clean_input($this->number_of_seats),
                'fare_amount'     => $cleanUp->clean_input($this->fare_amount),
                'total_amount'    => $cleanUp->clean_input($this->total_amount),
                'date_of_booking' => $cleanUp->clean_input($this->date_of_booking),
                'booking_status'  => $cleanUp->clean_input($this->booking_status),
                'id'              => $this->id
            ]);

            return $stmt;
        } 
        catch (\Throwable $th) 
        {
            echo $th;
        }
    }

    public function single()
    {
        try 
        {
            ////// CHECK IF BOOKING ID EXIST
            $this->checkIFBookingExist();
            
            ////  QUERY DB TO FETCH SINGLE BOOKING
            $stmt = $this->conn->prepare($this->singleBooking());
            ///BINDING PARAM
            $stmt->bindParam(1, $this->id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->user_id         = $row['user_id'];
            $this->schedule_id     = $row['schedule_id'];
            $this->customer_id     = $row['customer_id'];
            $this->number_of_seats = $row['number_of_seats'];
            $this->fare_amount     = $row['fare_amount'];
            $this->total_amount    = $row['total_amount'];
            $this->date_of_booking = $row['date_of_booking'];
            $this->booking_status  = $row['booking_status'];

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
            ////// CHECK IF BOOKING ID EXIST
            $this->checkIFBookingExist();
            
            ////// DELETE BOOKING FROM DB
            $stmt = $this->conn->prepare($this->deleteBooking());
            $stmt->execute(['id' => $this->id]);

            echo json_encode([
                'status'  => true,
                'message' => 'Booking Was Deleted Successfully!'
            ]);
        } 
        catch (\Throwable $th) 
        {
            echo $th;
        }
    }
}

