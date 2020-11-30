<?php session_start();

$response  = array("code"=>0, "msg"=>"Error");


if(!isset($_SESSION['CORE'])){die(json_encode($response));}
if(!isset($_POST['module'])){$response["msg"]="Error Data"; die(json_encode($response));}



$core = $_SESSION['CORE'];

$module = $_POST["module"];
switch ($module){
	
	case "first_step":
		
		if(isset($_POST["data"])){
			require_once($core."Location.php");
			$envirenment = $location->config->get()["GENERAL"]["ENVIRENMENT"];
			if(isset($_SESSION[$envirenment]["first_step"])) unset($_SESSION[$envirenment]["first_step"]);
			
			$_SESSION[$envirenment]["first_step"] = $_POST["data"];
			$response  = array("code"=>1, "msg"=>"Selected");
		}else{
			$response  = array("code"=>0, "msg"=>"Error Data!");
		}

	break;
		
	case "get_first_step":
		
		require_once($core."Location.php");
		$envirenment = $location->config->get()["GENERAL"]["ENVIRENMENT"];
		
		if(isset($_POST["data"])){
			
			if(isset($_SESSION[$envirenment]["first_step"])) unset($_SESSION[$envirenment]["first_step"]);
			
			$_SESSION[$envirenment]["first_step"] = $_POST["data"];
			$response  = array("code"=>1, "msg"=>"Selected");
		}else{
			$response  = array("code"=>0, "msg"=>"Error Data!");
		}

	break;
	
	case "edit_produit_prix_location":
		require_once($core."Location.php");
		$envirenment = $location->config->get()["GENERAL"]["ENVIRENMENT"];
		$UID = isset($_POST["UID"])? $_POST["UID"]: "";
		$id_produit = isset($_POST["id_produit"])? $_POST["id_produit"]: "";
		$prix_location = isset($_POST["prix_location"])? $_POST["prix_location"]: 0;
		
		$data =  isset($_SESSION[$envirenment]["LOCATION"][$UID])? $_SESSION[$envirenment]["LOCATION"][$UID]: array();
		foreach($data as $k=>$v){
			if($v["id"] === $id_produit){
				$_SESSION[$envirenment]["LOCATION"][$UID][$k]["prix_location"] = $prix_location;
			}
		}
		$response  = array("code"=>1, "msg"=>"changed");
		
}
/*
echo $response["msg"];
die();
*/
echo json_encode($response);
