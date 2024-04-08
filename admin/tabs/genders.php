<div class="mt-3">
    <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addgender">
        Add Gender
    </button>
    <div class="modal fade" id="addgender" tabindex="-1" aria-labelledby="addgenderLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Gender</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/actions.php" method="POST" onsubmit="return confirm('Are you sure you want to go ahead and add this gender?');">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="add_gender">
                        <div class="mb-3">
                            <label for="requestStatusName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="genderName" name="genderName" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="editSubmit" class="btn btn-primary">Add Gender</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <br />
    <div id="rowsText" class="d-inline align-text-middle">With Selected Row(s): </div>
    <button class="d-inline p-2 mb-3 btn btn-danger deleteRows" data-action="deletegenders">Delete</button>
    <table id="gendersTable" class="display wrap" style="width: 100%;">
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
                foreach ($genders as $gender) {
            ?>
                    <tr>
                        <td></td>
                        <td><?= $gender['id']; ?></td>
                        <td><?= $gender['name']; ?></td>
                        <td><?= $gender['created_full_name']; ?></td>
                        <td><?= $gender['created']; ?></td>
                        <td><?= $gender['modified_full_name']; ?></td>
                        <td><?= $gender['modified']; ?></td>
                        <td>
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editgender<?= $gender['id']; ?>">Edit</button>
                        </td>
                    </tr>
                    <div class="modal fade" id="editgender<?= $gender['id']; ?>" tabindex="-1" aria-labelledby="editgender<?= $gender['id']; ?>Label" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Editing gender: <?= $gender['id']; ?></h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="/actions.php" method="POST" onsubmit="return confirm('Are you sure you want to go ahead and edit this gender?');">
                                    <div class="modal-body">
                                        <input type="hidden" name="action" value="edit_gender">
                                        <input type="hidden" name="genderId" value="<?= $gender['id']; ?>">
                                        <div class="mb-3">
                                            <label for="genderName" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="genderName" name="genderName" value="<?= $gender['name']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="editSubmit" class="btn btn-primary">Edit Gender</button>
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