<div class="mt-3">
    <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addsignPost">
        Add Sign Post
    </button>
    <div class="modal fade" id="addsignPost" tabindex="-1" aria-labelledby="addsignPostLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Sign Post</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/actions.php" method="POST" onsubmit="return confirm('Are you sure you want to go ahead and add this sign post?');">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="add_sign_post">
                        <div class="mb-3">
                            <label for="signPostName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="signPostName" name="signPostName" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="editSubmit" class="btn btn-primary">Add Sign Post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <br />
    <div id="rowsText" class="d-inline align-text-middle">With Selected Row(s): </div>
    <button class="d-inline p-2 mb-3 btn btn-danger deleteRows" data-action="deletesignPosts">Delete</button>
    <table id="signPostTable" class="display wrap" style="width: 100%;">
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
                foreach ($signPosts as $signPost) {
            ?>
                    <tr>
                        <td></td>
                        <td><?= $signPost['id']; ?></td>
                        <td><?= $signPost['name']; ?></td>
                        <td><?= $signPost['created_full_name']; ?></td>
                        <td><?= $signPost['created']; ?></td>
                        <td><?= $signPost['modified_full_name']; ?></td>
                        <td><?= $signPost['modified']; ?></td>
                        <td>
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editsignPost<?= $signPost['id']; ?>">Edit</button>
                        </td>
                    </tr>
                    <div class="modal fade" id="editsignPost<?= $signPost['id']; ?>" tabindex="-1" aria-labelledby="editsignPost<?= $signPost['id']; ?>Label" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Editing Sign Post: <?= $signPost['id']; ?></h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="/actions.php" method="POST" onsubmit="return confirm('Are you sure you want to go ahead and edit this sign post?');">
                                    <div class="modal-body">
                                        <input type="hidden" name="action" value="edit_sign_post">
                                        <input type="hidden" name="signPostId" value="<?= $signPost['id']; ?>">
                                        <div class="mb-3">
                                            <label for="signPostName" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="signPostName" name="signPostName" value="<?= $signPost['name']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="editSubmit" class="btn btn-primary">Edit Sign Post</button>
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