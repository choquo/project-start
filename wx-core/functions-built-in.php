<?php 
/*
================================================================================================
┬─┐┌─┐┬ ┬┌┬┐┌─┐┌─┐  ┌─┐┌┐┌┌┬┐  ┬ ┬┬─┐┬  ┌─┐
├┬┘│ ││ │ │ ├┤ └─┐  ├─┤│││ ││  │ │├┬┘│  └─┐
┴└─└─┘└─┘ ┴ └─┘└─┘  ┴ ┴┘└┘─┴┘  └─┘┴└─┴─┘└─┘
================================================================================================
*/

function match_url($custom_route){
	global $requested_url;

	$original_custom_route = $custom_route;
	/**
	* Prepare regexp
	* remove variable names from url, let only type of data. i.e: {this_a_variable|s}  to only ->  {s}
	* this is for use to compare and match regexp
	* http://www.phpliveregex.com/p/f6g
	*/
	$route_type_data_only = preg_replace("/{[a-zA-Z0-9_-]+\|s}/", "{s}", $custom_route);
	$route_type_data_only = preg_replace("/{[a-zA-Z0-9_-]+\|i}/", "{i}", $route_type_data_only);

	$custom_route = ltrim($route_type_data_only,'/');
	$custom_route = '/'.$custom_route;
	$regexp = str_replace('/','\/', $custom_route);
	$regexp = str_replace('{s}', '.*', $regexp); //string
	$regexp = str_replace('{i}', '[0-9]', $regexp); //integer
	$regexp = '/^'.$regexp.'+$/'; //http://www.phpliveregex.com/p/eHz
	
	if( preg_match($regexp, $requested_url) ){
		//Set $_GET vars from URL only if have parameters in custom_route (when use {})
		if( preg_match('/{/', $custom_route) ){
			set_params($original_custom_route);
		}
		return true;
	}else{
		return false;
	}
}

function set_params($custom_route){
	global $requested_url;	
	$requested_url_clean = ltrim($requested_url,'/');

	$rep_a = array('|s}','|i}','{');
	$rep_b = array('','','');
	$custom_route_vars = str_replace($rep_a, $rep_b, $custom_route);

	//echo '<strong>Vars:</strong><br>'.$custom_route_vars.'<br>';
	//echo '<strong>Values:</strong><br>'.$requested_url_clean.'<br><br>';

	$array_variables = explode('/',$custom_route_vars);
	$array_values = explode('/',$requested_url_clean);

	$params = array_combine($array_variables, $array_values);
	
	//Declare variables and values
	foreach ($params as $key => $value) {
		//echo $key.' = '.$value.'<br>';
		$_GET[$key] = $value;
	}
}

/* Deprecated: possible future inclusion but needs revision
Get and individual parameter from url
function get_param($custom_route){
	global $requested_url;
	$custom_route = ltrim($custom_route,'/');
	$custom_route = '/'.$custom_route;
	$regexp = str_replace('/','\/', $custom_route);
	$regexp = str_replace('{this}', '(.*)', $regexp);
	$regexp = str_replace('{str}', '.*', $regexp);
	$regexp = str_replace('{int}', '[0-9]', $regexp);
	$regexp = '/^'.$regexp.'/'; //http://www.phpliveregex.com/p/eHz
	if( preg_match($regexp, $requested_url, $output) ){
		return $output[1];
	}else{
		return '';
	}
}
*/

//Home page
function is_homepage(){
	global $requested_url_params; //This variable is declared at core/init.php
	if( empty( $requested_url_params ) && is_array( $requested_url_params ) ){
		return true;
	}else{
		return false;
	}
}

?>