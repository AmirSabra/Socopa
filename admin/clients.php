<?php
    $pageHeading = "Clients";
    include_once('../templates/layout/header_admin.php');
    include_once('../controller_new.php');
    $controller = New Controller();
    $clients = $controller->getAllClients();
    $genders = $controller->getAllGenders();
    $ages = $controller->getAllAges();
    $disabilities = $controller->getAllDisabilities();
    $employmentStatuses = $controller->getAllEmploymentStatuses();
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
            All Clients (If Viewing On Phone Or Tablet, Click + Or - Respectively To Expand Or Collapse Rows)
        </div>
        <div class="card-body">
            <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addClient">
                Add Client
            </button>
            <div class="modal fade" id="addClient" tabindex="-1" aria-labelledby="addClientLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Add Client</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="/actions.php" method="POST" onsubmit="return confirm('Are you sure you want to go ahead and add this client?');">
                            <div class="modal-body">
                                <input type="hidden" name="action" value="add_client">
                                <div class="row">
                                    <div class="col-md-6 col-lg-6 col-xs-12">
                                        <div class="mb-3">
                                            <label for="clientFirstName" class="form-label">First Name</label>
                                            <input type="text" class="form-control" id="clientFirstName" name="clientFirstName" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-xs-12">
                                        <div class="mb-3">
                                            <label for="clientLastName" class="form-label">Last Name</label>
                                            <input type="text" class="form-control" id="clientLastName" name="clientLastName" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-lg-6 col-xs-12">
                                        <div class="mb-3">
                                            <label for="clientGenderId" class="form-label">Gender</label>
                                            <select class="form-select form-select-md mb-3" aria-label=".form-select-lg example" name="clientGenderId" required>
                                                <?php foreach ($genders as $gender) { ?>
                                                    <option value="<?= $gender['id']; ?>"><?= $gender['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-xs-12">
                                        <div class="mb-3">
                                            <label for="clientAge" class="form-label">Age</label>
                                            <select class="form-select form-select-md mb-3" aria-label=".form-select-lg example" name="clientAgeId" required>
                                                <?php foreach ($ages as $age) { ?>
                                                    <option value="<?= $age['id']; ?>"><?= $age['name']; ?></option>
                                                <?php } ?>
                                            </select>                                        
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-lg-6 col-xs-12">
                                        <div class="mb-3">
                                            <label for="clientEmail" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="clientEmail" name="clientEmail">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-xs-12">
                                        <div class="mb-3">
                                            <label for="clientMobile" class="form-label">Mobile</label>
                                            <input type="text" class="form-control" id="clientMobile" name="clientMobile" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-lg-6 col-xs-12">
                                        <div class="mb-3">
                                            <label for="clientPostcode" class="form-label">Postcode</label>
                                            <input type="text" class="form-control" id="clientPostcode" name="clientPostcode" pattern="^([Gg][Ii][Rr] 0[Aa]{2})|((([A-Za-z][0-9]{1,2})|(([A-Za-z][A-Ha-hJ-Yj-y][0-9]{1,2})|(([A-Za-z][0-9][A-Za-z])|([A-Za-z][A-Ha-hJ-Yj-y][0-9]?[A-Za-z])))) [0-9][A-Za-z]{2})$" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-xs-12">
                                        <div class="mb-3">
                                            <label for="clientEmploymentStatusId" class="form-label">Employment Status</label>
                                            <select class="form-select form-select-md mb-3" aria-label=".form-select-lg example" name="clientEmploymentStatusId" required>
                                                <?php foreach ($employmentStatuses as $employmentStatus) { ?>
                                                    <option value="<?= $employmentStatus['id']; ?>"><?= $employmentStatus['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-lg-6 col-xs-12">
                                        <div class="mb-3">
                                            <label for="clientNumberOfPeopleInHousehold" class="form-label">Number Of People In Household</label>
                                            <input type="number" class="form-control" id="clientNumberOfPeopleInHousehold" name="clientNumberOfPeopleInHousehold" steps="1" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-xs-12">
                                        <div class="mb-3">
                                            <label for="clientDisabilityId" class="form-label">Health Condition</label>
                                            <select class="form-select form-select-md mb-3" aria-label=".form-select-lg example" name="clientDisabilityId" required>
                                                <?php foreach ($disabilities as $client) { ?>
                                                    <option value="<?= $client['id']; ?>"><?= $client['name']; ?></option>
                                                <?php } ?>
                                            </select>                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" name="editSubmit" class="btn btn-primary">Add Client</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <br />
            <div id="rowsText" class="d-inline align-text-middle">With Selected Row(s): </div>
            <button class="d-inline p-2 mb-3 btn btn-danger deleteRows" data-action="deletedisabilitys">Delete</button>
            <table id="clientsTable" class="display wrap" style="width: 100%;">
                <thead>
                    <tr>
                        <th></th>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Gender</th>
                        <th>Age</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Postcode</th>
                        <th>Employment Status</th>
                        <th>Number Of People In Household</th>
                        <th>Health Condition</th>
                        <th>Created By</th>
                        <th>Created</th>
                        <th>Modified By</th>
                        <th>Modified</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($clients as $client) {
                    ?>
                            <tr>
                                <td></td>
                                <td><?= $client['id']; ?></td>
                                <td><?= $client['first_name']; ?></td>
                                <td><?= $client['last_name']; ?></td>
                                <td><?= $client['gender_name']; ?></td>
                                <td><?= $client['age_name']; ?></td>
                                <td><?= $client['email']; ?></td>
                                <td><?= $client['mobile']; ?></td>
                                <td><?= $client['postcode']; ?></td>
                                <td><?= $client['employment_status_name']; ?></td>
                                <td><?= $client['number_of_people_in_household']; ?></td>
                                <td><?= $client['disability_name']; ?></td>
                                <td><?= $client['created_full_name']; ?></td>
                                <td><?= $client['created']; ?></td>
                                <td><?= $client['modified_full_name']; ?></td>
                                <td><?= $client['modified']; ?></td>
                                <td>
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editClient<?= $client['id']; ?>">Edit</button>
                                    <a href="client.php?id=<?= $client['id']; ?>" class="btn btn-primary">View</button>
                                </td>
                            </tr>
                            <div class="modal fade" id="editClient<?= $client['id']; ?>" tabindex="-1" aria-labelledby="editClient<?= $client['id']; ?>Label" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Editing Client: <?= $client['id']; ?></h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="/actions.php" method="POST" onsubmit="return confirm('Are you sure you want to go ahead and edit this client?');">
                                            <div class="modal-body">
                                                <input type="hidden" name="action" value="edit_client">
                                                <input type="hidden" name="clientId" value="<?= $client['id']; ?>">
                                                <div class="row">
                                                    <div class="col-md-6 col-lg-6 col-xs-12">
                                                        <div class="mb-3">
                                                            <label for="clientFirstName" class="form-label">First Name</label>
                                                            <input type="text" class="form-control" id="clientFirstName" name="clientFirstName" value="<?= $client['first_name']; ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-6 col-xs-12">
                                                        <div class="mb-3">
                                                            <label for="clientLastName" class="form-label">Last Name</label>
                                                            <input type="text" class="form-control" id="clientLastName" name="clientLastName" value="<?= $client['last_name']; ?>" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 col-lg-6 col-xs-12">
                                                        <div class="mb-3">
                                                            <label for="clientGenderId" class="form-label">Gender</label>
                                                            <select class="form-select form-select-md mb-3" aria-label=".form-select-lg example" name="clientGenderId" required>
                                                                <?php foreach ($genders as $gender) { ?>
                                                                    <option value="<?= $gender['id']; ?>" <?= ($client['gender_id'] == $gender['id']) ? 'selected' : ''; ?>><?= $gender['name']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-6 col-xs-12">
                                                        <div class="mb-3">
                                                            <label for="clientAge" class="form-label">Age</label>
                                                            <select class="form-select form-select-md mb-3" aria-label=".form-select-lg example" name="clientAgeId" required>
                                                                <?php foreach ($ages as $age) { ?>
                                                                    <option value="<?= $age['id']; ?>" <?= ($client['age_id'] == $age['id']) ? 'selected' : ''; ?>><?= $age['name']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 col-lg-6 col-xs-12">
                                                        <div class="mb-3">
                                                            <label for="clientEmail" class="form-label">Email</label>
                                                            <input type="email" class="form-control" id="clientEmail" name="clientEmail" value="<?= $client['email']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-6 col-xs-12">
                                                        <div class="mb-3">
                                                            <label for="clientMobile" class="form-label">Mobile</label>
                                                            <input type="text" class="form-control" id="clientMobile" name="clientMobile" value="<?= $client['mobile']; ?>" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 col-lg-6 col-xs-12">
                                                        <div class="mb-3">
                                                            <label for="clientPostcode" class="form-label">Postcode</label>
                                                            <input type="text" class="form-control" id="clientPostcode" name="clientPostcode" value="<?= $client['postcode']; ?>" pattern="^([Gg][Ii][Rr] 0[Aa]{2})|((([A-Za-z][0-9]{1,2})|(([A-Za-z][A-Ha-hJ-Yj-y][0-9]{1,2})|(([A-Za-z][0-9][A-Za-z])|([A-Za-z][A-Ha-hJ-Yj-y][0-9]?[A-Za-z])))) [0-9][A-Za-z]{2})$" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-6 col-xs-12">
                                                        <div class="mb-3">
                                                            <label for="clientEmploymentStatusId" class="form-label">Employment Status</label>
                                                            <select class="form-select form-select-md mb-3" aria-label=".form-select-lg example" name="clientEmploymentStatusId" required>
                                                                <?php foreach ($employmentStatuses as $employmentStatus) { ?>
                                                                    <option value="<?= $employmentStatus['id']; ?>" <?= ($client['employment_status_id'] == $employmentStatus['id']) ? 'selected' : ''; ?>><?= $employmentStatus['name']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 col-lg-6 col-xs-12">
                                                        <div class="mb-3">
                                                            <label for="clientNumberOfPeopleInHousehold" class="form-label">Number Of People In Household</label>
                                                            <input type="number" class="form-control" id="clientNumberOfPeopleInHousehold" name="clientNumberOfPeopleInHousehold" steps="1" value="<?= $client['number_of_people_in_household']; ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-6 col-xs-12">
                                                        <div class="mb-3">
                                                            <label for="clientDisabilityId" class="form-label">Health Condition</label>
                                                            <select class="form-select form-select-md mb-3" aria-label=".form-select-lg example" name="clientDisabilityId" required>
                                                                <?php foreach ($disabilities as $disability) { ?>
                                                                    <option value="<?= $disability['id']; ?>" <?= ($client['disability_id'] == $disability['id']) ? 'selected' : ''; ?>><?= $disability['name']; ?></option>
                                                                <?php } ?>
                                                            </select>                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" name="editSubmit" class="btn btn-primary">Edit Client</button>
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
                        <th>Gender</th>
                        <th>Age</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Postcode</th>
                        <th>Employment Status</th>
                        <th>Number Of People In Household</th>
                        <th>Health Condition</th>
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
			var table = $('#clientsTable').DataTable({
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
