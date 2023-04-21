<?php
$page_title = "Notification";

include("./connection/db.php");

if(!isset($_SESSION['id'])){
    header("Location: ./signin.php");
    exit;
} else {
    $user_id = $_SESSION['id'];
    
    $query_get_notification = "SELECT `notification`.`id` as 'id', `notification`.`message`, `notification`.`class`, `users`.`firstName`, `users`.`lastName`, `document`.`fileName`, `document`.`office` FROM `notification` JOIN `users` ON `notification`.`sender` = `users`.`id` JOIN `document` ON `notification`.`docID` = `document`.`id` WHERE `receiver` = '$user_id' ORDER BY `notification`.`date` DESC";
    $result_get_notification = mysqli_query($db, $query_get_notification);
    $all_notifications = mysqli_fetch_all($result_get_notification, MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include("./components/head.php"); ?>
    </head>
    <body>
        <div class="col-lg-8 mx-auto">
            <main class="notification-window pt-5 pb-5">
                <!--Start Breadcrumbs-->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="./">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Notifications</li>
                    </ol>
                </nav>
                <!--End Breadcrumbs-->

                <h1>Notifications</h1>

                <div class="notification-list">
                    <?php foreach($all_notifications as $notification): ?>
                        <div class="notification-card <?php echo $notification['class'] ?> d-flex justify-content-between align-items-center p-3 my-3">
                            <div class="notification-icon">
                                <?php 
                                    if($notification['class'] === "notification-sent"){
                                        include("./assets/img/icons/mail-sent.php"); 
                                    } elseif ($notification['class'] === "notification-signed"){
                                        include("./assets/img/icons/sign.php");
                                    } elseif ($notification['class'] === "notification-released"){
                                        include("./assets/img/icons/check.php");
                                    } elseif ($notification['class'] === "notification-received"){
                                        include("./assets/img/icons/mail-check.php");
                                    } elseif ($notification['class'] === "notification-forwarded"){
                                        include("./assets/img/icons/mail-sent.php"); 
                                    }
                                ?>
                            </div>
                            <div class="notification-message"><?php
                                if($notification['class'] === "notification-sent"){
                                    echo $notification['fileName'] . " " . $notification['message'] . " " . $notification['firstName'] . " " . $notification['lastName'];
                                } elseif ($notification['class'] === "notification-signed"){
                                    echo $notification['fileName'] . " " . $notification['message'] . " by " . $notification['firstName'] . " " . $notification['lastName'];
                                } elseif ($notification['class'] === "notification-released"){
                                    echo $notification['fileName'] . " " . $notification['message'];
                                } elseif ($notification['class'] === "notification-received"){
                                    echo $notification['fileName'] . " " . $notification['message'] . " by " . $notification['firstName'] . " " . $notification['lastName'];
                                } elseif ($notification['class'] === "notification-forwarded"){
                                    echo $notification['fileName'] . " " . $notification['message'] . " " . $notification['office'] . " office";
                                }
                            ?>
                            </div>
                            <div class="notification-delete">
                                <a href="./models/delete/notification.php?id=<?php echo $notification['id'] ?>">
                                    <?php include("./assets/img/icons/trash.php"); ?>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div> 
            </main>
        </div>
        <script src="./assets/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
