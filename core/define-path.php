<?php 
//Define Path
$base_domain = $_SERVER['HTTP_HOST'];  
$base_uri = "//" . $base_domain . $_SERVER['PHP_SELF'];
$base_path_info = pathinfo($base_uri);
//As variables
$domain_name = $base_domain;
$base_href = $base_path_info['dirname']."/";
$current_url = "//".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
//As constants
define("DOMAIN_NAME", $base_domain);
define("BASE_HREF", $base_href);
define("CURRENT_URL", $current_url);
?>