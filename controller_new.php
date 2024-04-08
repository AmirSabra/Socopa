<?php
    include('db_config.php');
    class Controller {
        public $mysqli;
        public $dbConfig;

        function __construct() {
            $this->dbConfig = New DbConfig();
            $this->mysqli = $this->dbConfig->getDbConnection();
        }

        function getAllUsers()
        {
            $result = $this->mysqli->query("SELECT u.*, CONCAT(uc.first_name, ' ', uc.last_name) AS created_full_name, CONCAT(um.first_name, ' ', um.last_name) AS modified_full_name, us.name AS user_status_name, ur.name AS user_role_name
                                            FROM users u
                                            LEFT JOIN user_statuses us
                                            ON u.user_status_id = us.id
                                            LEFT JOIN user_roles ur
                                            ON u.user_role_id = ur.id
                                            LEFT JOIN users uc
                                            ON u.created_by_user_id = uc.id
                                            LEFT JOIN users um
                                            ON u.modified_by_user_id = um.id
                                            ORDER BY u.id ASC");
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        function getAllUserStatuses()
        {
            $result = $this->mysqli->query("SELECT us.*, CONCAT(uc.first_name, ' ', uc.last_name) AS created_full_name, CONCAT(um.first_name, ' ', um.last_name) AS modified_full_name
                                            FROM user_statuses us
                                            LEFT JOIN users uc
                                            ON us.created_by_user_id = uc.id
                                            LEFT JOIN users um
                                            ON us.modified_by_user_id = um.id
                                            ORDER BY us.id ASC");
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        function getAllUserRoles()
        {
            $result = $this->mysqli->query("SELECT ur.*, CONCAT(uc.first_name, ' ', uc.last_name) AS created_full_name, CONCAT(um.first_name, ' ', um.last_name) AS modified_full_name
                                            FROM user_roles ur
                                            LEFT JOIN users uc
                                            ON ur.created_by_user_id = uc.id
                                            LEFT JOIN users um
                                            ON ur.modified_by_user_id = um.id
                                            ORDER BY ur.id ASC");
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        function getAllClients()
        {
            $result = $this->mysqli->query("SELECT c.*, CONCAT(uc.first_name, ' ', uc.last_name) AS created_full_name, CONCAT(um.first_name, ' ', um.last_name) AS modified_full_name, g.name AS gender_name, a.name AS age_name, es.name AS employment_status_name, d.name AS disability_name
                                            FROM clients c
                                            LEFT JOIN genders g
                                            ON c.gender_id = g.id
                                            LEFT JOIN ages a
                                            ON c.age_id = a.id
                                            LEFT JOIN employment_statuses es
                                            ON c.employment_status_id = es.id
                                            LEFT JOIN disabilities d
                                            ON c.disability_id = d.id
                                            LEFT JOIN users uc
                                            ON c.created_by_user_id = uc.id
                                            LEFT JOIN users um
                                            ON c.modified_by_user_id = um.id
                                            ORDER BY c.id ASC");
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        function getAllClientAgesPerPostcode()
        {
            $keyValueArray = array();
            $result = $this->mysqli->query("SELECT c.postcode, GROUP_CONCAT(a.name) AS age_name
                                            FROM clients c
                                            LEFT JOIN ages a
                                            ON c.age_id = a.id
                                            GROUP BY c.postcode");
            
            $resultAsArray = $result->fetch_all(MYSQLI_ASSOC);

            foreach($resultAsArray as $value) {
                $keyValueArray[0][$value['postcode']] = $value['age_name'];
                $keyValueArray[1][$value['postcode']] = count(explode(',', $value['age_name']));
            }

            return $keyValueArray;
        }

        function getTotalClientNumberOfPeopleInHousehold()
        {
            $result = $this->mysqli->query("SELECT SUM(c.number_of_people_in_household) AS total_number_of_people_in_household
                                            FROM clients c");
            return $result->fetch_assoc();
        }

        function getAllClientRequests()
        {
            $result = $this->mysqli->query("SELECT cr.*, CONCAT(uc.first_name, ' ', uc.last_name) AS created_full_name, CONCAT(um.first_name, ' ', um.last_name) AS modified_full_name, CONCAT(c.first_name, ' ', c.last_name) AS client_name, crr.name AS client_request_reason_name, cro.name AS client_request_outcome_name, crref.name AS client_request_referral_name, sp.name AS sign_post_name
                                            FROM client_requests cr
                                            LEFT JOIN clients c
                                            ON cr.client_id = c.id
                                            LEFT JOIN client_request_reasons crr
                                            ON cr.client_request_reason_id = crr.id
                                            LEFT JOIN client_request_outcomes cro
                                            ON cr.client_request_outcome_id = cro.id
                                            LEFT JOIN client_request_referrals crref
                                            ON cr.client_request_referral_id = crref.id
                                            LEFT JOIN sign_posts sp
                                            ON cr.sign_post_id = sp.id
                                            LEFT JOIN users uc
                                            ON cr.created_by_user_id = uc.id
                                            LEFT JOIN users um
                                            ON cr.modified_by_user_id = um.id
                                            ORDER BY cr.id ASC");
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        function getAllClientRequestsById()
        {
            // To Fill In
        }

        function getAllClientRequestsByClientId()
        {
            // To Fill In
        }

        function getSettings()
        {
            $result = $this->mysqli->query("SELECT s.*, CONCAT(uc.first_name, ' ', uc.last_name) AS created_full_name, CONCAT(um.first_name, ' ', um.last_name) AS modified_full_name
                                            FROM settings s
                                            LEFT JOIN users uc
                                            ON s.created_by_user_id = uc.id
                                            LEFT JOIN users um
                                            ON s.modified_by_user_id = um.id
                                            ORDER BY s.id ASC");
            return $result->fetch_assoc();
        }

        function getAllClientRequestOutcomes()
        {
            $result = $this->mysqli->query("SELECT cro.*, CONCAT(uc.first_name, ' ', uc.last_name) AS created_full_name, CONCAT(um.first_name, ' ', um.last_name) AS modified_full_name
                                            FROM client_request_outcomes cro
                                            LEFT JOIN users uc
                                            ON cro.created_by_user_id = uc.id
                                            LEFT JOIN users um
                                            ON cro.modified_by_user_id = um.id
                                            ORDER BY cro.id ASC");
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        function getAllClientRequestReasons()
        {
            $result = $this->mysqli->query("SELECT crr.*, CONCAT(uc.first_name, ' ', uc.last_name) AS created_full_name, CONCAT(um.first_name, ' ', um.last_name) AS modified_full_name
                                            FROM client_request_reasons crr
                                            LEFT JOIN users uc
                                            ON crr.created_by_user_id = uc.id
                                            LEFT JOIN users um
                                            ON crr.modified_by_user_id = um.id
                                            ORDER BY crr.id ASC");
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        function getAllClientRequestReferrals()
        {
            $result = $this->mysqli->query("SELECT crr.*, CONCAT(uc.first_name, ' ', uc.last_name) AS created_full_name, CONCAT(um.first_name, ' ', um.last_name) AS modified_full_name
                                            FROM client_request_referrals crr
                                            LEFT JOIN users uc
                                            ON crr.created_by_user_id = uc.id
                                            LEFT JOIN users um
                                            ON crr.modified_by_user_id = um.id
                                            ORDER BY crr.id ASC");
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        function getAllDisabilities()
        {
            $result = $this->mysqli->query("SELECT d.*, CONCAT(uc.first_name, ' ', uc.last_name) AS created_full_name, CONCAT(um.first_name, ' ', um.last_name) AS modified_full_name
                                            FROM disabilities d
                                            LEFT JOIN users uc
                                            ON d.created_by_user_id = uc.id
                                            LEFT JOIN users um
                                            ON d.modified_by_user_id = um.id
                                            ORDER BY d.id ASC");
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        function getAllEmploymentStatuses()
        {
            $result = $this->mysqli->query("SELECT es.*, CONCAT(uc.first_name, ' ', uc.last_name) AS created_full_name, CONCAT(um.first_name, ' ', um.last_name) AS modified_full_name
                                            FROM employment_statuses es
                                            LEFT JOIN users uc
                                            ON es.created_by_user_id = uc.id
                                            LEFT JOIN users um
                                            ON es.modified_by_user_id = um.id
                                            ORDER BY es.id ASC");
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        function getAllGenders()
        {
            $result = $this->mysqli->query("SELECT g.*, CONCAT(uc.first_name, ' ', uc.last_name) AS created_full_name, CONCAT(um.first_name, ' ', um.last_name) AS modified_full_name
                                            FROM genders g
                                            LEFT JOIN users uc
                                            ON g.created_by_user_id = uc.id
                                            LEFT JOIN users um
                                            ON g.modified_by_user_id = um.id
                                            ORDER BY g.id ASC");
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        function getAllAges()
        {
            $result = $this->mysqli->query("SELECT a.*, CONCAT(uc.first_name, ' ', uc.last_name) AS created_full_name, CONCAT(um.first_name, ' ', um.last_name) AS modified_full_name
                                            FROM ages a
                                            LEFT JOIN users uc
                                            ON a.created_by_user_id = uc.id
                                            LEFT JOIN users um
                                            ON a.modified_by_user_id = um.id
                                            ORDER BY a.id ASC");
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        function getAllSignPosts()
        {
            $result = $this->mysqli->query("SELECT sp.*, CONCAT(uc.first_name, ' ', uc.last_name) AS created_full_name, CONCAT(um.first_name, ' ', um.last_name) AS modified_full_name
                                            FROM sign_posts sp
                                            LEFT JOIN users uc
                                            ON sp.created_by_user_id = uc.id
                                            LEFT JOIN users um
                                            ON sp.modified_by_user_id = um.id
                                            ORDER BY sp.id ASC");
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        function getAllTabs()
        {
            $result = $this->mysqli->query("SELECT t.*, CONCAT(uc.first_name, ' ', uc.last_name) AS created_full_name, CONCAT(um.first_name, ' ', um.last_name) AS modified_full_name
                                            FROM tabs t
                                            LEFT JOIN users uc
                                            ON t.created_by_user_id = uc.id
                                            LEFT JOIN users um
                                            ON t.modified_by_user_id = um.id
                                            ORDER BY t.display_order ASC");
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        function getNextTabOrder()
        {
            $result = $this->mysqli->query("SELECT MAX(t.display_order) AS display_order
                                            FROM tabs t");
            return $result->fetch_assoc()['display_order'] + 1;
        }

        function getExistingTab($tabFieldId, $contentFieldId, $tabId)
        {
            $result = null;
            if ($tabId != null) {
                $result = $this->mysqli->query("SELECT t.* FROM tabs t
                                            WHERE (t.field_id = '" . $this->mysqli->real_escape_string($tabFieldId) . "'
                                            OR t.content_field_id = '" . $this->mysqli->real_escape_string($contentFieldId) . "')
                                            AND t.id != '" . $this->mysqli->real_escape_string($tabId) . "'");
            } else {
                $result = $this->mysqli->query("SELECT t.* FROM tabs t
                                            WHERE t.field_id = '" . $this->mysqli->real_escape_string($tabFieldId) . "'
                                            OR t.content_field_id = '" . $this->mysqli->real_escape_string($contentFieldId) . "'");
            }
            return $result->fetch_assoc();
        }

        function insertTab($request)
        {
            $tabName = $request['tabName'];
            $tabFieldId = $request['tabFieldId'];
            $contentFileName = $request['contentFileName'];
            $contentFieldId = $request['contentFieldId'];
            $tabOrder = $request['tabOrder'];
            $loggedInUserId = $request['loggedInUserId'];
            $resultArray = array();
            
            $result = $this->getExistingTab($tabFieldId, $contentFieldId, null);
            
            if (!empty($result)) {
                $resultArray['errorExists'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>The Following Tab You Are Trying To Add Already Exists With The Same Field/Content Field ID:</strong><br />' . $result['name']  . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                $result = $this->mysqli->query("INSERT IGNORE INTO tabs (
                    name, 
                    field_id, 
                    content_file_name, 
                    content_field_id,
                    display_order,
                    created_by_user_id,
                    created,
                    modified_by_user_id,
                    modified
                ) VALUES (
                    '" . $this->mysqli->real_escape_string($tabName) . "', 
                    '" . $this->mysqli->real_escape_string($tabFieldId) . "', 
                    '" . $this->mysqli->real_escape_string($contentFileName) . "',
                    '" . $this->mysqli->real_escape_string($contentFieldId) . "',
                    '" . $this->mysqli->real_escape_string($tabOrder) . "',
                    '" . $this->mysqli->real_escape_string($loggedInUserId) . "',
                    '" . $this->mysqli->real_escape_string(date('Y-m-d H:i:s')) . "',
                    '" . $this->mysqli->real_escape_string($loggedInUserId) . "',
                    '" . $this->mysqli->real_escape_string(date('Y-m-d H:i:s')) . "')
                ");                
            }
            if ($result === true) {
                $resultArray['success'] .= '<div class="alert alert-success alert-dismissible fade show mb-3" role="alert"><strong>Success! The Following Tab Has Been Added:</strong><br />' . $tabName . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                if ($resultArray['errorExists'] == '') {
                    $resultArray['error'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>Error! The Following Tab Could Not Be Added Due To An Unknown Error, Please Try Again Later:</strong><br />' . $tabName . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }
            return $resultArray;
        }

        function updateTab($request)
        {
            $tabId = $request['tabId'];
            $tabName = $request['tabName'];
            $tabFieldId = $request['tabFieldId'];
            $contentFileName = $request['contentFileName'];
            $contentFieldId = $request['contentFieldId'];
            $tabOrder = $request['tabOrder'];
            $loggedInUserId = $request['loggedInUserId'];
            $resultArray = array();

            $result = $this->getExistingTab($tabFieldId, $contentFieldId, $tabId);
            
            if (!empty($result)) {
                $resultArray['errorExists'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>The Following Tab You Are Trying To Update Already Exists With The Same Field/Content Field ID:</strong><br />' . $result['name']  . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                $result = $this->mysqli->query("UPDATE tabs t
                SET t.name = '" . $this->mysqli->real_escape_string($tabName) . "',
                t.field_id = '" . $this->mysqli->real_escape_string($tabFieldId) . "',
                t.content_file_name = '" . $this->mysqli->real_escape_string($contentFileName) . "',
                t.content_field_id = '" . $this->mysqli->real_escape_string($contentFieldId) . "',
                t.display_order = '" . $this->mysqli->real_escape_string($tabOrder) . "',
                t.modified_by_user_id = '" . $this->mysqli->real_escape_string($loggedInUserId) . "',
                t.modified = '" . $this->mysqli->real_escape_string(date('Y-m-d H:i:s')) . "'
                WHERE t.id = '" . $this->mysqli->real_escape_string($tabId) . "'");                
            }
            if ($result === true) {
                $resultArray['success'] .= '<div class="alert alert-success alert-dismissible fade show mb-3" role="alert"><strong>Success! The Tab With The Following ID Has Been Updated: </strong>' . $tabId . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                if ($resultArray['errorExists'] == '') {
                    $resultArray['error'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>Error! The Tab With The Following ID Could Not Be Updated Due To An Unknown Error, Please Try Again Later: </strong><br />' . $tabId . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }
            return $resultArray;
        }

        function deleteTabsById($ids)
        {
            $resultArray = array();
            $item = '';
            $tableName = 'Tabs';
            $messageText = 'Deleted';
            foreach ($ids as $id) {
                $rows = $this->getRequestTypesById($id);
                foreach ($rows as $row) {
                    $result = $this->mysqli->query("DELETE FROM request_types
                                        WHERE id = '" . $this->mysqli->real_escape_string($row['id']) . "'");
                    $item = '<strong>' . $row['name']. '</strong><br />';
                    if ($result === true) {
                        $resultArray['success'] .= '<div class="toast-container position-fixed top-0 start-0 p-3"><div class="toast show text-bg-success" role="alert" aria-live="assertive" aria-atomic="true"><div class="toast-header"><strong class="me-auto">Success! The Following ' . $tableName . ' Has Been ' . $messageText . ':</strong><button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button></div><div class="toast-body">' . $item . '</div></div></div>';
                    } else {
                        $resultArray['error'] .= '<div class="toast-container position-fixed top-0 start-0 p-3"><div class="toast show text-bg-danger" role="alert" aria-live="assertive" aria-atomic="true"><div class="toast-header"><strong class="me-auto">Error! The Following ' . $tableName . ' Could Not Be ' . $messageText . ' Due To An Unknown Error, Please Try Again Later:</strong><button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button></div><div class="toast-body">' . $item . '</div></div></div>';
                    }                    
                }
            }
            return $resultArray;
        }

        function getExistingUser($userUsername, $userEmail, $userId)
        {
            $result = null;
            if ($userId != null) {
                $result = $this->mysqli->query("SELECT u.* FROM users u
                                            WHERE (u.username = '" . $this->mysqli->real_escape_string($userUsername) . "'
                                            OR u.email = '" . $this->mysqli->real_escape_string($userEmail) . "')
                                            AND u.id != '" . $this->mysqli->real_escape_string($userId) . "'");
            } else {
                $result = $this->mysqli->query("SELECT u.* FROM users u
                                            WHERE u.username = '" . $this->mysqli->real_escape_string($userUsername) . "'
                                            OR u.email = '" . $this->mysqli->real_escape_string($userEmail) . "'");
            }
            return $result->fetch_assoc();
        }

        function insertUser($request)
        {
            $userFirstName = $request['userFirstName'];
            $userLastName = $request['userLastName'];
            $userFullName = $userFirstName . ' ' . $userLastName;
            $userUsername = $request['userUsername'];
            $userEmail = $request['userEmail'];
            $userPassword = password_hash($request['userPassword'], PASSWORD_DEFAULT);
            $userIncorrectLoginAttempts = $request['userIncorrectLoginAttempts'];
            $userStatusId = $request['userUserStatusId'];
            $userRoleId = $request['userUserRoleId'];
            $loggedInUserId = $request['loggedInUserId'];
            $resultArray = array();
            
            $result = $this->getExistingUser($userUsername, $userEmail, null);
            
            if (!empty($result)) {
                $resultArray['errorExists'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>The User You Are Trying To Add Already Exists With The Same Username or Email</strong><br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                $result = $this->mysqli->query("INSERT IGNORE INTO users (
                    first_name,
                    last_name,
                    username,
                    email,
                    password,
                    incorrect_login_attempts,
                    user_status_id,
                    user_role_id,
                    created_by_user_id,
                    created,
                    modified_by_user_id,
                    modified
                ) VALUES (
                    '" . $this->mysqli->real_escape_string($userFirstName) . "',
                    '" . $this->mysqli->real_escape_string($userLastName) . "',
                    '" . $this->mysqli->real_escape_string($userUsername) . "',
                    '" . $this->mysqli->real_escape_string($userEmail) . "',
                    '" . $userPassword . "',
                    '" . $this->mysqli->real_escape_string($userIncorrectLoginAttempts) . "',
                    '" . $this->mysqli->real_escape_string($userStatusId) . "',
                    '" . $this->mysqli->real_escape_string($userRoleId) . "',
                    '" . $this->mysqli->real_escape_string($loggedInUserId) . "',
                    '" . $this->mysqli->real_escape_string(date('Y-m-d H:i:s')) . "',
                    '" . $this->mysqli->real_escape_string($loggedInUserId) . "',
                    '" . $this->mysqli->real_escape_string(date('Y-m-d H:i:s')) . "')
                ");                
            }
            if ($result === true) {
                $resultArray['success'] .= '<div class="alert alert-success alert-dismissible fade show mb-3" role="alert"><strong>Success! The Following User Has Been Added:</strong><br />' . $userFullName . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                if ($resultArray['errorExists'] == '') {
                    $resultArray['error'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>Error! The Following User Could Not Be Added Due To An Unknown Error, Please Try Again Later:</strong><br />' . $userFullName . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }
            return $resultArray;
        }

        function updateUser($request)
        {
            $userId = $request['userId'];
            $userFirstName = $request['userFirstName'];
            $userLastName = $request['userLastName'];
            $userFullName = $userFirstName . ' ' . $userLastName;
            $userUsername = $request['userUsername'];
            $userEmail = $request['userEmail'];
            $userPassword = (!empty($request['userPassword'])) ? password_hash($request['userPassword'], PASSWORD_DEFAULT) : '';
            $updatePasswordField = (!empty($userPassword)) ? "u.password = '" . $this->mysqli->real_escape_string($userPassword) . "'," : "";
            $userIncorrectLoginAttempts = $request['userIncorrectLoginAttempts'];
            $userStatusId = $request['userUserStatusId'];
            $userRoleId = $request['userUserRoleId'];
            $loggedInUserId = $request['loggedInUserId'];
            $resultArray = array();

            $result = $this->getExistingUser($userUsername, $userEmail, $userId);
            
            if (!empty($result)) {
                $resultArray['errorExists'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>The User You Are Trying To Update Already Exists With The Same Username or Email</strong><br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                $result = $this->mysqli->query("UPDATE users u
                SET u.first_name = '" . $this->mysqli->real_escape_string($userFirstName) . "',
                u.last_name = '" . $this->mysqli->real_escape_string($userLastName) . "',
                u.username = '" . $this->mysqli->real_escape_string($userUsername) . "',
                u.email = '" . $this->mysqli->real_escape_string($userEmail) . "',
                " . $updatePasswordField . "
                u.incorrect_login_attempts = '" . $this->mysqli->real_escape_string($userIncorrectLoginAttempts) . "',
                u.user_status_id = '" . $this->mysqli->real_escape_string($userStatusId) . "',
                u.user_role_id = '" . $this->mysqli->real_escape_string($userRoleId) . "',
                u.modified_by_user_id = '" . $this->mysqli->real_escape_string($loggedInUserId) . "',
                u.modified = '" . $this->mysqli->real_escape_string(date('Y-m-d H:i:s')) . "'
                WHERE u.id = '" . $this->mysqli->real_escape_string($userId) . "'");              
            }
            if ($result === true) {
                $resultArray['success'] .= '<div class="alert alert-success alert-dismissible fade show mb-3" role="alert"><strong>Success! The User With The Following ID Has Been Updated: </strong>' . $userId . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                if ($resultArray['errorExists'] == '') {
                    $resultArray['error'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>Error! The User With The Following ID Could Not Be Updated Due To An Unknown Error, Please Try Again Later: </strong><br />' . $userId . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }
            return $resultArray;
        }

        function deleteUserById($ids)
        {
            // To Fill In Later
        }

        function insertClient($request)
        {
            $clientFirstName = $request['clientFirstName'];
            $clientLastName = $request['clientLastName'];
            $clientName = $clientFirstName . ' ' . $clientLastName;
            $clientGenderId = $request['clientGenderId'];
            $clientAgeId = $request['clientAgeId'];
            $clientEmail = $request['clientEmail'];
            $clientMobile = $request['clientMobile'];
            $clientPostcode = strtoupper($request['clientPostcode']);
            $clientEmploymentStatusId = $request['clientEmploymentStatusId'];
            $clientNumberOfPeopleInHousehold = $request['clientNumberOfPeopleInHousehold'];
            $clientDisabilityId = $request['clientDisabilityId'];
            $loggedInUserId = $request['loggedInUserId'];
            $resultArray = array();
            
            $result = $this->mysqli->query("INSERT IGNORE INTO clients (
                first_name, 
                last_name, 
                gender_id, 
                age_id,
                email,
                mobile,
                postcode,
                employment_status_id,
                number_of_people_in_household,
                disability_id,
                created_by_user_id,
                created,
                modified_by_user_id,
                modified
            ) VALUES (
                '" . $this->mysqli->real_escape_string($clientFirstName) . "', 
                '" . $this->mysqli->real_escape_string($clientLastName) . "', 
                '" . $this->mysqli->real_escape_string($clientGenderId) . "',
                '" . $this->mysqli->real_escape_string($clientAgeId) . "',
                '" . $this->mysqli->real_escape_string($clientEmail) . "',
                '" . $this->mysqli->real_escape_string($clientMobile) . "',
                '" . $this->mysqli->real_escape_string($clientPostcode) . "',
                '" . $this->mysqli->real_escape_string($clientEmploymentStatusId) . "',
                '" . $this->mysqli->real_escape_string($clientNumberOfPeopleInHousehold) . "',
                '" . $this->mysqli->real_escape_string($clientDisabilityId) . "',
                '" . $this->mysqli->real_escape_string($loggedInUserId) . "',
                '" . $this->mysqli->real_escape_string(date('Y-m-d H:i:s')) . "',
                '" . $this->mysqli->real_escape_string($loggedInUserId) . "',
                '" . $this->mysqli->real_escape_string(date('Y-m-d H:i:s')) . "')
            ");

            if ($result === true) {
                $resultArray['success'] .= '<div class="alert alert-success alert-dismissible fade show mb-3" role="alert"><strong>Success! The Following Client Has Been Added:</strong><br />' . $clientName . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                if ($resultArray['errorExists'] == '') {
                    $resultArray['error'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>Error! The Following Client Could Not Be Added Due To An Unknown Error, Please Try Again Later:</strong><br />' . $clientName . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }
            return $resultArray;
        }

        function updateClient($request)
        {
            $clientId = $request['clientId'];
            $clientFirstName = $request['clientFirstName'];
            $clientLastName = $request['clientLastName'];
            $clientName = $clientFirstName . ' ' . $clientLastName;
            $clientGenderId = $request['clientGenderId'];
            $clientAgeId = $request['clientAgeId'];
            $clientEmail = $request['clientEmail'];
            $clientMobile = $request['clientMobile'];
            $clientPostcode = strtoupper($request['clientPostcode']);
            $clientEmploymentStatusId = $request['clientEmploymentStatusId'];
            $clientNumberOfPeopleInHousehold = $request['clientNumberOfPeopleInHousehold'];
            $clientDisabilityId = $request['clientDisabilityId'];
            $loggedInUserId = $request['loggedInUserId'];
            $resultArray = array();

            $result = $this->mysqli->query("UPDATE clients c
            SET c.first_name = '" . $this->mysqli->real_escape_string($clientFirstName) . "',
            c.last_name = '" . $this->mysqli->real_escape_string($clientLastName) . "',
            c.gender_id = '" . $this->mysqli->real_escape_string($clientGenderId) . "',
            c.age_id = '" . $this->mysqli->real_escape_string($clientAgeId) . "',
            c.email = '" . $this->mysqli->real_escape_string($clientEmail) . "',
            c.mobile = '" . $this->mysqli->real_escape_string($clientMobile) . "',
            c.postcode = '" . $this->mysqli->real_escape_string($clientPostcode) . "',
            c.employment_status_id = '" . $this->mysqli->real_escape_string($clientEmploymentStatusId) . "',
            c.number_of_people_in_household = '" . $this->mysqli->real_escape_string($clientNumberOfPeopleInHousehold) . "',
            c.disability_id = '" . $this->mysqli->real_escape_string($clientDisabilityId) . "',
            c.modified_by_user_id = '" . $this->mysqli->real_escape_string($loggedInUserId) . "',
            c.modified = '" . $this->mysqli->real_escape_string(date('Y-m-d H:i:s')) . "'
            WHERE c.id = '" . $this->mysqli->real_escape_string($clientId) . "'");
            
            if ($result === true) {
                $resultArray['success'] .= '<div class="alert alert-success alert-dismissible fade show mb-3" role="alert"><strong>Success! The Client With The Following ID Has Been Updated: </strong>' . $clientId . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                if ($resultArray['errorExists'] == '') {
                    $resultArray['error'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>Error! The Client With The Following ID Could Not Be Updated Due To An Unknown Error, Please Try Again Later: </strong><br />' . $clientId . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }
            return $resultArray;
        }

        function deleteClientsById($ids)
        {
            $resultArray = array();
            $item = '';
            $tableName = 'Clients';
            $messageText = 'Deleted';
            foreach ($ids as $id) {
                $rows = $this->getRequestTypesById($id);
                foreach ($rows as $row) {
                    $result = $this->mysqli->query("DELETE FROM request_types
                                        WHERE id = '" . $this->mysqli->real_escape_string($row['id']) . "'");
                    $item = '<strong>' . $row['name']. '</strong><br />';
                    if ($result === true) {
                        $resultArray['success'] .= '<div class="toast-container position-fixed top-0 start-0 p-3"><div class="toast show text-bg-success" role="alert" aria-live="assertive" aria-atomic="true"><div class="toast-header"><strong class="me-auto">Success! The Following ' . $tableName . ' Has Been ' . $messageText . ':</strong><button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button></div><div class="toast-body">' . $item . '</div></div></div>';
                    } else {
                        $resultArray['error'] .= '<div class="toast-container position-fixed top-0 start-0 p-3"><div class="toast show text-bg-danger" role="alert" aria-live="assertive" aria-atomic="true"><div class="toast-header"><strong class="me-auto">Error! The Following ' . $tableName . ' Could Not Be ' . $messageText . ' Due To An Unknown Error, Please Try Again Later:</strong><button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button></div><div class="toast-body">' . $item . '</div></div></div>';
                    }                    
                }
            }
            return $resultArray;
        }

        function insertClientRequest($request)
        {
            $clientRequestId = $request['clientRequestId'];
            $clientId = $request['clientId'];
            $clientRequestReasonId = $request['clientRequestReasonId'];
            $clientRequestOutcomeId = $request['clientRequestOutcomeId'];
            $clientRequestReferralId = $request['clientRequestReferralId'];
            $signPostId = $request['signPostId'];
            $notes = $request['notes'];
            $loggedInUserId = $request['loggedInUserId'];
            $resultArray = array();
            
            $result = $this->mysqli->query("INSERT IGNORE INTO client_requests (
                client_id, 
                client_request_reason_id, 
                client_request_outcome_id, 
                client_request_referral_id,
                sign_post_id,
                notes,
                created_by_user_id,
                created,
                modified_by_user_id,
                modified
            ) VALUES (
                '" . $this->mysqli->real_escape_string($clientId) . "', 
                '" . $this->mysqli->real_escape_string($clientRequestReasonId) . "', 
                '" . $this->mysqli->real_escape_string($clientRequestOutcomeId) . "',
                '" . $this->mysqli->real_escape_string($clientRequestReferralId) . "',
                '" . $this->mysqli->real_escape_string($signPostId) . "',
                '" . $this->mysqli->real_escape_string($notes) . "',
                '" . $this->mysqli->real_escape_string($loggedInUserId) . "',
                '" . $this->mysqli->real_escape_string(date('Y-m-d H:i:s')) . "',
                '" . $this->mysqli->real_escape_string($loggedInUserId) . "',
                '" . $this->mysqli->real_escape_string(date('Y-m-d H:i:s')) . "')
            ");

            if ($result === true) {
                $resultArray['success'] .= '<div class="alert alert-success alert-dismissible fade show mb-3" role="alert"><strong>Success! Client Request Has Been Added:</strong><br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                if ($resultArray['errorExists'] == '') {
                    $resultArray['error'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>Error! Client Request Could Not Be Added Due To An Unknown Error, Please Try Again Later:</strong><br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }
            return $resultArray;
        }

        function updateClientRequest($request)
        {
            $clientRequestId = $request['clientRequestId'];
            $clientId = $request['clientId'];
            $clientRequestReasonId = $request['clientRequestReasonId'];
            $clientRequestOutcomeId = $request['clientRequestOutcomeId'];
            $clientRequestReferralId = $request['clientRequestReferralId'];
            $signPostId = $request['signPostId'];
            $notes = $request['notes'];
            $loggedInUserId = $request['loggedInUserId'];
            $resultArray = array();

            $result = $this->mysqli->query("UPDATE client_requests cr
            SET cr.client_id = '" . $this->mysqli->real_escape_string($clientId) . "',
            cr.client_request_reason_id = '" . $this->mysqli->real_escape_string($clientRequestReasonId) . "',
            cr.client_request_outcome_id = '" . $this->mysqli->real_escape_string($clientRequestOutcomeId) . "',
            cr.client_request_referral_id = '" . $this->mysqli->real_escape_string($clientRequestReferralId) . "',
            cr.sign_post_id = '" . $this->mysqli->real_escape_string($signPostId) . "',
            cr.notes = '" . $this->mysqli->real_escape_string($notes) . "',
            cr.modified_by_user_id = '" . $this->mysqli->real_escape_string($loggedInUserId) . "',
            cr.modified = '" . $this->mysqli->real_escape_string(date('Y-m-d H:i:s')) . "'
            WHERE cr.id = '" . $this->mysqli->real_escape_string($clientRequestId) . "'");
            
            if ($result === true) {
                $resultArray['success'] .= '<div class="alert alert-success alert-dismissible fade show mb-3" role="alert"><strong>Success! The Client Request With The Following ID Has Been Updated: </strong>' . $clientRequestId . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                if ($resultArray['errorExists'] == '') {
                    $resultArray['error'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>Error! The Client Request With The Following ID Could Not Be Updated Due To An Unknown Error, Please Try Again Later: </strong><br />' . $clientRequestId . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }
            return $resultArray;
        }

        function deleteClientRequestsById($ids)
        {
            $resultArray = array();
            $item = '';
            $tableName = 'Clients';
            $messageText = 'Deleted';
            foreach ($ids as $id) {
                $rows = $this->getRequestTypesById($id);
                foreach ($rows as $row) {
                    $result = $this->mysqli->query("DELETE FROM request_types
                                        WHERE id = '" . $this->mysqli->real_escape_string($row['id']) . "'");
                    $item = '<strong>' . $row['name']. '</strong><br />';
                    if ($result === true) {
                        $resultArray['success'] .= '<div class="toast-container position-fixed top-0 start-0 p-3"><div class="toast show text-bg-success" role="alert" aria-live="assertive" aria-atomic="true"><div class="toast-header"><strong class="me-auto">Success! The Following ' . $tableName . ' Has Been ' . $messageText . ':</strong><button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button></div><div class="toast-body">' . $item . '</div></div></div>';
                    } else {
                        $resultArray['error'] .= '<div class="toast-container position-fixed top-0 start-0 p-3"><div class="toast show text-bg-danger" role="alert" aria-live="assertive" aria-atomic="true"><div class="toast-header"><strong class="me-auto">Error! The Following ' . $tableName . ' Could Not Be ' . $messageText . ' Due To An Unknown Error, Please Try Again Later:</strong><button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button></div><div class="toast-body">' . $item . '</div></div></div>';
                    }                    
                }
            }
            return $resultArray;
        }        

        function getExistingClientRequestOutcome($clientRequestOutcomeName, $clientRequestOutcomeId)
        {
            $result = null;
            if ($clientRequestOutcomeId != null) {
                $result = $this->mysqli->query("SELECT cro.* FROM client_request_outcomes cro
                                            WHERE cro.name = '" . $this->mysqli->real_escape_string($clientRequestOutcomeName) . "'
                                            AND cro.id != '" . $this->mysqli->real_escape_string($clientRequestOutcomeId) . "'");
            } else {
                $result = $this->mysqli->query("SELECT cro.* FROM client_request_outcomes cro
                                            WHERE cro.name = '" . $this->mysqli->real_escape_string($clientRequestOutcomeName) . "'");
            }
            return $result->fetch_assoc();
        }

        function insertClientRequestOutcome($request)
        {
            $clientRequestOutcomeName = $request['clientRequestOutcomeName'];
            $loggedInUserId = $request['loggedInUserId'];
            $resultArray = array();
            
            $result = $this->getExistingClientRequestOutcome($clientRequestOutcomeName, null);
            
            if (!empty($result)) {
                $resultArray['errorExists'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>The Following Tab You Are Trying To Add Already Exists With The Same Name:</strong><br />' . $result['name']  . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                $result = $this->mysqli->query("INSERT IGNORE INTO client_request_outcomes (
                    name,
                    created_by_user_id,
                    created,
                    modified_by_user_id,
                    modified
                ) VALUES (
                    '" . $this->mysqli->real_escape_string($clientRequestOutcomeName) . "',
                    '" . $this->mysqli->real_escape_string($loggedInUserId) . "',
                    '" . $this->mysqli->real_escape_string(date('Y-m-d H:i:s')) . "',
                    '" . $this->mysqli->real_escape_string($loggedInUserId) . "',
                    '" . $this->mysqli->real_escape_string(date('Y-m-d H:i:s')) . "')
                ");                
            }
            if ($result === true) {
                $resultArray['success'] .= '<div class="alert alert-success alert-dismissible fade show mb-3" role="alert"><strong>Success! The Following Client Request Outcome Has Been Added:</strong><br />' . $clientRequestOutcomeName . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                if ($resultArray['errorExists'] == '') {
                    $resultArray['error'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>Error! The Following Client Request Outcome Could Not Be Added Due To An Unknown Error, Please Try Again Later:</strong><br />' . $clientRequestOutcomeName . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }
            return $resultArray;
        }

        function updateClientRequestOutcome($request)
        {
            $clientRequestOutcomeId = $request['clientRequestOutcomeId'];
            $clientRequestOutcomeName = $request['clientRequestOutcomeName'];
            $loggedInUserId = $request['loggedInUserId'];
            $resultArray = array();

            $result = $this->getExistingClientRequestOutcome($clientRequestOutcomeName, $clientRequestOutcomeId);
            
            if (!empty($result)) {
                $resultArray['errorExists'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>The Following Client Request Outcome You Are Trying To Update Already Exists With The Same Name:</strong><br />' . $result['name']  . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                $result = $this->mysqli->query("UPDATE client_request_outcomes cro
                SET cro.name = '" . $this->mysqli->real_escape_string($clientRequestOutcomeName) . "',
                cro.modified_by_user_id = '" . $this->mysqli->real_escape_string($loggedInUserId) . "',
                cro.modified = '" . $this->mysqli->real_escape_string(date('Y-m-d H:i:s')) . "'
                WHERE cro.id = '" . $this->mysqli->real_escape_string($clientRequestOutcomeId) . "'");              
            }
            if ($result === true) {
                $resultArray['success'] .= '<div class="alert alert-success alert-dismissible fade show mb-3" role="alert"><strong>Success! The Client Request Outcome With The Following ID Has Been Updated: </strong>' . $clientRequestOutcomeId . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                if ($resultArray['errorExists'] == '') {
                    $resultArray['error'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>Error! The Client Request Outcome With The Following ID Could Not Be Updated Due To An Unknown Error, Please Try Again Later: </strong><br />' . $clientRequestOutcomeId . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }
            return $resultArray;
        }

        function deleteClientRequestOutcomesById($ids)
        {
            // To Fill In Later
        }

        function getExistingClientRequestReason($clientRequestReasonName, $clientRequestReasonId)
        {
            $result = null;
            if ($clientRequestReasonId != null) {
                $result = $this->mysqli->query("SELECT crr.* FROM client_request_reasons crr
                                            WHERE crr.name = '" . $this->mysqli->real_escape_string($clientRequestReasonName) . "'
                                            AND crr.id != '" . $this->mysqli->real_escape_string($clientRequestReasonId) . "'");
            } else {
                $result = $this->mysqli->query("SELECT crr.* FROM client_request_reasons crr
                                            WHERE crr.name = '" . $this->mysqli->real_escape_string($clientRequestReasonName) . "'");
            }
            return $result->fetch_assoc();
        }

        function insertClientRequestReason($request)
        {
            $clientRequestReasonName = $request['clientRequestReasonName'];
            $loggedInUserId = $request['loggedInUserId'];
            $resultArray = array();
            
            $result = $this->getExistingClientRequestReason($clientRequestReasonName, null);
            
            if (!empty($result)) {
                $resultArray['errorExists'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>The Following Tab You Are Trying To Add Already Exists With The Same Name:</strong><br />' . $result['name']  . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                $result = $this->mysqli->query("INSERT IGNORE INTO client_request_reasons (
                    name,
                    created_by_user_id,
                    created,
                    modified_by_user_id,
                    modified
                ) VALUES (
                    '" . $this->mysqli->real_escape_string($clientRequestReasonName) . "',
                    '" . $this->mysqli->real_escape_string($loggedInUserId) . "',
                    '" . $this->mysqli->real_escape_string(date('Y-m-d H:i:s')) . "',
                    '" . $this->mysqli->real_escape_string($loggedInUserId) . "',
                    '" . $this->mysqli->real_escape_string(date('Y-m-d H:i:s')) . "')
                ");                
            }
            if ($result === true) {
                $resultArray['success'] .= '<div class="alert alert-success alert-dismissible fade show mb-3" role="alert"><strong>Success! The Following Client Request Reason Has Been Added:</strong><br />' . $clientRequestReasonName . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                if ($resultArray['errorExists'] == '') {
                    $resultArray['error'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>Error! The Following Client Request Reason Could Not Be Added Due To An Unknown Error, Please Try Again Later:</strong><br />' . $clientRequestReasonName . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }
            return $resultArray;       
         }

        function updateClientRequestReason($request)
        {
            $clientRequestReasonId = $request['clientRequestReasonId'];
            $clientRequestReasonName = $request['clientRequestReasonName'];
            $loggedInUserId = $request['loggedInUserId'];
            $resultArray = array();

            $result = $this->getExistingClientRequestReason($clientRequestReasonName, $clientRequestReasonId);
            
            if (!empty($result)) {
                $resultArray['errorExists'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>The Following Client Request Reason You Are Trying To Update Already Exists With The Same Name:</strong><br />' . $result['name']  . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                $result = $this->mysqli->query("UPDATE client_request_reasons crr
                SET crr.name = '" . $this->mysqli->real_escape_string($clientRequestReasonName) . "',
                crr.modified_by_user_id = '" . $this->mysqli->real_escape_string($loggedInUserId) . "',
                crr.modified = '" . $this->mysqli->real_escape_string(date('Y-m-d H:i:s')) . "'
                WHERE crr.id = '" . $this->mysqli->real_escape_string($clientRequestReasonId) . "'");              
            }
            if ($result === true) {
                $resultArray['success'] .= '<div class="alert alert-success alert-dismissible fade show mb-3" role="alert"><strong>Success! The Client Request Reason With The Following ID Has Been Updated: </strong>' . $clientRequestReasonId . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                if ($resultArray['errorExists'] == '') {
                    $resultArray['error'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>Error! The Client Request Reason With The Following ID Could Not Be Updated Due To An Unknown Error, Please Try Again Later: </strong><br />' . $clientRequestReasonId . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }
            return $resultArray;
        }

        function deleteClientRequestReasonsById($ids)
        {
            // To Fill In Later
        }

        function getExistingClientRequestReferral($clientRequestReferralName, $clientRequestReferralId)
        {
            $result = null;
            if ($clientRequestReferralId != null) {
                $result = $this->mysqli->query("SELECT crr.* FROM client_request_referrals crr
                                            WHERE crr.name = '" . $this->mysqli->real_escape_string($clientRequestReferralName) . "'
                                            AND crr.id != '" . $this->mysqli->real_escape_string($clientRequestReferralId) . "'");
            } else {
                $result = $this->mysqli->query("SELECT crr.* FROM client_request_referrals crr
                                            WHERE crr.name = '" . $this->mysqli->real_escape_string($clientRequestReferralName) . "'");
            }
            return $result->fetch_assoc();
        }

        function insertClientRequestReferral($request)
        {
            $clientRequestReferralName = $request['clientRequestReferralName'];
            $loggedInUserId = $request['loggedInUserId'];
            $resultArray = array();
            
            $result = $this->getExistingClientRequestReferral($clientRequestReferralName, null);
            
            if (!empty($result)) {
                $resultArray['errorExists'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>The Following Tab You Are Trying To Add Already Exists With The Same Name:</strong><br />' . $result['name']  . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                $result = $this->mysqli->query("INSERT IGNORE INTO client_request_referrals (
                    name,
                    created_by_user_id,
                    created,
                    modified_by_user_id,
                    modified
                ) VALUES (
                    '" . $this->mysqli->real_escape_string($clientRequestReferralName) . "',
                    '" . $this->mysqli->real_escape_string($loggedInUserId) . "',
                    '" . $this->mysqli->real_escape_string(date('Y-m-d H:i:s')) . "',
                    '" . $this->mysqli->real_escape_string($loggedInUserId) . "',
                    '" . $this->mysqli->real_escape_string(date('Y-m-d H:i:s')) . "')
                ");                
            }
            if ($result === true) {
                $resultArray['success'] .= '<div class="alert alert-success alert-dismissible fade show mb-3" role="alert"><strong>Success! The Following Client Request Referral Has Been Added:</strong><br />' . $clientRequestReferralName . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                if ($resultArray['errorExists'] == '') {
                    $resultArray['error'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>Error! The Following Client Request Referral Could Not Be Added Due To An Unknown Error, Please Try Again Later:</strong><br />' . $clientRequestReferralName . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }
            return $resultArray;          }

        function updateClientRequestReferral($request)
        {
            $clientRequestReferralId = $request['clientRequestReferralId'];
            $clientRequestReferralName = $request['clientRequestReferralName'];
            $loggedInUserId = $request['loggedInUserId'];
            $resultArray = array();

            $result = $this->getExistingClientRequestReferral($clientRequestReferralName, $clientRequestReferralId);
            
            if (!empty($result)) {
                $resultArray['errorExists'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>The Following Client Request Referral You Are Trying To Update Already Exists With The Same Name:</strong><br />' . $result['name']  . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                $result = $this->mysqli->query("UPDATE client_request_referrals crr
                SET crr.name = '" . $this->mysqli->real_escape_string($clientRequestReferralName) . "',
                crr.modified_by_user_id = '" . $this->mysqli->real_escape_string($loggedInUserId) . "',
                crr.modified = '" . $this->mysqli->real_escape_string(date('Y-m-d H:i:s')) . "'
                WHERE crr.id = '" . $this->mysqli->real_escape_string($clientRequestReferralId) . "'");              
            }
            if ($result === true) {
                $resultArray['success'] .= '<div class="alert alert-success alert-dismissible fade show mb-3" role="alert"><strong>Success! The Client Request Referral With The Following ID Has Been Updated: </strong>' . $clientRequestReferralId . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                if ($resultArray['errorExists'] == '') {
                    $resultArray['error'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>Error! The Client Request Referral With The Following ID Could Not Be Updated Due To An Unknown Error, Please Try Again Later: </strong><br />' . $clientRequestReferralId . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }
            return $resultArray;
        }

        function deleteClientRequestReferralsById($ids)
        {
            // To Fill In Later
        }

        function getExistingDisability($disabilityName, $disabilityId)
        {
            $result = null;
            if ($disabilityId != null) {
                $result = $this->mysqli->query("SELECT d.* FROM disabilities d
                                            WHERE d.name = '" . $this->mysqli->real_escape_string($disabilityName) . "'
                                            AND d.id != '" . $this->mysqli->real_escape_string($disabilityId) . "'");
            } else {
                $result = $this->mysqli->query("SELECT d.* FROM  disabilities d
                                            WHERE d.name = '" . $this->mysqli->real_escape_string($disabilityName) . "'");
            }
            return $result->fetch_assoc();
        }

        function insertDisability($request)
        {
            $disabilityName = $request['disabilityName'];
            $loggedInUserId = $request['loggedInUserId'];
            $resultArray = array();
            
            $result = $this->getExistingDisability($disabilityName, null);
            
            if (!empty($result)) {
                $resultArray['errorExists'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>The Following Tab You Are Trying To Add Already Exists With The Same Name:</strong><br />' . $result['name']  . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                $result = $this->mysqli->query("INSERT IGNORE INTO disabilities (
                    name,
                    created_by_user_id,
                    created,
                    modified_by_user_id,
                    modified
                ) VALUES (
                    '" . $this->mysqli->real_escape_string($disabilityName) . "',
                    '" . $this->mysqli->real_escape_string($loggedInUserId) . "',
                    '" . $this->mysqli->real_escape_string(date('Y-m-d H:i:s')) . "',
                    '" . $this->mysqli->real_escape_string($loggedInUserId) . "',
                    '" . $this->mysqli->real_escape_string(date('Y-m-d H:i:s')) . "')
                ");                
            }
            if ($result === true) {
                $resultArray['success'] .= '<div class="alert alert-success alert-dismissible fade show mb-3" role="alert"><strong>Success! The Following Disability Has Been Added:</strong><br />' . $disabilityName . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                if ($resultArray['errorExists'] == '') {
                    $resultArray['error'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>Error! The Following Disability Could Not Be Added Due To An Unknown Error, Please Try Again Later:</strong><br />' . $disabilityName . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }
            return $resultArray;  
        }

        function updateDisability($request)
        {
            $disabilityId = $request['disabilityId'];
            $disabilityName = $request['disabilityName'];
            $loggedInUserId = $request['loggedInUserId'];
            $resultArray = array();

            $result = $this->getExistingDisability($disabilityName, $disabilityId);
            
            if (!empty($result)) {
                $resultArray['errorExists'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>The Following Disability You Are Trying To Update Already Exists With The Same Name:</strong><br />' . $result['name']  . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                $result = $this->mysqli->query("UPDATE disabilities d
                SET d.name = '" . $this->mysqli->real_escape_string($disabilityName) . "',
                d.modified_by_user_id = '" . $this->mysqli->real_escape_string($loggedInUserId) . "',
                d.modified = '" . $this->mysqli->real_escape_string(date('Y-m-d H:i:s')) . "'
                WHERE d.id = '" . $this->mysqli->real_escape_string($disabilityId) . "'");              
            }
            if ($result === true) {
                $resultArray['success'] .= '<div class="alert alert-success alert-dismissible fade show mb-3" role="alert"><strong>Success! The Disability With The Following ID Has Been Updated: </strong>' . $disabilityId . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                if ($resultArray['errorExists'] == '') {
                    $resultArray['error'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>Error! The Disability With The Following ID Could Not Be Updated Due To An Unknown Error, Please Try Again Later: </strong><br />' . $disabilityId . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }
            return $resultArray;
        }

        function deleteDisabilitiesById($ids)
        {
            // To Fill In Later
        }

        function getExistingEmploymentStatus($employmentStatusName, $employmentStatusId)
        {
            $result = null;
            if ($employmentStatusId != null) {
                $result = $this->mysqli->query("SELECT es.* FROM employment_statuses es
                                            WHERE es.name = '" . $this->mysqli->real_escape_string($employmentStatusName) . "'
                                            AND es.id != '" . $this->mysqli->real_escape_string($employmentStatusId) . "'");
            } else {
                $result = $this->mysqli->query("SELECT es.* FROM employment_statuses es
                                            WHERE es.name = '" . $this->mysqli->real_escape_string($employmentStatusName) . "'");
            }
            return $result->fetch_assoc();
        }

        function insertEmploymentStatus($request)
        {
               $employmentStatusName = $request['employmentStatusName'];
            $loggedInUserId = $request['loggedInUserId'];
            $resultArray = array();
            
            $result = $this->getExistingEmploymentStatus($employmentStatusName, null);
            
            if (!empty($result)) {
                $resultArray['errorExists'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>The Following Tab You Are Trying To Add Already Exists With The Same Name:</strong><br />' . $result['name']  . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                $result = $this->mysqli->query("INSERT IGNORE INTO employment_statuses (
                    name,
                    created_by_user_id,
                    created,
                    modified_by_user_id,
                    modified
                ) VALUES (
                    '" . $this->mysqli->real_escape_string($employmentStatusName) . "',
                    '" . $this->mysqli->real_escape_string($loggedInUserId) . "',
                    '" . $this->mysqli->real_escape_string(date('Y-m-d H:i:s')) . "',
                    '" . $this->mysqli->real_escape_string($loggedInUserId) . "',
                    '" . $this->mysqli->real_escape_string(date('Y-m-d H:i:s')) . "')
                ");                
            }
            if ($result === true) {
                $resultArray['success'] .= '<div class="alert alert-success alert-dismissible fade show mb-3" role="alert"><strong>Success! The Following employment status Has Been Added:</strong><br />' . $employmentStatusName . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                if ($resultArray['errorExists'] == '') {
                    $resultArray['error'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>Error! The Following employment status Could Not Be Added Due To An Unknown Error, Please Try Again Later:</strong><br />' . $employmentStatusName . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }
            return $resultArray;  
        }

        function updateEmploymentStatus($request)
        {
            $employmentStatusId = $request['employmentStatusId'];
            $employmentStatusName = $request['employmentStatusName'];
            $loggedInUserId = $request['loggedInUserId'];
            $resultArray = array();

            $result = $this->getExistingEmploymentStatus($employmentStatusName, $employmentStatusId);
            
            if (!empty($result)) {
                $resultArray['errorExists'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>The Following employment Status You Are Trying To Update Already Exists With The Same Name:</strong><br />' . $result['name']  . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                $result = $this->mysqli->query("UPDATE employment_statuses es
                SET es.name = '" . $this->mysqli->real_escape_string($employmentStatusName) . "',
                es.modified_by_user_id = '" . $this->mysqli->real_escape_string($loggedInUserId) . "',
                es.modified = '" . $this->mysqli->real_escape_string(date('Y-m-d H:i:s')) . "'
                WHERE es.id = '" . $this->mysqli->real_escape_string($employmentStatusId) . "'");              
            }
            if ($result === true) {
                $resultArray['success'] .= '<div class="alert alert-success alert-dismissible fade show mb-3" role="alert"><strong>Success! The employment status With The Following ID Has Been Updated: </strong>' . $employmentStatusId . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                if ($resultArray['errorExists'] == '') {
                    $resultArray['error'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>Error! The employment status With The Following ID Could Not Be Updated Due To An Unknown Error, Please Try Again Later: </strong><br />' . $employmentStatusId . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }
            return $resultArray;
        }

        function deleteEmploymentStatusesById($ids)
        {
            // To Fill In Later
        }

        function getExistingGender($genderName, $genderId)
        {
            $result = null;
            if ($genderId != null) {
                $result = $this->mysqli->query("SELECT g.* FROM genders g
                                            WHERE g.name = '" . $this->mysqli->real_escape_string($genderName) . "'
                                            AND g.id != '" . $this->mysqli->real_escape_string($genderId) . "'");
            } else {
                $result = $this->mysqli->query("SELECT g.* FROM genders g
                                            WHERE g.name = '" . $this->mysqli->real_escape_string($genderName) . "'");
            }
            return $result->fetch_assoc();
        }

        function insertGender($request)
        {
            $genderName = $request['genderName'];
            $loggedInUserId = $request['loggedInUserId'];
            $resultArray = array();
            
            $result = $this->getExistingGender($genderName, null);
            
            if (!empty($result)) {
                $resultArray['errorExists'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>The Following Gender You Are Trying To Add Already Exists With The Same Name:</strong><br />' . $result['name']  . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                $result = $this->mysqli->query("INSERT IGNORE INTO genders (
                    name,
                    created_by_user_id,
                    created,
                    modified_by_user_id,
                    modified
                ) VALUES (
                    '" . $this->mysqli->real_escape_string($genderName) . "',
                    '" . $this->mysqli->real_escape_string($loggedInUserId) . "',
                    '" . $this->mysqli->real_escape_string(date('Y-m-d H:i:s')) . "',
                    '" . $this->mysqli->real_escape_string($loggedInUserId) . "',
                    '" . $this->mysqli->real_escape_string(date('Y-m-d H:i:s')) . "')
                ");                
            }
            if ($result === true) {
                $resultArray['success'] .= '<div class="alert alert-success alert-dismissible fade show mb-3" role="alert"><strong>Success! The Following Gender Has Been Added:</strong><br />' . $genderName . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                if ($resultArray['errorExists'] == '') {
                    $resultArray['error'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>Error! The Following Gender Could Not Be Added Due To An Unknown Error, Please Try Again Later:</strong><br />' . $genderName . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }
            return $resultArray; 
        }

        function updateGender($request)
        {
            $genderId = $request['genderId'];
            $genderName = $request['genderName'];
            $loggedInUserId = $request['loggedInUserId'];
            $resultArray = array();

            $result = $this->getExistingGender($genderName, $genderId);
            
            if (!empty($result)) {
                $resultArray['errorExists'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>The Following Gender You Are Trying To Update Already Exists With The Same Name:</strong><br />' . $result['name']  . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                $result = $this->mysqli->query("UPDATE genders g
                SET g.name = '" . $this->mysqli->real_escape_string($genderName) . "',
                g.modified_by_user_id = '" . $this->mysqli->real_escape_string($loggedInUserId) . "',
                g.modified = '" . $this->mysqli->real_escape_string(date('Y-m-d H:i:s')) . "'
                WHERE g.id = '" . $this->mysqli->real_escape_string($genderId) . "'");              
            }
            if ($result === true) {
                $resultArray['success'] .= '<div class="alert alert-success alert-dismissible fade show mb-3" role="alert"><strong>Success! The Gender With The Following ID Has Been Updated: </strong>' . $genderId . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                if ($resultArray['errorExists'] == '') {
                    $resultArray['error'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>Error! The Gender With The Following ID Could Not Be Updated Due To An Unknown Error, Please Try Again Later: </strong><br />' . $genderId . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }
            return $resultArray;
        }

        function deleteGendersById($ids)
        {
            // To Fill In Later
        }

        function getExistingAge($ageName, $ageId)
        {
            $result = null;
            if ($ageId != null) {
                $result = $this->mysqli->query("SELECT a.* FROM ages a
                                            WHERE a.name = '" . $this->mysqli->real_escape_string($ageName) . "'
                                            AND a.id != '" . $this->mysqli->real_escape_string($ageId) . "'");
            } else {
                $result = $this->mysqli->query("SELECT a.* FROM ages a
                                            WHERE a.name = '" . $this->mysqli->real_escape_string($ageName) . "'");
            }
            return $result->fetch_assoc();
        }

        function insertAge($request)
        {
            $ageName = $request['ageName'];
            $loggedInUserId = $request['loggedInUserId'];
            $resultArray = array();
            
            $result = $this->getExistingAge($ageName, null);
            
            if (!empty($result)) {
                $resultArray['errorExists'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>The Following Age You Are Trying To Add Already Exists With The Same Name:</strong><br />' . $result['name']  . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                $result = $this->mysqli->query("INSERT IGNORE INTO ages (
                    name,
                    created_by_user_id,
                    created,
                    modified_by_user_id,
                    modified
                ) VALUES (
                    '" . $this->mysqli->real_escape_string($ageName) . "',
                    '" . $this->mysqli->real_escape_string($loggedInUserId) . "',
                    '" . $this->mysqli->real_escape_string(date('Y-m-d H:i:s')) . "',
                    '" . $this->mysqli->real_escape_string($loggedInUserId) . "',
                    '" . $this->mysqli->real_escape_string(date('Y-m-d H:i:s')) . "')
                ");                
            }
            if ($result === true) {
                $resultArray['success'] .= '<div class="alert alert-success alert-dismissible fade show mb-3" role="alert"><strong>Success! The Following Age Has Been Added:</strong><br />' . $genderName . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                if ($resultArray['errorExists'] == '') {
                    $resultArray['error'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>Error! The Following Age Could Not Be Added Due To An Unknown Error, Please Try Again Later:</strong><br />' . $genderName . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }
            return $resultArray; 
        }

        function updateAge($request)
        {
            $ageId = $request['ageId'];
            $ageName = $request['ageName'];
            $loggedInUserId = $request['loggedInUserId'];
            $resultArray = array();

            $result = $this->getExistingAge($ageName, $ageId);
            
            if (!empty($result)) {
                $resultArray['errorExists'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>The Following Age You Are Trying To Update Already Exists With The Same Name:</strong><br />' . $result['name']  . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                $result = $this->mysqli->query("UPDATE ages a
                SET a.name = '" . $this->mysqli->real_escape_string($ageName) . "',
                a.modified_by_user_id = '" . $this->mysqli->real_escape_string($loggedInUserId) . "',
                a.modified = '" . $this->mysqli->real_escape_string(date('Y-m-d H:i:s')) . "'
                WHERE a.id = '" . $this->mysqli->real_escape_string($ageId) . "'");              
            }
            if ($result === true) {
                $resultArray['success'] .= '<div class="alert alert-success alert-dismissible fade show mb-3" role="alert"><strong>Success! The Age With The Following ID Has Been Updated: </strong>' . $genderId . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                if ($resultArray['errorExists'] == '') {
                    $resultArray['error'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>Error! The Age With The Following ID Could Not Be Updated Due To An Unknown Error, Please Try Again Later: </strong><br />' . $genderId . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }
            return $resultArray;
        }

        function deleteAgesById($ids)
        {
            // To Fill In Later
        }

        function getExistingSignPost($signPostName, $signPostId)
        {
            $result = null;
            if ($signPostId != null) {
                $result = $this->mysqli->query("SELECT sp.* FROM sign_posts sp
                                            WHERE sp.name = '" . $this->mysqli->real_escape_string($signPostName) . "'
                                            AND sp.id != '" . $this->mysqli->real_escape_string($signPostId) . "'");
            } else {
                $result = $this->mysqli->query("SELECT sp.* FROM sign_posts sp
                                            WHERE sp.name = '" . $this->mysqli->real_escape_string($signPostName) . "'");
            }
            return $result->fetch_assoc();
        }

        function insertSignPost($request)
        {
            $signPostName = $request['signPostName'];
            $loggedInUserId = $request['loggedInUserId'];
            $resultArray = array();
            
            $result = $this->getExistingSignPost($signPostName, null);
            
            if (!empty($result)) {
                $resultArray['errorExists'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>The Following Tab You Are Trying To Add Already Exists With The Same Name:</strong><br />' . $result['name']  . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                $result = $this->mysqli->query("INSERT IGNORE INTO sign_posts (
                    name,
                    created_by_user_id,
                    created,
                    modified_by_user_id,
                    modified
                ) VALUES (
                    '" . $this->mysqli->real_escape_string($signPostName) . "',
                    '" . $this->mysqli->real_escape_string($loggedInUserId) . "',
                    '" . $this->mysqli->real_escape_string(date('Y-m-d H:i:s')) . "',
                    '" . $this->mysqli->real_escape_string($loggedInUserId) . "',
                    '" . $this->mysqli->real_escape_string(date('Y-m-d H:i:s')) . "')
                ");                
            }
            if ($result === true) {
                $resultArray['success'] .= '<div class="alert alert-success alert-dismissible fade show mb-3" role="alert"><strong>Success! The Following sign post Has Been Added:</strong><br />' . $signPostName . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                if ($resultArray['errorExists'] == '') {
                    $resultArray['error'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>Error! The Following sign post  Could Not Be Added Due To An Unknown Error, Please Try Again Later:</strong><br />' . $signPostName . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }
            return $resultArray; 
        }

        function updateSignPost($request)
        {
            $signPostId = $request['signPostId'];
            $signPostName = $request['signPostName'];
            $loggedInUserId = $request['loggedInUserId'];
            $resultArray = array();

            $result = $this->getExistingSignPost($signPostName, $signPostId);
            
            if (!empty($result)) {
                $resultArray['errorExists'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>The Following sign post You Are Trying To Update Already Exists With The Same Name:</strong><br />' . $result['name']  . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                $result = $this->mysqli->query("UPDATE sign_posts sp
                SET sp.name = '" . $this->mysqli->real_escape_string($signPostName) . "',
                sp.modified_by_user_id = '" . $this->mysqli->real_escape_string($loggedInUserId) . "',
                sp.modified = '" . $this->mysqli->real_escape_string(date('Y-m-d H:i:s')) . "'
                WHERE sp.id = '" . $this->mysqli->real_escape_string($signPostId) . "'");              
            }
            if ($result === true) {
                $resultArray['success'] .= '<div class="alert alert-success alert-dismissible fade show mb-3" role="alert"><strong>Success! The sign post With The Following ID Has Been Updated: </strong>' . $signPostId . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                if ($resultArray['errorExists'] == '') {
                    $resultArray['error'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>Error! The sign post With The Following ID Could Not Be Updated Due To An Unknown Error, Please Try Again Later: </strong><br />' . $signPostId . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }
            return $resultArray;
        }

        function deleteSignPostsById($ids)
        {
            // To Fill In Later
        }
    }
?>