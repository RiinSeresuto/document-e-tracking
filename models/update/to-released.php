<?php
include("../../connection/db.php");

$timestamp = current_time();
$sender_id = $_SESSION['id'];
$forward_id = $_POST['forward-to'];
$file_uploader_id = $_POST['uploader-id'];
$document_id = $_POST['doc-id'];

$endorse_reciever_notification_id = makeid();
$file_uploader_notification_id = makeid();
$log_id = makeid();

$message = "released";
$class = "notification-released";

$query_to_release = "UPDATE `document` SET `status` = 'released', `forID` = '$forward_id', `dateUpdated` = '$timestamp', `isSent` = 1, `isReceived` = 1, `isEndorsed` = 1, `isReleased` = 1, `isReturned` = 0, `isSigned` = 0, `isApproved` = 0 WHERE `id` = '$document_id'";
$query_release_receiver_notification = "INSERT INTO `notification`(`id`, `sender`, `receiver`, `message`, `docID`, `class`) VALUES ('$endorse_reciever_notification_id', '$sender_id', '$forward_id', '$message', '$document_id', '$class')";
$query_file_uploader_notification = "INSERT INTO `notification`(`id`, `sender`, `receiver`, `message`, `docID`, `class`) VALUES ('$file_uploader_notification_id', '$sender_id', '$file_uploader_id', '$message', '$document_id', '$class')";
$query_new_log = "INSERT INTO `log`(`id`, `documentID`, `date`, `status`, `updatedBy`, `forOffice`) VALUES ('$log_id','$document_id','$timestamp','released','$sender_id', '$forward_id')";
?>

<p>Sender ID: <?php echo $sender_id;?></p>
<p>Reciever ID: <?php echo $forward_id;?></p>
<p>Uploader ID: <?php echo $file_uploader_id;?></p>
<p>Timestamp: <?php echo $timestamp; ?></p>

<?php 
if(mysqli_query($db, $query_to_release)){
    if(mysqli_query($db, $query_release_receiver_notification)){
        if(mysqli_query($db, $query_file_uploader_notification)){
            if(mysqli_query($db, $query_new_log)){
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit;
            } else {
                echo "Log: " . $db->error;
            }
        } else {
            echo "Uploader Notification: " . $db->error;
        }
    } else {
        echo "Reciever Notification: " . $db->error;
    }
} else {
    echo "Update: " . $db->error;
}
?>