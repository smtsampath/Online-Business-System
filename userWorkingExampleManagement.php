<?php
require("includes/mysql_database_connection.php");
require("includes/projects_management_function.php");
require("includes/profile_management_function.php");
require("includes/session.php");
require("includes/util.php");

redirectToHTTPS();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $userProfilePicturePath = getProfilePicturePathByUsername($username);
	$projectArray = getProjectsListByUsername($username);
	 
    $isUserAdminValue = isUserAdmin($username);
	
    if (isset($_POST['projectUploadSubmit'])) {
		$projectTitle = ($_POST['projectTitle']);
		$description = ($_POST['projectDescription']);
		if(getProjectDetailsByUsernameAndTitle($username,$projectTitle) == null){
			
			$uploadedFileName = $_FILES["projectFile"]["name"];
			$fileExt = end(explode(".", $uploadedFileName));
			if ( isset($fileExt) && ( $fileExt == "rar" || $fileExt == "zip" ) ) {
				if ($_FILES["projectFile"]["error"] > 0) {
					$error = "Return Code: " . $_FILES["projectFile"]["error"] . "<br />";
				} else {
					 
					$fileName = $projectTitle.".". $fileExt;
					$directoryPath = "user_projects/" .$username ;
					$finalFilePath = $directoryPath."/". $fileName; 
					
					if(! file_exists($directoryPath)){
						mkdir($directoryPath, 0777 , true);  
					}
									
					move_uploaded_file($_FILES["projectFile"]["tmp_name"], $finalFilePath);
					manageProject($username, $finalFilePath, $description ,$projectTitle);
					
					$projectArray = getProjectsListByUsername($username); 
				}
			} else {
				$error = "Only .rar and .zip file types are allowed";
			}

		}else {
			$error = "A file with the same project title already exists. Try different project title";
		}
    } else {
        $description = "";
    } 
	
	
	if(isset($_GET['filePathToDelete'])){
		$filePathToDelete = $_GET['filePathToDelete'];
		unlink($filePathToDelete);
		deleteProject($filePathToDelete);
		redirect_to("../userProject");
	}
} else {
    redirect_to("home");
}
?>
<script type="text/javascript" language="javascript" src="js/userProject.js"></script>
<script type="text/javascript" language="javascript">


    function resetAdminArea(){
<?php
if (isset($_SESSION['selectedUsername'])) {
    unset($_SESSION['selectedUsername']);
}
?>	
            }

</script>
<head>
    <title>Be Linked! User project management</title>
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
                <form name="projectUploadForm" id="projectUploadForm" action="userProject" method="post"  onsubmit="return validateForm()" enctype="multipart/form-data">
                    <table   border="0" cellpadding="5" class="fontOnly">
                    	<tr>
                        	 
                        	<td><label for="projectTitle">Project Title </label>
                            	<input type="text" name="projectTitle" id="projectTitle" maxlength="100" value="<?php if(isset($projectTitle)){echo htmlentities($projectTitle);} ?>" onChange="this.value=this.value.trim()" onKeyUp="clearMsg()" onBlur="isProjectTitleValid(this.value)" size="52"/>
                            </td>
                            <td><div id="projectTitleMsg" ></div></td>
                        </tr>
                        <tr>
                            <td><label for="projectDescription">Description </label><br><textarea rows="3" cols="50" name="projectDescription" maxlength="250" id="projectDescription" onChange="this.value=this.value.trim()" onKeyUp="clearMsg()" onBlur="isProjectDescriptionValid(this.value)"  ><?php echo $description ?></textarea></td>
                            <td><div id="projectDescriptionMsg"></div></td>
                        </tr>
                        <tr>
                            <td><label for="projectFile">File name </label><input type="file" name="projectFile" id="projectFile" size="30" /></td>
                        </tr>
                        <tr>
                            <td><input type="submit" value="Upload Project" name="projectUploadSubmit" ></td>
                        </tr>
                    </table>
<?php if (isset($_POST['projectUploadSubmit']) && isset($error)) { ?>
                    <div id="projectUploadMsg"><font color=red><?php echo $error ?></font></div>
<?php } ?><br/>

<table id="projectsTable" border="1" class="fontOnly" style='table-layout:fixed' width="100%" >
 <col width=25%>
 <col width=35%>
 <col width=20%>
 <col width=20%>

	<?php  
	
	if(count($projectArray) > 0){
	
		foreach($projectArray as $project){ ?>
        	<tr>
            	<td>
                	<b><?php echo $project["project_file_title"]; ?></b>
                	
                </td>
                <td width="35%"   >
                	<div style="overflow:scroll"> <?php echo htmlentities($project["project_description"]);   ?> </div>
                	
                </td>
                 <td>
                	<a href="<?php echo $project["project_file_path"] ?>" class="search" target="_blank"><u>Download Project</u></a>
                	
                </td>
                <td>
                	<a href="userProjects-<?php echo $project["project_file_path"]  ; ?>" class="search"  onclick="return ConfirmDelete();" ><u>Remove Project</u></a>
                	
                </td>
                
            </tr>
        
        
    
    <?php } ?>
    <?php }else{ ?>
    	No projects have been uploaded yet.
    <?php } ?>
</table>

 
                </form></br>
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