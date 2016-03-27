<?php 
$config = true;
/**
* Define charset for plain-text outputs
* This doesn't have nothing to do with database utf, the database utf is set in admin/classes/DatabaseClass.php
*/
header('Content-Type: text/html; charset=utf-8');


/**
* Set variables to use globally
*/
$admin_dirname		= 'admin';
$core_dirname 		= 'wx-core';
$includes_dirname 	= 'wx-includes';
$uploads_url 		= $admin_dirname.'/uploads';
?>