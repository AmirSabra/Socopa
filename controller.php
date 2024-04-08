<?php
    include('db_config.php');
    class Controller {
        public $mysqli;
        public $dbConfig;

        function __construct() {
            $this->dbConfig = New DbConfig();
            $this->mysqli = $this->dbConfig->getDbConnection();
        }

        function getAllRequests()
        {
            $result = $this->mysqli->query("SELECT r.*, rt.name AS request_type_name, rs.name AS request_status_name, rs.colour AS request_status_colour, rrr.name AS request_rejection_reason_name
                                            FROM requests r
                                            LEFT JOIN request_types rt
                                            ON r.request_type_id = rt.id
                                            LEFT JOIN request_statuses rs
                                            ON r.request_status_id = rs.id
                                            LEFT JOIN request_rejection_reasons rrr
                                            ON r.request_rejection_reason_id = rrr.id
                                            ORDER BY r.id ASC");
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        function getRequestsById($ids)
        {
            $result = $this->mysqli->query("SELECT r.*, rt.name AS request_type_name, rs.name AS request_status_name
                                            FROM requests r
                                            LEFT JOIN request_types rt
                                            ON r.request_type_id = rt.id
                                            LEFT JOIN request_statuses rs
                                            ON r.request_status_id = rs.id
                                            WHERE r.id IN ($ids)
                                            ORDER BY r.id ASC");
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        function getExistingRequest($albumTrack, $artistName, $albumTrackName)
        {
            $result = $this->mysqli->query("SELECT r.*, rt.name AS request_type_name, rs.name AS request_status_name
                                            FROM requests r
                                            LEFT JOIN request_types rt
                                            ON r.request_type_id = rt.id
                                            LEFT JOIN request_statuses rs
                                            ON r.request_status_id = rs.id
                                            WHERE r.request_type_id = '" . $this->mysqli->real_escape_string($albumTrack) . "'
                                            AND r.artist_name = '" . $this->mysqli->real_escape_string($artistName) . "'
                                            AND r.album_track_name = '" . $this->mysqli->real_escape_string($albumTrackName) . "'");
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        function insertRequest($request)
        {
            $albumTrackKeys = $this->getAllRequestTypesList();
            $youTubeChannelName = $request['youTubeChannelName'];
            $albumTracks = $request['requestTypeIds'];
            $artistNames = $request['artistNames'];
            $albumTrackNames = $request['albumTrackNames'];
            $status = 1;
            $resultArray = array();
            for ($i = 0; $i < sizeof($albumTracks); $i++) {
                $albumTrack = $albumTracks[$i];
                $artistName = $artistNames[$i];
                $albumTrackName = $albumTrackNames[$i];
                
                $result = $this->getExistingRequest($albumTrack, $artistName, $albumTrackName);
                
                if ($result->num_rows > 0) {
                    foreach ($result as $row) {
                        $resultArray['albumTracksExist'] .= $row['request_type_name'] . ' <strong>' . $row['artist_name'] . ' - ' . $row['album_track_name'] . '</strong> has already been requested by <strong>' . $row['youtube_channel_name'] . '</strong>.<br />';
                    }
                }
                else {
                    $result = $this->mysqli->query("INSERT IGNORE INTO requests (
                        youtube_channel_name, 
                        request_type_id, 
                        artist_name, 
                        album_track_name,
                        request_status_id,
                        created,
                        modified
                    ) VALUES (
                        '" . $this->mysqli->real_escape_string($youTubeChannelName) . "', 
                        '" . $this->mysqli->real_escape_string($albumTrack) . "', 
                        '" . $this->mysqli->real_escape_string($artistName) . "',
                        '" . $this->mysqli->real_escape_string($albumTrackName) . "',
                        '" . $this->mysqli->real_escape_string($status) . "',
                        '" . $this->mysqli->real_escape_string(date('Y-m-d H:i:s')) . "',
                        '" . $this->mysqli->real_escape_string(date('Y-m-d H:i:s')) . "')
                    ");                
                }
                if ($result === true) {
                    $resultArray['albumTracksSuccess'] .= $albumTrackKeys[$albumTrack] . ' <strong>' . $artistName . ' - ' . $albumTrackName . '</strong><br />';
                }
                else {
                    if ($resultArray['albumTracksExist'] == '') {
                        $resultArray['albumTracksError'] .= $albumTrackKeys[$albumTrack] . ' <strong>' . $artistName . ' - ' . $albumTrackName . '</strong><br />';
                    }
                }
            }
            return $resultArray;
        }

        function updateRequest($request)
        {
            $albumTrackKeys = $this->getAllRequestTypesList();
            $requestId = $request['requestId'];
            $youTubeChannelName = $request['youTubeChannelName'];
            $albumTrack = $request['requestTypeId'];
            $artistName = $request['artistName'];
            $albumTrackName = $request['albumTrackName'];
            $completedRequestUrl = $request['completedRequestUrl'];
            $status = $request['requestStatusId'];
            $resultArray = array();
            $result = $this->getExistingRequest($albumTrack, $artistName, $albumTrackName);
            
            if ($result->num_rows > 0) {
                foreach ($result as $row) {
                    $resultArray['errorExists'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>The Following Request You Are Trying To Update Already Exists:</strong> ' . $row['request_type_name'] . ' <strong>' . $row['artist_name'] . ' - ' . $row['album_track_name'] . '</strong> has already been requested by <strong>' . $row['youtube_channel_name'] . '</strong>.<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }
            else {
                $result = $this->mysqli->query("UPDATE requests
                SET youtube_channel_name = '" . $this->mysqli->real_escape_string($youTubeChannelName) . "',
                request_type_id = '" . $this->mysqli->real_escape_string($albumTrack) . "',
                artist_name = '" . $this->mysqli->real_escape_string($artistName) . "',
                album_track_name = '" . $this->mysqli->real_escape_string($albumTrackName) . "',
                completed_request_url = '" . $this->mysqli->real_escape_string($completedRequestUrl) . "',
                request_status_id = '" . $this->mysqli->real_escape_string($status) . "',
                modified = '" . $this->mysqli->real_escape_string(date('Y-m-d H:i:s')) . "'
                WHERE id = '" . $this->mysqli->real_escape_string($requestId) . "'");                
            }
            if ($result === true) {
                $resultArray['success'] .= '<div class="alert alert-success alert-dismissible fade show mb-3" role="alert"><strong>Success! The Request With The Following ID Has Been Updated:</strong> ' . $requestId .'<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                if ($resultArray['errorExists'] == '') {
                    $resultArray['error'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>Error! The Request With The Following ID Could Not Be Updated Due To An Unknown Error, Please Try Again Later:</strong><br />' . $requestId .'<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }
            return $resultArray;
        }

        function markRequestsAsCompleteById($ids)
        {
            $resultArray = array();
            $item = '';
            $tableName = 'Requests';
            $messageText = 'Marked As Complete';
            foreach ($ids as $id) {
                $rows = $this->getRequestsById($id);
                foreach ($rows as $row) {
                    $result = $this->mysqli->query("UPDATE requests
                                                SET request_status_id = '" . $this->mysqli->real_escape_string(2) . "'
                                                WHERE id = '" . $this->mysqli->real_escape_string($row['id']) . "'");
                    $item = $row['request_type_name'] . ' <strong>' . $row['artist_name'] . ' - ' . $row['album_track_name'] . '</strong><br />';
                    if ($result === true) {
                        $resultArray['success'] .= '<div class="toast-container position-fixed top-0 start-0 p-3"><div class="toast show text-bg-success" role="alert" aria-live="assertive" aria-atomic="true"><div class="toast-header"><strong class="me-auto">Success! The Following ' . $tableName . ' Has Been ' . $messageText . ':</strong><button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button></div><div class="toast-body">' . $item . '</div></div></div>';
                    } else {
                        $resultArray['error'] .= '<div class="toast-container position-fixed top-0 start-0 p-3"><div class="toast show text-bg-danger" role="alert" aria-live="assertive" aria-atomic="true"><div class="toast-header"><strong class="me-auto">Error! The Following ' . $tableName . ' Could Not Be ' . $messageText . ' Due To An Unknown Error, Please Try Again Later:</strong><button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button></div><div class="toast-body">' . $item . '</div></div></div>';
                    }                    
                }
            }
            return $resultArray;
        }

        function deleteRequestsById($ids)
        {
            $resultArray = array();
            $item = '';
            $tableName = 'Request';
            $messageText = 'Deleted';
            foreach ($ids as $id) {
                $rows = $this->getRequestsById($id);
                foreach ($rows as $row) {
                    $result = $this->mysqli->query("DELETE FROM requests
                                        WHERE id = '" . $this->mysqli->real_escape_string($row['id']) . "'");
                    $item = $row['request_type_name'] . ' <strong>' . $row['artist_name'] . ' - ' . $row['album_track_name'] . '</strong><br />';
                    if ($result === true) {
                        $resultArray['success'] .= '<div class="toast-container position-fixed top-0 start-0 p-3"><div class="toast show text-bg-success" role="alert" aria-live="assertive" aria-atomic="true"><div class="toast-header"><strong class="me-auto">Success! The Following ' . $tableName . ' Has Been ' . $messageText . ':</strong><button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button></div><div class="toast-body">' . $item . '</div></div></div>';
                    } else {
                        $resultArray['error'] .= '<div class="toast-container position-fixed top-0 start-0 p-3"><div class="toast show text-bg-danger" role="alert" aria-live="assertive" aria-atomic="true"><div class="toast-header"><strong class="me-auto">Error! The Following ' . $tableName . ' Could Not Be ' . $messageText . ' Due To An Unknown Error, Please Try Again Later:</strong><button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button></div><div class="toast-body">' . $item . '</div></div></div>';
                    }                    
                }
            }
            return $resultArray;
        }

        function getAllRequestTypes()
        {
            $result = $this->mysqli->query("SELECT * FROM request_types
                                            ORDER BY request_types.id ASC");
            $result = $result->fetch_all(MYSQLI_ASSOC);
            return $result;
        }

        function getAllRequestTypesList()
        {
            $result = array();
            $allRequestTypes = $this->getAllRequestTypes();
            foreach ($allRequestTypes as $requestType) {
                $result[$requestType['id']] = $requestType['name'];
            }
            return $result;
        }

        function getRequestTypesById($ids)
        {
            $result = $this->mysqli->query("SELECT rt.* FROM request_types rt
                                            WHERE rt.id IN ($ids)
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

        function deleteRequestTypesById($ids)
        {
            $resultArray = array();
            $item = '';
            $tableName = 'Request Type';
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

        function getAllRequestStatuses()
        {
            $result = $this->mysqli->query("SELECT * FROM request_statuses
                                            ORDER BY request_statuses.id ASC");
            $result = $result->fetch_all(MYSQLI_ASSOC);
            return $result;
        }

        function getRequestStatusesById($ids)
        {
            $result = $this->mysqli->query("SELECT rs.* FROM request_statuses rs
                                            WHERE rs.id IN ($ids)
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
                $rows = $this->getRequestStatusesById($id);
                foreach ($rows as $row) {
                    $result = $this->mysqli->query("DELETE FROM request_statuses
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

        function getAllRequestRejectionReasons()
        {
            $result = $this->mysqli->query("SELECT * FROM request_rejection_reasons
                                            ORDER BY request_rejection_reasons.id ASC");
            $result = $result->fetch_all(MYSQLI_ASSOC);
            return $result;
        }

        function getRequestRejectionReasonsById($ids)
        {
            $result = $this->mysqli->query("SELECT rrr.* FROM request_rejection_reasons rrr
                                            WHERE rrr.id IN ($ids)
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
                $rows = $this->getRequestRejectionReasonsById($id);
                foreach ($rows as $row) {
                    $result = $this->mysqli->query("DELETE FROM request_rejection_reasons
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

        function getAllCustomisations()
        {
            $result = $this->mysqli->query("SELECT * FROM customisations
                                            ORDER BY customisations.id ASC");
            $result = $result->fetch_all(MYSQLI_ASSOC);
            return $result;
        }

        function updateCustomisation($request)
        {
            $customisationId = $request['customisationId'];
            $customisationContent = $request['customisationContent'];
            $resultArray = array();

            $result = $this->mysqli->query("UPDATE customisations c
            SET c.content = '" . $this->mysqli->real_escape_string($customisationContent) . "',
            c.modified = '" . $this->mysqli->real_escape_string(date('Y-m-d H:i:s')) . "'
            WHERE c.id = '" . $this->mysqli->real_escape_string($customisationId) . "'");

            if ($result === true) {
                $resultArray['success'] .= '<div class="alert alert-success alert-dismissible fade show mb-3" role="alert"><strong>Success! The Customisation With The Following ID Has Been Updated: </strong>' . $customisationId . '<br /><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            else {
                $resultArray['error'] .= '<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"><strong>Error! The Customisation With The Following ID Could Not Be Updated Due To An Unknown Error, Please Try Again Later: </strong><br />' . $customisationId . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            return $resultArray;
        }

        function login($request)
        {
            $username = $request['username'];
            $password = $request['password'];
            $result = $this->mysqli->query("SELECT u.id, u.username, u.first_name, u.last_name, u.password, u.user_status_id, us.name as user_status_name, ur.name as user_role_name
                                            FROM users u
                                            LEFT JOIN user_statuses us
                                            ON u.user_status_id = us.id
                                            LEFT JOIN user_roles ur
                                            ON u.user_role_id = ur.id
                                            WHERE u.username = '" . $this->mysqli->real_escape_string($username) . "'");
            $result = $result->fetch_all(MYSQLI_ASSOC);
            if (empty($result)) {
                return 'Username does not exist, please try again.';
            }
            foreach ($result as $user) {
                if ($user['user_status_id'] == 1) {
                    if (password_verify($password, $user['password'])) {
                        return $result;
                    } else {
                        return 'Username or Password is Incorrect, please try again.';
                    }
                } else {
                    return 'User is ' . $user['user_status_name'] . ', please contact Administrator.';
                }                 
            }
        }
    }
?>