<?php

$adminEmail = "admin@test.com";

// common method that use for redirect user to another link according to the situation
function redirect_to($location = NULL) {
    if ($location != NULL) {
        header("Location:{$location}");
        exit;
    }
}

// check if the particular user is the admin of the website by username
function isUserAdmin($username) { 
    $userStatus = getUserStatus($username);
    if (isset($userStatus)) {
        if ($userStatus == "ADMIN USER") {
            return true;
        } else if ($userStatus == "NORMAL USER") {
            return false;
        }
    } else {
        return null;
    }
}

//check if query is executed successfully
function isQuerySuccess($result_set){
	if(!$result_set){
		die("DB Query failed - ". mysql_error());
	}else{
		return true;	
	}
}

function isNonFetchQuerySuccess($query){
	if(!mysql_query($query)){
		die("DB Query failed - ". mysql_error());
	}else{
		return true;	
	}
}

//check if user is already logged in 
function isUserLoggedIn() {
    return (isset($_SESSION['username']));
}

//redirect to https if SSL has installed in the server
function redirectToHTTPS(){
 	if($_SERVER["SERVER_PORT"] == 443){ 
		$redirect= "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		header("Location:$redirect");
	}  
}


//encrypt the string in 3 times - use for storing password
function encodeString($str){
  for($i=0; $i<3;$i++)  {
    $str=strrev(base64_encode($str));  
  }
  return $str;
}

//decrypt the string - use for retrieve password
function decodeString($str){
  for($i=0; $i<3;$i++)   {
    $str=base64_decode(strrev($str));  
  }
  return $str;
}

//check if given input has sensitive characters. This method is used for ptevent SQL injection
function hasNotSensitiveCharacters( $string ) {
	$result = false;
	if ( function_exists( "mysql_real_escape_string" ) ) { 
		$string2 = mysql_real_escape_string( $string ); 
		if(strcmp($string,$string2)==0){
			$result = true;			
		}else{
			$result = false;
		}
	} else {
		$string3 = addslashes( $string ); 
		if(strcmp($string,$string3)==0){
			$result = true;	
		}else{
			$result = false;
		}
	} 
	return $result; 
} 
 	 
?>

