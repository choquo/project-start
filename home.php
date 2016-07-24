<?php 
//To access to database just use global $database this uses the index.php instance of database
global $database;
require INCLUDES_DIRNAME.'/settings.php'; //Datos de la tabla page_settings
require INCLUDES_DIRNAME.'/functions.php'; //Funciones de uso general
?>

<h1>Home</h1>

<?php echo BASE_HREF; ?>
<br>
<?php echo $settings['company_name']; ?>
<br>
<?php echo CURRENT_URL; ?>
<br>
<?php echo DOMAIN_NAME; ?>
<br>
<?php 
	$database->query("SELECT * FROM page_home");
	$chido = $database->getOne();
	echo $chido['seo_title'].' - ';
	echo $chido['seo_description'];
?>