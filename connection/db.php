<?php
session_start();

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'e-tracking');

// Connecting to server
$db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die("Connection failed: " . $db->connect_error);

function makeid(){
    return md5(uniqid(mt_rand(), true));
}

function current_time(){
    $timezone = date_default_timezone_get();
    date_default_timezone_set('Asia/Manila');
    $current_timestamp = time();

    return date("Y-m-d H:i:s",$current_timestamp);
}

//check the number of users in the database
$get_users_query = "SELECT * FROM `users`";
$get_users_result = mysqli_query($db, $get_users_query);

//check if there is no users and add main admin
if(mysqli_num_rows($get_users_result) === 0){
    $first_user_id = makeid();
    $first_user_password = 'admin';
    $first_user_email = 'admin@mail.com';
    $first_user_position = 'Admin';
    $first_user_office = 'Admin';

    // Hash password using bcrypt
    $hashed_password = password_hash($first_user_password, PASSWORD_BCRYPT);

    $add_first_user_query = "INSERT INTO `users`(`id`, `email`, `position`, `office`, `password`, `superAdmin`) VALUES ('$first_user_id','$first_user_email', '$first_user_position','$first_user_office','$hashed_password','1')";
    mysqli_query($db, $add_first_user_query);
}
