<div class="mt-3">
    <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addDisability">
        Add Health Condition
    </button>
    <div class="modal fade" id="addDisability" tabindex="-1" aria-labelledby="addDisabilityLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Health Condition</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/actions.php" method="POST" onsubmit="return confirm('Are you sure you want to go ahead and add this health condition?');">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="add_disability">
                        <div class="mb-3">
                            <label for="disabilityName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="disabilityName" name="disabilityName" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="editSubmit" class="btn btn-primary">Add Health Condition</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <br />
    <div id="rowsText" class="d-inline align-text-middle">With Selected Row(s): </div>
    <button class="d-inline p-2 mb-3 btn btn-danger deleteRows" data-action="deletedisabilitys">Delete</button>
    <table id="disabilitiesTable" class="display wrap" style="width: 100%;">
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
                foreach ($disabilities as $disability) {
            ?>
                    <tr>
                        <td></td>
                        <td><?= $disability['id']; ?></td>
                        <td><?= $disability['name']; ?></td>
                        <td><?= $disability['created_full_name']; ?></td>
                        <td><?= $disability['created']; ?></td>
                        <td><?= $disability['modified_full_name']; ?></td>
                        <td><?= $disability['modified']; ?></td>
                        <td>
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editDisability<?= $disability['id']; ?>">Edit</button>
                        </td>
                    </tr>
                    <div class="modal fade" id="editDisability<?= $disability['id']; ?>" tabindex="-1" aria-labelledby="editDisability<?= $disability['id']; ?>Label" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Editing Health Condition: <?= $disability['id']; ?></h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="/actions.php" method="POST" onsubmit="return confirm('Are you sure you want to go ahead and edit this health condition?');">
                                    <div class="modal-body">
                                        <input type="hidden" name="action" value="edit_disability">
                                        <input type="hidden" name="disabilityId" value="<?= $disability['id']; ?>">
                                        <div class="mb-3">
                                            <label for="disabilityName" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="disabilityName" name="disabilityName" value="<?= $disability['name']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="editSubmit" class="btn btn-primary">Edit Health Condition</button>
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