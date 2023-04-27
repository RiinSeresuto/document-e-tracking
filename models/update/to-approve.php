<?php
include("../../connection/db.php");

$id = $_GET['doc-id'];

$receiver_notification_id = $_GET['sender-id'];
$sender_notification_id = $_SESSION['id'];
$new_notification_id = makeid();
$msg = "is approved";

$query_to_forward = "UPDATE `document` SET `status` = 'approved', `isReceived` = '1', `isForwarded` = '1', `isSigned` = '1', `isReleased` = '1', `isApproved` = '1' WHERE `document`.`id` = '$id'";
$query_new_notifiation = "INSERT INTO `notification`(`id`, `sender`, `receiver`, `message`, `docID`, `class`) VALUES ('$new_notification_id','$sender_notification_id','$receiver_notification_id','$msg','$id','notification-forwarded')";

if(mysqli_query($db, $query_to_forward)){
    if(mysqli_query($db, $query_new_notifiation)){
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    } else {
        echo "notification : " . $db->error;
    }
} else {
    echo"update: " . $db->error;
}
?>