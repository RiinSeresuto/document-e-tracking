<?php
$page_title = "File";

include("./connection/db.php");

$query_get_all_offices = "SELECT * FROM `users`";
$result_get_all_offices = mysqli_query($db, $query_get_all_offices);
$all_offices = mysqli_fetch_all($result_get_all_offices, MYSQLI_ASSOC);

$login_id = $_SESSION['id'];

if(!isset($_SESSION['id'])){
    header("Location: ./signin.php");
    exit;
} else {
    $id = $_GET['id'];

    $query_document = "SELECT * FROM `document` WHERE `id` = '$id'";
    $result_document = mysqli_query($db, $query_document);
    $document = mysqli_fetch_assoc($result_document);

    $sender_id = $document['fromID'];
    $receiver_id = $document['forID'];

    $query_sender = "SELECT `position`, `office` FROM `users` WHERE `id` = '$sender_id'";
    $result_sender = mysqli_query($db, $query_sender);
    $sender = mysqli_fetch_assoc($result_sender);

    $query_receiver = "SELECT `position`, `office` FROM `users` WHERE `id` = '$receiver_id'";
    $result_receiver = mysqli_query($db, $query_receiver);
    $receiver = mysqli_fetch_assoc($result_receiver);

    $query_logs = "SELECT `log`.`date`, `log`.`status`, `sender`.`office` as sender, `receiver`.`office` as receiver FROM `log` LEFT JOIN `users` AS sender ON `sender`.`id` = `log`.`updatedBy` LEFT JOIN `users` as receiver ON `receiver`.`id` = `log`.`forOffice` WHERE `log`.`documentID` = '$id' ORDER BY  `log`.`date` DESC";
    $result_logs = mysqli_query($db, $query_logs);
    $logs = mysqli_fetch_all($result_logs, MYSQLI_ASSOC);

    $query_all_users = "SELECT * FROM `users`";
    $result_all_users = mysqli_query($db, $query_all_users);
    $all_users = mysqli_fetch_all($result_all_users, MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include("./components/head.php"); ?>
    </head>
    <body>
        <div class="col-lg-8 mx-auto">
            <main class="add-file pt-5 pb-5">
                <!--Start Breadcrumbs-->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="./">Home</a></li>
                        <li class="breadcrumb-item"><a href="./dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <?php echo $document['fileName'] ?>
                        </li>
                    </ol>
                </nav>
                <!--End Breadcrumbs-->

                <header class="d-flex justify-content-center align-items-center">
                    <?php if(pathinfo($document['fileName'], PATHINFO_EXTENSION) == "pdf"){ ?>
                        <img src="./assets/img/pdf-icon.png" alt="PDF Logo" />
                    <?php } elseif(pathinfo($document['fileName'], PATHINFO_EXTENSION) == "docx" || pathinfo($document['fileName'], PATHINFO_EXTENSION) == "doc"){ ?>
                        <img src="./assets/img/word-icon.png" alt="PDF Logo" />
                    <?php }?>
                    <h1 class="mb-0">Document Details</h1>
                </header>

                <div class="p-4">
                    <section class="mb-5">
                        <div class="d-flex justify-content-between align-items-center">
                            <h2>File Information</h2>

                            <div class="d-flex">
                                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#viewDocumentModal">
                                    View Document
                                </button>
                                <a href="./storage/uploads/<?php echo$document['fileName'] ?>" class="btn btn-info ms-3">Download File</a>
                            </div>
                        </div>
                        <div class="file-info p-4">
                            <p class="mb-2"><strong>Filename:</strong> <?php echo $document['fileName'] ?></p>
                            <p class="mb-4"><strong>Status:</strong> <?php echo $document['status'] ?></p>

                            <h6>UPDATES </h6>

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Date</th>
                                        <th scope="col">Time</th>
                                        <th scope="col">Update</th>
                                        <th scope="col">From</th>
                                        <th scope="col">To</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($logs as $log):?>
                                        <tr>
                                            <td><?php echo date('F d, Y', strtotime($log['date'])); ?></td>
                                            <td><?php echo date('h:ia', strtotime($log['date'])); ?></td>
                                            <td><?php echo $log['status'] ?></td>
                                            <td><?php echo $log['sender'] ?></td>
                                            <td><?php echo $log['receiver'] ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </section>

                    <?php if($document['forID'] === $login_id): ?>
                        <section class="mb-5">
                            <h2>Action</h2>
                            <form class="my-3" method="POST" action="./models/update/status-change.php">
                                <div class="row">
                                    <div class="col-5">
                                        <label for="status" class="form-label">Status</label>
                                        <select name="status" id="status" class="form-select" required>
                                            <option value="" selected disabled>-- Select Status --</option>
                                            <option value="received">Receive</option>
                                            <option value="endorsed">Endorse</option>
                                            <option value="released">Release</option>
                                            <option value="returned">Return</option>
                                            <option value="signed">Signed</option>
                                            <option value="approved">Approve</option>
                                        </select>
                                    </div>
                                    <div class="col-5">
                                        <label for="to-office" class="form-label">Office</label>
                                        <select name="to-office" id="to-office" class="form-select">
                                            <option selected value="">-- No Receiver -- </option>
                                            <?php foreach($all_users as $user): if($user['id'] != $login_id):?>
                                                <option value="<?php echo $user['id']?>"><?php echo $user['office'] ?></option>
                                            <?php endif; endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col d-flex justify-content-center align-items-end">
                                        <input type="hidden" name="doc-id" value="<?php echo $id?>">
                                        <div>
                                            <button type="submit" class="btn btn-primary">Change</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </section>
                    <?php endif;?>
                </div>
            </main>
            <?php include("./components/modals/view-document.php") ?>
            <?php include("./components/modals/endorsed-to.php"); ?>
            <?php include("./components/modals/modal-released.php"); ?>
            <?php include("./components/modals/modal-returned.php"); ?>
        </div>
        <script src="./assets/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
