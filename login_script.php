<?php
	session_start();
	if (isset($_POST['submit'])) {
        include_once('controller.php');
        $controller = New Controller();
        $result = $controller->login($_POST);
        if (gettype($result) == 'string') {
            $_SESSION['login_logout_message'] = '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>Could Not Login:</strong><br />' . $result . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            header('location:/');
        } elseif (gettype($result) == 'array') {
            foreach ($result as $user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['first_name'] = $user['first_name'];
                $_SESSION['last_name'] = $user['last_name'];
                $_SESSION['user_role_name'] = $user['user_role_name'];
                $_SESSION['logged_in'] = 'Yes';
            }
            header('location:/admin');
        }
	}
?>