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
$data = $ob->find(null, $cond, "v_location");

if( count($data) > 0 ){	
	
	
	// Remove status of location
	foreach( $ob->find("", array("conditions"=>array("id_location="=>$id)), "status_of_location") as $k=>$v){
		$ob->delete($v["id"], "status_of_location");
	}
	// Remove location detail
	foreach( $ob->find("", array("conditions"=>array("id_location="=>$id)), "location_detail") as $k=>$v){
		$ob->delete($v["id"], "location_detail");
	}
	// Remove paiement
	foreach( $ob->find("", array("conditions AND"=>array("source="=>"location", "id_source="=>$id)), "caisse_mouvement") as $k=>$v){
		$ob->delete($v["id"], "caisse_mouvement");
	}
	// Remove location
	
	echo $ob->delete($_POST["id"]);
	
	// Save tracking
	
	$person_activity->saveActivity("fr",$_SESSION[$env]["USER"]["id"],array("Location","-1"),$_POST["id"], $data[0]["location_status"]);
	
}else{
	
}

