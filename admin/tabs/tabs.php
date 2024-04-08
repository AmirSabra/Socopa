<div class="mt-3">
    <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addTab">
        Add Tab
    </button>
    <div class="modal fade" id="addTab" tabindex="-1" aria-labelledby="addTabLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Tab</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/actions.php" method="POST" onsubmit="return confirm('Are you sure you want to go ahead and add this tab?');">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="add_tab">
                        <div class="mb-3">
                            <label for="tabName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="tabName" name="tabName" required>
                        </div>
                        <div class="mb-3">
                            <label for="tabFieldId" class="form-label">Tab Field ID</label>
                            <input type="text" class="form-control" id="tabFieldId" name="tabFieldId" required>
                        </div>
                        <div class="mb-3">
                            <label for="contentFileName" class="form-label">Content File Name</label>
                            <input type="text" class="form-control" id="contentFileName" name="contentFileName" required>
                        </div>
                        <div class="mb-3">
                            <label for="contentFieldId" class="form-label">Content Field ID</label>
                            <input type="text" class="form-control" id="contentFieldId" name="contentFieldId" required>
                        </div>
                        <div class="mb-3">
                            <label for="tabOrder" class="form-label">Order</label>
                            <input type="number" class="form-control" id="tabOrder" name="tabOrder" min="1" steps="1" value="<?= $nextTabOrder; ?>" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="editSubmit" class="btn btn-primary">Add Tab</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <br />
    <div id="rowsText" class="d-inline align-text-middle">With Selected Row(s): </div>
    <button class="d-inline p-2 mb-3 btn btn-danger deleteRows" data-action="deleteTabs">Delete</button>
    <table id="tabsTable" class="display wrap" style="width: 100%;">
        <thead>
            <tr>
                <th></th>
                <th>ID</th>
                <th>Name</th>
                <th>Field ID</th>
                <th>Content File Name</th>
                <th>Content Field ID</th>
                <th>Order</th>
                <th>Created By</th>
                <th>Created</th>
                <th>Modified By</th>
                <th>Modified</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach ($tabs as $tab) {
            ?>
                    <tr>
                        <td></td>
                        <td><?= $tab['id']; ?></td>
                        <td><?= $tab['name']; ?></td>
                        <td><?= $tab['field_id']; ?></td>
                        <td><?= $tab['content_file_name']; ?></td>
                        <td><?= $tab['content_field_id']; ?></td>
                        <td><?= $tab['display_order']; ?></td>
                        <td><?= $tab['created_full_name']; ?></td>
                        <td><?= $tab['created']; ?></td>
                        <td><?= $tab['modified_full_name']; ?></td>
                        <td><?= $tab['modified']; ?></td>
                        <td>
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editTab<?= $tab['id']; ?>">Edit</button>
                        </td>
                    </tr>
                    <div class="modal fade" id="editTab<?= $tab['id']; ?>" tabindex="-1" aria-labelledby="editTab<?= $tab['id']; ?>Label" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Editing Tab: <?= $tab['id']; ?></h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="/actions.php" method="POST" onsubmit="return confirm('Are you sure you want to go ahead and edit this tab?');">
                                    <div class="modal-body">
                                        <input type="hidden" name="action" value="edit_tab">
                                        <input type="hidden" name="tabId" value="<?= $tab['id']; ?>">
                                        <div class="mb-3">
                                            <label for="tabName" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="tabName" name="tabName" value="<?= $tab['name']; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="tabFieldId" class="form-label">Tab Field ID</label>
                                            <input type="text" class="form-control" id="tabFieldId" name="tabFieldId" value="<?= $tab['field_id']; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="contentFileName" class="form-label">Content File Name</label>
                                            <input type="text" class="form-control" id="contentFileName" name="contentFileName" value="<?= $tab['content_file_name']; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="contentFieldId" class="form-label">Content Field ID</label>
                                            <input type="text" class="form-control" id="contentFieldId" name="contentFieldId" value="<?= $tab['content_field_id']; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="tabOrder" class="form-label">Order</label>
                                            <input type="number" class="form-control" id="tabOrder" name="tabOrder" min="1" steps="1" value="<?=$tab['display_order']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="editSubmit" class="btn btn-primary">Edit Tab</button>
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
                <th>Field ID</th>
                <th>Content File Name</th>
                <th>Content Field ID</th>
                <th>Order</th>
                <th>Created By</th>
                <th>Created</th>
                <th>Modified By</th>
                <th>Modified</th>
                <th>Actions</th>
            </tr>
        </tfoot>
    </table>
</div>