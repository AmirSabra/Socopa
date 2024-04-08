<?php
    $pageHeading = "View Client";
    include_once('../templates/layout/header_admin.php');
    include_once('../controller_new.php');
    $controller = New Controller();
    $clients = $controller->getAllClients();
    $genders = $controller->getAllGenders();
    $ages = $controller->getAllAges();
    $disabilities = $controller->getAllDisabilities();
    $employmentStatuses = $controller->getAllEmploymentStatuses();
    $clientRequestReasons = $controller->getAllClientRequestReasons();

    $clientRequestOutcomes = $controller->getAllClientRequestOutcomes();
    $clientRequestReferrals = $controller->getAllClientRequestReferrals();
    $signPosts = $controller->getAllSignPosts();
    $clientRequests = $controller->getAllClientRequests();
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
<section>
    <nav>   
<ul>
<?php
                      
$id=$_GET['id'];
$query=mysql_query($con,"select * from clients where id='' ");


                   { ?>                   
                         <li>   Id:  <?= $client['id']; ?> </li>
                         <li>   First Name: <?= $client['first_name']; ?> </li>
                         <li>   Last Name: <?= $client['last_name']; ?> </li> 
                         <li> Gender: <?= $client['gender_name']; ?> </li>
                         <li>   Age: <?= $client['age_name']; ?>  </li>
                         <li>   Email: <?= $client['email']; ?> </li> 
                         <li>  Mobile: <?= $client['mobile']; ?> </li>
                         <li>  Postcode:<?= $client['postcode']; ?> </li>
                         <li>  Employment Status:  <?= $client['employment_status_name']; ?> </li>
                         <li>  Number Of People In Household: <?= $client['number_of_people_in_household']; ?> </li>
                         <li>  Health Condition:  <?= $client['disability_name']; ?> </li>
                         <li> Created By:  <?= $client['created_full_name']; ?> </li>
                         <li>  Created: <?= $client['created']; ?> </li>
                         <li>    Modified By:<?= $client['modified_full_name']; ?> </li>
                            <li>     Modified : <?= $client['modified']; ?></li>
                            <?php } ?>
</ul>
</nav>
</section>                              


<div id="rowsText" class="d-inline align-text-middle">With Selected Row(s): </div>
            <button class="d-inline p-2 mb-3 btn btn-danger deleteRows" data-action="deletedisabilitys">Delete</button>
