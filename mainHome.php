<?php
require("includes/mysql_database_connection.php");
require("includes/login_function.php");
require("includes/util.php");
require("includes/session.php");
 
redirectToHTTPS(); 

if (isset($_SESSION['username'])) {
    redirect_to("userHome");
} else {
			
    if (isset($_POST['submit'])) {
        $username = ($_POST['username']);
        $password = ($_POST['password']);
        $loginResponse = signIn($username, $password); 
		unset($_SESSION['firstSignIn']);
		unset($_SESSION['forgotPW']);
    } else {
        $username = "";
        $password = "";
    }  
}
?>

<script type="text/javascript" language="javascript" src="js/login.js">
 

</script>


<html> 
    <head>
        <title>Be Linked! Home Page</title>
        <link rel="stylesheet" href="css/layout.css" type="text/css">
        <link rel="stylesheet" href="css/style.css" type="text/css"> 
    </head>
    <body class='home'>
    
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
      				<div  class="homePageLogo"><?php require_once("homePageLogo.php"); ?>  </div>
                </td>
            </tr>
             <tr>
             
            	<td width="100%" ><div  class="nonCenterForm2">
      				
        <form action="home" id="signInForm" name="signInForm" method="post" onSubmit="return validateForm()" >  
            <table border="0" cellpadding="1" class="fontOnly" > 
            	<tr><td></td>
                <td>	<?php  if(isset($_SESSION['firstSignIn'])){ ?>
        	<div id="redirectMsg" class="fontOnly"><font color="green"><?php echo $_SESSION['firstSignIn'] ?></font></div>
        <?php  }else if(isset($_SESSION['forgotPW'])){  ?>
        	<div id="redirectMsg" class="fontOnly"><font color="green"><?php echo $_SESSION['forgotPW'] ?></font></div>
        <?php  } else{?>
        	<div id="redirectMsg" class="fontOnly"><font color="green"> &nbsp;<br> &nbsp;</font> </div>
        <?php  } ?></td>
                </tr>            
                <tr>
                    <td>Username </td>
                    <td><input type="text" name="username" id="username" maxlength="20" value="" onChange="this.value=this.value.trim()" onKeyUp="clearUernameResponseText()" onBlur="isUsernameValid(this.value)"/> </td>
                    <td><div id="usernameMsg"></div></td>
                </tr>
                <tr>
                    <td>Password </td>
                    <td><input type="password" name="password" id="password" maxlength="20" value="" onChange="this.value=this.value.trim()" onKeyUp="isPWValid(this.value)" /></td>
                    <td><div id="pwMsg"></div></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td><input type="submit"    value="Log in" value="submit"  name="submit" /></td>
                    <td>
                        <?php if (isset($_POST['submit'])) {
                        ?>
                            <div id="signInResponseMsg"><font color="red"><?php echo $loginResponse ?></font></div>
                        <?php } ?>
                    </td>
                </tr>
				<tr>
                	<td></td>
                    <td style="padding-top:8px">
                    	<a class="search" href="getPassword"><u>Forgot Password ?</u></a>
                    </td>
                </tr>
            </table>
        </form></div>
                </td>
            </tr> 
            <tr>
            	<td>
                	<div class="signUpDes">Do not have an account ? <a href="signUp" class="search"><font class="fontOnly"><u><i>Sign Up</i></u></font></a> for an account and show how smart you in your career!</div><br> 
                
                </td>
            
            </tr>
		</table>
         

     

</body> 
</html>
<?php

if(isset($connection)){
	mysql_close($connection);
}

?>