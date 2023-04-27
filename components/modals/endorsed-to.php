<div
    class="modal fade"
    id="statusToForwarded"
    tabindex="-1"
    aria-labelledby="statusToForwardedLabel"
    aria-hidden="true"
>
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="GET" action="./models/update/to-forward.php">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="statusToForwardedLabel">Forward to</h1>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body">
                    <label for="office" class="form-label">Office</label>
                    <select name="office" id="office" class="form-select">
                        <option selected disabled></option>
                        <?php foreach($all_offices as $office): ?>
                        <option value="<?php echo $office['office'] ?>">
                            <?php echo $office['office'] ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <input type="hidden" name="notification-to" value="<?php echo $sender_id ?>" />
                    <input type="hidden" name="document-id" value="<?php echo $id ?>" />
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
