<!doctype html>
<html lang="en">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<head>
	<!-- CSS Files -->
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css">
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.6.0/css/select.dataTables.min.css">
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
		<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />	
		<!-- JS Files -->
		<script src="https://code.jquery.com/jquery-3.6.3.js"></script>
		<script type="application/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
		<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
		<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
		<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/select/1.6.0/js/dataTables.select.min.js"></script>
		<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
		<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
		<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
		<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
		<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
		<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
		<script src="https://kit.fontawesome.com/99ad3b8828.js" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.umd.min.js"></script>
	<body>
        <div class="container-fluid">
            <h1 class="d-inline mb-3"><?= $pageHeading; ?></h1>
            <a href="../admin" id="dashboard" class="p-2 mb-3 btn btn-primary">Dashboard</a>
			<a href="../admin/users.php" id="users" class="p-2 mb-3 btn btn-primary">Users</a>
            <a href="../admin/clients.php" id="clients" class="p-2 mb-3 btn btn-primary">Clients</a>
            <a href="../admin/client_requests.php" id="client_requests" class="p-2 mb-3 btn btn-primary">Client Requests</a>
            <a href="../admin/settings.php" id="settings" class="p-2 mb-3 btn btn-primary">Settings</a>
            <a href="../logout.php" id="logout" class="p-2 mb-3 btn btn-danger" onclick="return confirm('Are you sure you want to logout?');">Logout</a>