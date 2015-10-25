<?php
require("includes/mysql_database_connection.php");
require("includes/profile_management_function.php");
require("includes/session.php");
require("includes/util.php");
require("includes/country_list.php");

redirectToHTTPS();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
	
	if (isset($_POST['profileSubmit'])) {
        $firstname = ($_POST['firstname']);
        $lastname = ($_POST['lastname']);
		$gender = ($_POST['gender']);
		$address1 = ($_POST['address1']);
		$address2 = ($_POST['address2']);
		$country = ($_POST['country']);
        $contactnumber = ($_POST['contactnumber']);

        $updateProfileResponse = updateProdileDetails($username, $firstname, $lastname, $gender, $address1, $address2, $country, $contactnumber); 
    }
	
    $userProfileDetails = getProfileDetailsByUsername($username);
	
    if (isset($userProfileDetails)) {
        $userFirstName = $userProfileDetails["first_name"];
        $userLastName = $userProfileDetails["last_name"];
		$gender = $userProfileDetails["gender"];
        $userEmail = $userProfileDetails["email"];
		if(isset($userProfileDetails["contact_number"])){
			$userContactNumber =$userProfileDetails["contact_number"]; 	
		}else{
			$userContactNumber = "" ;	
		}
       
		$address1 = $userProfileDetails["address_line1"]; 
		
		if(isset($userProfileDetails["address_line2"])){
			$address2 = $userProfileDetails["address_line2"];  
		}else{
			$address2 = "" ;	
		}
		 
		$country = $userProfileDetails["country"]; 
		
    }

    $userProfilePicturePath = getProfilePicturePathByUsername($username);

    $isUserAdminValue = isUserAdmin($username);

    
    if (isset($_POST['changePasswordSubmit'])) {
        $currentPassword = ($_POST['currentPassword']);
        $newPassword = ($_POST['newPassword']);

        $updatePasswordResponseMsg = updateUserPassWord($username, $currentPassword, $newPassword);
    }

    if (isset($_POST['profilePicUploadSubmit'])) {
        if ((($_FILES["profilePicFile"]["type"] == "image/gif") || ($_FILES["profilePicFile"]["type"] == "image/jpeg") || ($_FILES["profilePicFile"]["type"] == "image/png") || ($_FILES["profilePicFile"]["type"] == "image/pjpeg"))) {
            if (($_FILES["profilePicFile"]["size"] < 40000)) {
                if ($_FILES["profilePicFile"]["error"] > 0) {
                    $error = "Return Code: " . $_FILES["profilePicFile"]["error"] . "<br />";
                } else {
                    $uploadedFileName = $_FILES["profilePicFile"]["name"];
                    $fileExt = end(explode(".", $uploadedFileName));
                    $fileName = $username . "." . $fileExt;
                    $finalFilePath = "user_profile_pictures/" . $fileName;
                    if (hasPicUploadedOnce($username)) {
                        $picFilePath = getProfilePicturePathByUsername($username);
                        unlink($picFilePath);
                    }
                    move_uploaded_file($_FILES["profilePicFile"]["tmp_name"], $finalFilePath);
                    manageProfilePicture($username, $finalFilePath);
                    $userProfilePicturePath = getProfilePicturePathByUsername($username);
                }
            } else {
                $error = "file size shold be less than 40KB";
            }
        } else {
            $error = "Invalid file type.Valid file types are gif,jpeg,png,pjpeg ";
        }
    }

    if (isset($_POST['deletePicFormSubmit'])) {
        if (hasPicUploadedOnce($username)) {
            $picFilePath = getProfilePicturePathByUsername($username);
            unlink($picFilePath);
            manageProfilePicture($username, "");
            $userProfilePicturePath = getProfilePicturePathByUsername($username);
            $isDeleteSuccess = true;
        } else {
            $isDeleteSuccess = false;
        }
    } 
	
} else {
    redirect_to("home");
}
?>

