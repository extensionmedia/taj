<?php session_start();

if(!isset($_SESSION['CORE'])){die("-1");}
if(!isset($_POST['t_n'])){die("-2");}
if(!isset($_POST['columns'])){die("-3");}


$table_name = $_POST['t_n'];

if(file_exists($_SESSION['CORE'].$table_name.".php")){
	
	require_once($_SESSION['CORE'].$table_name.".php");
	$ob = new $table_name();
	
	$login = array();
	$data = array();
	
	foreach($_POST["columns"] as $k=>$v){
		
		if($k !== "password"){ $_POST["columns"][$k] = addslashes ($v); }
		
		if($k === "login"){ $login["login"] = $_POST["columns"]["login"];}
		if($k === "password"){$login["password_"] = $_POST["columns"]["password"];}
		
		$data[$k] = $_POST["columns"][$k];
		
	}
	$data["created_by"] = $_SESSION["TAJ-MANAGER"]["USER"]["id"];
	$data["updated"] = date("Y-m-d H:i:s");
	$data["updated_by"] = $_SESSION["TAJ-MANAGER"]["USER"]["id"];
	
	unset($data["login"], $data["password"]);
	
	if(isset($data["id"])){
		unset($data["created_by"]);
		$d = $ob->find("id",array( "conditions"=>array("id_person=" => $data["id"] )),"person_login");
		if(count($d)>0){
			$ob->save(array("login"=>$login["login"], "id"=>$d[0]["id"]), "person_login");
		}		
		$ob->save($data);
		
	}else{
		unset($data["updated"], $data["updated_by"]);
		$ob->save($data);
		$lastID = $ob->getLastID();
		$password = md5($login["password_"]);
		$ob->save(array("login"=>$login["login"], "password_"=>$password, "id_person"=>$lastID), "person_login");
	}
	
	echo "1";
}else{
	echo "File not exists : " . $_SESSION['CORE'].$table_name.".php";
}


