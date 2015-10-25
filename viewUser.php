<?php
require("includes/mysql_database_connection.php");
require("includes/projects_management_function.php");
include("includes/cv_management_function.php");
include("includes/profile_management_function.php");
include("includes/session.php");
include("includes/util.php");

redirectToHTTPS();

if (isset($_GET['selectedSearchedUsername'])) {

    $searchedUsername = urldecode($_GET['selectedSearchedUsername']);
    if (hasProfileDetailsByUsername($searchedUsername)) {
        $userProfilePicturePath = getProfilePicturePathByUsername($searchedUsername);
        $selectedUserProfileDetails = getProfileDetailsByUsername($searchedUsername);
        $selectedUserEmail = $selectedUserProfileDetails["email"];
        $selectedUserFirstName = $selectedUserProfileDetails["first_name"];
        $selectedUserLastName = $selectedUserProfileDetails["last_name"];
		$selectedUserGender = $selectedUserProfileDetails["gender"];
		$selectedUserAddress1 = $selectedUserProfileDetails["address_line1"];
		if(isset($userProfileDetails["address_line2"])){
			$selectedUserAddress2 = $userProfileDetails["address_line2"] ;	
		}else{
			$selectedUserAddress2 = "" ;	
		}
		$selectedUserCountry = $selectedUserProfileDetails["country"];
		if(isset($userProfileDetails["contact_number"])){
			$selectedUserContactNumber  =$userProfileDetails["contact_number"] ;	
		}else{
			$selectedUserContactNumber  = "" ;	
		}		
        $cvFilePath = getCVPathByUsername($searchedUsername);
        
		$projectArray = getProjectsListByUsername($searchedUsername);
    } else {
        redirect_to("search");
    }
	if(isset($connection)){
		mysql_close($connection);
	}
} else {
    redirect_to("search");
}
?>

<head>
    <title>Be Linked! View user</title>
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
            	<td width="100%">
      				<div  class="siteMenu"><?php require_once("siteMenu.php"); ?>  </div>
                </td>
            </tr> 
            <tr>
            	<td width="100%">
      				<div  class="viewUser">
                     <table border="0" cellpadding="2" class="fontOnly">
        <tr>
            <td><img width="120" height="120" src="<?php echo $userProfilePicturePath ?>" /></td>
        </tr>
        <tr>
            <td>Username </td>
            <td> <?php echo $searchedUsername ?></td>
        </tr>
        <tr>
            <td>Email </td>
            <td> <?php echo $selectedUserEmail ?></td>
        </tr>
        <tr>
            <td>First name </td>
            <td> <?php echo $selectedUserFirstName ?></td>
        </tr>
        <tr>
            <td>Last name </td>
            <td> <?php echo $selectedUserLastName ?></td>
        </tr>
         <tr>
            <td>Gender </td>
            <td> <?php echo $selectedUserGender ?></td>
        </tr>
         <tr>
            <td>Address </td>
            <td>
            	<?php echo $selectedUserAddress1 ?><br>
            	<?php echo $selectedUserAddress2 ?>
            </td>
        </tr>
         <tr>
            <td>Country </td>
            <td> <?php echo $selectedUserCountry ?></td>
        </tr>
        <tr>
            <td>Contact number </td>
            <td><?php if ($selectedUserContactNumber == "") { ?>
    				Not Set
<?php } else { ?>
                <?php echo $selectedUserContactNumber ?>
                <?php } ?>
            </td>
        </tr>
        <tr>
            <td>CV information :</td>
            <td>
<?php if (isset($cvFilePath)) { ?> 
        <br><a href="<?php echo $cvFilePath ?>" class="search" target="_blank"><u>Download / Show CV</u></a>&nbsp(CV can be checked online on Opera and Google Chrome web browsers)  <br/><br/>
<?php } else { ?>
        	Not has been uploaded yet.
        <?php } ?>
        </td>
    </tr>
    <tr>
        <td>Project information :</td>
        <td>
<table id="projectsTable" border="1" class="fontOnly" style='table-layout:fixed' width="100%" >
 <col width=25%>
 <col width=55%>
 <col width=20%> 

	<?php  
	
	if(count($projectArray) > 0){
	
		foreach($projectArray as $project){ ?>
        	<tr>
            	<td>
                	<b><?php echo $project["project_file_title"]; ?></b>
                	
                </td>
                <td width="35%" align="center"	style="overflow:hidden;" >
                	 <div style="overflow:scroll"> <?php echo htmlentities($project["project_description"]);   ?> </div>
                	
                </td>
                 <td>
                	<a href="<?php echo $project["project_file_path"] ?>" class="search" target="_blank"><u>Download Project</u></a>
                	
                </td> 
            </tr> 
    
    <?php } ?>
    <?php }else{ ?>
    	No projects have been uploaded yet.
    <?php } ?>
</table>

    </td>
</tr> 
</table>
                    
                    </div>
                </td>
            </tr>  
            </table>
   


</body>
</html>