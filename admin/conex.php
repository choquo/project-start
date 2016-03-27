<?php
$mysqlHost = "localhost";
$mysqlUsername = "root";
$mysqlPassword = "";
$mysqlDatabase = "diagnolabsnuevo";

$conex = mysql_connect($mysqlHost, $mysqlUsername, $mysqlPassword);
mysql_select_db($mysqlDatabase, $conex);



//PDO Define configuration
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "diagnolabsnuevo");
?>