<?php
$id = $_GET['id'];

include("../../connection/db.php");

$query_to_received = "UPDATE `document` SET `status` = 'sent', `dateReceived` = NULL, `isSigned` = '1', `isReceived` = '0', `isSigned` = '0', `isReleased` = '0' WHERE `document`.`id` = '$id'";

if(mysqli_query($db, $query_to_received)){
    echo "updated";
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}
?>