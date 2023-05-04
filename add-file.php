<?php
$page_title = "Add File";

include("./connection/db.php");

//check if someone was signed in
if(!isset($_SESSION['id'])){
    header("Location: ./signin.php");
    exit;
} else {
    $query_get_all_users = "SELECT `id`, `position`, `office` FROM `users`";
    $result_get_all_users = mysqli_query($db, $query_get_all_users);
    $all_users = mysqli_fetch_all($result_get_all_users, MYSQLI_ASSOC);

    $query_get_all_offices = "SELECT `office`, COUNT(*) FROM `users` GROUP BY `office`";
    $result_get_all_offices = mysqli_query($db, $query_get_all_offices);
    $all_offices = mysqli_fetch_all($result_get_all_offices, MYSQLI_ASSOC);

    if(isset($_POST['upload'])){
        $fileName = $_FILES['file']['name'];
        $fileType = $_FILES['file']['type'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];

        $uploadPath = './storage/uploads/';
        $newFileName = uniqid() . '_' . $fileName;
        $uploadFilePath = $uploadPath . $newFileName;
        move_uploaded_file($fileTmpName, $uploadFilePath);

        $upload_id = makeid();
        $notification_id = makeid();
        $log_id = makeid();
        $type = $_POST['type'];
        $forwardto = $_POST['forward-to'];
        $from = $_SESSION['id'];
        $notification_msg = "document uploaded";

        $query_upload_file = "INSERT INTO `document`(`id`, `type`, `fileName`, `forID`, `fromID`) VALUES ('$upload_id','$type','$newFileName','$forwardto','$from')";
        $query_add_notofication = "INSERT INTO `notification`(`id`, `sender`, `receiver`,`docID`, `class`, `message`) VALUES ('$notification_id','$from','$forwardto','$upload_id','notification-sent','$notification_msg')";
        $query_add_log = "INSERT INTO `log`(`id`, `documentID`, `status`, `updatedBy`, `forOffice`) VALUES ('$log_id', '$upload_id', 'sent', '$from', '$forwardto')";


        if(mysqli_query($db, $query_upload_file)){
            if(mysqli_query($db, $query_add_notofication)){
                if(mysqli_query($db, $query_add_log)){
                    $uploaded = "File Uploaded";
                } else {
                    echo "Log not saved: " . $db->error;
                }
            } else {
                echo "Notification not sent: " . $db->error;
            }
        } else {
            echo "Document record not saved: " . $db->error;
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
            <main class="add-file pt-5 pb-5">
                <!--Start Breadcrumbs-->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="./">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add File</li>
                    </ol>
                </nav>
                <!--End Breadcrumbs-->

                <h3 class="page-heading mb-5">ADD FILE</h3>

                <?php if(isset($uploaded)): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo $uploaded; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label for="type" class="form-label">Select document type</label>
                        <select name="type" id="type" class="form-select" required>
                            <option selected disabled></option>
                            <option value="MOA">MOA</option>
                            <option value="Project Proposal">Project Proposal</option>
                            <option value="Training Designs">Training Designs</option>
                            <option value="Annual Operational Plans">
                                Annual Operational Plans
                            </option>
                            <option value="Quarterly Operational Plans">
                                Quarterly Operational Plans
                            </option>
                            <option value="Work and Financial Plans">
                                Work and Financial Plans
                            </option>
                            <option value="Others">Others</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col mb-4">
                            <label for="forward-to" class="form-label">Forward to</label>
                            <select name="forward-to" id="forward-to" class="form-select" required>
                                <option selected disabled></option>
                                <?php foreach($all_users as $user): ?>
                                    <?php if($user['id'] != $_SESSION['id']): ?>
                                        <option value="<?php echo $user['id'] ?>"><?php echo $user['office']?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="file" class="form-label">File</label>
                        <input type="file" name="file" id="file" class="form-control" accept=".pdf, .doc, .docx" required />
                    </div>
                    <div class="col">
                        <button name="upload" type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </main>
        </div>

        <script src="./assets/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
