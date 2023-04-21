<?php
$page_title = "Profile";

include("./connection/db.php");

//check if someone was signed in
if(!isset($_SESSION['id'])){
    header("Location: ./signin.php");
    exit;
} else {
    $user_id = $_SESSION['id'];

    $get_user_data = "SELECT `email`, `firstName`, `lastName`, `position`, `office` FROM `users` WHERE `id` = '$user_id'";
    $result_user_data = mysqli_query($db, $get_user_data);
    $user_data = mysqli_fetch_assoc($result_user_data);
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include("./components/head.php"); ?>
    </head>
    <body>
        <div class="col-lg-8 mx-auto">
            <main class="profile py-5">
                <!--Start Breadcrumbs-->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="./">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Profile</li>
                    </ol>
                </nav>
                <!--End Breadcrumbs-->

                <h3 class="page-heading">PROFILE</h3>

                <div class="profile-info my-4 p-4">
                    <p class="mb-3"><strong>Name:</strong> <?php echo $user_data['firstName'] . " " . $user_data['lastName'] ?></p>
                    <p class="mb-3"><strong>Email:</strong> <?php echo $user_data['email'] ?></p>
                    <p class="mb-3"><strong>Position:</strong> <?php echo $user_data['position'] ?></p>
                    <p class="mb-0"><strong>Office:</strong> <?php echo $user_data['office'] ?></p>
                </div>

                <a href="./edit-profile.php" class="btn btn-info">Edit</a>
            </main>
        </div>

        <script src="./assets/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
