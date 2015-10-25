<?php

// check if profile is exists by username
function hasProfileDetailsByUsername($username) {
    $query = "select * from user_profile_details WHERE username='{$username}' ";
    $result_set = mysql_query($query);
	if(isQuerySuccess($result_set)){
		if (mysql_num_rows($result_set) == 1) {
			return true;
		} else {
			return false;
		}	
	} 
}

// fetch profile details by username
function getProfileDetailsByUsername($username) {
    $query = "select * from user_profile_details WHERE username='{$username}' ";
    $result_set = mysql_query($query);
	if(isQuerySuccess($result_set)){
		if (mysql_num_rows($result_set) ==1) {
			$userProfile = mysql_fetch_array($result_set);  
			return $userProfile;
		} else {
			return null;
		}
	}
}
 
// fetch profile picture path to show
function getProfilePicturePathByUsername($username) {
	
    $query = "select * from user_profile_details WHERE username='{$username}' ";
    $result_set = mysql_query($query);
	if(isQuerySuccess($result_set)){ 
		if (mysql_num_rows($result_set) == 1) {
			$userProfile = mysql_fetch_array($result_set);
			$userProfilePicPath = $userProfile["picture_file_path"];
			if($userProfilePicPath != ""){
				$userProfilePicPath = $userProfile['picture_file_path']; 
				return $userProfilePicPath;
			}else {
				$userProfilePicPath = "images/defaultAvatar.gif"; 
				return $userProfilePicPath;
			}	
			
		}  
	} 
}


//check if logged in users gender is male
function isMale($username){ 
	$query = "select * from user_profile_details WHERE username='{$username}' ";
	$result_set = mysql_query($query); 
	if(isQuerySuccess($result_set)){
		if (mysql_num_rows($result_set) == 1) {
			$userAddress2Raw = mysql_fetch_array($result_set);
			$gender =  $userAddress2Raw['gender'];;
			if($gender == "Male"){
				return true;
			}else{
				return false;	
			}
		}	
	} 
}

function isFemale($username){ 
	$query = "select * from user_profile_details WHERE username='{$username}' ";
	$result_set = mysql_query($query); 
	if(isQuerySuccess($result_set)){
		if (mysql_num_rows($result_set) == 1) {
			$userAddress2Raw = mysql_fetch_array($result_set);
			$gender =  $userAddress2Raw['gender'];;
			if($gender == "Female"){
				return true;
			}else{
				return false;	
			}
		}  	
	} 
}


// fetch the status of the user by username
function getUserStatus($username) {
    $query = "select * from user_login WHERE username='{$username}'";
    $result_set = mysql_query($query);
	if(isQuerySuccess($result_set)){
		if (mysql_num_rows($result_set) == 1) {
			$userLogin = mysql_fetch_array($result_set);
			$userStatus = $userLogin['status'];
			return $userStatus;
		} else {
			return null;
		}	
	} 
}

// update profile details after subnit
function updateProdileDetails($username, $firstname, $lastname, $gender, $address1, $address2, $country,$contactnumber) {
	if(hasNotSensitiveCharacters($firstname)){
		if(hasNotSensitiveCharacters($lastname)){
			if(hasNotSensitiveCharacters($gender)){
				if(hasNotSensitiveCharacters($address1)){
					if(hasNotSensitiveCharacters($address2)){
						if(hasNotSensitiveCharacters($country)){
							if(hasNotSensitiveCharacters($contactnumber)){
								 
								if(isNonFetchQuerySuccess("UPDATE user_profile_details SET first_name = '{$firstname}' ,last_name = '{$lastname}' ,gender = '{$gender}',address_line1 = '{$address1}',country = '{$country}' ,address_line2 = '{$address2}' ,contact_number = '{$contactnumber}'  WHERE username = '{$username}' ")){ 
									return "<font color=green>Profile details successfully updated</green>";
								}else{
									return "<font color=red>Error has occured in profile updating</font>";		
								}								
							}else{
								return "<font color=red>Contact number has Invalid characters</font>";
							}
						}else{
							return "<font color=red>Country has Invalid characters</font>";
						}
					}else{
						return "<font color=red>Address Line 2 has Invalid characters</font>";
					}	
				}else{
					return "<font color=red>Address Line 1 has Invalid characters</font>";
				}
			}else{
				return "<font color=red>Gender has Invalid characters</font>";
			}
		}else{
			return "<font color=red>Last name has Invalid characters</font>";
		} 
	} else{
		return "<font color=red>First name has Invalid characters</font>";
	} 
}

// change password
function updateUserPassWord($username, $currentPassword, $newPassword) {
	
	if(hasNotSensitiveCharacters($currentPassword)){
		if(hasNotSensitiveCharacters($newPassword)){
			$currentPassword = encodeString($currentPassword);
			$query = "select * from user_login WHERE username='{$username}' AND password='{$currentPassword}'";
			$result_set = mysql_query($query);
			if(isQuerySuccess($result_set)){
				if (mysql_num_rows($result_set) == 1) { 
					$newPassword = encodeString($newPassword);
					isNonFetchQuerySuccess("UPDATE user_login SET password = '{$newPassword}' WHERE username = '{$username}' ");
					 
					return "<font color=green>Password is changed successfully</font>";
				} else {
					return "<font color=red>Invalid current password</font>";
				}	
			} 
		}else{
			return "<font color=red>Invalid new password</font>";
		} 
	} else{
		return "<font color=red>Invalid current password</font>";
	} 
}

// check  if user has upload his/her own profile picture
function hasPicUploadedOnce($username) {
	$response = false;
    $query = "select * from user_profile_details WHERE username='{$username}' ";
    $result_set = mysql_query($query);
	if(isQuerySuccess($result_set)){
		if (mysql_num_rows($result_set) == 1) {
			$userProfile = mysql_fetch_array($result_set);
			$userProfilePicPath = $userProfile["picture_file_path"];
			if($userProfilePicPath != ""){
				$response = true;
			}  
		}   
	} 
	return $response;
}

// update profile picture file path in database
function manageProfilePicture($username, $finalFilePath) {
    isNonFetchQuerySuccess("UPDATE user_profile_details SET picture_file_path = '{$finalFilePath}' WHERE username = '{$username}' ");
}

// delete profile picture by username
function deleteProfilePicturePath($selectedUsername) {
    isNonFetchQuerySuccess("UPDATE user_profile_details SET picture_file_path = '' WHERE username = '{$selectedUsername}' ");
}
 
?>