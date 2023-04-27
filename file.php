<?php
$page_title = "File";

include("./connection/db.php");

$query_get_all_offices = "SELECT `office`, COUNT(*) FROM `users` GROUP BY `office`";
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

    $query_sender = "SELECT `firstName`, `lastName` FROM `users` WHERE `id` = '$sender_id'";
    $result_sender = mysqli_query($db, $query_sender);
    $sender = mysqli_fetch_assoc($result_sender);

    $query_receiver = "SELECT `firstName`, `lastName` FROM `users` WHERE `id` = '$receiver_id'";
    $result_receiver = mysqli_query($db, $query_receiver);
    $receiver = mysqli_fetch_assoc($result_receiver);
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
                            <a href="./storage/uploads/<?php echo$document['fileName'] ?>" class="btn btn-info">Download File</a>
                        </div>
                        <div class="file-info p-4">
                            <p class="mb-2"><strong>Filename:</strong> <?php echo $document['fileName'] ?></p>
                            <p class="mb-2"><strong>Status:</strong> <?php echo $document['status'] ?></p>
                            <p class="mb-2"><strong>Date Sent:</strong> <?php
                                if($document['dateSent'] != ""):
                                    echo date('F d, Y', strtotime($document['dateSent']));
                                endif;
                            ?> </p>
                            <p class="mb-2"><strong>Date Received:</strong> <?php 
                                if($document['dateReceived'] != ""):
                                    echo date('F d, Y', strtotime($document['dateReceived']));
                                endif;
                             ?></p>
                            <p class="mb-2"><strong>To:</strong> <?php echo $receiver['firstName'] . " " . $receiver['lastName'] ?></p>
                            <p class="m-0"><strong>From:</strong> <?php echo $sender['firstName'] . " " . $sender['lastName'] ?></p>
                        </div>
                    </section>

                    <section class="mb-5">
                        <h2>Actions</h2>
                        <div class="actions d-flex justify-content-between align-items-center">
                            <div class="timeline d-flex justify-content-between align-items-center">
                                <div class="line"></div>
                                <a href="./models/update/to-sent.php?id=<?php echo $id?>&receiver=<?php echo $receiver_id ?>&sender=<?php echo $sender_id ?>" class="py-2 px-3 status active">Sent</a>
                                <a href="./models/update/to-received.php?doc-id=<?php echo $id?>&receiver-id=<?php echo $sender_id ?>&sender-id=<?php echo $receiver_id ?>" class="py-2 px-3 status <?php if($document['isReceived']): echo "active"; endif; ?>">Received</a>
                                <button type="button" class="btn btn-primary py-2 px-3 status <?php if($document['isForwarded']): echo "active"; endif; ?>" data-bs-toggle="modal" data-bs-target="#statusToForwarded">
                                    Endorsed
                                </button>
                                <a href="./models/update/to-signed.php?doc-id=<?php echo $id?>&receiver-id=<?php echo $sender_id ?>&sender-id=<?php echo $login_id ?>" class="py-2 px-3 status <?php if($document['isSigned']): echo "active"; endif; ?>">Signed</a>
                                <a href="./models/update/to-released.php?id=<?php echo $id?>&receiver=<?php echo $sender_id ?>&sender=<?php echo $login_id ?>" class="py-2 px-3 status <?php if($document['isReleased']): echo "active"; endif; ?>">Released</a>
                                <a href="./models/update/to-approve.php?doc-id=<?php echo $id?>&receiver-id=<?php echo $sender_id ?>&sender-id=<?php echo $login_id ?>" class="py-2 px-3 status <?php if($document['isApproved']): echo "active"; endif; ?>">Approved</a>
                            </div>
                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#viewDocumentModal">
                                View Document
                            </button>

                            <div class="modal fade" id="viewDocumentModal" tabindex="-1" aria-labelledby="viewDocumentLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="viewDocumentLabel">
                                            Document
                                            <?php if(pathinfo($document['fileName'], PATHINFO_EXTENSION) == "docx" || pathinfo($document['fileName'], PATHINFO_EXTENSION) == "doc"): ?>
                                            Text Content
                                            <?php endif;?>
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <?php if(pathinfo($document['fileName'], PATHINFO_EXTENSION) == "pdf"){ ?>
                                            <!--<iframe src="./ViewerJs/#../../storage/uploads/<?php //echo $document['fileName'] ?>" width='100%' height='300'></iframe>-->
                                            <iframe src="./storage/uploads/<?php echo $document['fileName'] ?>" width='100%' height='300'></iframe>
                                        <?php } elseif(pathinfo($document['fileName'], PATHINFO_EXTENSION) == "docx" || pathinfo($document['fileName'], PATHINFO_EXTENSION) == "doc"){ ?>
                                            <iframe src="./models/read/doc.php?file=<?php echo $document['fileName']?>" width="100%" height='300' ></iframe>
                                        <?php }?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-info" data-bs-dismiss="modal">Close</button>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </main>
            <div class="modal fade" id="statusToForwarded" tabindex="-1" aria-labelledby="statusToForwardedLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="GET" action="./models/update/to-forward.php">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="statusToForwardedLabel">Forward to</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <label for="office" class="form-label">Office</label>
                                <select name="office" id="office" class="form-select">
                                    <option selected disabled></option>
                                    <?php foreach($all_offices as $office): ?>
                                        <option value="<?php echo $office['office'] ?>"><?php echo $office['office'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <input type="hidden" name="notification-to" value="<?php echo $sender_id ?>">
                                <input type="hidden" name="document-id" value="<?php echo $id ?>">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button name="submit-forward" type="submit" class="btn btn-info" value="true">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script src="./assets/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
