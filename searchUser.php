<?php
require("includes/mysql_database_connection.php");
require("includes/search_user_function.php");
include("includes/profile_management_function.php");
require("includes/util.php");
require("includes/session.php");

redirectToHTTPS();

if (isset($_POST['searchSubmit'])) {
    $searchTxt = $_POST['searchField'];
	$searchTerm = $_POST['searchOptions'];
	
    $allUsernamesWithNoDuplicates = getSearchResults($searchTxt,$searchTerm);
	if(isset($allUsernamesWithNoDuplicates)){
		if (!empty($allUsernamesWithNoDuplicates)) {
			$msg = sizeof($allUsernamesWithNoDuplicates) . " results found";
		} else {
			$msg = "<font color=red>No results found</font>";
		} 
	} else {
		$msg = "<font color=red>Invalid Character found.Try different keywords</font>";
	}     
} else {
    $msg = "";
    $searchTxt = "";
}
?>

<script type="text/javascript" language="javascript" src="js/userSearch.js">

    

</script>

<head>
    <title>Be Linked! Search user</title>
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
      				<div  class="searchForm">
                    <form action="search" method="post" id="searchForm" name="searchForm" onSubmit="return validateSearchForm()">
        <table border="0" cellpadding="1" class="fontOnly" >
             
            <tr>
                <td>Search &nbsp;<input type="text" name="searchField" id="searchField" size="40" maxlength="75" value="<?php  echo htmlentities($searchTxt);   ?>" onChange="this.value=this.value.trim()" onBlur="isSearchTermValid(this.value)"/> By
                <select   name="searchOptions"  id="searchOptions"   >
                	<option>All Terms</option>
                    <option>First Name</option>
                    <option>Last Name</option>
                    <option>Username</option>
                    <option>Email</option>
                    <option>Country</option>
                    <option>Contact Number</option>
                    <option>Gender</option>
                </select> 
                 </td>
                <td><input type="submit"     value="Search" name="searchSubmit" /> </td>
            </tr>
            <tr><td><div id="searchFieldValidateMsg"></div></td> </tr>
            <tr><td><div id="searchFieldMsg"><?php echo $msg ?></div></td> </tr>
            <tr><td>
<?php
if (isset($allUsernamesWithNoDuplicates)) {
    foreach ($allUsernamesWithNoDuplicates as $username) {
        $selectedUserProfilePicturePath = getProfilePicturePathByUsername($username);
        $selectedUserProfileDetails = getProfileDetailsByUsername($username);
        $selectedUserGender = $selectedUserProfileDetails["gender"];
        $selectedUserFirstName = $selectedUserProfileDetails["first_name"];
        $selectedUserLastName = $selectedUserProfileDetails["last_name"];
        $selectedUserContactNumber = $selectedUserProfileDetails["contact_number"];
?>
                    <table  class="fontOnly">
                        <tr>
                            <td  > <img src="<?php echo $selectedUserProfilePicturePath ?>" width="45" height="45"> </td>
                            <td>
                                <a  class="search" href="users-<?php echo urlencode($username) ?>" target="_blank"><u><?php echo $username ?></u> </a><br>
<?php echo $selectedUserGender ?><br>
<?php echo $selectedUserFirstName . " " . $selectedUserLastName ?><br>
                            </td>
                        </tr>
                    </table><hr>
<?php } ?>
<?php } ?>
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