<?php session_start();

if(!isset($_SESSION['CORE'])){die();}
if(!isset($_POST['data'])){die();}


$table_name = $_POST['data']['t_n'];
$core = $_SESSION['CORE'];

if(file_exists($core.$table_name.".php")){
	require_once($core.$table_name.".php");
	$ob = new $table_name();
	
	$args = array(
		"p_p"			=>	(isset($_POST['data']['p_p']))? $_POST['data']['p_p'] : null,
		"sort_by"		=>	(isset($_POST['data']['sort_by']))? $_POST['data']['sort_by'] : "created DESC",
		"current"		=>	(isset($_POST['data']['current']))? $_POST['data']['current'] : null,
		"column_style"	=>	(isset($_POST['data']['column_style']))? $_POST['data']['column_style'] : "person_activity",
	);
	
	$request =  $_POST['data']['request'];
	
	$conditions = array();
	
	if($request !== ""){$conditions["code like "] = "%".$request."%";}
		
	if(isset($_POST['data']['filter'])){
		foreach($_POST['data']['filter'] as $k=>$v){
			if($k === "urilisateur") $conditions["created_by = "] = $v;
			if($k === "action") $conditions["activity_action = "] = $v;
		}
	}

		if(count($conditions)>1){
		$conditions = array("conditions AND"=>$conditions);	
	}else{
		$conditions = array("conditions"=>$conditions);		
	}	
	
	/*
	var_dump($conditions);
	*/
	
	echo $ob->drawTable($args,$conditions, "person_activity");

}else{
	echo -1;
}