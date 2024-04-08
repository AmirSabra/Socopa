<?php
    $pageHeading = "Users";
    include_once('../templates/layout/header_admin.php');
    include_once('../controller_new.php');
    $controller = New Controller();
    $users = $controller->getAllUsers();
    $userStatuses = $controller->getAllUserStatuses();
    $userRoles = $controller->getAllUserRoles();
    /*include_once('../controller.php');
    $controller = New Controller();
    $requestTypes = $controller->getAllRequestTypes();
    $requestStatuses = $controller->getAllRequestStatuses();
    $requestRejectionReasons = $controller->getAllRequestRejectionReasons();*/
    session_start();
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == '') {
        header('location:/login.php');
    }
    if (isset($_SESSION['message_success']) && $_SESSION['message_success'] != '') {
        echo $_SESSION['message_success'];
        unset($_SESSION['message_success']);
    }
    if (isset($_SESSION['message_exists']) && $_SESSION['message_exists'] != '') {
        echo $_SESSION['message_exists'];
        unset($_SESSION['message_exists']);
    }
    if (isset($_SESSION['message_error']) && $_SESSION['message_error'] != '') {
        echo $_SESSION['message_error'];
        unset($_SESSION['message_error']);
    }
?>
    <div class="card">
        <div class="card-header">
            All Users (If Viewing On Phone Or Tablet, Click + Or - Respectively To Expand Or Collapse Rows)
        </div>
        <div class="card-body">
            <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addUser">
                Add User
            </button>
            <div class="modal fade" id="addUser" tabindex="-1" aria-labelledby="addUserLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Add User</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="/actions.php" method="POST" onsubmit="return confirm('Are you sure you want to go ahead and add this user?');">
                            <div class="modal-body">
                                <input type="hidden" name="action" value="add_user">
                                <div class="row">
                                    <div class="col-md-6 col-lg-6 col-xs-12">
                                        <div class="mb-3">
                                            <label for="userFirstName" class="form-label">First Name</label>
                                            <input type="text" class="form-control" id="userFirstName" name="userFirstName" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-xs-12">
                                        <div class="mb-3">
                                            <label for="userLastName" class="form-label">Last Name</label>
                                            <input type="text" class="form-control" id="userLastName" name="userLastName" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-lg-6 col-xs-12">
                                        <div class="mb-3">
                                            <label for="userUsername" class="form-label">Username</label>
                                            <input type="text" class="form-control" id="userUsername" name="userUsername" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-xs-12">
                                        <div class="mb-3">
                                            <label for="userEmail" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="userEmail" name="userEmail" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-lg-6 col-xs-12">
                                        <div class="mb-3">
                                            <label for="userPassword" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="userPassword" name="userPasword" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-xs-12">
                                        <div class="mb-3">
                                            <label for="userIncorrectLoginAttempts" class="form-label">Incorrect Login Attempts</label>
                                            <input type="number" min="0" steps="1" class="form-control" id="userIncorrectLoginAttempts" name="userIncorrectLoginAttempts" value="0" readonly required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-lg-6 col-xs-12">
                                        <div class="mb-3">
                                            <label for="userUserStatusId" class="form-label">User Status</label>
                                            <select class="form-select form-select-md mb-3" aria-label=".form-select-lg example" name="userUserStatusId" required>
                                                <?php foreach ($userStatuses as $userStatus) { ?>
                                                    <option value="<?= $userStatus['id']; ?>"><?= $userStatus['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-xs-12">
                                        <div class="mb-3">
                                            <label for="userUserRoleId" class="form-label">User Role</label>
                                            <select class="form-select form-select-md mb-3" aria-label=".form-select-lg example" name="userUserRoleId" required>
                                                <?php foreach ($userRoles as $userRole) { ?>
                                                    <option value="<?= $userRole['id']; ?>"><?= $userRole['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" name="editSubmit" class="btn btn-primary">Add User</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <br />
            <div id="rowsText" class="d-inline align-text-middle">With Selected Row(s): </div>
            <button class="d-inline p-2 mb-3 btn btn-danger deleteRows" data-action="deletedisabilitys">Delete</button>
            <table id="usersTable" class="display wrap" style="width: 100%;">
                <thead>
                    <tr>
                        <th></th>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Incorrect Login Attempts</th>
                        <th>User Status</th>
                        <th>User Role</th>
                        <th>Created By</th>
                        <th>Created</th>
                        <th>Modified By</th>
                        <th>Modified</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($users as $user) {
                    ?>
                            <tr>
                                <td></td>
                                <td><?= $user['id']; ?></td>
                                <td><?= $user['first_name']; ?></td>
                                <td><?= $user['last_name']; ?></td>
                                <td><?= $user['username']; ?></td>
                                <td><?= $user['email']; ?></td>
                                <td><?= $user['incorrect_login_attempts']; ?></td>
                                <td><?= $user['user_status_name']; ?></td>
                                <td><?= $user['user_role_name']; ?></td>
                                <td><?= $user['created_full_name']; ?></td>
                                <td><?= $user['created']; ?></td>
                                <td><?= $user['modified_full_name']; ?></td>
                                <td><?= $user['modified']; ?></td>
                                <td>
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editUser<?= $user['id']; ?>">Edit</button>
                                </td>
                            </tr>
                            <div class="modal fade" id="editUser<?= $user['id']; ?>" tabindex="-1" aria-labelledby="editUser<?= $user['id']; ?>Label" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Editing User: <?= $user['id']; ?></h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="/actions.php" method="POST" onsubmit="return confirm('Are you sure you want to go ahead and edit this user?');">
                                            <div class="modal-body">
                                                <input type="hidden" name="action" value="edit_user">
                                                <input type="hidden" name="userId" value="<?= $user['id']; ?>">
                                                <div class="row">
                                                    <div class="col-md-6 col-lg-6 col-xs-12">
                                                        <div class="mb-3">
                                                            <label for="userFirstName" class="form-label">First Name</label>
                                                            <input type="text" class="form-control" id="userFirstName" name="userFirstName" value="<?= $user['first_name']; ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-6 col-xs-12">
                                                        <div class="mb-3">
                                                            <label for="userLastName" class="form-label">Last Name</label>
                                                            <input type="text" class="form-control" id="userLastName" name="userLastName" value="<?= $user['last_name']; ?>" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 col-lg-6 col-xs-12">
                                                        <div class="mb-3">
                                                            <label for="userUsername" class="form-label">Username</label>
                                                            <input type="text" class="form-control" id="userUsername" name="userUsername" value="<?= $user['username']; ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-6 col-xs-12">
                                                        <div class="mb-3">
                                                            <label for="userEmail" class="form-label">Email</label>
                                                            <input type="email" class="form-control" id="userEmail" name="userEmail" value="<?= $user['email']; ?>" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 col-lg-6 col-xs-12">
                                                        <div class="mb-3">
                                                            <label for="userPassword" class="form-label">Password (Leave blank if you are not changing it)</label>
                                                            <input type="password" class="form-control" id="userPassword" name="userPasword">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-6 col-xs-12">
                                                        <div class="mb-3">
                                                            <label for="userIncorrectLoginAttempts" class="form-label">Incorrect Login Attempts</label>
                                                            <input type="number" min="0" steps="1" class="form-control" id="userIncorrectLoginAttempts" name="userIncorrectLoginAttempts" value="<?= $user['incorrect_login_attempts']; ?>" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 col-lg-6 col-xs-12">
                                                        <div class="mb-3">
                                                            <label for="userUserStatusId" class="form-label">User Status</label>
                                                            <select class="form-select form-select-md mb-3" aria-label=".form-select-lg example" name="userUserStatusId" required>
                                                                <?php foreach ($userStatuses as $userStatus) { ?>
                                                                    <option value="<?= $userStatus['id']; ?>" <?= ($user['user_status_id'] == $userStatus['id']) ? 'selected' : ''; ?>><?= $userStatus['name']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-6 col-xs-12">
                                                        <div class="mb-3">
                                                            <label for="userUserRoleId" class="form-label">User Role</label>
                                                            <select class="form-select form-select-md mb-3" aria-label=".form-select-lg example" name="userUserRoleId" required>
                                                                <?php foreach ($userRoles as $userRole) { ?>
                                                                    <option value="<?= $userRole['id']; ?>" <?= ($user['user_role_id'] == $userRole['id']) ? 'selected' : ''; ?>><?= $userRole['name']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" name="editSubmit" class="btn btn-primary">Edit User</button>
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
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Incorrect Login Attempts</th>
                        <th>Active</th>
                        <th>User Role</th>
                        <th>Created By</th>
                        <th>Created</th>
                        <th>Modified By</th>
                        <th>Modified</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <script>
		$(document).ready(function () {
			var table = $('#usersTable').DataTable({
                dom: 'Blfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
				columnDefs: [
					{
						orderable: false,
						className: 'select-checkbox',
						targets:   0
					} 
				],
                lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
				select: {
					style:    'multi',
					selector: 'td:first-child'
				},
				responsive: true,
				order: [[1, 'asc']]
			});
            $('.form-select').each(function () {
                $(this).select2({
                    theme: 'bootstrap-5',
                    dropdownParent: $(this).parent(),
                });
            });
        });
    </script>
<?php include_once('../templates/layout/footer_admin.php'); ?>
