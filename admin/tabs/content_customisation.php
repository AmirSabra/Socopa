<div class="mt-3">
    <table id="customisationsTable" class="display wrap" style="width: 100%;">
        <thead>
            <tr>
                <th></th>
                <th>ID</th>
                <th>Name</th>
                <th>Content</th>
                <th>Created</th>
                <th>Modified</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach ($customisations as $customisation) {
            ?>
                    <tr>
                        <td></td>
                        <td><?= $customisation['id']; ?></td>
                        <td><?= $customisation['name']; ?></td>
                        <td><?= $customisation['content']; ?></td>
                        <td><?= $customisation['created']; ?></td>
                        <td><?= $customisation['modified']; ?></td>
                        <td>
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editCustomisation<?= $customisation['id']; ?>">Edit</button>
                        </td>
                    </tr>
                    <div class="modal fade" id="editCustomisation<?= $customisation['id']; ?>" tabindex="-1" aria-labelledby="editcustomisation<?= $customisation['id']; ?>Label" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Editing Customisation: <?= $customisation['id']; ?></h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="/actions.php" method="POST" onsubmit="return confirm('Are you sure you want to go ahead and edit this customisation?');">
                                    <div class="modal-body">
                                        <input type="hidden" name="action" value="edit_customisation">
                                        <input type="hidden" name="customisationId" value="<?= $customisation['id']; ?>">
                                        <div class="mb-3">
                                            <label for="customisationContent" class="form-label">Content</label>
                                            <input type="text" class="form-control" id="customisationContent" name="customisationContent" value="<?= $customisation['content']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="editSubmit" class="btn btn-primary">Edit Customisation</button>
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
                <th>Content</th>
                <th>Created</th>
                <th>Modified</th>
                <th>Actions</th>
            </tr>
        </tfoot>
    </table>
</div>