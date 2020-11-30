<?php
session_start();

unset($_SESSION["ERRORS"]);

$D_S = DIRECTORY_SEPARATOR;
$path_to_config_file = "app".$D_S."Core".$D_S."Helpers".$D_S."Config.php";
if(file_exists($path_to_config_file)){
	require_once($path_to_config_file);
	$config = new Config;
	$envirenment = $config->get()["GENERAL"]["ENVIRENMENT"];
	$config->bootstrap(realpath(dirname(__FILE__)));
	
	
}else{
	die("ERROR! : Config file not found!" );
}

$errors = (isset($_SESSION["ERRORS"]))? $_SESSION["ERRORS"]:array();

$url =array();
$lang = "fr";	// 	es | ar | fr | en
$dir = "ltr";	//	ltr | rtl | auto




if (count($errors)>0){
	
	if(isset($errors["FILE_NOT_EXISTS"])){
		
		$page_title = "FILE NOT FOUND - " . $errors["FILE_NOT_EXISTS"];
		define('APP_TEMPLATE',"errors");
		$page = "404";
		
	}elseif(isset($errors["DB_CONNECT"])){
		
		$page_title = "DB ERRORS";
		define('APP_TEMPLATE',"errors");
		$page = "db_error";
		
	}elseif(isset($errors["USER"])){
		$page_title = $envirenment . " : Log In";
		define('APP_TEMPLATE',"login");
		$page = "index";
		
	}

}else{
	
	
	
	if(isset($_GET['url'])){
		
		$url = explode("/",rtrim($_GET['url'], '/'));

		require_once(CORE."Template.php");
		$templates = $template->find('all',array('conditions'=>array('status='=>1)),null);
		
		// Define wether lang parameter is set in Session
		
		if(isset($_SESSION["params"]["lang"])){
			
			$page_title = $_SESSION["params"]["lang"]["title"];
			$lang = $_SESSION["params"]["lang"]["lang"];
			$dir = $_SESSION["params"]["lang"]["dir"];
			
			$page = $url[0];
			
		}else{
			
			$page_title = $templates[0]["template_title"];
			$lang = $templates[0]["template_lang"];
			$dir = $templates[0]["template_direction"];
			
			$page = $url[0];
		}

		
		if(!file_exists(APP_PAGES.$templates[0]["template_name"].DIRECTORY_SEPARATOR.$page.'.php')){
			$page_title = "404 - Page not found";
			define('APP_TEMPLATE',"errors");
			$page = "404";
		}else{
			define('APP_TEMPLATE',$templates[0]["template_name"]);
		}	

	}else{
		if(file_exists(CORE."Template.php")){
			
			require_once(CORE."Template.php");
			$templates = $template->find(null,array('conditions'=>array('status='=>1)),null);
			//var_dump($templates);
			if(isset($_SESSION["params"]["lang"])){

				$page_title = $_SESSION["params"]["lang"]["title"];
				$lang = $_SESSION["params"]["lang"]["lang"];
				$dir = $_SESSION["params"]["lang"]["dir"];	
				
				$page = $templates[0]["start_page"];
				
			}else{

				$page_title = $templates[0]["template_title"];
				$lang = $templates[0]["template_lang"];	
				$dir = $templates[0]["template_direction"];	
				
				$page = $templates[0]["start_page"];
			}
			
			define('APP_TEMPLATE',$templates[0]["template_name"]);
			
			
		}else{
			
			$page_title = "404 - Page not found";
			define('APP_TEMPLATE',"errors");
			$page = "404";
			
		}
	}
	
}

/*
 *---------------------------------------------------------------
 * SETUP TEMPLATE
 *---------------------------------------------------------------
 *
 */

define('APP_TEMPLATE_PATH','templates'.$D_S.APP_TEMPLATE.$D_S);

if(APP_TEMPLATE !== "errors" and APP_TEMPLATE !== "login"){
	require_once(GLOBAL_TEMPLATE_PATH.'header.php');
}

require_once(APP_TEMPLATE_PATH . 'header.php');
require_once(APP_PAGES.APP_TEMPLATE.$D_S.$page.'.php');
require_once(APP_TEMPLATE_PATH . 'footer.php');

if(APP_TEMPLATE !== "errors" and APP_TEMPLATE !== "login"){
	
	require_once(GLOBAL_TEMPLATE_PATH.'footer.php');
}

?>