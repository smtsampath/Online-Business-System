<?php

// check if user has uploaded his/her working examples already
function hasProjectUploadedOnce($username) {
    $query = "select * from user_project WHERE username='{$username}' ";
	$result_set = mysql_query($query);
	if(isQuerySuccess($result_set)){
		if (mysql_num_rows($result_set) == 1) {
			return true;
		} else {
			return false;
		}	
	} 
}

// Add a record of working examples by username and title
function manageProject($username, $finalFilePath, $description, $title) { 
         
        isNonFetchQuerySuccess("INSERT INTO user_project (username, project_file_path,project_description,project_file_title) VALUES ('$username', '$finalFilePath','$description','$title')");
		
    
}

// delete a record of wrking examples by username and title
function deleteProject($filePath) {
      
        isNonFetchQuerySuccess("DELETE FROM user_project WHERE project_file_path='{$filePath}' ");
		 
}

// fetch the working examples details by username
function getProjectDetailsByUsernameAndTitle($username,$title) {
    $query = "select * from user_project WHERE username='{$username}' AND project_file_title='{$title}' ";
    $result_set = mysql_query($query);
	if(isQuerySuccess($result_set)){
		if (mysql_num_rows($result_set) == 1) {
			$userProject = mysql_fetch_array($result_set); 
			return $userProject;
		} else {
			return null;
		}	
	} 
}

// fetch project list by username
function getProjectsListByUsername($username) {
	$projectsArray = array();
    $query = "select * from user_project WHERE username='{$username}' ";
    $result_set = mysql_query($query);
	if(isQuerySuccess($result_set)){
		$recordCount = 0;
		if (mysql_num_rows($result_set) > 0) {
			while($row = mysql_fetch_array($result_set)){ 
				$projectsArray[$recordCount] = $row ;
				$recordCount = $recordCount +1 ;
			} 
		}  	
	} 
	return $projectsArray;
}


?>