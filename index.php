<?php

require("includes/util.php");
require("includes/session.php");

redirectToHTTPS();

//check if user has logged in and riderect to the proper home page
if (isset($_SESSION['username'])) {
    redirect_to("userHome");
} else {
    redirect_to("home");
}
?>