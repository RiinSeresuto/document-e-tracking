<?php
$page_title = "Dashboard";

include("./connection/db.php");

if(!isset($_SESSION['id'])){
    header("Location: ./signin.php");
    exit;
} else {
    $query_all_documents = "SELECT * FROM `document`";
    $result_all_documents = mysqli_query($db, $query_all_documents);
    $all_documents = mysqli_fetch_all($result_all_documents, MYSQLI_ASSOC);

    $query_count_incoming_document = "SELECT * from `document` WHERE `isSent` = 1 AND `isReceived` = 0 AND `isSigned` = 0 AND `isReleased` = 0";
    $result_count_incoming_document = mysqli_query($db, $query_count_incoming_document);

    $query_count_pending_document = "SELECT * from `document` WHERE `isSent` = 1 AND `isReceived` = 1 AND `isSigned` = 1 AND `isReleased` = 0";
    $result_count_pending_document = mysqli_query($db, $query_count_pending_document);

    $query_count_recieved_document = "SELECT * from `document` WHERE `isSent` = 1 AND `isReceived` = 1 AND `isSigned` = 0 AND `isReleased` = 0";
    $result_count_recieved_document = mysqli_query($db, $query_count_recieved_document);
    //print_r($count_incoming_document);
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include("./components/head.php"); ?>
    </head>
    <body>
        <div class="col-lg-8 mx-auto">
            <main class="dashboard pt-5 pb-5">
                <!--Start Breadcrumbs-->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="./">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </nav>
                <!--End Breadcrumbs-->

                <h3 class="page-heading">DASHBOARD</h3>

                <!--Start Cards-->
                <div class="row">
                    <div class="col-4">
                        <div class="count-card card1">
                            <h2 class="count-card-title title1">Incoming Documents</h2>
                            <!--Status: Sent-->
                            <p class="count mb-0 count1"><?php echo mysqli_num_rows($result_count_incoming_document); ?></p>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="count-card card2">
                            <h2 class="count-card-title title2">Pending Documents</h2>
                            <!--Status: Signed && !Released-->
                            <p class="count mb-0 count2"><?php echo mysqli_num_rows($result_count_pending_document); ?></p>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="count-card card3">
                            <h2 class="count-card-title title3">Recieved Documents</h2>
                            <p class="count mb-0 count3"><?php echo mysqli_num_rows($result_count_recieved_document); ?></p>
                        </div>
                    </div>
                </div>
                <!--End Cards-->

                <h4 class="mt-5 mb-2">Sent Files</h4>

                <!--Start Table-->
                <table class="table table-info table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Type</th>
                            <th scope="col">Status</th>
                            <th scope="col">Office</th>
                            <th scope="col">Date Submitted</th>
                            <th scope="col">Date Recieved</th>
                            <th scope="col">File</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($all_documents as $document): ?>

                            <tr>
                                <td><?php echo $document['type'] ?></td>
                                <td><?php echo $document['status'] ?></td>
                                <td><?php echo $document['office'] ?></td>
                                <td><?php 
                                    if($document['dateSent'] != ""):
                                        echo date('F d, Y', strtotime($document['dateSent']));
                                    endif;
                                ?></td>
                                <td><?php 
                                    if($document['dateReceived'] != ""):
                                        echo date('F d, Y', strtotime($document['dateReceived']));
                                    endif;
                                ?></td>
                                <td>
                                    <a href="./file.php?id=<?php echo $document['id'] ?>"><?php echo $document['fileName'] ?></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <!--End Table-->
            </main>
        </div>
        <script src="./assets/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
