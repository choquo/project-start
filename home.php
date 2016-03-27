<?php 
require 'wx-includes/db.php';
require 'wx-includes/settings.php';
?>

<h1>Home</h1>

<?php echo $base_href; ?>
<br>
<?php echo $uploads_url; ?>
<br>
<?php echo $settings['company_name']; ?>
<br>
<?php echo $current_url; ?>
<br>
<?php echo $domain_name; ?>

<br>
<?php 
	$database->query("SELECT * FROM page_home");
	$chido = $database->getOne();
	echo $chido['seo_title'].' - ';
	echo $chido['seo_description'];
?>