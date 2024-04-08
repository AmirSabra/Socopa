<div class="mt-3">
    <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addAge">
        Add Age
    </button>
    <div class="modal fade" id="addAge" tabindex="-1" aria-labelledby="addAgeLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Age</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/actions.php" method="POST" onsubmit="return confirm('Are you sure you want to go ahead and add this age?');">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="add_age">
                        <div class="mb-3">
                            <label for="ageName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="ageName" name="ageName" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="editSubmit" class="btn btn-primary">Add Age</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <br />
    <div id="rowsText" class="d-inline align-text-middle">With Selected Row(s): </div>
    <button class="d-inline p-2 mb-3 btn btn-danger deleteRows" data-action="deleteAges">Delete</button>
    <table id="agesTable" class="display wrap" style="width: 100%;">
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
                foreach ($ages as $age) {
            ?>
                    <tr>
                        <td></td>
                        <td><?= $age['id']; ?></td>
                        <td><?= $age['name']; ?></td>
                        <td><?= $age['created_full_name']; ?></td>
                        <td><?= $age['created']; ?></td>
                        <td><?= $age['modified_full_name']; ?></td>
                        <td><?= $age['modified']; ?></td>
                        <td>
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editAge<?= $age['id']; ?>">Edit</button>
                        </td>
                    </tr>
                    <div class="modal fade" id="editAge<?= $age['id']; ?>" tabindex="-1" aria-labelledby="editAge<?= $age['id']; ?>Label" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Editing gender: <?= $age['id']; ?></h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="/actions.php" method="POST" onsubmit="return confirm('Are you sure you want to go ahead and edit this age?');">
                                    <div class="modal-body">
                                        <input type="hidden" name="action" value="edit_age">
                                        <input type="hidden" name="ageId" value="<?= $age['id']; ?>">
                                        <div class="mb-3">
                                            <label for="ageName" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="ageName" name="ageName" value="<?= $age['name']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="editSubmit" class="btn btn-primary">Edit Age</button>
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