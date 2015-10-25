<?php
 
//fetch login details if exists and redirect user for correct page
function signIn($username, $password) {
	if(hasNotSensitiveCharacters($username)){
		if(hasNotSensitiveCharacters($password)){
			$password = encodeString($password); 
			$query = "select * from user_login WHERE username='{$username}' AND password='{$password}'";
			$result_set = mysql_query($query);
			if(isQuerySuccess($result_set)){
				if (mysql_num_rows($result_set) == 1 ) {
					$userLogin = mysql_fetch_array($result_set);
					$_SESSION['username'] = $userLogin['username'];
					redirect_to("userHome");   
					return""; 
				} else {  
					return "Invalid Login details";
				}
			}			
		}else{
			return "Password has invalid characters";
		}
	}else{
		return "Username has invalid characters";
	}	
}

?>