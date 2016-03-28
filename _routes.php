<?php 
//Load Homepage
if( is_homepage() ){ 
	view('home.php');
}

//Load Other pages
if( match_url('about-us') ){
	view('about.php');
}

if( match_url('our-services') ){
	view('services.php');
}

if( match_url('test') ){
	view('prueba.php');
}

if( match_url('post/{slug|s}/{id|i}') ){
	view('post.php');
}

/**
* =====================================================================
* ERROR 404
* Do not remove anything below this line, keep this code at bottom.
* =====================================================================
*/
file_exists('404.php') ? include '404.php' : include $includes_dirname.'/defaults/errors/404.php';
?>