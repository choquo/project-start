<?php
//Required files
if( !class_exists('Database') ){ 
	require INCLUDES_DIRNAME.'/db.php';
}
//Get settings from database
$database->query("SELECT * FROM page_settings");
$settings = $database->getOne();
?>