<?php session_start();

if(!isset($_SESSION['CORE'])){die();}
if(!isset($_POST['data'])){die();}


$table_name = $_POST['data']['t_n'];
$core = $_SESSION['CORE'];

if(file_exists($core.$table_name.".php")){
	require_once($core.$table_name.".php");
	$ob = new $table_name();
	
	$args = array(
		"p_p"				=>	(isset($_POST['data']['p_p']))? $_POST['data']['p_p'] : null,
		"sort_by"			=>	(isset($_POST['data']['sort_by']))? $_POST['data']['sort_by'] : "date_caisse DESC",
		"current"			=>	(isset($_POST['data']['current']))? $_POST['data']['current'] : null,
		"style"				=>	(isset($_POST['data']['style']))? $_POST['data']['style'] : "list",
		"column_name"		=>	"v_location"
	);

	unset($_SESSION["REQUEST"]);	
	$_SESSION["REQUEST"] = array(
		$table_name	=> array(
								"args"	=>	$args
							)
	);
	$request =  isset($_POST['data']['request'])? strtolower($_POST['data']['request']):"";
	
	$conditions = array();
	
	if(isset($_POST['data']['filter'])){
		foreach($_POST['data']['filter'] as $k=>$v){
			if($k === "marque") {
				$conditions["id_vehicule_marque = "] = $v; 
			}
			if($k === "location_status") {
				$conditions["last_location_status = "] = $v; 
			}
		}
	}
	
	if($request !== ""){
		$conditions["LOWER(name) like "] = $request ; 
	}
	
	if(count($conditions)>1){
		$conditions = array("conditions AND"=>$conditions);
	}else{
		$conditions = array("conditions"=>$conditions);
	}

	echo $ob->drawTable($args,$conditions, "v_caisse_mouvement");

}else{
	echo -1;
}