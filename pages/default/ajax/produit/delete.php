<?php session_start(); $core = $_SESSION['CORE']; 

$table_name = $_POST["page"];
require_once($core.$table_name.".php");
require_once($core."Helpers/Config.php");
require_once($core."Person_Activity.php");
$config = new Config;
$env = $config->get()["GENERAL"]["ENVIRENMENT"];

$ob = new $table_name();
$id = $_POST["id"];
$cond = array("conditions" => array("id=" => $id) );
$data = $ob->find(null, $cond, null);
$dS = DIRECTORY_SEPARATOR;
if( count($data) > 0 ){
	
	echo $ob->delete($_POST["id"]);
	
	$person_activity->saveActivity("fr",$_SESSION[$env]["USER"]["id"],array("Produit","-1"),$data[0]["id"], $data[0]["code"]);
	
}else{
	echo -1;
}

