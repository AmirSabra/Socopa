<?php
	session_start();
	if (isset($_POST['editSubmit'])) {
        include_once('controller.php');
        $controller = New Controller();
        $action = $_POST['action'];
        $result = '';
        $redirect = '';
        
        switch ($action) {
            case 'add_request':
                $result = $controller->insertRequest($_POST);
                $redirect = '/admin';
                break;
            case 'edit_request':
                $result = $controller->updateRequest($_POST);
                $redirect = '/admin';
                break;
            case 'add_request_type':
                $result = $controller->insertRequestType($_POST);
                $redirect = '/admin/settings.php';
                break;
            case 'edit_request_type':
                $result = $controller->updateRequestType($_POST);
                $redirect = '/admin/settings.php';
                break;
            case 'add_request_status':
                $result = $controller->insertRequestStatus($_POST);
                $redirect = '/admin/settings.php';
                break;
            case 'edit_request_status':
                $result = $controller->updateRequestStatus($_POST);
                $redirect = '/admin/settings.php';
                break;
            case 'add_request_rejection_reason':
                $result = $controller->insertRequestRejectionReason($_POST);
                $redirect = '/admin/settings.php';
                break;
            case 'edit_request_rejection_reason':
                $result = $controller->updateRequestRejectionReason($_POST);
                $redirect = '/admin/settings.php';
                break;
            default:
              echo "Your favorite color is neither red, blue, nor green!";
        }
		
		if ($result['success'] != '') {
			$_SESSION['message_success'] = $result['success'];				
		}
		if ($result['error'] != '') {
			$_SESSION['message_error'] = $result['error'];				
		}
		if ($result['errorExists'] != '') {
			$_SESSION['message_exists'] = $result['errorExists'];				
		}
		header('location:' . $redirect);
	}
?>