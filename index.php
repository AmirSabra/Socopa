<!doctype html>
<html lang="en">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<head>
	<!-- CSS Files -->
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css">
	<!-- JS Files -->
		<script src="https://code.jquery.com/jquery-3.6.3.js"></script>
		<script type="application/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
		<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
		<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
		<script src="https://kit.fontawesome.com/99ad3b8828.js" crossorigin="anonymous"></script>
	</head>
	<body>
		<div class="position-absolute top-50 start-50 translate-middle">
            <?php
				include_once('controller_new.php');
				$controller = New Controller();
				$settings = $controller->getSettings();
                session_start();
                if (isset($_SESSION['login_logout_message']) && $_SESSION['login_logout_message'] != '') {
                    echo $_SESSION['login_logout_message'];
                    unset($_SESSION['login_logout_message']);
                }
				if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] != '') {
					header('location:/admin');
				}
            ?>
			<img src="uploads/<?= $settings['company_logo']; ?>" class="mb-3" style="width: 100%;"/>
			<div class="card mb-3">
				<div class="card-header">
					Login
				</div>
				<div class="card-body">
					<form class="mb-3" action="login_script.php" method="POST">
						<div class="mb-3">
							<label for="username" class="form-label">Username</label>
							<input type="text" class="form-control" id="username" name="username" required>
						</div>
						<div class="mb-3">
							<label for="password" class="form-label">Password</label>
							<input type="password" class="form-control" id="password" name="password" required>
						</div>
						<button type="submit" name="submit" class="btn btn-primary">Go</button>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>	