<script type="text/javascript" language="javascript" src="js/manageProfile.js"></script>
<script type="text/javascript" language="javascript">
 
 

    function hasConfirmDeletePic(){
        <?php if (hasPicUploadedOnce($username)) { ?> 
            var agree=confirm("Are you sure to delete your profile picture?");
            if (agree){
                return true;
            }else{
                return false;
            }
      <?php } ?> 
    } 
	
    function resetAdminArea(){
<?php
if (isset($_SESSION['selectedUsername'])) {
    unset($_SESSION['selectedUsername']);
}
?>	
   	}  
</script>
<head>
    <title>Be Linked! User profile management</title>
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
            	<td  width="100%">
      				<div  class="siteMenu"><?php require_once("siteMenu.php"); ?>  </div>
                </td>
            </tr> 
            <tr>
            	<td width="100%">
      				<div  class="myAccount">
                      <table  id="myAccountNavigationTable" border="0" cellpadding="3" class="fontOnly">
        <tr>
            <td><img width="120" height="120" src="<?php echo $userProfilePicturePath ?>" /></td>
        </tr>
        <tr>
            <td><a href="userProfile" class="search"><u>Manage Profile</u></a><br></td>
        </tr>
        <tr>
            <td><a href="userCV"  class="search"><u>Manage CV</u></a> </td>
        </tr>
        <tr>
            <td><a href="userProject"  class="search"><u>Manage Project</u></a></td>
        </tr>
        <tr>
            <td><?php if ($isUserAdminValue) { ?>

                    <a href="adminPanel"  class="search"><u>Admin Panel</u></a> <br>

<?php } ?></td>
        </tr>
    </table> 

    <table id="formTable" border="0"  class="fontOnly" >
        <tr>
            <td>
                <form name="updateProfileForm" id="updateProfileForm" action="userProfile" method="post" onSubmit="return validateUpdateProfileForm()">

                    <table border="0" cellpadding="5" class="fontOnly">
                        <tr>
                            <td>Username </td>
                            <td> <?php echo $username ?></td>
                        </tr>
                        <tr>
                            <td>Email </td>
                            <td><?php echo $userEmail ?> </td>
                        </tr>
                        <tr>
                            <td>First name </td>
                            <td><input type="text" name="firstname" id="firstname" maxlength="45" value="<?php echo htmlentities($userFirstName); ?>" onChange="this.value=this.value.trim()" onKeyUp="clearProfileDetailsResponseMsg()" onBlur="isFNameValid(this.value)"></td>
                            <td><div id="fnameMsg"></div></td>
                        </tr>
                        <tr>
                            <td>Last name </td>
                            <td><input type="text" name="lastname" id="lastname" maxlength="45" value="<?php echo htmlentities($userLastName); ?>" onChange="this.value=this.value.trim()" onKeyUp="clearProfileDetailsResponseMsg()" onBlur="isLNameValid(this.value)"></td>
                            <td><div id="lnameMsg"></div></td>
                        </tr>
                        <tr>
                            <td>Gender </td>
                            <td>
                    	 		<select   name="gender"  id="gender"   >
                                    <?php if(isMale($username)){?>
                                    	<option >Male</option>
                                    	<option >Female</option>
                                    <?php }else if(isFemale($username)){ ?>
                                    	<option >Female</option>
                                    	<option >Male</option>
                                    <?php } ?>
                                    
                          		</select>
                    		</td>
                            <td><div id="lnameMsg"></div></td>
                        </tr>
                         <tr>
                    <td>Address line 1 </td>
                    <td><input type="text" name="address1" id="address1" maxlength="60" value="<?php echo htmlentities($address1); ?>" onChange="this.value=this.value.trim()" onBlur="isAddress1Valid(this.value)"></td>
                    <td><div id="address1Msg"></div></td>
                </tr>
				<tr>
                    <td>Address line 2 (Optional)  </td>
                    <td><input type="text" name="address2" id="address2" maxlength="60" value="<?php echo htmlentities($address2); ?>" onChange="this.value=this.value.trim()" ></td>
                    <td><div id="address2Msg"></div></td>
                </tr>
                <tr>
                    <td>Country </td>
                    <td>
                    	<select   name="country"  id="country"   > 
                            <?php  	foreach ($country_list as $countryVal){	
										if(strcmp($countryVal ,$country ) == 0){		
							?>
                           		<option selected><?php echo $countryVal ?></option>
                            <?php }else{?>
                            	<option ><?php echo $countryVal ?></option>
                            <?php }?>
                           
                        	<?php }?>
                    	</select>
                    </td>
                    <td><div id="countryMsg"></div></td>
                </tr>
                        <tr>
                            <td>Contact number<br>
                            (Optional) </td>
                            <td><input type="text" name="contactnumber" id="contactnumber" maxlength="10" value="<?php echo htmlentities($userContactNumber); ?>" onChange="this.value=this.value.trim()" onKeyUp="clearProfileDetailsResponseMsg()" onBlur="isTPNumberValid(this.value)"></td>
                            <td><div id="tpNumberMsg"></div></td>
                        </tr>

                        <tr>
                            <td>&nbsp;</td>
                            <td><input type="submit"  value="Update Profile" name="profileSubmit" ></td>
                            <td><?php if (isset($_POST['profileSubmit'])) { ?>
                    <div id="updateProfileResponseMsg"> <?php echo $updateProfileResponse ?> </div>
<?php } ?> </td>
                        </tr>

                    </table>



                </form>

                <form name="changePasswordForm" id="changePasswordForm" action="userProfile" method="post" onSubmit="return changePasswordValidateForm()">
                    <table class="fontOnly">
                        <tr>
                            <td>Current Password </td>
                            <td><input type="password" name="currentPassword" id="currentPassword" maxlength="20" value="" onChange="this.value=this.value.trim()" onKeyUp="isCurrentPWValid(this.value)" onBlur="isCurrentPWValid(this.value)"></td>
                            <td><div id="currentPWMsg"></div></td>
                        </tr>
                        <tr>
                            <td>New Password </td>
                            <td><input type="password" name="newPassword" id="newPassword" maxlength="20" value="" onChange="this.value=this.value.trim()" onKeyUp="isNewPWValid(this.value)" onBlur="isNewPWValid(this.value)"></td>
                            <td><div id="newPWMsg"></div></td>
                        </tr>
                        <tr>
                            <td>Confirm New password  </td>
                            <td><input type="password" name="confirmpassword" id="confirmpassword" maxlength="20" value="" onChange="this.value=this.value.trim()" onKeyUp="isConfirmPWValid(this.value)" onBlur="isConfirmPWValid(this.value)"></td>
                            <td><div id="confirmNewPWMsg"></div></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td><input type="submit"  value="Change Password" name="changePasswordSubmit" ></td>
                            <td><?php if (isset($updatePasswordResponseMsg)) { ?>
                    <div id="updatePasswordResponseMsg"><?php echo $updatePasswordResponseMsg ?></div>
<?php }  ?> </td>
                        </tr>
                    </table>

 


                </form><br />


                <form name="profilePicUploadForm" id="profilePicUploadForm" action="userProfile" method="post" onSubmit="true" enctype="multipart/form-data">
                    <table   border="0" class="fontOnly">

                        <tr>
                        <label for="profilePicFile">Profile Picture File name :</label>
                        <td><input type="file" name="profilePicFile" id="profilePicFile" /></td>
                        </tr>
                        <tr>
                            <td><input type="submit"  value="Upload Picture" name="profilePicUploadSubmit" ></td>
                        </tr>
                    </table>
<?php if (isset($_POST['profilePicUploadSubmit']) && isset($error)) { ?>
                    <div id="picUploadMsg"><font color=red><?php echo $error ?></font></div>
<?php } ?>
                </form>
                <form name="deletePicForm" id="deletePicForm" action="userProfile" method="post" onSubmit="return hasConfirmDeletePic()" >
                    <input type="submit"  value="delete Picture" name="deletePicFormSubmit" />

<?php if (isset($_POST['deletePicFormSubmit']) && $isDeleteSuccess) { ?>
                    <div id="picDeleteMsg"><font color=green>Profile picture is successsfully deleted.</font></div>
<?php } else if (isset($_POST['deletePicFormSubmit']) && !$isDeleteSuccess) { ?>
                    <div id="picDeleteMsg"><font color=red>Upload a profile picture first.</font></div>
<?php } ?>
                </form>
            </td>
        </tr>
    </table> 
                    </div>
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