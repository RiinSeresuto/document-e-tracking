<?php
include("../../connection/db.php");

$timestamp = current_time();
$status = $_POST['status'];
$receiver = $_POST['to-office'];
$sender_id = $_SESSION['id'];
$document_id = $_POST['doc-id'];

$new_log_id = makeid();
$new_notification_id = makeid();

$is_recieved_status = 0;
$is_signed_status = 0;
$is_released_status = 0;
$class = "notification-" . $status;

if($status == "received"){
    $is_recieved_status = 1;
    $is_signed_status = 0;
    $is_released_status = 0;
} elseif($status == "endorsed"){
    $is_recieved_status = 0;
    $is_signed_status = 0;
    $is_released_status = 0;
} elseif($status == "released"){
    $is_recieved_status = 1;
    $is_signed_status = 1;
    $is_released_status = 1;    
} elseif($status == "returned"){
    $is_recieved_status = 0;
    $is_signed_status = 0;
    $is_released_status = 0;
} elseif($status == "signed"){
    $is_recieved_status = 1;
    $is_signed_status = 1;
    $is_released_status = 0;
} elseif($status == "approved"){
    $is_recieved_status = 1;
    $is_signed_status = 1;
    $is_released_status = 1;
}
?>

<p>Time: <?php echo $timestamp ?></p>
<p>Status: <?php echo $status ?></p>
<p>Receiver: <?php echo $receiver ?></p>
<p>Document: <?php echo $document_id ?></p>
<p>Received: <?php echo $is_recieved_status ?></p>
<p>Signed: <?php echo $is_signed_status ?></p>
<p>Released: <?php echo $is_released_status ?></p>

<?php

if($receiver != ""){
    echo "with content";
    $query_to_received = "UPDATE `document` SET `forID` = '$receiver', `status` = '$status', `dateUpdated` = '$timestamp', `isSent` = 1, `isReceived` = $is_recieved_status, `isSigned` = $is_signed_status, `isReleased` = $is_released_status WHERE `id` = '$document_id'";
} else {
    $query_to_received = "UPDATE `document` SET `status` = '$status', `dateUpdated` = '$timestamp', `isSent` = 1, `isReceived` = $is_recieved_status, `isSigned` = $is_signed_status, `isReleased` = $is_released_status WHERE `id` = '$document_id'";
}

$query_new_log = "INSERT INTO `log`(`id`, `documentID`, `date`, `status`, `updatedBy`, `forOffice`) VALUES ('$new_log_id','$document_id','$timestamp','$status','$sender_id', '$receiver')";
$query_new_notification = "INSERT INTO `notification`(`id`, `sender`, `receiver`, `message`, `docID`, `class`) VALUES ('$new_notification_id', '$sender_id', '$receiver', '$status', '$document_id', '$class')";

if(mysqli_query($db, $query_to_received)){
    if(mysqli_query($db, $query_new_log)){
        if(mysqli_query($db, $query_new_notification)){
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        } else {
            echo "Notification: " . $db->error;
        }
    } else {
        echo "Log: " . $db->error;
    }
} else {
    echo "Update: " . $db->error;
}
?>