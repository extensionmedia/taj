<?php
session_start();

$core = $_SESSION["CORE"];
$host = $_SESSION["HOST"];
$upload_folder = $_SESSION["UPLOAD_FOLDER"];
$dS = DIRECTORY_SEPARATOR;

require_once($core."Helpers".$dS."Modal.php");
$modal = new Modal;
$params = $modal->getConfig();
$UID_ENTREPRISE = $_SESSION[$params["GENERAL"]["ENVIRENMENT"]]["USER"]["entreprise_UID"];

//var_dump($_GET);
$isOK=false;
$message="";
$dS = DIRECTORY_SEPARATOR;
//$autorizedExt = array("jpg","jpeg","png","gif","bmp","JPG","JPEG","doc","docx","pdf");
$autorizedExt = array("jpg","jpeg","png","gif","bmp","JPG","JPEG");
//$autorizedType = array("image/jpeg","image/gif","image/png","image/bmp","image/jpg","application/msword","application/vnd.openxmlformats-officedocument.wordprocessingml.document","application/pdf");
$autorizedType = array("image/jpeg","image/gif","image/png","image/bmp","image/jpg");


//sleep(2);
if(isset($_FILES['upload_file'])){
	if(!empty($_FILES['upload_file']) && ($_FILES['upload_file']['error'] == 0)){
		if(in_array($_FILES['upload_file']['type'], $autorizedType)){
			if($_FILES['upload_file']['size']>10000){	// > 20 ko
				if($_FILES['upload_file']['size']<4000000){	// < 4.0 Mo
					$filename = basename($_FILES['upload_file']['name']);
					$ext = substr($filename, strrpos($filename, '.') + 1);
					if (in_array($ext, $autorizedExt)){
						if(isset($_GET["id"])){
							if(!empty($_GET["id"])){
								
								$isOK=true;
								
							}else{$message=$message."<br>empty File : ".$ext;}	
						}else{$message=$message."<br>unset File : ".$ext;}										
					}else{$message=$message."<br>Erreur Format : ".$ext;}
				}else{$message=$message."<br>fichier volumineu : ".round($_FILES['upload_file']['size'] /1000000 , 2);}
			}else{$message=$message."<br>fichier trop petit : ".round($_FILES['upload_file']['size'] /1000000 , 2);}
		}else{$message=$message."<br>Erreur Format : ".$_FILES["upload_file"]["type"];}
	}else{$message=$message."<br>fichier est vide";}
}else{$message=$message."<br>fichier non envoyé";}

//echo $message;

if ($isOK){

	//$filesDirectory = $core.'..'.$dS.'..'.$dS.'..'.$dS.'public_html'.$dS.'statics'.$dS.'produits'.$dS.$_GET["id"].$dS;

	$filesDirectory = $upload_folder.$dS.$UID_ENTREPRISE.$dS.$_GET["id"].$dS;
	//$filesDirectory = $core.'..'.$dS.'..'.$dS.'pages'.$dS.'uploads'.$dS.'produits'.$dS.$_GET["id"].$dS;
	$is_default = "";
	if (!file_exists($filesDirectory)) {
		mkdir($filesDirectory, 0777, true);
		$is_default = "(default)";
	}elseif( strpos($_GET["id"], 'person/') !== false ){
		array_map('unlink', glob("$filesDirectory/*.*"));
		require_once($core.'Person.php');
		$person->saveActivity("fr",$_SESSION[$params["GENERAL"]["ENVIRENMENT"]]["USER"]["id"],array("Person",2),"0");
	}elseif( strpos($_GET["id"], 'category/') !== false  ){
		array_map('unlink', glob("$filesDirectory/*.*"));
	}
	
	
	$fileSize = round($_FILES['upload_file']['size'] /1000000 , 2);
	$lastId = time();
	$ext = substr($filename, strrpos($filename, '.') + 1);
	$file = $filesDirectory.$lastId.$is_default.'.'.$ext;

	$_SESSION["UPLOADED_FILE"] = $lastId.'.'.$ext;

	
	if (move_uploaded_file($_FILES['upload_file']['tmp_name'], $file)) {
	  	echo 1; 
	}else{echo '0';}
}else{
	echo '0';
	echo $message;
}
