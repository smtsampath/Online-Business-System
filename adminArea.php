<?php
require("includes/mysql_database_connection.php");
include("includes/admin_area_functions.php");
include("includes/cv_management_function.php");
include("includes/profile_management_function.php");
include("includes/session.php");
include("includes/util.php");
require("includes/country_list.php");

redirectToHTTPS();

if (isset($_SESSION['username'])) {
    if (isUserAdmin($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $userProfilePicturePath = getProfilePicturePathByUsername($username);
        $isUserAdminValue = isUserAdmin($username);

        if (isset($_POST['userSelectFormResetSubmit'])) {
            unset($_SESSION['selectedUsername']);
        }

        if (isset($_POST['userSelectFormResetSubmit0'])) {
            unset($_SESSION['selectedUsername']);
        }

        if (isset($_POST['userSelectFormSubmit'])) {
            $selectedUsername = $_POST['users']; 
			if(strcmp($selectedUsername,"Select User") != 0){
				$_SESSION['selectedUsername'] = $selectedUsername;
				$selectedUserProfilePicturePath = getProfilePicturePathByUsername($selectedUsername);
				$selectedUserProfileDetails = getProfileDetailsByUsername($selectedUsername);
				$selectedUserEmail = $selectedUserProfileDetails["email"];
				$selectedUserFirstName = $selectedUserProfileDetails["first_name"];
				$selectedUserLastName = $selectedUserProfileDetails["last_name"];
				$selectedUserGender = $selectedUserProfileDetails["gender"];
				$selectedUserAddress1 = $selectedUserProfileDetails["address_line1"]; 
				
				if(isset($selectedUserProfileDetails["address_line2"])){
					$selectedUserAddress2 = $selectedUserProfileDetails["address_line2"] ;	
				}else{
					$selectedUserAddress2 = "" ;	
				} 
				$selectedUserCountry = $selectedUserProfileDetails["country"]; 
				if(isset($selectedUserProfileDetails["contact_number"])){
					$selectedUserContactNumber =$selectedUserProfileDetails["contact_number"] ;	
				}else{
					$selectedUserContactNumber = "" ;	
				}	
			} 
             
        }  

        if (isset($_POST['profileSubmit'])) {
            if (isset($_SESSION['selectedUsername'])) {
                $selectedUsername = $_SESSION['selectedUsername'];
                $selectedUserFirstName = ($_POST['firstname']);
                $selectedUserLastName = ($_POST['lastname']);
				$selectedUserGender= ($_POST['gender']);
				$selectedUserAddress1 = ($_POST['address1']);
				$selectedUserAddress2 = ($_POST['address2']);
				$selectedUserCountry= ($_POST['country']);
                $selectedUserContactNumber = ($_POST['contactnumber']);

                if (hasProfileDetailsByUsername($selectedUsername)) {

                    $selectedUserUpdateProfileResponse = updateProdileDetails($selectedUsername, $selectedUserFirstName, $selectedUserLastName, $selectedUserGender, $selectedUserAddress1, $selectedUserAddress2, $selectedUserCountry,$selectedUserContactNumber);

                    $selectedUserProfileDetails = getProfileDetailsByUsername($selectedUsername);
                    if (isset($selectedUserProfileDetails)) {
                        $selectedUserFirstName = $selectedUserProfileDetails["first_name"];
						$selectedUserLastName = $selectedUserProfileDetails["last_name"];
                        $selectedUserContactNumber =$selectedUserProfileDetails["contact_number"] ;	
                        $selectedUserEmail = $selectedUserProfileDetails["email"];
                    }
                    $selectedUserProfilePicturePath = getProfilePicturePathByUsername($selectedUsername);
                } else {
                    $selectUserFirstMsg = "User does not exists";
                }
            } else {
                $selectedUserUpdateProfileResponse = "";
                $selectUserFirstMsg = "You have to select a user first";
            }
        }
        if (isset($_POST['changePasswordSubmit'])) {

            if (isset($_SESSION['selectedUsername'])) {

                $selectedUsername = $_SESSION['selectedUsername'];
                $currentPassword = ($_POST['currentPassword']);
                $newPassword = ($_POST['newPassword']);

                $updatePasswordResponseMsg = updateUserPassWord($selectedUsername, $currentPassword, $newPassword);
            } else {
                $updatePasswordResponseMsg = "";
            }
        }

        if (isset($_POST['profilePicUploadSubmit'])) {
            if (isset($_SESSION['selectedUsername'])) {
                $selectedUsername = $_SESSION['selectedUsername'];
                if ((($_FILES["profilePicFile"]["type"] == "image/gif") || ($_FILES["profilePicFile"]["type"] == "image/jpeg") || ($_FILES["profilePicFile"]["type"] == "image/png") || ($_FILES["profilePicFile"]["type"] == "image/pjpeg"))) {
                    if (($_FILES["profilePicFile"]["size"] < 40000)) {
                        if ($_FILES["profilePicFile"]["error"] > 0) {
                            $error = "Return Code: " . $_FILES["profilePicFile"]["error"] . "<br />";
                        } else {
                            $uploadedFileName = $_FILES["profilePicFile"]["name"];
                            $fileExt = end(explode(".", $uploadedFileName));
                            $fileName = $selectedUsername . "." . $fileExt;
                            $finalFilePath = "user_profile_pictures/" . $fileName;
                            if (hasPicUploadedOnce($selectedUsername)) {
                                $picFilePath = getProfilePicturePathByUsername($selectedUsername);
                                unlink($picFilePath);
                            }
                            move_uploaded_file($_FILES["profilePicFile"]["tmp_name"], $finalFilePath);
                            manageProfilePicture($selectedUsername, $finalFilePath);
                            $selectedUserProfilePicturePath = getProfilePicturePathByUsername($selectedUsername);
                        }
                    } else {
                        $error = "file size shold be less than 40KB";
                    }
                } else {
                    $error = "Invalid file type.Valid file types are gif,jpeg,png,pjpeg ";
                }
            } else {
                $error = "Select a user first";
            }
        }

        if (isset($_POST['deletePicFormSubmit'])) {
            if (isset($_SESSION['selectedUsername'])) {
                $selectedUsername = $_SESSION['selectedUsername'];
                if (hasPicUploadedOnce($selectedUsername)) {
                    $picFilePath = getProfilePicturePathByUsername($selectedUsername);
                    unlink($picFilePath);
                    manageProfilePicture($selectedUsername, "");
                    $selectedUserProfilePicturePath = getProfilePicturePathByUsername($selectedUsername);
                    $isPicDeleteSuccess = true;
                } else {
                    $isPicDeleteSuccess = false;
                }
            }
        }

        if (isset($_SESSION['selectedUsername'])) {
            $selectedUsername = $_SESSION['selectedUsername'];
            $cvFilePath = getCVPathByUsername($selectedUsername);
        }
        if (isset($_POST['cvUploadSubmit'])) {
            if (isset($_SESSION['selectedUsername'])) {
                $selectedUsername = $_SESSION['selectedUsername'];
                if ((($_FILES["cvFile"]["type"] == "application/pdf"))) {
                    if ($_FILES["cvFile"]["error"] > 0) {
                        $error = "Return Code: " . $_FILES["cvFile"]["error"] . "<br />";
                    } else {
                        $uploadedFileName = $_FILES["cvFile"]["name"];
                        $fileExt = end(explode(".", $uploadedFileName));
                        $fileName = $selectedUsername . "." . $fileExt;
                        $finalFilePath = "user_cvs/" . $fileName;
                        if (hasCVUploadedOnce($selectedUsername)) {
                            $cvFilePath = getCVPathByUsername($selectedUsername);
                            unlink($cvFilePath);
                        }
                        move_uploaded_file($_FILES["cvFile"]["tmp_name"], $finalFilePath);
                        manageCV($selectedUsername, $finalFilePath);
                        $cvFilePath = getCVPathByUsername($selectedUsername);
                    }
                } else {
                    $error = "Only .pdf file type is allowed";
                }
            } else {
                $error = "Select a user first";
            }
        }

        if (isset($_POST['deleteCVFormSubmit'])) {
            if (isset($_SESSION['selectedUsername'])) {
                $selectedUsername = $_SESSION['selectedUsername'];
                if (hasCVUploadedOnce($selectedUsername)) {
                    $cvFilePath = getCVPathByUsername($selectedUsername);
                    unlink($cvFilePath);
                    deleteCVPath($selectedUsername);
                    $cvFilePath = getCVPathByUsername($selectedUsername);
                    $isCVDeleteSuccess = true;
                } else {
                    $isCVDeleteSuccess = false;
                }
            }
        }

        if (isset($_SESSION['selectedUsername'])) {
            $selectedUsername = $_SESSION['selectedUsername']; 
            $selectedUserProfileDetails = getProfileDetailsByUsername($selectedUsername); 
            $selectedUserEmail =  $selectedUserProfileDetails["email"]; 
            $selectedUserFirstName =$selectedUserProfileDetails["first_name"];
            $selectedUserLastName = $selectedUserProfileDetails["last_name"];
			$selectedUserGender = $selectedUserProfileDetails["gender"];
			$selectedUserAddress1 = $selectedUserProfileDetails["address_line1"]; 
			if(isset($selectedUserProfileDetails["address_line2"])){
				$selectedUserAddress2 = $selectedUserProfileDetails["address_line2"] ;	
			}else{
				$selectedUserAddress2 = "" ;	
			}
			$selectedUserCountry = $selectedUserProfileDetails["country"];
            if(isset($selectedUserProfileDetails["contact_number"])){
			$selectedUserContactNumber =$selectedUserProfileDetails["contact_number"] ;	
			}else{
				$selectedUserContactNumber = "" ;	
			}
			$selectedUserProfilePicturePath = getProfilePicturePathByUsername($selectedUsername);
				 
        } else {
            $selectedUsername = "Select a user";
            $selectedUserEmail = "Select a user";
            $selectedUserFirstName = "Select a user";
            $selectedUserLastName = "Select a user"; 
			$selectedUserAddress1 = "Select a user";
			$selectedUserAddress2 = "Select a user"; 
            $selectedUserContactNumber = "Select a user";
        }
    } else {
        redirect_to("userHome");
    } 
} else {
    redirect_to("home");
}
?>

<script type="text/javascript" language="javascript" src="js/adminArea.js"></script>
<script type="text/javascript" language="javascript">
 
    
    function hasConfirmDeletePic(){
  
  		<?php if(isset($selectedUsername)){ ?> 
		<?php 	if(hasPicUploadedOnce($selectedUsername)){ ?>  
					var agree=confirm("Are you sure to delete the profile picture of user <?php echo $selectedUsername ?>?");
					if (agree){
						return true;
					}else{
						return false;
					}
        <?php 	}?>
        <?php }?>
	
    }

    function hasConfirmDeleteCV(){

        <?php if(isset($selectedUsername)){ ?> 
		<?php 	if(hasCVUploadedOnce($selectedUsername)){ ?>   
					var agree=confirm("Are you sure to delete the CV of user <?php echo $selectedUsername ?>?");
					if (agree){
						return true;
					}else{
						return false;
					} 
		<?php 	}?>
        <?php }?>
    } 
</script>
<head>
    <title>Be Linked! Admin area</title>
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


    <table id="formTable" border="0"  class="fontOnly">
        <tr>
            <td>

            </td>
            <td>
                <table  border="0"  class="fontOnly">

                    <tr>
                        <td>
                            <form name="userSelectForm" id="userSelectForm" action="adminPanel" method="post" onSubmit="return validateUserSelectForm()">

                              <div>  <select   name="users"  id="users"   >
                                    <option >Select User</option>
<?php
$usernames = getAllUsernames();
if (isset($usernames)) {
    foreach (getAllUsernames () as $username) { ?>
<?php if(isset($_SESSION['selectedUsername']) && strcmp($_SESSION['selectedUsername'] , $username) ==0){ ?>
                                    <option selected><?php echo $username ?></option>
<?php }else{ ?>
                                    
					<option > <?php echo $username ?></option>				
<?php } ?>
<?php } ?>
<?php } ?>
                                </select>
                                <input type="submit" value="Show Details" name="userSelectFormSubmit"   /> </div>
                                <div id="userSelectionMsg"></div> 
                                
                            </form>
                            <form name="userSelectFormReset" id="userSelectFormReset" action="adminPanel" method="post" onSubmit="true">
                                    <input type="submit"   value="Reset" name="userSelectFormResetSubmit" />
                                </form>

                        </td>
                    </tr>
                    <tr><td>
<?php if (isset($_SESSION['selectedUsername'])) { ?>
                            <img width="120" height="120" src="<?php echo getProfilePicturePathByUsername($_SESSION['selectedUsername']) ?>" />
<?php } else { ?>
                            <img width="120" height="120" src="images/noUserHasBeenSelected.png" />
<?php } ?>
                        </td></tr>
                    <tr>
                        <td>
                            <form name="updateProfileForm" id="updateProfileForm" action="adminPanel" method="post" onSubmit="return validateUpdateProfileForm()">

                                <table border="0" cellpadding="5"  class="fontOnly">
                                    <tr>
                                        <td>Username </td>
                                        <td> <?php echo $selectedUsername ?></td>
                                        </tr>
                                        <tr>
                                            <td>Email </td>
                                            <td><?php echo $selectedUserEmail ?> </td>
                                        </tr>
                                        <tr>
                                            <td>First name </td>
                                            <td><input type="text" name="firstname" id="firstname" maxlength="45" value="<?php echo htmlentities($selectedUserFirstName); ?>" onChange="this.value=this.value.trim()" onKeyUp="clearProfileDetailsResponseMsg()" onBlur="isFNameValid(this.value)"></td>
                                            <td><div id="fnameMsg"></div></td>
                                        </tr>
                                        <tr>
                                            <td>Last name </td>
                                            <td><input type="text" name="lastname" id="lastname" maxlength="45" value="<?php echo htmlentities($selectedUserLastName); ?>" onChange="this.value=this.value.trim()" onKeyUp="clearProfileDetailsResponseMsg()" onBlur="isLNameValid(this.value)"></td>
                                            <td><div id="lnameMsg"></div></td>
                                        </tr>
                                        <tr>
                            <td>Gender </td>
                            <td>
                    	 		<select   name="gender"  id="gender"   >
                                    
                                    <?php if(isFemale($selectedUsername)){ ?>
                                    	<option >Female</option>
                                    	<option >Male</option>
                                    <?php }else{ ?>
                                    	<option >Male</option>
                                    	<option >Female</option>
                                    <?php }?>
                                    
                          		</select>
                    		</td> 
                        </tr>
                         <tr>
                    <td>Address line 1 </td>
                    <td><input type="text" name="address1" id="address1" maxlength="60" value="<?php echo htmlentities($selectedUserAddress1); ?>" onChange="this.value=this.value.trim()" onBlur="isAddress1Valid(this.value)"></td>
                    <td><div id="address1Msg"></div></td>
                </tr>
				<tr>
                    <td>Address line 2 (Optional)  </td>
                    <td><input type="text" name="address2" id="address2" maxlength="60" value="<?php echo htmlentities($selectedUserAddress2); ?>" onChange="this.value=this.value.trim()" ></td>
                    <td><div id="address2Msg"></div></td>
                </tr>
                <tr>
                    <td>Country </td>
                    <td>
                    	<select   name="country"  id="country"   > 
                            <?php  	foreach ($country_list as $countryVal){	
										if(isset($selectedUserCountry) && strcmp($countryVal ,$selectedUserCountry ) == 0){		
							?>
                           		<option selected><?php echo $countryVal ?></option>
                            <?php }else{?>
                            	<option ><?php echo $countryVal ?></option>
                            <?php }?>
                           
                        	<?php }?>
                    	</select>
                    </td> 
                </tr>
                                        <tr>
                                            <td>Contact number<br>
                                            (Optional) </td>
                                            <td><input type="text" name="contactnumber" id="contactnumber" maxlength="10" value="<?php echo htmlentities($selectedUserContactNumber); ?>" onChange="this.value=this.value.trim()" onKeyUp="clearProfileDetailsResponseMsg()" onBlur="isTPNumberValid(this.value)"></td>
                                            <td><div id="tpNumberMsg"></div></td>
                                        </tr>

                                        <tr>
                                            <td>&nbsp;</td>
                                            <td><input type="submit"   value="Update Profile" name="profileSubmit" ></td>
                                        </tr>

                                    </table>

<?php if (isset($_POST['profileSubmit'])) { ?>
                                        <div id="updateProfileResponseMsg"><?php echo $selectedUserUpdateProfileResponse ?></div>
<?php } ?>

<?php if (isset($selectUserFirstMsg)) { ?>
                                        <div id="updateProfileResponseMsg2"><font color="red"><?php echo $selectUserFirstMsg ?></font></div>
<?php } ?>

                                </form>   <br />

                                <form name="changePasswordForm" id="changePasswordForm" action="adminPanel" method="post" onSubmit="return changePasswordValidateForm()">
                                    <table  class="fontOnly">
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
                                            <td><div id="updatePasswordResponseMsg">
                                            <?php 	if(isset($updatePasswordResponseMsg)){  
                                              			echo $updatePasswordResponseMsg ;
													}
											  ?>
                                            
                                            </div></td>
                                        </tr>
                                    </table>




                            </form><br />


                            <form name="profilePicUploadForm" id="profilePicUploadForm" action="adminPanel" method="post" onSubmit="true" enctype="multipart/form-data">
                                <table   border="0"  class="fontOnly">

                                    <tr>
                                    <label for="profilePicFile"><font color="#000000">Profile Picture File name :</font></label>
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

                            <form name="deletePicForm" id="deletePicForm" action="adminPanel" method="post" onSubmit="return hasConfirmDeletePic()">
                                <input type="submit"   value="Delete Picure" name="deletePicFormSubmit" />

                                <?php if (isset($_POST['deletePicFormSubmit'])) {
                                    if (isset($_SESSION['selectedUsername']) && $isPicDeleteSuccess) { ?>
                                        <div id="picDeleteMsg"><font color=green>Profile picture is successsfully deleted.</font></div>
<?php } else if (isset($_SESSION['selectedUsername']) && !$isPicDeleteSuccess) { ?>
                                        <div id="picDeleteMsg"><font color=red>Default avatar is used.No picture has been uploaded to delete.</font></div>
<?php } else { ?>
                                        <div id="picDeleteMsg"><font color=red>Select a user first.</font></div>
<?php } ?>
                                <?php } ?>
                            </form>

                        </td>
                    </tr>
                    <tr>
                        <td>
                            <form name="cvUploadForm" id="cvUploadForm" action="adminPanel" method="post"  enctype="multipart/form-data">
                                <table   border="0"  class="fontOnly">

                                    <tr>
                                    <label for="profilePicFile">CV File name :</label>
                                    <td><input type="file" name="cvFile" id="cvFile" size="30" /></td>
                                    </tr>
                                    <tr>
                                        <td><input type="submit"   value="Upload CV" name="cvUploadSubmit" ></td>
                                    </tr>
                                </table>
<?php if (isset($_POST['cvUploadSubmit']) && isset($error)) { ?>
                                    <div id="cvUploadMsg"><font color=red><?php echo $error ?></font></div>
<?php } else if (isset($_POST['cvUploadSubmit']) && !isset($error)) { ?>
                                    <div id="cvUploadMsg"><font color=green>CV is successfully uploaded</font></div>
<?php } ?>
<?php if (isset($cvFilePath)) { ?> 
                                    <a href="<?php echo $cvFilePath ?>" class="search" target="_blank">Download / Show CV</a><br>(CV can be checked online on Opera and Google Chrome web browsers) 


                                <?php } ?>
                            </form>

                                <?php if (isset($cvFilePath)) {
 ?>
                                <form name="deleteCVForm" id="deleteCVForm" action="adminPanel" method="post" onSubmit="return hasConfirmDeleteCV()">
                                    <input type="submit" value="Delete CV" name="deleteCVFormSubmit" />


                                </form>
<?php } ?>
                            <?php if (isset($_POST['deleteCVFormSubmit'])) {
                                    if (isset($_SESSION['selectedUsername'])) { ?>
                                        <div id="picDeleteMsg"><font color=green>CV is successsfully deleted.</font></div>
<?php } else { ?>
                                        <div id="picDeleteMsg"><font color=red>Select a user first.</font></div>
<?php } ?>
                            <?php } ?>
                        </td>
                    </tr>
                </table> 
            </td>

        </tr>
        <tr>

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