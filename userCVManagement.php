<?php
require("includes/mysql_database_connection.php");
require("includes/cv_management_function.php");
require("includes/profile_management_function.php");
require("includes/session.php");
require("includes/util.php");

redirectToHTTPS();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $userProfilePicturePath = getProfilePicturePathByUsername($username);
    $cvFilePath = getCVPathByUsername($username);
    $isUserAdminValue = isUserAdmin($username);
    if (isset($_POST['cvUploadSubmit'])) {
        if ((($_FILES["cvFile"]["type"] == "application/pdf"))) {
            if ($_FILES["cvFile"]["error"] > 0) {
                $error = "Return Code: " . $_FILES["cvFile"]["error"] . "<br />";
            } else {
                $uploadedFileName = $_FILES["cvFile"]["name"];
                $fileExt = end(explode(".", $uploadedFileName));
                $fileName = $username . "." . $fileExt;
                $finalFilePath = "user_cvs/" . $fileName;
                if (hasCVUploadedOnce($username)) {
                    $cvFilePath = getCVPathByUsername($username);
                    unlink($cvFilePath);
                }
                move_uploaded_file($_FILES["cvFile"]["tmp_name"], $finalFilePath);
                manageCV($username, $finalFilePath);
                $cvFilePath = getCVPathByUsername($username);
            }
        } else {
            $error = "Only .pdf file type is allowed";
        }
    }

    if (isset($_POST['deleteCVFormSubmit'])) {
        if (hasCVUploadedOnce($username)) {
            $cvFilePath = getCVPathByUsername($username);
            unlink($cvFilePath);
            deleteCVPath($username);
            $cvFilePath = getCVPathByUsername($username);
            $isDeleteSuccess = true;
        } else {
            $isDeleteSuccess = false;
        }
    }
} else {
    redirect_to("home");
}
?>

<script type="text/javascript" language="javascript">
 
    function hasConfirmDeleteCV(){
		<?php if(hasCVUploadedOnce($username)){ ?>
            var agree=confirm("Are you sure to delete your CV?");
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
    <title>Be Linked! User CV management</title>
        <link rel="stylesheet" href="css/layout.css" type="text/css">
        <link rel="stylesheet" href="css/style.css" type="text/css"> 
</head>
<body > 
     <table width="100%" >
        	<tr>
            	<td width="100%"> 
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
      				<div class="myAccount">
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

    <table id="formTable" border="0" class="fontOnly">
        <tr>
            <td>

            </td>
            <td>
                <form name="cvUploadForm" id="cvUploadForm" action="userCV" method="post"  enctype="multipart/form-data">
                    <table   border="0" class="fontOnly">

                        <tr>
                        <label for="profilePicFile">CV File name :</label>
                        <td><input type="file" name="cvFile" id="cvFile" size="30" /></td>
                        </tr>
                        <tr>
                            <td><input type="submit" value="Upload CV" name="cvUploadSubmit" ></td>
                        </tr>
                    </table>
<?php if (isset($_POST['cvUploadSubmit']) && isset($error)) { ?>
                    <div id="cvUploadMsg"><font color=red><?php echo $error ?></font></div>
<?php } ?><br/>
                    <?php if (isset($cvFilePath)) {
 ?> 					Current CV info : <br><br>
                        <a href="<?php echo $cvFilePath ?>" class="search" target="_blank"><u>Download / Show CV</u></a> <br>(CV can be checked online on Opera and Google Chrome web browsers) 
<?php } ?>
                </form></br>

<?php if (isset($cvFilePath)) { ?>
                    <form name="deleteCVForm" id="deleteCVForm" action="userCV" method="post" onSubmit="return hasConfirmDeleteCV()">
                        <input type="submit"  value="Delete  CV" name="deleteCVFormSubmit" />

                    </form>
<?php } ?>
<?php if (isset($_POST['deleteCVFormSubmit']) && $isDeleteSuccess) { ?>
                        <div id="picDeleteMsg"><font color=green>CV is successsfully deleted.</font></div>
                <?php } else if (isset($_POST['deleteCVFormSubmit']) && !$isDeleteSuccess) {
 ?>
                        <div id="picDeleteMsg"><font color=red>Upload a CV first</font></div>
<?php } ?>

            </td>

        </tr>
        <tr>

        </tr>
    </table> </div> 
                    
                   
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