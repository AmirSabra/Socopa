<div class="mt-3">
    <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addClientRequestOutcome">
        Add Client Request Outcome
    </button>
    <div class="modal fade" id="addClientRequestOutcome" tabindex="-1" aria-labelledby="addClientRequestOutcomeLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Client Request Outcome</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/actions.php" method="POST" onsubmit="return confirm('Are you sure you want to go ahead and add this client request outcome?');">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="add_client_request_outcome">
                        <div class="mb-3">
                            <label for="requestStatusName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="clientRequestOutcomeName" name="clientRequestOutcomeName" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="editSubmit" class="btn btn-primary">Add Client Request Outcome</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <br />
    <div id="rowsText" class="d-inline align-text-middle">With Selected Row(s): </div>
    <button class="d-inline p-2 mb-3 btn btn-danger deleteRows" data-action="deleteClientRequestOutcomes">Delete</button>
    <table id="clientRequestOutcomesTable" class="display wrap" style="width: 100%;">
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
                foreach ($clientRequestOutcomes as $clientRequestOutcome) {
            ?>
                    <tr>
                        <td></td>
                        <td><?= $clientRequestOutcome['id']; ?></td>
                        <td><?= $clientRequestOutcome['name']; ?></td>
                        <td><?= $clientRequestOutcome['created_full_name']; ?></td>
                        <td><?= $clientRequestOutcome['created']; ?></td>
                        <td><?= $clientRequestOutcome['modified_full_name']; ?></td>
                        <td><?= $clientRequestOutcome['modified']; ?></td>
                        <td>
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editClientRequestOutcome<?= $clientRequestOutcome['id']; ?>">Edit</button>
                        </td>
                    </tr>
                    <div class="modal fade" id="editClientRequestOutcome<?= $clientRequestOutcome['id']; ?>" tabindex="-1" aria-labelledby="editClientRequestOutcome<?= $clientRequestOutcome['id']; ?>Label" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Editing Client Request Outcome: <?= $clientRequestOutcome['id']; ?></h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="/actions.php" method="POST" onsubmit="return confirm('Are you sure you want to go ahead and edit this client request outcome?');">
                                    <div class="modal-body">
                                        <input type="hidden" name="action" value="edit_client_request_outcome">
                                        <input type="hidden" name="clientRequestOutcomeId" value="<?= $clientRequestOutcome['id']; ?>">
                                        <div class="mb-3">
                                            <label for="clientRequestOutcomeName" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="clientRequestOutcomeName" name="clientRequestOutcomeName" value="<?= $clientRequestOutcome['name']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="editSubmit" class="btn btn-primary">Edit Client Request Outcome</button>
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