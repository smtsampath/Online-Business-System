<table border="0" width="100%"> 
	<tr>
        <td> 
			<div  class="fontOnly">
				<?php if (isset($_SESSION['username'])) { ?>
                		<a href="userHome" >Home</a>
                		<a href="userProfile" >My Account</a>
               			<a href="search" >Search User</a>
                		<a href="signOut" >Sign Out</a>
                 		<a href="mailto:<?php echo $adminEmail?> " >Contact Us</a>
                <?php } else { ?>
                        <a href="home" >Home</a>
                        <a href="signUp" >Sign Up</a>
                        <a href="search" >Search User</a>
                        <a href="mailto:<?php echo $adminEmail?> " >Contact Us</a>
                <?php } ?>  
                
        	</div>    
       	</td>
	</tr> 
</table> 