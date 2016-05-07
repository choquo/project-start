<?php 
$_config = false;
require '_config.php';

//Load core files
require CORE_DIRNAME.'/define-path.php';
require CORE_DIRNAME.'/functions-built-in.php';

//Defaults
//Put your database user and password into admin/conex.php
$install_dirname 	= dirname($_SERVER['PHP_SELF']); //The dirname where app is running, this facilitate the change of the website folder without headaches, just move to another folder and your website will be ready automatically.

//Prepare routes (url_params are required by is_hompage() function )
$requested_url_params = array();
$requested_url = str_replace($install_dirname, '', $_SERVER['REQUEST_URI']); //Remove install dirname to get the real requested url: domain-name-com/[this] or domain-name-com/installdirname/[this]
$requested_url = '/'.ltrim($requested_url,'/'); //Fix to work on localhost and online routes (remove /// and leave only one slash / )
$requested_url_params = array_merge(array_filter(explode('/',$requested_url)));

//Load content
require '_routes.php';
?>