<div class="mt-3">
    <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addEmploymentStatus">
        Add Employment Status
    </button>
    <div class="modal fade" id="addEmploymentStatus" tabindex="-1" aria-labelledby="addEmploymentStatusLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Employment Status</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/actions.php" method="POST" onsubmit="return confirm('Are you sure you want to go ahead and add this employment status?');">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="add_employment_status">
                        <div class="mb-3">
                            <label for="employmentStatusName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="employmentStatusName" name="employmentStatusName" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="editSubmit" class="btn btn-primary">Add Employment Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <br />
    <div id="rowsText" class="d-inline align-text-middle">With Selected Row(s): </div>
    <button class="d-inline p-2 mb-3 btn btn-danger deleteRows" data-action="deleteemploymentStatuss">Delete</button>
    <table id="employmentStatusesTable" class="display wrap" style="width: 100%;">
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
                foreach ($employmentStatuses as $employmentStatus) {
            ?>
                    <tr>
                        <td></td>
                        <td><?= $employmentStatus['id']; ?></td>
                        <td><?= $employmentStatus['name']; ?></td>
                        <td><?= $employmentStatus['created_full_name']; ?></td>
                        <td><?= $employmentStatus['created']; ?></td>
                        <td><?= $employmentStatus['modified_full_name']; ?></td>
                        <td><?= $employmentStatus['modified']; ?></td>
                        <td>
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editEmploymentStatus<?= $employmentStatus['id']; ?>">Edit</button>
                        </td>
                    </tr>
                    <div class="modal fade" id="editEmploymentStatus<?= $employmentStatus['id']; ?>" tabindex="-1" aria-labelledby="editEmploymentStatus<?= $employmentStatus['id']; ?>Label" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Editing Employment Status: <?= $employmentStatus['id']; ?></h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="/actions.php" method="POST" onsubmit="return confirm('Are you sure you want to go ahead and edit this employment status?');">
                                    <div class="modal-body">
                                        <input type="hidden" name="action" value="edit_employment_status">
                                        <input type="hidden" name="employmentStatusId" value="<?= $employmentStatus['id']; ?>">
                                        <div class="mb-3">
                                            <label for="employmentStatusName" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="employmentStatusName" name="employmentStatusName" value="<?= $employmentStatus['name']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="editSubmit" class="btn btn-primary">Edit Employment Status</button>
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