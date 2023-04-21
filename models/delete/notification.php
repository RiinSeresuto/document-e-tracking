<?php
include("../../connection/db.php");

$id = $_GET['id'];

$query_delete_notification = "DELETE FROM `notification` WHERE `id` = '$id'";

if(mysqli_query($db, $query_delete_notification)){
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
} else {
    echo $db->error;
}
?>