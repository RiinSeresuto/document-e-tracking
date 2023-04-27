<?php
$page_title = "Edit";

include("./connection/db.php");

//check if someone was signed in
if(!isset($_SESSION['id'])){
    header("Location: ./signin.php");
    exit;
} else {
    $user_id = $_SESSION['id'];

    $get_user_data = "SELECT `email`, `position`, `office`, `password` FROM `users` WHERE `id` = '$user_id'";
    $result_user_data = mysqli_query($db, $get_user_data);
    $user_data = mysqli_fetch_assoc($result_user_data);

    if(isset($_POST['save'])){
        $email = $_POST['email'];
        $position = $_POST['position'];
        $office = $_POST['office'];

        if(!empty($_POST['password'])){
            $password = $_POST['password'];
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            $query_edit_profile = "UPDATE `users` SET `email`='$email',`position`='$position',`office`='$office',`password`='$hashed_password' WHERE `id` = '$user_id'";
        } else {
            $query_edit_profile = "UPDATE `users` SET `email`='$email',`position`='$position',`office`='$office' WHERE `id` = '$user_id'";
        }

        if(mysqli_query($db, $query_edit_profile)){
            session_destroy();

            header("Location: ./");
            exit();
        }
    }
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
                        <li class="breadcrumb-item"><a href="./profile.php">Profile</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
                <!--End Breadcrumbs-->

                <h3 class="page-heading">EDIT PROFILE</h3>

                <form method="POST" class="profile-info my-4 p-4">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="<?php echo $user_data['email'] ?>" />
                    </div>
                    <div class="mb-3">
                        <label for="position" class="form-label">Position</label>
                        <input type="text" name="position" id="position" class="form-control" value="<?php echo $user_data['position'] ?>" />
                    </div>
                    <div class="mb-3">
                        <label for="office" class="form-label">Office</label>
                        <input type="text" name="office" id="office" class="form-control" value="<?php echo $user_data['office'] ?>" />
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" name="password" id="password" class="form-control" />
                    </div>
                    <button name="save" type="submit" class="btn btn-info">Save</button>
                </form>
            </main>
        </div>

        <script src="./assets/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
