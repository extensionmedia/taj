<?php session_start();

if(!isset($_SESSION['CORE'])){die("-1");}
if(!isset($_POST['t_n'])){die("-2");}
if(!isset($_POST['columns'])){die("-3");}

/*
var_dump($_POST['columns']);
die();
*/

$table_name = $_POST['t_n'];
$array_temp = array();

if(file_exists($_SESSION['CORE'].$table_name.".php")){
	
	require_once($_SESSION['CORE'].$table_name.".php");
	require_once($_SESSION['CORE']."Helpers/Config.php");
	require_once($_SESSION['CORE']."Person_Activity.php");
	$config = new Config;
	$env = $config->get()["GENERAL"]["ENVIRENMENT"];
	
	
	$ob = new $table_name();
	
	foreach($_POST["columns"] as $k=>$v){
		if(!is_array($v)){
			$_POST["columns"][$k] = addslashes ($v);
			
		}else{
			$array_temp = $_POST["columns"][$k];
			unset($_POST["columns"][$k]);
		}
		
	}	
	
	$ob->save($_POST["columns"]);
	
	$lastID = 0;
	
	if( isset($_POST["columns"]["id"]) ){
		$mgs = $ob->find(null,array("conditions"=>array("id_produit="=>$_POST["columns"]["id"])),"produit_of_magasin");
		$mgs = (is_null($mgs))? array():$mgs;
		foreach($mgs as $kk=>$vv){
			$ob->delete($vv["id"], "produit_of_magasin");
		}	
		
		$lastID = $_POST["columns"]["id"];
		
		// Track Edeting
		
		$person_activity->saveActivity("fr",$_SESSION[$env]["USER"]["id"],array("Produit","0"),$lastID, $_POST["columns"]["code"]);
		
	}else{
		$lastID = $ob->getLastID();
		
		// Track Edeting
		
		$person_activity->saveActivity("fr",$_SESSION[$env]["USER"]["id"],array("Produit","1"),$lastID, $_POST["columns"]["code"]);
		
	}
	
	// propriete options
	if(isset($array_temp)){
		for( $i = 0; $i < count($array_temp); $i++){
			$ob->save(array("id_produit"=>$lastID, "id_magasin"=>$array_temp[$i]), "produit_of_magasin");
		}

	}
	
	echo "1";
	

}else{
	echo "File not exists : " . $_SESSION['CORE'].$table_name.".php";
}


