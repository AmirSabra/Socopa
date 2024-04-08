<?php
	session_start();
	if (isset($_POST['submit'])) {
        session_destroy();
        $_SESSION['login_logout_message'] = '<div class="alert alert-success alert-dismissible fade show mb-3" role="alert"><strong>You Have Successfully Logged Out.</strong><br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        header('location:/login.php');
	}
?>