<?php
include("../../connection/db.php");

$timezone = date_default_timezone_get();
date_default_timezone_set($timezone);
$current_timestamp = time();

$id = $_GET['doc-id'];
$receiver_id = $_GET['receiver-id'];
$sender_id = $_GET['sender-id'];
$msg = "is received";

$timestamp = date("Y-m-d H:i:s",$current_timestamp);

$query_to_received = "UPDATE `document` SET `status` = 'received', `dateReceived` = '$timestamp', `isReceived` = '1', `isForwarded` = '0', `isSigned` = '0', `isReleased` = '0' WHERE `document`.`id` = '$id'";

$new_notification_id = makeid();
$query_new_notifiation = "INSERT INTO `notification`(`id`, `sender`, `receiver`, `message`, `docID`, `class`) VALUES ('$new_notification_id','$sender_id','$receiver_id','$msg','$id','notification-received')";

if(mysqli_query($db, $query_to_received)){
    if(mysqli_query($db, $query_new_notifiation)){
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }
}
?>