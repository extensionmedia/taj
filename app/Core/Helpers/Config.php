<?php

date_default_timezone_set('Africa/Casablanca');
require_once('Utils.php');

class Config{

	private $config = array(); // Loaded from Config/config.json
	
	public function __construct($config_file_name=null){
		
		try{
			if($config_file_name === null)
				$config_json_file = realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR."Config".DIRECTORY_SEPARATOR."config.json";
			else
				$config_json_file = realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR."Config".DIRECTORY_SEPARATOR.$config_file_name.".json";

			if(file_exists($config_json_file)){
				$content = file_get_contents($config_json_file);
				$this->config = json_decode(file_get_contents($config_json_file), true);	
			}
			
		}catch(Exception $e){
			die($e->getMessage());
		}
	}
	
	public function get(){	return $this->config;	}
	
	public function bootstrap($__FILE__ = null){
		
		$D_S = DIRECTORY_SEPARATOR;

		if($this->getEnv() == "DEV"){
			error_reporting(E_ALL);
			$STATICS = $this->get()["GENERAL"]["HOST_DEV"].'../statics/';
			define('HOST',$this->get()["GENERAL"]["HOST_DEV"]);
			define('HTTP',"http://");


		} else{
			error_reporting(E_ALL);
			$STATICS = "statics." . $this->get()["GENERAL"]["DOMAIN"]."/";

			define('HOST',$this->get()["GENERAL"]["HOST_PROD"]);
			if( isset($_SERVER['HTTPS'] ) ) {
				define('HTTP',"https://");
			}else{
				define('HTTP',"http://");
			}
		}
		//foreach($_SESSION as $k=>$v){	unset($_SESSION[$k]);	}
		define('ROOT', $D_S);
		define('APP', 'app'.$D_S);

		define('CORE', APP.'Core'.$D_S);
		define('APP_PAGES','pages'.$D_S);

		define('GLOBAL_TEMPLATE_PATH','templates'.'/global/');

		define('UPLOAD_FOLDER','files'.$D_S.'upload'.$D_S);
		define('DOWNLOAD_FOLDER','files'.$D_S.'download'.$D_S);
		
		/*
			*************
			Uncomment this section when you are using the login section

			*************
		*/
		if(!isset($_SESSION[$this->get()["GENERAL"]["ENVIRENMENT"]]["USER"])){
			$_SESSION["ERRORS"]["USER"] = "unknown";
		}
		
		if(!file_exists(CORE."Helpers".$D_S."Modal.php")){
			$_SESSION["ERRORS"]["FILE_NOT_EXISTS"] = CORE."Helpers".$D_S."Modal.php";

		}else{
			require_once(CORE."Helpers".$D_S."Modal.php");
			$modal = new Modal;
			if (!$modal->isConnected){
				$_SESSION["ERRORS"]["DB_CONNECT"] = $modal->err;
			}else{
				$_SESSION["HOST"] = HOST;
				$_SESSION["CORE"] = $__FILE__.$D_S.CORE;

				$_SESSION["UPLOAD_FOLDER"] = $__FILE__.$D_S."..".$D_S."statics".$D_S;

				$_SESSION["STATICS"] = HTTP . $STATICS;				
			}
		}
		//var_dump($_SESSION);

	}
	
	public function getEnv() {
		if($this->getIP() == "::1" || $this->getIP() == "127.0.0.1"){
			return "DEV";
		}else{
			return "PROD";
		}
	}
	
	public function getIP() {
		$ipaddress = '';
		if (isset($_SERVER['HTTP_CLIENT_IP']))
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_X_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if(isset($_SERVER['REMOTE_ADDR']))
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else
			$ipaddress = 'UNKNOWN';
		return $ipaddress;
	}	

	public function ListView($name = null){
		$returned = array("empty");
		$string = "";
		if(file_exists(realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR."lists".DIRECTORY_SEPARATOR.$name.".json"))
			$string = file_get_contents(realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR."lists".DIRECTORY_SEPARATOR.$name.".json");
		
		$returned = json_decode($string, true);
		return $returned;
	}
}

