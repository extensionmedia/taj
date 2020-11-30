<?php session_start(); $core = $_SESSION['CORE']; 

$table_name = $_POST["page"];
require_once($core.$table_name.".php");
$ob = new $table_name();
$id = $_POST["id"];
$cond = array("conditions" => array("id=" => $id) );
$data = $ob->find(null, $cond, null);
$dS = DIRECTORY_SEPARATOR;
if( count($data) > 0 ){
		
	$ob->setID($id);
	$UID = $ob->read()[0]["UID"];
	$upload_folder = $_SESSION["UPLOAD_FOLDER"];
	$filesDirectory = $upload_folder.'person'.$dS.$UID.$dS;
		
	if (file_exists($filesDirectory)) {
		array_map('unlink', glob("$filesDirectory/*.*"));
		rmdir($filesDirectory);
		
	}
	echo $ob->delete($_POST["id"]);
	
}else{
	
}

