<div class="mt-3">
    <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addclientRequestReasons">
        Add Client Request Reason
    </button>
    <div class="modal fade" id="addclientRequestReasons" tabindex="-1" aria-labelledby="addclientRequestReasonsLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Client Request Reason</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/actions.php" method="POST" onsubmit="return confirm('Are you sure you want to go ahead and add this client request reason?');">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="add_client_request_reason">
                        <div class="mb-3">
                            <label for="clientRequestReasonName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="clientRequestReasonName" name="clientRequestReasonName" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="editSubmit" class="btn btn-primary">Add Client Request Reason</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <br />
    <div id="rowsText" class="d-inline align-text-middle">With Selected Row(s): </div>
    <button class="d-inline p-2 mb-3 btn btn-danger deleteRows" data-action="deleteclientRequestReasonss">Delete</button>
    <table id="clientRequestReasonsTable" class="display wrap" style="width: 100%;">
        <thead>
            <tr>
                <th></th>
                <th>ID</th>
                <th>Name</th>
                <th>Created By</th>
                <th>Created</th>
                <th>Modified By</th>
                <th>Modified</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach ($clientRequestReasons as $clientRequestReasons) {
            ?>
                    <tr>
                        <td></td>
                        <td><?= $clientRequestReasons['id']; ?></td>
                        <td><?= $clientRequestReasons['name']; ?></td>
                        <td><?= $clientRequestReasons['created_full_name']; ?></td>
                        <td><?= $clientRequestReasons['created']; ?></td>
                        <td><?= $clientRequestReasons['modified_full_name']; ?></td>
                        <td><?= $clientRequestReasons['modified']; ?></td>
                        <td>
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editclientRequestReasons<?= $clientRequestReasons['id']; ?>">Edit</button>
                        </td>
                    </tr>
                    <div class="modal fade" id="editclientRequestReasons<?= $clientRequestReasons['id']; ?>" tabindex="-1" aria-labelledby="editclientRequestReasons<?= $clientRequestReasons['id']; ?>Label" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Editing Client Request Reason: <?= $clientRequestReasons['id']; ?></h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="/actions.php" method="POST" onsubmit="return confirm('Are you sure you want to go ahead and edit this client request reason?');">
                                    <div class="modal-body">
                                        <input type="hidden" name="action" value="edit_client_request_reason">
                                        <input type="hidden" name="clientRequestReasonId" value="<?= $clientRequestReasons['id']; ?>">
                                        <div class="mb-3">
                                            <label for="clientRequestReasonName" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="clientRequestReasonName" name="clientRequestReasonName" value="<?= $clientRequestReasons['name']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="editSubmit" class="btn btn-primary">Edit Client Request Reason</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
            <?php } ?>
        </tbody>
        <tfoot>
            <tr>
            <th></th>
                <th>ID</th>
                <th>Name</th>
                <th>Created By</th>
                <th>Created</th>
                <th>Modified By</th>
                <th>Modified</th>
                <th>Actions</th>
            </tr>
        </tfoot>
    </table>
</div>