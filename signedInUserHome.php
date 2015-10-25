<?php
require("includes/mysql_database_connection.php");
require("includes/profile_management_function.php");
require("includes/session.php");
require("includes/util.php");

redirectToHTTPS();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $userProfileDetails = getProfileDetailsByUsername($username);
    if (isset($userProfileDetails)) {
        $userFullName = $userProfileDetails["first_name"] . " " . $userProfileDetails["last_name"];
        $userEmail = $userProfileDetails["email"];
        $userGender = $userProfileDetails["gender"]; 
		if(isset($userProfileDetails["contact_number"])){
			$userContactNumber  =$userProfileDetails["contact_number"] ;	
		}else{
			$userContactNumber  = "" ;	
		}
    }

    $userProfilePicturePath = getProfilePicturePathByUsername($username);	
	
	if(isset($connection)){
		mysql_close($connection);
	}
} else {
    redirect_to("home");
}
?>


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
            	<td width="100%" >
      				<center>
                    
            <table   border="0" cellpadding="5" class="fontOnly" >
                <tr><td><br>Welcome &nbsp;<b><?php echo $_SESSION['username']; ?> :</b> </td></tr>
                <tr>
                    <td>
                        <img  src="<?php echo $userProfilePicturePath ?>" width="120" height="120" />
                    </td>
                    <td>  
                        <table   border="0" cellpadding="5" class="fontOnly" >
                            <tr>
                                <td>Full name </td>
                                <td><b>:&nbsp;</b><?php echo $userFullName ?></td>
                            </tr> 
                            <tr>
                                <td>Email </td>
                                <td><b>:&nbsp;</b><?php echo $userEmail ?></td>
                            </tr>
                            <tr>
                                <td>Contact Number </td>
                                <td><b>:&nbsp;</b><?php if ($userContactNumber == "") { ?>
    					Not Set
<?php } else { ?>
<?php echo $userContactNumber ?> 
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td><a class="search" href="userProfile" ><u>Edit Profile</u> </a></td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td><a class="search" href="userCV" ><u>Manage Your CV</u></a></td>
                                <td>&nbsp;</td>
                            </tr>
                        </table>

                    </td>
                </tr>
            </table>
                    
                    </center>
                </td>
            </tr>
            </table>
 

    </body>
</html>