<?php

//check if email already exists in form submit
function isUserExistsByEmail($email) {
    $query = "select * from user_profile_details WHERE email='{$email}' ";
	$result_set = mysql_query($query);
	if(isQuerySuccess($result_set)){
		if (mysql_num_rows($result_set) ==1) { 
			return true;
		} else { 
			return false;
		}	
	} 
}

// send login details to particular user email
function sendMail($email){ 
	if(hasNotSensitiveCharacters($email)){
		$userLoginDetails = getLoginDetails($email);		
		if(isset($userLoginDetails)){ 
			$usernameToSent = $userLoginDetails['username'];
			$pwToSent = $userLoginDetails['password'];
			$pwToSent = decodeString($pwToSent);
			 
			$subject = "Your Login Details";
			$message = "Here are your login details <br><br> Username : ".$usernameToSent."<br> Password :".$pwToSent."<br>";
			$from = "admin@belinked.com";
			$headers = "From: $from";
			
			// P.S php.ini file should be modified according to use mail function - 
			// More reference on configuring the php,ini file - http://www.w3schools.com/php/php_ref_mail.asp 
			
			mail($email,$subject,$message,$headers);
			
			$_SESSION['forgotPW'] = "An email has sent. <br>Check your email inbox" ;
			
			redirect_to("home");
			return "<font color=green>An email has sent.Redirecting to home page....</font>";
		}  	
	} else{
		return "<font color=red>Email has Invalid characters</font>";
	}
	
}

// get login detail by username
function getLoginDetails($email) {  
	$username = getUsernameByEmail($email);
    $query = "select * from user_login WHERE username='{$username}' ";
    $result_set = mysql_query($query);
	if(isQuerySuccess($result_set)){
		if (mysql_num_rows($result_set) == 1) {
			$userLogin = mysql_fetch_array($result_set); 
			return $userLogin; 
		} else {  
			return null; 
		}	
	} 
}

//fetch username by the given email
function getUsernameByEmail($email){
	$query = "select * from user_profile_details WHERE email='{$email}' ";
    $result_set = mysql_query($query);
	if(isQuerySuccess($result_set)){
		if (mysql_num_rows($result_set) == 1) {
			$userProfile = mysql_fetch_array($result_set);
			$username = $userProfile['username'];
			return $username;
		} else {
			return "";
		}	
	} 
}

?>