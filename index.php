<?php 
/**
* Define charset for plain-text outputs
* This doesn't have nothing to do with database utf, the database utf is set in admin/classes/DatabaseClass.php
*/
header('Content-Type: text/html; charset=utf-8');

//Define configuration environment vars
require '_config.php';

//Requires always a database connection
require INCLUDES_DIRNAME.'/db.php';	//Acceso a la base de datos
require INCLUDES_DIRNAME.'/settings.php'; //Datos de la tabla page_settings
require INCLUDES_DIRNAME.'/functions.php'; //Funciones de uso general

//Wake up Neo...
require CORE_DIRNAME.'/init.php';  
?>