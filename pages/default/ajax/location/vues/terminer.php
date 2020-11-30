<?php session_start() ;
if(!isset($_SESSION["STATICS"], $_SESSION["CORE"])) die("-1");

$statics = $_SESSION["STATICS"];
$core = $_SESSION["CORE"];	
$id_location = isset($_POST["id_location"])? $_POST["id_location"]: 0;

require_once($core."Location.php");
$data = $location->find("", array("conditions"=>array("id="=>$id_location)), "v_location");
if(count($data) === 0) die("-2");

$data = $data[0];

$today = date("Y-m-d");
$date_fin = $data["date_fin"];

if($today >= $date_fin){
	
	require_once($core."Helpers/Config.php");
	$config = new Config;
	$env = $config->get()["GENERAL"]["ENVIRENMENT"];
	$created = date("Y-m-d H:i:s");
	$created_by = $_SESSION[$env]["USER"]["id"];
	
	$data = array(
		'created'				=>	$created,
		'created_by'			=>	$created_by,
		'id_location_status'	=>	3,
		'id_location'			=>	$id_location
	);
	echo "Ok c est bon!";
	$location->save($data, 'status_of_location');
}else{
	echo "Non date fin n est pas encore arrivée";
}


/*
var_dump($data);
*/
?>