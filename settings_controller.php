<?php
    include('db_config.php');
    class SettingsController {
        public $mysqli;
        public $dbConfig;

        function __construct() {
            $this->dbConfig = New DbConfig();
            $this->mysqli = $this->dbConfig->getDbConnection();
        }

        function getAllRequestTypes()
        {
            $result = $this->mysqli->query("SELECT * FROM request_types
                                            ORDER BY request_types.id ASC");
            $result = $result->fetch_all(MYSQLI_ASSOC);
            return $result;
        }

        function getRequestTypesByIds($requestTypeIds)
        {
            $result = $this->mysqli->query("SELECT rt.* FROM request_types rt
                                            WHERE rt.id IN ($requestTypeIds)
                                            ORDER BY rt.id ASC");
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        function getExistingRequestType($requestTypeName)
        {
            $result = $this->mysqli->query("SELECT rt.* FROM request_types rt WHERE rt.name = '" . $this->mysqli->real_escape_string($requestTypeName) . "'");
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        function insertRequestType($request)
        {
            $requestTypeName = $request['requestTypeName'];
            $resultArray = array();
            $result = $this->getExistingRequestType($requestTypeName);
            
            if ($result->num_rows > 0) {
                foreach ($result as $row) {
                    $resultArray['errorExists'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>The Following Request Type Already Exists:</strong><br />Request Type: <strong>' . $row['name']  . '</strong><br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }
            else {
                $result = $this->mysqli->query("INSERT IGNORE INTO request_types (
                    name,
                    created,
                    modified
                ) VALUES (
                    '" . $this->mysqli->real_escape_string($requestTypeName) . "',
                    '" . $this->mysqli->real_escape_string(date('Y-m-d H:i:s')) . "',
                    '" . $this->mysqli->real_escape_string(date('Y-m-d H:i:s')) . "')
                ");                
            }
            if ($result === true) {
                $resultArray['success'] .= '<div class="alert alert-success alert-dismissible fade show mb-3" role="alert"><strong>Success! The Following Request Type Has Been Added:</strong><br />Request Type: <strong>' . $requestTypeName . '</strong><br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                if ($resultArray['errorExists'] == '') {
                    $resultArray['error'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>Error! The Following Request Type Could Not Be Added Due To An Unknown Error, Please Try Again Later:</strong><br />Request Type: <strong>' . $requestTypeName . '</strong><br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }
            return $resultArray;
        }

        function updateRequestType($request)
        {
            $requestTypeId = $request['requestTypeId'];
            $requestTypeName = $request['requestTypeName'];
            $resultArray = array();
            $result = $this->getExistingRequestType($requestTypeName);
            
            if ($result->num_rows > 0) {
                foreach ($result as $row) {
                    $resultArray['errorExists'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>The Following Request Type You Are Trying To Update Already Exists:</strong><br />Request Type: <strong>' . $row['name']  . '</strong><br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }
            else {
                $result = $this->mysqli->query("UPDATE request_types rt
                SET rt.name = '" . $this->mysqli->real_escape_string($requestTypeName) . "',
                rt.modified = '" . $this->mysqli->real_escape_string(date('Y-m-d H:i:s')) . "'
                WHERE rt.id = '" . $this->mysqli->real_escape_string($requestTypeId) . "'");                
            }
            if ($result === true) {
                $resultArray['success'] .= '<div class="alert alert-success alert-dismissible fade show mb-3" role="alert"><strong>Success! The Request Type With The Following ID Has Been Updated: </strong>' . $requestTypeId . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                if ($resultArray['errorExists'] == '') {
                    $resultArray['error'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>Error! The Request Type With The Following ID Could Not Be Updated Due To An Unknown Error, Please Try Again Later: </strong><br />' . $requestTypeId . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }
            return $resultArray;
        }

        function deleteRequestTypes($ids)
        {
            $resultArray = array();
            $item = '';
            $tableName = 'Request Type';
            $messageText = 'Deleted';
            foreach ($ids as $id) {
                $rows = $controller->getRequestTypesByIds($id);
                foreach ($rows as $row) {
                    $result = $this->mysqli->query("DELETE FROM request_types
                                        WHERE id = '" . $this->mysqli->real_escape_string($row['id']) . "'");
                    $item = '<strong>' . $row['name']. '</strong><br />';
                    if ($result === true) {
                        $resultArray['success'] .= '<div class="toast-container position-fixed top-0 start-0 p-3"><div class="toast show text-bg-success" role="alert" aria-live="assertive" aria-atomic="true"><div class="toast-header"><strong class="me-auto">Success! The Following ' . $tableName . ' Have Been ' . $messageText . ':</strong><button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button></div><div class="toast-body">' . $albumTracks . '</div></div></div>';
                    } else {
                        $resultArray['error'] .= '<div class="toast-container position-fixed top-0 start-0 p-3"><div class="toast show text-bg-danger" role="alert" aria-live="assertive" aria-atomic="true"><div class="toast-header"><strong class="me-auto">Error! The Following ' . $tableName . ' Could Not Be ' . $messageText . ' Due To An Unknown Error, Please Try Again Later:</strong><button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button></div><div class="toast-body">' . $albumTracks . '</div></div></div>';
                    }                    
                }
            }
            return $resultArray;
        }

        function getAllRequestStatuses()
        {
            $result = $this->mysqli->query("SELECT * FROM request_statuses
                                            ORDER BY request_statuses.id ASC");
            $result = $result->fetch_all(MYSQLI_ASSOC);
            return $result;
        }

        function getRequestStatusesById($requestStatusIds)
        {
            $result = $this->mysqli->query("SELECT rs.* FROM request_statuses rs
                                            WHERE rs.id IN ($requestStatusIds)
                                            ORDER BY rs.id ASC");
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        function getExistingRequestStatus($requestStatusName)
        {
            $result = $this->mysqli->query("SELECT rs.* FROM request_statuses rs WHERE rs.name = '" . $this->mysqli->real_escape_string($requestStatusName) . "'");
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        function insertRequestStatus($request)
        {
            $requestStatusName = $request['requestStatusName'];
            $requestStatusColour = $request['requestStatusColour'];
            $resultArray = array();
            $result = $this->getExistingRequestStatus($requestStatusName);
            
            if ($result->num_rows > 0) {
                foreach ($result as $row) {
                    $resultArray['errorExists'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>The Following Request Status Already Exists:</strong><br />Request Status: <strong>' . $row['name']  . '</strong><br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }
            else {
                $result = $this->mysqli->query("INSERT IGNORE INTO request_statuses (
                    name,
                    colour,
                    created,
                    modified
                ) VALUES (
                    '" . $this->mysqli->real_escape_string($requestTypeName) . "',
                    '" . $this->mysqli->real_escape_string($requestTypeColour) . "',
                    '" . $this->mysqli->real_escape_string(date('Y-m-d H:i:s')) . "',
                    '" . $this->mysqli->real_escape_string(date('Y-m-d H:i:s')) . "')
                ");                
            }
            if ($result === true) {
                $resultArray['success'] .= '<div class="alert alert-success alert-dismissible fade show mb-3" role="alert"><strong>Success! The Following Request Status Has Been Added:</strong><br />Request Status: <strong>' . $requestStatusName . '</strong><br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                if ($resultArray['errorExists'] == '') {
                    $resultArray['error'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>Error! The Following Request Status Could Not Be Added Due To An Unknown Error, Please Try Again Later:</strong><br />Request Type: <strong>' . $requestStatusName . '</strong><br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }
            return $resultArray;
        }

        function updateRequestStatus($request)
        {
            $requestStatusId = $request['requestStatusId'];
            $requestStatusName = $request['requestStatusName'];
            $requestStatusColour = $request['requestStatusColour'];
            $resultArray = array();
            $result = $this->getExistingRequestStatus($requestStatusName);
            
            if ($result->num_rows > 0) {
                foreach ($result as $row) {
                    $resultArray['errorExists'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>The Following Request Status You Are Trying To Update Already Exists:</strong><br />Request Status: <strong>' . $row['name']  . '</strong><br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }
            else {
                $result = $this->mysqli->query("UPDATE request_statuses rs
                SET rs.name = '" . $this->mysqli->real_escape_string($requestStatusName) . "',
                SET rs.colour = '" . $this->mysqli->real_escape_string($requestStatusColour) . "',
                rs.modified = '" . $this->mysqli->real_escape_string(date('Y-m-d H:i:s')) . "'
                WHERE rs.id = '" . $this->mysqli->real_escape_string($requestStatusId) . "'");                
            }
            if ($result === true) {
                $resultArray['success'] .= '<div class="alert alert-success alert-dismissible fade show mb-3" role="alert"><strong>Success! The Request Status With The Following ID Has Been Updated: </strong>' . $requestStatusId . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                if ($resultArray['errorExists'] == '') {
                    $resultArray['error'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>Error! The Request Status With The Following ID Could Not Be Updated Due To An Unknown Error, Please Try Again Later: </strong><br />' . $requestStatusId . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }
            return $resultArray;
        }

        function deleteRequestStatusesById($ids)
        {
            $resultArray = array();
            $item = '';
            $tableName = 'Request Status';
            $messageText = 'Deleted';
            foreach ($ids as $id) {
                $rows = $controller->getRequestStatusesById($id);
                foreach ($rows as $row) {
                    $result = $this->mysqli->query("DELETE FROM request_statuses
                                        WHERE id = '" . $this->mysqli->real_escape_string($row['id']) . "'");
                    $item = '<strong>' . $row['name']. '</strong><br />';
                    if ($result === true) {
                        $resultArray['success'] .= '<div class="toast-container position-fixed top-0 start-0 p-3"><div class="toast show text-bg-success" role="alert" aria-live="assertive" aria-atomic="true"><div class="toast-header"><strong class="me-auto">Success! The Following ' . $tableName . ' Have Been ' . $messageText . ':</strong><button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button></div><div class="toast-body">' . $albumTracks . '</div></div></div>';
                    } else {
                        $resultArray['error'] .= '<div class="toast-container position-fixed top-0 start-0 p-3"><div class="toast show text-bg-danger" role="alert" aria-live="assertive" aria-atomic="true"><div class="toast-header"><strong class="me-auto">Error! The Following ' . $tableName . ' Could Not Be ' . $messageText . ' Due To An Unknown Error, Please Try Again Later:</strong><button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button></div><div class="toast-body">' . $albumTracks . '</div></div></div>';
                    }                    
                }
            }
            return $resultArray;
        }

        function getAllRequestRejectionReasons()
        {
            $result = $this->mysqli->query("SELECT * FROM request_rejection_reasons
                                            ORDER BY request_rejection_reasons.id ASC");
            $result = $result->fetch_all(MYSQLI_ASSOC);
            return $result;
        }

        function getRequestRejectionReasonsById($requestRejectionReasonIds)
        {
            $result = $this->mysqli->query("SELECT rrr.* FROM request_rejection_reasons rrr
                                            WHERE rrr.id IN ($requestRejectionReasonIds)
                                            ORDER BY rrr.id ASC");
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        function getExistingRequestRejectionReason($requestRejectionReasonName)
        {
            $result = $this->mysqli->query("SELECT rrr.* FROM request_rejection_reasons rrr WHERE rrr.name = '" . $this->mysqli->real_escape_string($requestRejectionReasonName) . "'");
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        function insertRequestRejectionReason($request)
        {
            $requestRejectionReasonName = $request['requestRejectionReasonName'];
            $resultArray = array();
            $result = $this->getExistingRequestRejectionReason($requestRejectionReasonName);
            
            if ($result->num_rows > 0) {
                foreach ($result as $row) {
                    $resultArray['errorExists'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>The Following Request Rejection Reason Already Exists:</strong><br />Request Rejection Reason: <strong>' . $row['name']  . '</strong><br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }
            else {
                $result = $this->mysqli->query("INSERT IGNORE INTO request_rejection_reasons (
                    name,
                    created,
                    modified
                ) VALUES (
                    '" . $this->mysqli->real_escape_string($requestRejectionReasonName) . "',
                    '" . $this->mysqli->real_escape_string(date('Y-m-d H:i:s')) . "',
                    '" . $this->mysqli->real_escape_string(date('Y-m-d H:i:s')) . "')
                ");                
            }
            if ($result === true) {
                $resultArray['success'] .= '<div class="alert alert-success alert-dismissible fade show mb-3" role="alert"><strong>Success! The Following Request Rejection Reason Has Been Added:</strong><br />Request Rejection Reason: <strong>' . $requestRejectionReasonName . '</strong><br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                if ($resultArray['errorExists'] == '') {
                    $resultArray['error'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>Error! The Following Request Rejection Reason Could Not Be Added Due To An Unknown Error, Please Try Again Later:</strong><br />Request Type: <strong>' . $requestRejectionReasonName . '</strong><br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }
            return $resultArray;
        }

        function updateRequestRejectionReason($request)
        {
            $requestRejectionReasonId = $request['requestRejectionReasonId'];
            $requestRejectionReasonName = $request['requestRejectionReasonName'];
            $resultArray = array();
            $result = $this->getExistingRequestRejectionReason($requestRejectionReasonName);
            
            if ($result->num_rows > 0) {
                foreach ($result as $row) {
                    $resultArray['errorExists'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>The Following Request Rejection Reason You Are Trying To Update Already Exists:</strong><br />Request Rejection Reason: <strong>' . $row['name']  . '</strong><br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }
            else {
                $result = $this->mysqli->query("UPDATE request_rejection_reasons rrr
                SET rrr.    name = '" . $this->mysqli->real_escape_string($requestRejectionReasonName) . "',
                rrr.modified = '" . $this->mysqli->real_escape_string(date('Y-m-d H:i:s')) . "'
                WHERE rrr.id = '" . $this->mysqli->real_escape_string($requestRejectionReasonId) . "'");                
            }
            if ($result === true) {
                $resultArray['success'] .= '<div class="alert alert-success alert-dismissible fade show mb-3" role="alert"><strong>Success! The Request Rejection Reason With The Following ID Has Been Updated: </strong>' . $requestRejectionReasonId . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                if ($resultArray['errorExists'] == '') {
                    $resultArray['error'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>Error! The Request Rejection Reason With The Following ID Could Not Be Updated Due To An Unknown Error, Please Try Again Later: </strong><br />' . $requestRejectionReasonId . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }
            return $resultArray;
        }

        function deleteRequestRejectionReasonsById($ids)
        {
            $resultArray = array();
            $item = '';
            $tableName = 'Request Rejection Reason';
            $messageText = 'Deleted';
            foreach ($ids as $id) {
                $rows = $controller->getRequestRejectionReasonsById($id);
                foreach ($rows as $row) {
                    $result = $this->mysqli->query("DELETE FROM request_rejection_reasons
                                        WHERE id = '" . $this->mysqli->real_escape_string($row['id']) . "'");
                    $item = '<strong>' . $row['name']. '</strong><br />';
                    if ($result === true) {
                        $resultArray['success'] .= '<div class="toast-container position-fixed top-0 start-0 p-3"><div class="toast show text-bg-success" role="alert" aria-live="assertive" aria-atomic="true"><div class="toast-header"><strong class="me-auto">Success! The Following ' . $tableName . ' Have Been ' . $messageText . ':</strong><button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button></div><div class="toast-body">' . $albumTracks . '</div></div></div>';
                    } else {
                        $resultArray['error'] .= '<div class="toast-container position-fixed top-0 start-0 p-3"><div class="toast show text-bg-danger" role="alert" aria-live="assertive" aria-atomic="true"><div class="toast-header"><strong class="me-auto">Error! The Following ' . $tableName . ' Could Not Be ' . $messageText . ' Due To An Unknown Error, Please Try Again Later:</strong><button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button></div><div class="toast-body">' . $albumTracks . '</div></div></div>';
                    }                    
                }
            }
            return $resultArray;
        }
    }
?>