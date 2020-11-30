<?php session_start();

if(!isset($_SESSION['CORE'])){die("-1");}
if(!isset($_POST['t_n'])){die("-2");}

if(!isset($_POST['columns'])){die("-3");}


$table_name = $_POST['t_n'];

if(file_exists($_SESSION['CORE'].$table_name.".php")){
	
	require_once($_SESSION['CORE'].$table_name.".php");
	$ob = new $table_name();
	require_once($_SESSION['CORE']."Person_Activity.php");

	$envirenment = $ob->config->get()["GENERAL"]["ENVIRENMENT"];
	$now = date("Y-m-d H:i:s");
	$created_by = $_SESSION[$envirenment]["USER"]["id"];
	$data = array(
		"created"			=>	date("Y-m-d H:i:s"),
		"created_by"		=>	$created_by,
		"date_caisse"		=>	$_POST['columns']['date_caisse'],
		"entree"			=>	$_POST['columns']['type'] === "1"? $_POST['columns']['avance']:0,
		"sortie"			=>	$_POST['columns']['type'] === "1"? 0: $_POST['columns']['avance'],
		"source"			=>	'location',
		"id_source"			=>	$_POST['columns']['id_location']
	);
	
	$lastID = 0;
	
	if(isset($_POST["columns"]["id"])){		
		
	}else{

		$ob->save($data);
		$lastID = $ob->getLastID();
		$operation = $_POST['columns']['type'] === "1"? "+" . $ob->format($_POST['columns']['avance']):0;
		$operation = $_POST['columns']['type'] === "0"? "-" . $ob->format($_POST['columns']['avance']):$operation;
			
			
		$person_activity->saveActivity("fr",$created_by,array("Caisse","1"),$lastID, $operation);
		
	}

	echo 1;
	
}else{
	echo "File not exists : " . $_SESSION['CORE'].$table_name.".php";
}
