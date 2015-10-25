<?php  

require("mysql_database_connection.php");  
require("util.php");
//check if username already exists for ajax validation
if (isset($_GET['username'])) {
    $username = $_GET['username'];
    if (!isUserExistsByUsername($username)) { 
        echo "<font color=green> Username is available</font>";
    } else {
        echo "<font color=red> Username is not available</font>"; 
    }
}

//check if email already exists for ajax validation
if (isset($_GET['email'])) {
    $email = $_GET['email'];
    if (!isUserExistsByEmail($email)) {
        echo "<font color=green>Valid</font>";
    } else {
        echo "<font color=red>Email already exisits</font>";
    }
}
 
//check if username already exists in form submit
function isUserExistsByUsername($username) {
    $query = "select * from user_profile_details WHERE username='{$username}' ";
    $result_set = mysql_query($query);
	if(isQuerySuccess($result_set)){
		if (mysql_num_rows($result_set) > 0) { 
			return true;
		} else { 
			return false;
		}	
	}     
}

//check if email already exists in form submit
function isUserExistsByEmail($email) {
    $query = "select * from user_profile_details WHERE email='{$email}' ";
    $result_set = mysql_query($query);
    if(isQuerySuccess($result_set)){
		if (mysql_num_rows($result_set) > 0) { 
			return true;
		} else { 
			return false;
		}	
	}	
}
  
//Add a user to database  
function addUser($username, $email, $firstname, $lastname, $gender,$address1,$address2,$country, $contactnumber, $password) {
	if(hasNotSensitiveCharacters($username)){
		if(hasNotSensitiveCharacters($email)){
			if(hasNotSensitiveCharacters($firstname)){
				if(hasNotSensitiveCharacters($lastname)){
					if(hasNotSensitiveCharacters($gender)){
						if(hasNotSensitiveCharacters($address1)){
							if(hasNotSensitiveCharacters($address2)){
								if(hasNotSensitiveCharacters($country)){
									if(hasNotSensitiveCharacters($contactnumber)){
										if(hasNotSensitiveCharacters($password)){
											if($gender != "Select a gender" && $country != "Select a country"){
												if (!(isUserExistsByUsername($username) || isUserExistsByEmail($email))) { 		
												
													if(isNonFetchQuerySuccess("INSERT INTO user_profile_details (username, first_name, last_name,gender,address_line1,country,email,address_line2,picture_file_path,contact_number) VALUES ('$username', '$firstname','$lastname' , '$gender' , '$address1', '$country', '$email', '$address2', '', '$contactnumber')")){
														
														$password = encodeString($password);
														if (isAdminAlreadyExists($username)) {
															isNonFetchQuerySuccess("INSERT INTO user_login (username, password , status) VALUES ('$username', '$password', 'NORMAL USER')");
														} else {
															isNonFetchQuerySuccess("INSERT INTO user_login (username, password , status) VALUES ('$username', '$password', 'ADMIN USER')");
														}																																													 
														$_SESSION['firstSignIn'] = "Successfully signed up! <br> Now you can login here" ;
														redirect_to("home");	
													}else{
														return "Registration Failed";
													}													
												} else if (isUserExistsByUsername($username)) { 
													return "Username is not available";
												} else if (isUserExistsByEmail($email)) { 
													return "Email already exists";
												}	
											}
										}else{
											return "Password has Invalid characters";
										}
									}else{
										return "Contact number has Invalid characters";
									}
								}else{
									return "Country has Invalid characters";
								}
							}else{
								return "Address Line 2 has Invalid characters";
							}	
						}else{
							return "Address Line 1 has Invalid characters";
						}
					}else{
						return "Gender has Invalid characters";
					}
				}else{
					return "Last name has Invalid characters";
				}					
			}else{
				return "First name has Invalid characters";
			}
		}else{
			return "Email has Invalid characters";
		} 
	} else{
		return "Username has Invalid characters";
	}
   
}

//check if admin already exists
function isAdminAlreadyExists($username) {
    $query = "select * from user_login WHERE status='ADMIN USER' ";
    $result_set = mysql_query($query);
	if(isQuerySuccess($result_set)){
		if (mysql_num_rows($result_set) > 0) { 
			return true;
		} else { 
			return false;
		}	
	} 
} 
 
?>