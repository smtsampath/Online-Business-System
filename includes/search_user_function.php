<?php

// fetch data according to search query
function singleSearch($tableName,$searchTerm,$searchTxt) {  
	$counter = 0;
	$allUsernamesWithDuplicates = array();  
	$result_set = mysql_query("select * from  " . $tableName . "  where " . $searchTerm . " ='{$searchTxt}'");
	if(isQuerySuccess($result_set)){
		if (mysql_num_rows($result_set) > 0) {
			while ($result = mysql_fetch_assoc($result_set)) {
				$allUsernamesWithDuplicates[$counter] = $result['username'];
				$counter++;
			}
		} 	
	}	
	$allUsernamesWithNoDuplicates = array_unique($allUsernamesWithDuplicates);
	return $allUsernamesWithNoDuplicates; 
}

// fetch results by search all function
function allSearch($searchTxt){
	$tableArray = array("user_profile_details","user_profile_details","user_profile_details","user_profile_details","user_profile_details","user_profile_details","user_profile_details"); 
	$columnArray = array("first_name","last_name","username","email","country","contact_number","gender"); 
	$counter = 0;
	$counter2 = 0;
	$allUsernamesWithDuplicates = array();   
	foreach($tableArray as $table){
		$result_set = mysql_query("select * from  " . $table . "  where " . $columnArray[$counter2] . " ='{$searchTxt}'");
		if (mysql_num_rows($result_set) > 0) {
			while ($result = mysql_fetch_assoc($result_set)) {
				$allUsernamesWithDuplicates[$counter] = $result['username'];
				$counter++;
			}
		} 	
		$counter2++;
	} 
	$allUsernamesWithNoDuplicates = array_unique($allUsernamesWithDuplicates);
	return $allUsernamesWithNoDuplicates;	 
}

// main search function which use above singleSearch() and allSearch() function according to the search type
function getSearchResults($searchTxt,$searchTermComboVal){
	if(hasNotSensitiveCharacters($searchTxt)){
		if($searchTermComboVal == "All Terms"){
			$searchResults = allSearch($searchTxt);
			return $searchResults;
		}else{
			$tableArray = array("user_profile_details","user_profile_details","user_profile_details","user_profile_details","user_profile_details","user_profile_details","user_profile_details");
	
			$columnArray = array("first_name","last_name","username","email","country","contact_number","gender");	
			
			$comboValuesArray = array("First Name","Last Name","Username","Email","Country","Contact Number","Gender");	
			
			$counter = 0;
			
			foreach($comboValuesArray as $comboValue){
				if($searchTermComboVal == $comboValue){
					$searchResults = singleSearch($tableArray[$counter],$columnArray[$counter],$searchTxt); 
					return $searchResults;
				}
				$counter++;
			} 
			return null;
		}	
	} 
}

?>