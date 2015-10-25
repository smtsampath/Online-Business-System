<?php include("includes/session.php"); ?> 
<?php require("includes/util.php"); ?> 
<html>
    <head>
        <title>Be Linked! Error</title>
        <link rel="stylesheet" href="css/layout.css" type="text/css">
        <link rel="stylesheet" href="css/style.css" type="text/css"> 
    </head>
    <body > 
      <table width="100%" >
        	<tr>
            	<td > 
      				<div class="headerImage"><?php require_once("headerImage.php"); ?> </div>
                </td>
            </tr> 
            <tr>
            	<td>
      				<div  class="siteMenu"><?php require_once("siteMenu.php"); ?>  </div>
                </td>
            </tr> 
             <tr>
            	<td>
      				<div  >
                    <div>&nbsp;</div>
<center ><b>

<div class="error1"><font color="#000000">OOps......</font></div><br>
<div class="error2"><font color="#FF0000">You got a wrong destination here</font></div><br>
<div class="error2"><font color="#666666"><a href="home"  class="errorLink"  style="margin:0px;">Click here to go back to the homepage</a></font></div><br>
</div>
</b></center>
                    </div>
                </td>
            </tr>  
         </table> 
    </body>
</html>
