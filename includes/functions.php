<?php 
@session_start();

//Idioma a usar (default español si no hay ninguno seleccionado)
//Declara la variable $lang con un valor especifico para determinar el idioma actual
if($_SESSION['lang']==''){ $_SESSION['lang']='es'; $lang='es'; }else{ $lang=$_SESSION['lang']; }

/*============================
┌─┐┌─┐┌┬┐   ┌─┐┌─┐┌─┐┬─┐┌┬┐┌─┐
│ ┬├┤  │    │  │ ││ │├┬┘ ││└─┐
└─┘└─┘ ┴────└─┘└─┘└─┘┴└──┴┘└─┘
*/
//OBTENER COORDENADAS DE UN LINK DE GOOGLE MAPS
//https://www.google.com.mx/maps/@20.9817112,-89.6152666,15z?hl=es  ->  20.9817112,-89.6152666
//Tambien se podría extraer el zoom pero hay que modificar el script
//Puede recibir una url un ifram o solo las coordenadas y devuelve siempre las coordenadas de la url
function get_coords($url){
    $url = trim($url); //Eliminar espacios al inicio o final
    //Iframe
	//Detectar si ya viene con un iframe no hacer nada solo devolver solo el mapa con su iframe
	preg_match("/iframe/", $url, $iframe);
	if(count($iframe)>=1){
		$is_iframe = true;
		$coords  = $url;

	}else{
			//URL
			//con el formato http://maps.google.com/maps/@4324,-34324,23z/?adasd=asdas etc. tipo URL
			preg_match("/@(.*)?z/", $url, $tipo_url);
			preg_match("/http/", $url, $have_http);
			if($tipo_url[1]!='' && count($have_http)>=1){
				$coordenadas = explode(",", $tipo_url[1]);
				$coords =  $coordenadas[0].','.$coordenadas[1];
				$is_url=true;
			}	
	}
	//SIMPLES CORRDENADAS 390284932,-234234324
	if(!$is_iframe && !$is_url && $url!=''){
		$coords = $url;
	}
	return $coords;
}


/*========================================================
┌─┐┌─┐┌┬┐   ┌┬┐┌─┐┌─┐  ┬  ┌─┐┌┬┐  ┬  ┌─┐┌┐┌   ┌─┐┌─┐┌─┐┌┬┐
│ ┬├┤  │    │││├─┤├─┘  │  ├─┤ │   │  │ ││││   ┌─┘│ ││ ││││
└─┘└─┘ ┴────┴ ┴┴ ┴┴    ┴─┘┴ ┴ ┴┘  ┴─┘└─┘┘└┘┘  └─┘└─┘└─┘┴ ┴
To get map data from CMS in many flavors, only lat, only lon, only zoom, lat and lon.
*/
function get_map_lat_lon($string){
    $map_data = explode("|",$string);
	return $map_data[0];
}
function get_map_lat($string){
	$map_data = explode("|",$string);
	$map_latlon = explode(",",$map_data[0]);
	return $map_latlon[0];
}
function get_map_lon($string){
	$map_data = explode("|",$string);
	$map_latlon = explode(",",$map_data[0]);
	return $map_latlon[1];
}
function get_map_zoom($string){
	$map_data = explode("|",$string);
	return $map_data[1];
}



