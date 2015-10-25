<?php

require("db_constants.php");

// create a database connectivity
$connection = mysql_connect(DB_HOST, DB_USERNAME, DB_PASSWORD);
if (!$connection) {
    die("Database connection failed" . mysql_error());
}
// select the database from the server using above connection
$db_select = mysql_select_db(DB_NAME, $connection);
if (!$db_select) {
    die("Database selection failed " . mysql_error());
}
?>