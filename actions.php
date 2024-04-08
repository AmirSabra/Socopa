<?php
	session_start();
	if (isset($_POST['editSubmit'])) {
        include_once('controller_new.php');
        $controller = New Controller();
        $_POST['loggedInUserId'] = $_SESSION['user_id'];
        $action = $_POST['action'];
        $result = '';
        $redirect = '';
        
        switch ($action) {
            case 'add_tab':
                $result = $controller->insertTab($_POST);
                $redirect = '/admin/settings.php';
                break;
            case 'edit_tab':
                $result = $controller->updateTab($_POST);
                $redirect = '/admin/settings.php';
                break;
            case 'add_user':
                $result = $controller->insertUser($_POST);
                $redirect = '/admin/users.php';
                break;
            case 'edit_user':
                $result = $controller->updateUser($_POST);
                $redirect = '/admin/users.php';
                break;
            case 'add_client':
                $result = $controller->insertClient($_POST);
                $redirect = '/admin/clients.php';
                break;
            case 'edit_client':
                $result = $controller->updateClient($_POST);
                $redirect = '/admin/clients.php';
                break;
            case 'add_client_request':
                $result = $controller->insertClientRequest($_POST);
                $redirect = '/admin/client_requests.php';
                break;
            case 'edit_client_request':
                $result = $controller->updateClientRequest($_POST);
                $redirect = '/admin/client_requests.php';
                break;
            case 'add_client_request_outcome':
                $result = $controller->insertClientRequestOutcome($_POST);
                $redirect = '/admin/settings.php';
                break;
            case 'edit_client_request_outcome':
                $result = $controller->updateClientRequestOutcome($_POST);
                $redirect = '/admin/settings.php';
                break;
            case 'add_client_request_reason':
                $result = $controller->insertClientRequestReason($_POST);
                $redirect = '/admin/settings.php';
                break;
            case 'edit_client_request_reason':
                $result = $controller->updateClientRequestReason($_POST);
                $redirect = '/admin/settings.php';
                break;
            case 'add_client_request_referral':
                $result = $controller->insertClientRequestReferral($_POST);
                $redirect = '/admin/settings.php';
                break;
            case 'edit_client_request_referral':
                $result = $controller->updateClientRequestReferral($_POST);
                $redirect = '/admin/settings.php';
                break;
            case 'add_disability':
                $result = $controller->insertDisability($_POST);
                $redirect = '/admin/settings.php';
                break;
            case 'edit_disability':
                $result = $controller->updateDisability($_POST);
                $redirect = '/admin/settings.php';
                break;
            case 'add_employment_status':
                $result = $controller->insertEmploymentStatus($_POST);
                $redirect = '/admin/settings.php';
                break;
            case 'edit_employment_status':
                $result = $controller->updateEmploymentStatus($_POST);
                $redirect = '/admin/settings.php';
                break;
            case 'add_gender':
                $result = $controller->insertGender($_POST);
                $redirect = '/admin/settings.php';
                break;
            case 'edit_gender':
                $result = $controller->updateGender($_POST);
                $redirect = '/admin/settings.php';
                break;
            case 'add_age':
                $result = $controller->insertAge($_POST);
                $redirect = '/admin/settings.php';
                break;
            case 'edit_age':
                $result = $controller->updateAge($_POST);
                $redirect = '/admin/settings.php';
                break;    
            case 'add_sign_post':
                $result = $controller->insertSignPost($_POST);
                $redirect = '/admin/settings.php';
                break;
            case 'edit_sign_post':
                $result = $controller->updateSignPost($_POST);
                $redirect = '/admin/settings.php';
                break;    
            case 'edit_customisation':
                $result = $controller->updateCustomisation($_POST);
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