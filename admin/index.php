<?php     	
	$pageHeading = "Admin Dashboard";
	include_once('../templates/layout/header_admin.php');
	include_once('../controller_new.php');
	$controller = New Controller();
	$clients = $controller->getAllClients();
	$clientTotalNumberOfPeopleInHousehold = $controller->getTotalClientNumberOfPeopleInHousehold();
	$clientAgesPerPostcode = $controller->getAllClientAgesPerPostcode();
	/*$requestTypes = $controller->getAllRequestTypes();
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
<div class="row">
	<div class="col-md-2 col-lg-2 col-xs-12">
		<div class="card text-center">
			<div class="card-header">
				Total Clients Helped:
			</div>
			<div class="card-body">
				<h3 class="card-title"><?= $clientTotalNumberOfPeopleInHousehold['total_number_of_people_in_household']; ?></h3>
			</div>
		</div>
	</div>
	<div class="col-md-10 col-lg-10 col-xs-12">
	</div>
</div>
<div class="row">
	<div class="col-md-6 col-lg-6 col-xs-12">
		<div>
			<canvas id="myChart"></canvas>
		</div>
	</div>
	<div class="col-md-6 col-lg-6 col-xs-12">
		<div>
			<canvas id="myChart2"></canvas>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6 col-lg-6 col-xs-12">
		<div>
			<canvas id="myChart3"></canvas>
		</div>
	</div>
	<div class="col-md-6 col-lg-6 col-xs-12">
		<div>
			<canvas id="myChart4"></canvas>
		</div>
	</div>
</div>
<script>
	$(document).ready(function () {
		const data = {
			"labels": [<?= "'".implode("','", array_keys($clientAgesPerPostcode[1]))."'"; ?>],
			"ageRanges": [<?= "'".implode("','", array_values($clientAgesPerPostcode[0]))."'"; ?>],
			"datasets": [{
				"label": '# of Age Ranges Per Postcode',
				"data": [<?= "'".implode("','", array_values($clientAgesPerPostcode[1]))."'"; ?>],
				"borderWidth": 1
			}]
		};
		const ctx = document.getElementById('myChart');
		chart1 = new Chart(ctx, {
			type: 'bar',
			data: data,
			options: {
				scales: {
					y: {
						beginAtZero: true
					}
				},
				plugins: {
					tooltip: {
						callbacks: {
								label: (tooltipItem, data) => {
								let i = tooltipItem.index;
								console.log(data.ageRanges);
								return data;
							}
						}
					}
				}
			}
		});
		const ctx2 = document.getElementById('myChart2');
		new Chart(ctx2, {
			type: 'bar',
			data: {
			labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
			datasets: [{
				label: '# of Votes',
				data: [12, 19, 3, 5, 2, 3],
				borderWidth: 1
			}]
			},
			options: {
			scales: {
				y: {
				beginAtZero: true
				}
			}
			}
		});
		const ctx3 = document.getElementById('myChart3');
		new Chart(ctx3, {
			type: 'bar',
			data: {
			labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
			datasets: [{
				label: '# of Votes',
				data: [12, 19, 3, 5, 2, 3],
				borderWidth: 1
			}]
			},
			options: {
			scales: {
				y: {
				beginAtZero: true
				}
			}
			}
		});
		const ctx4 = document.getElementById('myChart4');
		new Chart(ctx4, {
			type: 'bar',
			data: {
			labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
			datasets: [{
				label: '# of Votes',
				data: [12, 19, 3, 5, 2, 3],
				borderWidth: 1
			}]
			},
			options: {
			scales: {
				y: {
				beginAtZero: true
				}
			}
			}
		});
	});
</script>
<?php include_once('../templates/layout/footer.php'); ?>