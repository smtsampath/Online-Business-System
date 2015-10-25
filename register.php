<?php  
require("includes/register_function.php");
require("includes/session.php");  
require("includes/country_list.php");

redirectToHTTPS();

if (isset($_SESSION['username'])) {
    redirect_to("userHome");
} else {
    if (isset($_POST['submit'])) {
        $username = ($_POST['username']);
        $email = ($_POST['email']);
        $firstname = ($_POST['firstname']);
        $lastname = ($_POST['lastname']); 
		$gender = ($_POST['gender']);
		$address1 = ($_POST['address1']);
		$address2 = ($_POST['address2']);
		$country = ($_POST['country']);
        $contactnumber = ($_POST['contactnumber']);
        $password = ($_POST['password']);
        $signUpResponse = addUser($username, $email, $firstname, $lastname,$gender,$address1,$address2,$country, $contactnumber, $password); 
    } else {
        $username = "";
        $email = "";
        $firstname = "";
        $lastname = "";
		$gender =  "";
		$address1 =  "";
		$address2 =  "";
		$country =  "";
        $contactnumber = "";
        $password = "";
		
    }
}
?>


<html>
    <head>
        <title>Be Linked! Sign up</title>
        <link rel="stylesheet" href="css/layout.css" type="text/css">
        <link rel="stylesheet" href="css/style.css" type="text/css"> 
    </head>
    <body >
        <script type="text/javascript" language="javascript" src="js/register.js">
 
            
        </script>



        <!--<center>
            <img src="images/headerimage.png" width="950" height="90" /></center>
        <div class='siteMenu'>
            <a href="home" >Home</a>
            <a href="signUp" >Sign Up</a>
            <a href="search" >Search User</a>
            <a href="mailto:<?php echo $adminEmail?> " >Contact Us</a>
        </div><br><br> <br>-->
        
        <table width="100%"  >
        	<tr>
            	<td width="100%" > 
      				<div class="headerImage"><?php require_once("headerImage.php"); ?> </div>
                </td>
            </tr> 
            <tr>
            	<td  width="100%"  >
      				<div  class="siteMenu"><?php require_once("siteMenu.php"); ?>  </div>
                </td>
            </tr> 
            <tr>
            	<td width="100%" ><div class="nonCenterForm1">
                	 <form name="signupform" id="signupform" action="signUp" method="post" onSubmit="return validateForm()" class="fontOnly">

            <table border="0" cellpadding="1" class="fontOnly" >
                <tr>
                    <td>Username </td>
                    <td><input type="text" name="username" id="username" maxlength="20" value="<?php echo htmlentities($username); ?>" onChange="this.value=this.value.trim()" onKeyUp="clearResponseText()" onBlur="isUsernameValid(this.value)"/> </td>
                    <td><div id="usernameMsg" ></div></td>
                </tr>
                <tr>
                    <td>Email </td>
                    <td><input type="text" name="email" id="email" maxlength="45" value="<?php echo htmlentities($email); ?>" onChange="this.value=this.value.trim()" onKeyUp="clearResponseText()"  onBlur="isEmailValid(this.value)"></td>
                    <td><div id="emailMsg"></div></td>
                </tr>
                <tr>
                    <td>First name </td>
                    <td><input type="text" name="firstname" id="firstname" maxlength="45" value="<?php echo htmlentities($firstname); ?>" onChange="this.value=this.value.trim()" onBlur="isFNameValid(this.value)"></td>
                    <td><div id="fnameMsg"></div></td>
                </tr>
                <tr>
                    <td>Last name </td>
                    <td><input type="text" name="lastname" id="lastname" maxlength="45" value="<?php echo htmlentities($lastname); ?>" onChange="this.value=this.value.trim()" onBlur="isLNameValid(this.value)"></td>
                    <td><div id="lnameMsg"></div></td>
                </tr>
                <tr>
                    <td>Gender</td>
                    <td>
                    	 <select   name="gender"  id="gender"  onBlur="isGenderComboValid(this.value)" >
                         	<option >Select gender</option>
                            <option >Male</option>
                            <option >Female</option>
                         </select>
                    </td>
                    <td><div id="genderMsg"></div></td>
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
                    	<select   name="country"  id="country"  onBlur="isCountriesComboValid(this.value)" >
                         	<option >Select a country</option>
                            <?php foreach ($country_list as $countryVal){ ?>
                            <option ><?php echo $countryVal ?></option>
                        	<?php }?>
                    	</select>
                    </td>
                    <td><div id="countryMsg"></div></td>
                </tr>
                
                <tr>
                    <td>Contact number (Optional) </td>
                    <td><input type="text" name="contactnumber" id="contactnumber" maxlength="10" value="<?php echo htmlentities($contactnumber); ?>" onChange="this.value=this.value.trim()" onBlur="isTPNumberValid(this.value)"></td>
                    <td><div id="tpNumberMsg"></div></td>
                </tr>
                <tr>
                    <td>Password </td>
                    <td><input type="password" name="password" id="password" maxlength="20" value="" onChange="this.value=this.value.trim()" onKeyUp="isPWValid(this.value)"></td>
                    <td><div id="pwMsg"></div></td>
                </tr>
                <tr>
                    <td>Confirm password  </td>
                    <td><input type="password" name="confirmpassword" id="confirmpassword" maxlength="20" value="" onChange="this.value=this.value.trim()" onKeyUp="isConfirmPWValid(this.value)"></td>
                    <td><div id="confirmPWMsg"></div></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td><input type="submit"     value="Sign Up" name="submit" ></td>
                    <td><?php if (isset($_POST['submit'])) { ?>
                            <div id="signUpResponseMsg"><font color="red"><?php echo $signUpResponse ?></font></div>
<?php } ?></td>
                </tr>
                 
            </table>
        </form></div>
                </td>
            </tr> 
        </table> 
    </body> 
    <?php require_once("footer.php"); ?>
</html>
