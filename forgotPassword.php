<?php
require("includes/mysql_database_connection.php");  
include("includes/profile_management_function.php");
include("includes/forgot_password_function.php");
require("includes/util.php");
require("includes/session.php");

redirectToHTTPS();

if (isset($_SESSION['username'])) {
    redirect_to("signedInUserHome.php");
} else {
	if (isset($_POST['forgotPWSubmit'])) {
		$emailToForgotPassword = $_POST['email']; 
		if (isUserExistsByEmail($emailToForgotPassword)) {
			$msg = sendMail($emailToForgotPassword);
		}else {
			$msg = "Email does not exists";
		}
		
	} else {
		$msg = "";
		$emailToForgotPassword = "";
	}	
}

?>

<script type="text/javascript" language="javascript" src="js/forgotPassword.js"></script>

<head>
    <title>Be Linked! Forgot password</title>
        <link rel="stylesheet" href="css/layout.css" type="text/css">
        <link rel="stylesheet" href="css/style.css" type="text/css"> 
</head>
<body > 
    <table width="100%" >
        	<tr>
            	<td width="100%" > 
      				<div class="headerImage"><?php require_once("headerImage.php"); ?> </div>
                </td>
            </tr> 
            <tr>
            	<td width="100%" >
      				<div  class="siteMenu"><?php require_once("siteMenu.php"); ?>  </div>
                </td>
            </tr> 
            <tr>
            	<td width="100%" >
      				<div  class="getPW">
                     <form action="getPassword" method="post" id="forgotPasswordForm" name="forgotPasswordForm" onSubmit="return validateEmail	()">
        <table border="0" cellpadding="1" class="fontOnly" >
            <tr><td><font size="2" >Enter your email address for the login details to be sent</font></td></tr>
            <tr>
                <td><input type="text" name="email" id="email" maxlength="45" size="50" value="<?php echo htmlentities($emailToForgotPassword); ?>" onChange="this.value=this.value.trim()" onKeyUp="isEmailValid(this.value)"   ></td>
                <td><input type="submit"   value="Send mail" name="forgotPWSubmit"> </td>
            </tr>
            <tr><td><div id="emailMsg"></div></td> </tr>
            <tr><td><div id="forgotPWMsg"><font color="red"><?php echo $msg ?></font></div></td> </tr>
            <tr><td>
 
                </td> </tr>
        </table>
    </form>
                    
                    </div>
                </td>
            </tr> 
            </table>

   
<?php  
	
	if(isset($connection)){
		mysql_close($connection);
	}

?>
</body>
</html>