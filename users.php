<?php
$page_title = "User";

include("./connection/db.php");

//check if someone was signed in
if(!isset($_SESSION['id'])){
    header("Location: ./signin.php");
    exit;
} elseif($_SESSION['isSuperAdmin'] != "1"){
    header("Location: ./");
    exit;
} else {
    if(isset($_POST['add'])){
        $id = makeid();
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $position = $_POST['position'];
        $office = $_POST['office'];
        $password = $_POST['password'];
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $query_add_user = "INSERT INTO `users`(`id`, `email`, `firstName`, `lastName`, `position`, `office`, `password`) VALUES ('$id','$email','$firstname','$lastname','$position','$office','$hashed_password')";
        
        mysqli_query($db, $query_add_user);
    }

    $query_get_all_users = "SELECT `firstName`, `lastName`, `position`, `office`, `email`, `superAdmin` FROM `users` ORDER BY `lastName`";
    $result_get_all_users = mysqli_query($db, $query_get_all_users);
    $all_users = mysqli_fetch_all($result_get_all_users, MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include("./components/head.php"); ?>
    </head>
    <body>
        <div class="col-lg-8 mx-auto">
            <main class="users py-5">
                <!--Start Breadcrumbs-->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="./">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Users</li>
                    </ol>
                </nav>
                <!--End Breadcrumbs-->
                <div class="d-flex justify-content-between align-items-center">
                    <h1>Users</h1>
                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#add-user-modal" >
                        Add User
                    </button>
                </div>

                <!--Start Table-->
                <table class="table table-info table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Position</th>
                            <th scope="col">Office</th>
                            <th scope="col">Email</th>
                            <th scope="col">Admin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($all_users as $user):?>
                            <tr>
                                <td><?php echo $user['lastName'] . ", " . $user['firstName'] ?></td>
                                <td><?php echo $user['position'] ?></td>
                                <td><?php echo $user['office'] ?></td>
                                <td><?php echo $user['email'] ?></td>
                                <td>To be followed...</td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
                <!--End Table-->

                <!-- Modal -->
                <div class="modal fade" id="add-user-modal" tabindex="-1" aria-labelledby="add-user-modal" aria-hidden="true" >
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="add-user-modal">
                                        New User Information
                                    </h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">First Name</label>
                                        <input type="text" name="firstname" id="firstname" class="form-control" required />
                                    </div>
                                    <div class="mb-3">
                                        <label for="lastname" class="form-label">Last Name</label>
                                        <input type="text" name="lastname" id="lastname" class="form-control" required />
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" name="email" id="email" class="form-control" required />
                                    </div>
                                    <div class="mb-3">
                                        <label for="position" class="form-label">Position</label>
                                        <input type="text" name="position" id="position" class="form-control" required />
                                    </div>
                                    <div class="mb-3">
                                        <label for="office" class="form-label">Office</label>
                                        <input type="text" name="office" id="office" class="form-control" required />
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" name="password" id="password" class="form-control" required />
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" >
                                        Cancel
                                    </button>
                                    <button name="add" type="submit" class="btn btn-info">Add User</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <script src="./assets/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
