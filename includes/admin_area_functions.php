<?php

// fetch all usernames to an array that admin select a username and edit the details of particular user
function getAllUsernames() {

    $result_set = mysql_query("select * from user_login where status='NORMAL USER'");
	if(isQuerySuccess($result_set)){
		if (mysql_num_rows($result_set) > 0) {
			$usernames = array();
			$counter = 0;
			while ($result = mysql_fetch_assoc($result_set)) {
				$usernames[$counter] = $result['username'];
				$counter++;
			}
			return $usernames;
		} else {
			return null;
		}	
	} 
}

?>