<?php
//To access to database just use global $database this uses the index.php instance of database
global $database;
require 'wx-includes/functions.php'; //Permite usar las funciones generales
require 'wx-includes/settings.php'; //Permite usar datos de la tabla page_settings con $settings['']; 
?>
<?php echo $settings['company_name']; ?>