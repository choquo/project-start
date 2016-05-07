<?php 
/**
* Define charset for plain-text outputs
* This doesn't have nothing to do with database utf, the database utf is set in admin/classes/DatabaseClass.php
*/
header('Content-Type: text/html; charset=utf-8');

//Define configuration vars
require '_config.php';

//Wake up Neo...
require CORE_DIRNAME.'/init.php';  
?>