<div
    class="modal fade"
    id="statusToReleased"
    tabindex="-1"
    aria-labelledby="statusToReleasedLabel"
    aria-hidden="true"
>
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="./models/update/to-released.php">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="statusToReleasedLabel">Released</h1>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body">
                    <label for="forward-to" class="form-label">Office</label>
                    <select name="forward-to" id="forward-to" class="form-select">
                        <option selected disabled></option>
                        <?php foreach($all_offices as $office): ?>
                        <option value="<?php echo $office['id'] ?>">
                            <?php echo $office['office'] ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <input type="hidden" name="doc-id" value="<?php echo $id; ?>">
                    <input type="hidden" name="uploader-id" value="<?php echo $sender_id; ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button name="submit-forward" type="submit" class="btn btn-info" value="true">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
