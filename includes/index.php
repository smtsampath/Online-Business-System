<?php

require("../includes/util.php");
require("../includes/session.php");

if (isset($_SESSION['username'])) {
    redirect_to("../userHome");
} else {
    redirect_to("../home");
}
?>