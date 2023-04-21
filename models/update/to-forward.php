<?php
include("../../connection/db.php");
/*
$forward_office = $_POST['office'];

$query_to_forward = "UPDATE `document` SET `status` = 'forwarded', `office` = '$forward_office', `isReceived` = '1', `isForwarded` = '1', `isSigned` = '0', `isReleased` = '0' WHERE `document`.`id` = '$id'";

$receiver_notification_id = $sender_id;
$sender_notification_id = $_SESSION['id'];
$msg = "is forwarded to";
$new_notification_id = makeid();
$query_new_notifiation = "INSERT INTO `notification`(`id`, `sender`, `receiver`, `message`, `docID`, `class`) VALUES ('$new_notification_id','$sender_notification_id','$receiver_notification_id','$msg','$id','notification-forwarded')";

if(mysqli_query($db, $query_to_forward)){
    mysqli_query($db, $query_new_notifiation);
}
*/
$id = $_GET['document-id'];

$forward_office = $_GET['office'];
$receiver_notification_id = $_GET['notification-to'];
$sender_notification_id = $_SESSION['id'];
$new_notification_id = makeid();
$msg = "is forwarded to";

$query_to_forward = "UPDATE `document` SET `status` = 'forwarded', `office` = '$forward_office', `isReceived` = '1', `isForwarded` = '1', `isSigned` = '0', `isReleased` = '0' WHERE `document`.`id` = '$id'";
$query_new_notifiation = "INSERT INTO `notification`(`id`, `sender`, `receiver`, `message`, `docID`, `class`) VALUES ('$new_notification_id','$sender_notification_id','$receiver_notification_id','$msg','$id','notification-forwarded')";

if(mysqli_query($db, $query_to_forward)){
    if(mysqli_query($db, $query_new_notifiation)){
        //header("Location: " . $_SERVER['HTTP_REFERER']);
        //exit;
    } else {
        echo "notification : " . $db->error;
    }
} else {
    echo"update: " . $db->error;
}
?>