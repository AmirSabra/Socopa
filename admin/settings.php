<?php
    $pageHeading = "Settings";
    include_once('../templates/layout/header_admin.php');
	include_once('../controller_new.php');
	$controller = New Controller();
	$clientRequestOutcomes = $controller->getAllClientRequestOutcomes();
	$clientRequestReasons = $controller->getAllClientRequestReasons();
	$clientRequestReferrals = $controller->getAllClientRequestReferrals();
	$disabilities = $controller->getAllDisabilities();
	$employmentStatuses = $controller->getAllEmploymentStatuses();
	$genders = $controller->getAllGenders();
	$ages = $controller->getAllAges();
	$signPosts = $controller->getAllSignPosts();
	$settings = $controller->getSettings();
	$tabs = $controller->getAllTabs();
	$nextTabOrder = $controller->getNextTabOrder();
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
	<ul class="nav nav-tabs" id="myTab" role="tablist">
		<?php foreach ($tabs as $tab) { ?>
			<li class="nav-item" role="presentation">
				<button class="nav-link <?= ($settings['default_tab_id'] == $tab['id']) ? 'active' : ''; ?>" id="<?= $tab['field_id']; ?>-tab" data-bs-toggle="tab" data-bs-target="#<?= $tab['content_field_id']; ?>-tab-pane" type="button" role="tab" aria-controls="<?= $tab['content_field_id']; ?>-tab-pane" aria-selected="true"><?= $tab['name']; ?></button>
			</li>
		<?php } ?>
			<li class="nav-item" role="presentation">
				<button class="nav-link" id="tabs-tab" data-bs-toggle="tab" data-bs-target="#tabs-tab-pane" type="button" role="tab" aria-controls="tabs-tab-pane" aria-selected="true">Tabs</button>
			</li>
	</ul>
	<div class="tab-content" id="myTabContent">
		<?php foreach ($tabs as $tab) { ?>
			<div class="tab-pane fade <?= ($settings['default_tab_id'] == $tab['id']) ? 'show active' : ''; ?>" id="<?= $tab['content_field_id']; ?>-tab-pane" role="tabpanel" aria-labelledby="<?= $tab['field_id']; ?>-tab" tabindex="0">
				<?php include_once($tab['content_file_name']); ?>				
			</div>
		<?php } ?>
		<div class="tab-pane fade" id="tabs-tab-pane" role="tabpanel" aria-labelledby="tabs-tab" tabindex="0">
			<?php include_once('tabs/tabs.php'); ?>				
		</div>
	</div>
	<script>
		$(document).ready(function () {
			var table = $('table[id*=Table]').DataTable({
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
			$('.deleteRows').click(function () {
				var namesConfirm = '';
				var activeTab = $('.tab-content').find('.active');
				var action = $(this).attr('data-action');
				var ids = $.map(activeTab.find('table[id*=Table]').DataTable().rows('.selected').data(), function (item) {
					return item[1]
				});
				var names = $.map(activeTab.find('table[id*=Table]').DataTable().rows('.selected').data(), function (item) {
					return item[2];
				});
				for (var i = 0; i < names.length; i++) {
					namesConfirm += names[i] + '\n';
				}
				if (ids.length == 0) {
					alert('Please select atleast 1 row.');
				} else {
					var confirmAction = confirm("Are you sure you want to delete the following:\n\n" + namesConfirm);
					if (confirmAction) {
						$.ajax({
							url: '/actions/admin.php',
							method: 'POST',
							data: {action: action, ids: ids},
							success: function(result) {
								window.location.reload(true);
							},
							error: function (jqXhr, textStatus, errorMessage) {
								console.log(jqXhr);
								console.log(textStatus);
								console.log(errorMessage);
							}
						});
					}
				}
				/*console.log(ids)
				alert(table.rows('.selected').data().length + ' row(s) selected');*/
			});
		});
	</script>
<?php include_once('../templates/layout/footer_admin.php'); ?>