<table id="clientRequestsTable" class="display wrap" style="width: 100%;">
                <thead>
                    <tr>
                        <th></th>
                        <th>ID</th>
                        <th>Client</th>
                        <th>Client Request Reason</th>
                        <th>Client Request Outcome</th>
                        <th>Client Request Referral</th>
                        <th>Sign Post</th>
                        <th>Notes</th>
                        <th>Created By</th>
                        <th>Created</th>
                        <th>Modified By</th>
                        <th>Modified</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                       $id=$_GET['id'];
                       $query=mysql_query($con,"select * from clients where id='' ");
                    {?>
                            <tr>
                                <td></td>
                                <td><?= $clientRequest['id']; ?></td>
                                <td><?= $clientRequest['client_name']; ?></td>
                                <td><?= $clientRequest['client_request_reason_name']; ?></td>
                                <td><?= $clientRequest['client_request_outcome_name']; ?></td>
                                <td><?= $clientRequest['client_request_referral_name']; ?></td>
                                <td><?= $clientRequest['sign_post_name']; ?></td>
                                <td><?= $clientRequest['notes']; ?></td>
                                <td><?= $clientRequest['created_full_name']; ?></td>
                                <td><?= $clientRequest['created']; ?></td>
                                <td><?= $clientRequest['modified_full_name']; ?></td>
                                <td><?= $clientRequest['modified']; ?></td>
                                <td>
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editClientRequest<?= $clientRequest['id']; ?>">Edit</button>
                                </td>
                            </tr>
                            <div class="modal fade" id="editClientRequest<?= $clientRequest['id']; ?>" tabindex="-1" aria-labelledby="editClientRequest<?= $clientRequest['id']; ?>Label" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Editing Client: <?= $client['id']; ?></h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="/actions.php" method="POST" onsubmit="return confirm('Are you sure you want to go ahead and edit this client request?');">
                                            <div class="modal-body">
                                                <input type="hidden" name="action" value="edit_client_request">
                                                <input type="hidden" name="clientRequestId" value="<?= $clientRequest['id']; ?>">
                                                <div class="row">
                                                    <div class="col-md-6 col-lg-6 col-xs-12">
                                                        <div class="mb-3">
                                                            <label for="clientId" class="form-label">Client</label>
                                                            <select class="form-select form-select-md mb-3" aria-label=".form-select-lg example" name="clientId" required>
                                                                <?php foreach ($clients as $client) { ?>
                                                                    <option value="<?= $client['id']; ?>" <?= ($clientRequest['client_id'] == $client['id']) ? 'selected' : ''; ?>><?= $client['first_name'] . ' ' . $client['last_name']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-6 col-xs-12">
                                                        <div class="mb-3">
                                                            <label for="clientRequestReasonId" class="form-label">Client Request Reason</label>
                                                            <select class="form-select form-select-md mb-3" aria-label=".form-select-lg example" name="clientRequestReasonId" required>
                                                                <?php foreach ($clientRequestReasons as $clientRequestReason) { ?>
                                                                    <option value="<?= $clientRequestReason['id']; ?>" <?= ($clientRequest['client_request_reason_id'] == $clientRequestReason['id']) ? 'selected' : ''; ?>><?= $clientRequestReason['name']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 col-lg-6 col-xs-12">
                                                        <div class="mb-3">
                                                            <label for="clientRequestOutcomeId" class="form-label">Client Request Outcome</label>
                                                            <select class="form-select form-select-md mb-3" aria-label=".form-select-lg example" name="clientRequestOutcomeId">
                                                                <?php foreach ($clientRequestOutcomes as $clientRequestOutcome) { ?>
                                                                    <option value="<?= $clientRequestOutcome['id']; ?>" <?= ($clientRequest['client_request_outcome_id'] == $clientRequestOutcome['id']) ? 'selected' : ''; ?>><?= $clientRequestOutcome['name']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-6 col-xs-12">
                                                        <div class="mb-3">
                                                            <label for="clientRequestReferralId" class="form-label">Client Request Referral</label>
                                                            <select class="form-select form-select-md mb-3" aria-label=".form-select-lg example" name="clientRequestReferralId" required>
                                                                <?php foreach ($clientRequestReferrals as $clientRequestReferral) { ?>
                                                                    <option value="<?= $clientRequestReferral['id']; ?>" <?= ($clientRequest['client_request_referral_id'] == $clientRequestReferral['id']) ? 'selected' : ''; ?>><?= $clientRequestReferral['name']; ?></option>
                                                                <?php } ?>
                                                            </select>                                        
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 col-lg-6 col-xs-12">
                                                        <div class="mb-3">
                                                            <label for="signPostId" class="form-label">Sign Post</label>
                                                            <select class="form-select form-select-md mb-3" aria-label=".form-select-lg example" name="signPostId">
                                                            <?php foreach ($signPosts as $signPost) { ?>
                                                                    <option value="<?= $signPost['id']; ?>" <?= ($clientRequest['sign_post_id'] == $signPost['id']) ? 'selected' : ''; ?>><?= $signPost['name']; ?></option>
                                                                <?php } ?>
                                                            </select>                                        
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-6 col-xs-12">
                                                        <div class="mb-3">
                                                            <label for="notes" class="form-label">Notes</label>
                                                            <textarea class="form-control" id="notes" name="notes"><?= $clientRequest['notes']; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" name="editSubmit" class="btn btn-primary">Edit Client Request</button>
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
                        <th>Client</th>
                        <th>Client Request Reason</th>
                        <th>Client Request Outcome</th>
                        <th>Client Request Referral</th>
                        <th>Sign Post</th>
                        <th>Notes</th>
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
    <script>
		$(document).ready(function () {
			var table = $('#clientRequestsTable').DataTable({
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