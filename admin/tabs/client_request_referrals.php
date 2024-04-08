<div class="mt-3">
    <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addClientRequestReferral">
        Add Client Request Referral
    </button>
    <div class="modal fade" id="addClientRequestReferral" tabindex="-1" aria-labelledby="addClientRequestReferralLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Client Request Referral</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/actions.php" method="POST" onsubmit="return confirm('Are you sure you want to go ahead and add this client Referral?');">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="add_client_request_referral">
                        <div class="mb-3">
                            <label for="requestStatusName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="clientRequestReferralName" name="clientRequestReferralName" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="editSubmit" class="btn btn-primary">Add Client Request Referral</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <br />
    <div id="rowsText" class="d-inline align-text-middle">With Selected Row(s): </div>
    <button class="d-inline p-2 mb-3 btn btn-danger deleteRows" data-action="deleteClientRequestReferrals">Delete</button>
    <table id="clientRequestReferralsTable" class="display wrap" style="width: 100%;">
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
                foreach ($clientRequestReferrals as $clientRequestReferral) {
            ?>
                    <tr>
                        <td></td>
                        <td><?= $clientRequestReferral['id']; ?></td>
                        <td><?= $clientRequestReferral['name']; ?></td>
                        <td><?= $clientRequestReferral['created_full_name']; ?></td>
                        <td><?= $clientRequestReferral['created']; ?></td>
                        <td><?= $clientRequestReferral['modified_full_name']; ?></td>
                        <td><?= $clientRequestReferral['modified']; ?></td>
                        <td>
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editClientRequestReferral<?= $clientRequestReferral['id']; ?>">Edit</button>
                        </td>
                    </tr>
                    <div class="modal fade" id="editClientRequestReferral<?= $clientRequestReferral['id']; ?>" tabindex="-1" aria-labelledby="editClientRequestReferral<?= $clientRequestReferral['id']; ?>Label" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Editing Client Request Referral: <?= $clientRequestReferral['id']; ?></h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="/actions.php" method="POST" onsubmit="return confirm('Are you sure you want to go ahead and edit this client Referral?');">
                                    <div class="modal-body">
                                        <input type="hidden" name="action" value="edit_client_request_referral">
                                        <input type="hidden" name="clientRequestReferralId" value="<?= $clientRequestReferral['id']; ?>">
                                        <div class="mb-3">
                                            <label for="clientRequestReferralName" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="clientRequestReferralName" name="clientRequestReferralName" value="<?= $clientRequestReferral['name']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="editSubmit" class="btn btn-primary">Edit Client Request Referral</button>
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