<?php session_start();

if(!isset($_SESSION['CORE'])){die("-1");}
if(!isset($_POST['t_n'])){die("-2");}
if(!isset($_POST['columns'])){die("-3");}


$table_name = $_POST['t_n'];

if(file_exists($_SESSION['CORE'].$table_name.".php")){
	
	require_once($_SESSION['CORE'].$table_name.".php");
	$ob = new $table_name();
	
	foreach($_POST["columns"] as $k=>$v){
		$_POST["columns"][$k] = addslashes ($v);
	}	
	
	if (isset($_POST["columns"]["is_default"])){
		if( $_POST["columns"]["is_default"] == 1 ){
			$dt = $ob->fetchAll();
			foreach($dt as $k=>$v){
				$ob->save(array("id"=>$v["id"],"is_default"=>0),null);
			}
		}		
	}
	

	/*
	$data = array(
		"produit_category"	=>	$_POST["data"]["columns"]["produit_category"],
		"is_default"	=>	$_POST["data"]["columns"]["is_default"]
	);
	
	if( isset($_POST["data"]["columns"]["id"]) ){
		$data["id"] = $_POST["data"]["columns"]["id"];
	}	
	*/
	$ob->save($_POST["columns"]);
	echo "1";
	

}else{
	echo "File not exists : " . $_SESSION['CORE'].$table_name.".php";
}


