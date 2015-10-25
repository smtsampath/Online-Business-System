<?php

// check if user has already uploaded a CV in his/her account
function hasCVUploadedOnce($username) {
    $query = "select * from user_cv WHERE username='{$username}' ";
    $result_set = mysql_query($query);
	if(isQuerySuccess($result_set)){
		if (mysql_num_rows($result_set) == 1) {
			return true;
		} else {
			return false;
		}	
	} 
}

// Add CV path to database
function manageCV($username, $finalFilePath) {
    if (!hasCVUploadedOnce($username)) {
        isNonFetchQuerySuccess("INSERT INTO user_cv (username, cv_file_path) VALUES ('$username', '$finalFilePath')");
    }
}

// delete a cv by username
function deleteCVPath($selectedUsername) {
    isNonFetchQuerySuccess("DELETE FROM user_cv WHERE username='{$selectedUsername}'");
}

// get the user CV path by username
function getCVPathByUsername($username) {
    $query = "select * from user_cv WHERE username='{$username}' ";
    $result_set = mysql_query($query);
	if(isQuerySuccess($result_set)){
		if (mysql_num_rows($result_set) == 1) {
			$userCV = mysql_fetch_array($result_set);
			$userCVPath = $userCV['cv_file_path'];
			return $userCVPath;
		} else {
			return null;
		}	
	} 
} 

?>