<?php 
$_config = true; //For validate !isset($_config) in external includes if var is not present then include this file "_config.php"

/**
* Set variables to use globally
*/
define('ADMIN_DIRNAME', 'admin');
define('CORE_DIRNAME', 'core');
define('INCLUDES_DIRNAME', 'includes');
define('UPLOADS_URL', ADMIN_DIRNAME.'/uploads');

//$admin_dirname		= 'admin';
//$core_dirname 		= 'wx-core';
//$includes_dirname 	= 'wx-includes';
//$uploads_url 		= $admin_dirname.'/uploads';

?>