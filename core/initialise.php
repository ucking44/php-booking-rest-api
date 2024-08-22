<?php

    defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
    defined('SITE_ROOT') ? null : define('SITE_ROOT', DS . 'xampp'.DS.'htdocs'.DS.'apirestphp');
    defined('INC_PATH') ? null : define('INC_PATH', SITE_ROOT.DS.'includes');
    defined('CORE_PATH') ? null : define('CORE_PATH', SITE_ROOT.DS.'core');
    defined('USER_PATH') ? null : define('USER_PATH', CORE_PATH.DS.'User');
    defined('BOOKING_PATH') ? null : define('BOOKING_PATH', CORE_PATH.DS.'Booking');
    defined('BUS_PATH') ? null : define('BUS_PATH', CORE_PATH.DS.'Bus');
    defined('CUSTOMER_PATH') ? null : define('CUSTOMER_PATH', CORE_PATH.DS.'Customer');
    defined('DRIVER_PATH') ? null : define('DRIVER_PATH', CORE_PATH.DS.'Driver');
    defined('PAYMENT_PATH') ? null : define('PAYMENT_PATH', CORE_PATH.DS.'Payment');
    defined('SCHEDULE_PATH') ? null : define('SCHEDULE_PATH', CORE_PATH.DS.'Schedule');

    //// LOAD THE CONFIG FILE FIRST
    require_once(INC_PATH.DS."config.php");

    /// CORE CLASSES
    require_once(CORE_PATH.DS."clean.php");
    require_once(USER_PATH.DS."user_db.php");
    require_once(USER_PATH.DS."user.php");

    require_once(BUS_PATH.DS."bus_db.php");
    require_once(BUS_PATH.DS."bus.php");

    require_once(CUSTOMER_PATH.DS."customer_db.php");
    require_once(CUSTOMER_PATH.DS."customer.php");

    require_once(DRIVER_PATH.DS."driver_db.php");
    require_once(DRIVER_PATH.DS."driver.php");

    require_once(SCHEDULE_PATH.DS."schedule_db.php");
    require_once(SCHEDULE_PATH.DS."schedule.php");

    require_once(BOOKING_PATH.DS."booking_db.php");
    require_once(BOOKING_PATH.DS."booking.php");
    
    require_once(PAYMENT_PATH.DS."payment_db.php");
    require_once(PAYMENT_PATH.DS."payment.php");

