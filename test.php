<?php
require 'wx-includes/db.php'; //Permite usar querys a la db
require 'wx-includes/functions.php'; //Permite usar las funciones generales
require 'wx-includes/settings.php'; //Permite usar datos de la tabla page_settings con $settings['']; 
?>
<?php echo $settings['company_name']; ?>