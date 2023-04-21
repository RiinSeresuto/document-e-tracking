<?php

include("../../connection/db.php");

$id = $_GET['doc-id'];
$receiver_id = $_GET['receiver-id'];
$sender_id = $_GET['sender-id'];
$msg = "signed";

$query_to_received = "UPDATE `document` SET `status` = 'signed', `isReceived` = '1', `isSigned` = '1', `isReleased` = '0' WHERE `document`.`id` = '$id'";

$new_notification_id = makeid();
$query_new_notifiation = "INSERT INTO `notification`(`id`, `sender`, `receiver`, `message`, `docID`, `class`) VALUES ('$new_notification_id','$sender_id','$receiver_id','$msg','$id','notification-signed')";

if(mysqli_query($db, $query_to_received)){
    if(mysqli_query($db, $query_new_notifiation)){
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }
}
?>