/*==============================
┌─┐┌┬┐┌┐ ┌─┐┌┬┐   ┬  ┬┬┌┬┐┌─┐┌─┐
├┤ │││├┴┐├┤  ││   └┐┌┘│ ││├┤ │ │
└─┘┴ ┴└─┘└─┘─┴┘────└┘ ┴─┴┘└─┘└─┘
*/
//GET EMBED VIDEO (youtube & vimeo)
//Devuelve el iframe de un video cualquiera que sea la estructura recibida, solo la url o un iframe como tal
function embed_video($video){
    //Detectar si ya viene con un iframe no hacer nada solo devolver el video
	preg_match("/iframe/", $video, $video_detect);
    if(count($video_detect)>=1){
    	return $video;
    }else{
    	//Youtube
    	preg_match("/youtube/", $video, $youtube);
    	if( count($youtube)>=1 ){ 
			$step1=explode('v=', $video);
			$step2 =explode('&',$step1[1]);
			$vedio_id = $step2[0];
			return '<iframe width="320" height="240" src="http://www.youtube.com/embed/'. $vedio_id.'" frameborder="0"></iframe>';
		}
		//Vimeo
		preg_match("/vimeo/", $video, $vimeo);
		if( count($vimeo)>=1 ){ 
			$vedio_id = str_replace('http://vimeo.com/','',$video); //http
			$vedio_id = str_replace('https://vimeo.com/','',$video); //https
			return '<iframe width="320" height="240" src="https://player.vimeo.com/video/'.$vedio_id.'" webkitallowfullscreen="webkitallowfullscreen" mozallowfullscreen="mozallowfullscreen" allowfullscreen="allowfullscreen" frameborder="0"></iframe>';
		}
    }
}



/*=============
┌┬┐┬─┐┌─┐┌┐┌┌─┐
 │ ├┬┘├─┤│││└─┐
 ┴ ┴└─┴ ┴┘└┘└─┘
*/
//IDIOMA
//Funcion para traducir
function trans($es, $en, $lang_choosed){
    //ES (spanish default)
    if($lang_choosed == 'es' or $lang_choosed == ''){
        return stripslashes($es);
    }
    //EN (english)
    if($lang_choosed == 'en'){
        return stripslashes($en);
    }    
}


/*==========
┌─┐┬  ┬ ┬┌─┐
└─┐│  │ ││ ┬
└─┘┴─┘└─┘└─┘
*/
//SLUG
//Genera un slug de una cadena por ejemplo: La piña es una fruta = la-pina-es-una-fruta
setlocale(LC_ALL, 'en_US.UTF8');
function slug($str, $replace=array(), $delimiter='-') {
    $str = trim($str);
	if( !empty($replace) ) {
		$str = str_replace((array)$replace, ' ', $str);
	}
	$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
	$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
	$clean = strtolower(trim($clean, '-'));
	$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
	return $clean;
}


/*==========
┌┐┌┌─┐┌┐ ┬─┐
││││ │├┴┐├┬┘
┘└┘└─┘└─┘┴└─
*/
//ELIMINAR BR DE INICIO Y FIN DE STRING
function nobr($string){
	return preg_replace('/^(?:<br\s*\/?>\s*)/', '', $string);
}


/*===============
┌┬┐┌─┐┬  ┬┬┌─┐┌─┐
 ││├┤ └┐┌┘││  ├┤ 
─┴┘└─┘ └┘ ┴└─┘└─┘
*/
//IDENTIFICAR DISPOSITIVO
$dispositivo = strtolower($_SERVER['HTTP_USER_AGENT']);
if(stripos($dispositivo,'ipad')){
    $tablet = true;
    $ipad = true;
}else if(stripos($dispositivo,'iphone') or ( stripos($dispositivo,'android') && stripos($dispositivo,'mobile') ) ){
    $mobile = true;
    $telefono = true;
    $iphone = true;
    $android = true;
}else{
    $pc = true;
}
//FORZAR CUANDO SE TRABAJA EN LOCAL
//$telefono = false;
//$tablet = true;
//$pc = false;



