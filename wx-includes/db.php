<?php
//Required files
if( !isset($_config) ){ require '_config.php'; }

//Get database connection and set $database as current database access
include $admin_dirname.'/conex.php';
include $admin_dirname.'/classes/DatabaseClass.php';
$database = new Database;
?>