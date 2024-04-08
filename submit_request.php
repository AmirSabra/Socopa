<?php
	session_start();
	if (isset($_POST['submit'])) {
        include_once('controller.php');
        $controller = New Controller();
        $result = $controller->insertRequest($_POST);
		
		if ($result['albumTracksSuccess'] != '') {
			$_SESSION['message_success'] = '<div class="alert alert-success alert-dismissible fade show mb-3" role="alert"><strong>Success! The Following Requests Have Been Added:</strong><br />' . $result['albumTracksSuccess'] . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';				
		}
		if ($result['albumTracksError'] != '') {
			$_SESSION['message_error'] = '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>Error! The Following Requests Could Not Be Added Due To An Unknown Error, Please Try Again Later:</strong><br />' . $result['albumTracksError'] . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';				
		}
		if ($result['albumTracksExist'] != '') {
			$_SESSION['message_exists'] = '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>The Following Requests Already Exist:</strong><br />' . $result['albumTracksExist'] . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';				
		}
		if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == ''){
			header('location:/');
		} else {
			header('location:/admin');
		}
	}
?>