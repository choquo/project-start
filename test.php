<?php
//To access to database just use global $database this uses the index.php instance of database
global $database;
require 'includes/functions.php'; //Permite usar las funciones generales
require 'includes/settings.php'; //Permite usar datos de la tabla page_settings con $settings['']; 
?>
<?php echo $settings['company_name']; ?>