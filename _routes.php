<?php 
//Load Homepage
if( is_homepage() ){ 
	include 'home.php';  
	exit; }

//Load Other pages
if( match_url('about-us') ){
	include 'about.php';
	exit; }

if( match_url('our-services') ){
	include 'services.php';
	exit; }

if( match_url('post/{slug|s}/{id|i}') ){
	include 'post.php';
	exit; }

/**
* =====================================================================
* ERROR 404
* Do not remove anything below this line, keep this code at bottom.
* =====================================================================
*/
file_exists('404.php') ? include '404.php' : include $includes_dirname.'/defaults/errors/404.php';
?>