/*======================
┌─┐┌─┐┌┬┐   ┌┬┐┌─┐┌┬┐┌─┐
│ ┬├┤  │     ││├─┤ │ ├┤ 
└─┘└─┘ ┴─────┴┘┴ ┴ ┴ └─┘
*/
//CONVERTIR UNA FECHA A FORMATO EN ESPAÑOL
function get_date($fecha){
	$nd = explode(" ",$fecha); //Recibe 0000-00-00 00:00:00
	switch (date('w', strtotime( $nd[0] ))){ //Formato 0000-00-00
	    case 0: $nombredia = "Domingo"; break;
	    case 1: $nombredia = "Lunes"; break;
	    case 2: $nombredia = "Martes"; break;
	    case 3: $nombredia = "Miercoles"; break;
	    case 4: $nombredia = "Jueves"; break;
	    case 5: $nombredia = "Viernes"; break;
	    case 6: $nombredia = "Sábado"; break;
	}
	$ddate = date_create( $fecha ); 
	$array_meses_ingles = array('January','February','March','April','May','June','July','August','September','October','November','December');
	$array_meses_spanish = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
	$fecha_return = str_replace($array_meses_ingles, $array_meses_spanish, date_format($ddate, 'd  \d\e  F \d\e  Y') );
	return $nombredia.' '.$fecha_return;
}


/*=======================================
┌─┐┬  ┬┌─┐┌─┐       ┌─┐┌─┐┌─┐┬─┐┌┬┐┌─┐┬─┐
└─┐│  ││  ├┤   ───  ├─┤│  │ │├┬┘ │ ├─┤├┬┘
└─┘┴─┘┴└─┘└─┘       ┴ ┴└─┘└─┘┴└─ ┴ ┴ ┴┴└─
*/
//RECORDAR UNA CADENA PONER SUSPENSIVOS EN DETERMINADA CANTIDAD DE TEXTO
function slice($cadena, $limite, $corte=" ", $pad="...") {
    //devuelve la cadena sin cambios si la palabra es mas corta que el limite
    if(strlen($cadena) <= $limite)
        return $cadena;
    // is $break present between $limit and the end of the string? 
    if(false !== ($breakpoint = strpos($cadena, $corte, $limite))) {
        if($breakpoint < strlen($cadena) - 1) {
            $cadena = substr($cadena, 0, $breakpoint) . $pad;
        }
    }
    return $cadena;
    //acortar($str, 21, " ", "...")
}


/*====================
┌─┐─┐ ┬┌─┐┌─┐┬─┐┌─┐┌┬┐
├┤ ┌┴┬┘│  ├┤ ├┬┘├─┘ │ 
└─┘┴ └─└─┘└─┘┴└─┴   ┴ 
*/
//OBTENER RESUMEN DE PUBLICACION A PARTIR DE RECORTAR UNA CADENA DONDE APAREZCA EL PRIMER <-- pagebreak -->
function get_excerpt($string){
    if( preg_match("/<!-- pagebreak -->/",$string,$output) ){
		$excerpt_return = explode("<!-- pagebreak -->",stripslashes( $string ));
		return $excerpt_return[0];
	}else{
		return slice($string,420, ' ', '');
	}
}


/*=========================
┬┌┐┌ ┬┌─┐┌─┐┌┬┐┌─┐┌┐ ┬  ┌─┐
││││ │├┤ │   │ ├─┤├┴┐│  ├┤ 
┴┘└┘└┘└─┘└─┘ ┴ ┴ ┴└─┘┴─┘└─┘
*/
function injectable($string){
    //Prevent SQL injection by REGEXP
	//All characters are permited except "spaces, quotes of any type, and reserved words of SQL Queries"
	//The "<script>" validation is for XSS Cross Site Scripting
	if( preg_match("/script>|<\/script>|\s|`|´|'|\"|\sAND|\sOR|\sDROP|\sTRUNCATE|\sDELETE|\sINSERT|\sSELECT|\sUNION|AND\s|OR\s|DROP\s|TRUNCATE\s|DELETE\s|INSERT\s|SELECT\s|UNION\s|GROUP_CONCAT|INFORMATION_SCHEMA|TABLE_SCHEMA/i", $string, $output_array) ){
		return true;
	}
}


