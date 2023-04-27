<div
    class="modal fade"
    id="viewDocumentModal"
    tabindex="-1"
    aria-labelledby="viewDocumentLabel"
    aria-hidden="true"
>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="viewDocumentLabel">
                    Document
                    <?php if(pathinfo($document['fileName'], PATHINFO_EXTENSION) == "docx" || pathinfo($document['fileName'], PATHINFO_EXTENSION) == "doc"): ?>
                    Text Content
                    <?php endif;?>
                </h1>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <div class="modal-body">
                <?php if(pathinfo($document['fileName'], PATHINFO_EXTENSION) == "pdf"){ ?>
                <!--<iframe src="./ViewerJs/#../../storage/uploads/<?php //echo $document['fileName'] ?>" width='100%' height='300'></iframe>-->
                <iframe
                    src="./storage/uploads/<?php echo $document['fileName'] ?>"
                    width="100%"
                    height="300"
                ></iframe>
                <?php } elseif(pathinfo($document['fileName'], PATHINFO_EXTENSION) == "docx" || pathinfo($document['fileName'], PATHINFO_EXTENSION) == "doc"){ ?>
                <iframe
                    src="./models/read/doc.php?file=<?php echo $document['fileName']?>"
                    width="100%"
                    height="300"
                ></iframe>
                <?php }?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
