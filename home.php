<h1>Home</h1>
<p>Todo es de alcance global, revisa el contenido de este archivo.</p>

<?php echo trans('Hola','Hello',$_SESSION['lang']); ?><br>

<?php echo slug("Generando un slug con las funciones globales"); ?><br>

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