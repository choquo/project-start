<?php
//Required files
if( !WX_CONFIG ){ require '_config.php'; }
if( !class_exists('Database') ){ require $includes_dirname.'/db.php'; }

//Get settings from database
$database->query("SELECT * FROM page_settings");
$settings = $database->getOne();
?>