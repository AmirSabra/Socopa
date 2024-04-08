<?php
	session_start();
	if (isset($_POST['action'])) {
		$action = $_POST['action'];
		$ids = $_POST['ids'];
		include_once('../controller.php');
        $controller = New Controller();
        $result = null;
        switch ($action) {
            case 'markRequestsAsComplete':
                $result = $controller->markRequestsAsCompleteById($ids);
                break;
            case 'deleteRequests':
                $result = $controller->deleteRequestsById($ids);
                break;
            case 'deleteRequestTypes':
                $result = $controller->deleteRequestTypesById($ids);
                break;
            case 'deleteRequestStatuses':
                $result = $controller->deleteRequestStatusesById($ids);
                break;
            case 'deleteRequestRejectionReasons':
                $result = $controller->deleteRequestRejectionReasonsById($ids);
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
    }
?>