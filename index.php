<?php
$page_title = "Home";

session_start();

//check if someone was signed in
if(!isset($_SESSION['id'])){
    header("Location: ./signin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include("./components/head.php"); ?>
    </head>
    <body>
        <main class="col-lg-8 mx-auto">
            <div class="home d-flex justify-content-center align-items-center">
                <div class="col-8">
                    <h4 class="page-heading text-center mb-3">HOME</h4>
                    <h1 class="page-heading text-center mb-0">E-TRACK MO</h1>
                    <h5 class="page-heading text-center mb-5">Document Tracking &amp; Monitoring System</h5>
                    <div class="row mb-4">
                        <div class="col">
                            <a href="./dashboard.php" class="card-link">
                                <div class="card-button d-flex justify-content-center align-items-center p-3">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="card-icon me-4">
                                            <?php include("./assets/img/icons/dashboard.php") ?>
                                        </div>
                                        <div class="card-caption">
                                            <strong>DASHBOARD</strong>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col">
                            <a href="./add-file.php" class="card-link">
                                <div class="card-button d-flex justify-content-center align-items-center p-3">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="card-icon me-4">
                                            <?php include("./assets/img/icons/upload.php") ?>
                                        </div>
                                        <div class="card-caption">
                                            <strong>ADD FILE</strong>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col">
                            <a href="./notification.php" class="card-link">
                                <div class="card-button d-flex justify-content-center align-items-center p-3">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="card-icon me-4">
                                            <?php include("./assets/img/icons/bell.php") ?>
                                        </div>
                                        <div class="card-caption">
                                            <strong>NOTIFICATION</strong>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="./profile.php" class="card-link">
                                <div class="card-button d-flex justify-content-center align-items-center p-3">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="card-icon me-4">
                                            <?php include("./assets/img/icons/person.php") ?>
                                        </div>
                                        <div class="card-caption"><strong>PROFILE</strong></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <?php if($_SESSION['isSuperAdmin'] === "1"): ?>
                            <div class="col">
                                <a href="./users.php" class="card-link">
                                    <div class="card-button d-flex justify-content-center align-items-center p-3">
                                        <div class="card-body"><strong>USERS</strong></div>
                                    </div>
                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="col">
                            <a href="./connection/logout.php" class="card-link">
                                <div class="card-button d-flex justify-content-center align-items-center p-3" >
                                    <div class="card-body"><strong>SIGN OUT</strong></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <script src="./assets/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
