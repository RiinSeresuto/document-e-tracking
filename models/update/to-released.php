<?php
include("../../connection/db.php");

$timezone = date_default_timezone_get();
date_default_timezone_set($timezone);
$current_timestamp = time();

$id = $_GET['id']; //document id
$receiver_id = $_GET['receiver'];
$sender_id = $_GET['sender'];
$msg = "has been released";
$timestamp = date("Y-m-d H:i:s",$current_timestamp);

$query_to_received = "UPDATE `document` SET `status` = 'released', `isReceived` = '1', `isSigned` = '1', `isReleased` = '1' WHERE `document`.`id` = '$id'";

$new_notification_id = makeid();
$query_new_notifiation = "INSERT INTO `notification`(`id`, `sender`, `receiver`, `message`, `docID`, `class`) VALUES ('$new_notification_id','$sender_id','$receiver_id','$msg','$id','notification-released')";

if(mysqli_query($db, $query_to_received)){
    if(mysqli_query($db, $query_new_notifiation)){
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }
}
?>