/*==============
┌─┐┌─┐┌┬┐   ┬┌─┐
│ ┬├┤  │    │├─┘
└─┘└─┘ ┴────┴┴  
*/
// Function to get the client IP address
//http://stackoverflow.com/questions/15699101/get-the-client-ip-address-using-php
function get_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}


/*================================================================================================
┌─┐┌─┐┌─┐   ┌┬┐┬┌┬┐┬  ┌─┐       ┌─┐┌─┐┌─┐    ┌┬┐┌─┐┌─┐┌─┐┬─┐┬┌─┐┌┬┐┬┌─┐┌┐┌
└─┐├┤ │ │    │ │ │ │  ├┤   ───  └─┐├┤ │ │     ││├┤ └─┐│  ├┬┘│├─┘ │ ││ ││││
└─┘└─┘└─┘────┴ ┴ ┴ ┴─┘└─┘       └─┘└─┘└─┘─────┴┘└─┘└─┘└─┘┴└─┴┴   ┴ ┴└─┘┘└┘
*/
function get_title($default_title="", $seo_title=""){
    if( $default_title!='' ){
        $response = strip_tags(stripslashes( $default_title ));
	}
	if( $seo_title!=''){
		$response = strip_tags(stripslashes( $seo_title ));
	}
	return $response;
}

function get_description($default_description="",$seo_description=""){
	if( $default_description!='' ){
		$response = htmlspecialchars(strip_tags(stripslashes($default_description)));
	}
	if( $seo_description!=''){
		$response = htmlspecialchars(strip_tags(stripslashes($seo_description)));
	}
	return substr($response,0,250);
}



/*================================================================================================
┌─┐┌─┐┌┬┐     ┬┌┬┐┌─┐┌─┐┌─┐┌─┐
│ ┬├┤  │      ││││├─┤│ ┬├┤ └─┐
└─┘└─┘ ┴ ─── ─┴┴ ┴┴ ┴└─┘└─┘└─┘
Obtener las imagenes y datos de un campo con multiples imagenes
Recibe un string con formato imagen.jpg¬texto linea 01 [enter] texto linea 02 | imagen.jpg....
Devuelve un array con el nombre de la imagen, y los datos del campo de texto por linea en caso de tenerlos, sino, solo devuelve el nombre de la imagen y los rows vacíos
De este modo el campo de texto adjunto puede usarse o no, y se pueden usar los textos de cada línea de forma individual
*/
function get_images($string){

    $images = explode("|",$string);
	foreach ($images as $im) {
		$slide_image = explode("¬",$im);
		$slide_data = explode(PHP_EOL, $slide_image[1]);

		//Store results
		$image = $slide_image[0];//<---- Image
		$row01 = $slide_data[0];
		$row02 = $slide_data[1];
		$row03 = $slide_data[2];
		$row04 = $slide_data[3];
		$row05 = $slide_data[4];

		$array_return[] = array("image"=>$image, "row01"=>$row01, "row02"=>$row02, "row03"=>$row03, "row04"=>$row04, "row05"=>$row05);
	}
	return $array_return;

}

/*================================================================================================
┌─┐┌─┐┌┬┐   ┌─┐─┐ ┬┌─┐┬  ┌─┐┌┬┐┌─┐
│ ┬├┤  │    ├┤ ┌┴┬┘├─┘│  │ │ ││├┤ 
└─┘└─┘ ┴────└─┘┴ └─┴  ┴─┘└─┘─┴┘└─┘
Obtener un array mediante la funcion explode, ejemplo:
De una lista de emails: 'email@dom.com, correo@dom.com'
Solo mostrar el primero con echo get_explode($datos['emails'],',')[0];
Devuelve: 'email@dom.com';
Esta funcion es muy util cuando se quiere obtener un array de una lista dividida con cualquier separador , |, etc
*/
function get_explode($string, $separator){
    $explode_string = explode("$separator", $string);
	return $explode_string;
}

?>