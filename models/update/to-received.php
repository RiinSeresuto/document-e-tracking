<?php
include("../../connection/db.php");

$timestamp = current_time();
$sender_id = $_SESSION['id'];
$receiver_id = $_GET['rec-id'];
$document_id = $_GET['doc-id'];

$new_notification_id = makeid();
$message = "is received";
$class = "notification-received";

$new_log_id = makeid();

$query_to_received = "UPDATE `document` SET `status` = 'received', `dateUpdated` = '$timestamp', `isSent` = 1, `isReceived` = 1, `isEndorsed` = 0, `isReleased` = 0, `isReturned` = 0, `isSigned` = 0, `isApproved` = 0 WHERE `id` = '$document_id'";
$query_new_notification = "INSERT INTO `notification`(`id`, `sender`, `receiver`, `message`, `docID`, `class`) VALUES ('$new_notification_id', '$sender_id', '$receiver_id', '$message', '$document_id', '$class')";
$query_new_log = "INSERT INTO `log`(`id`, `documentID`, `date`, `status`, `updatedBy`) VALUES ('$new_log_id','$document_id','$timestamp','received','$sender_id')";

if(mysqli_query($db, $query_to_received)){
    if(mysqli_query($db, $query_new_notification)){
        if(mysqli_query($db, $query_new_log)){
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        } else {
            echo "log error: " . $db->error;
        }
    } else {
        echo "notification error: " . $db->error;
    }
} else {
    echo "update error: " . $db->error;
}
?>