<?php session_start();

$core = $_SESSION["CORE"];
$host = $_SESSION["HOST"];
$statics = $_SESSION["STATICS"];
$upload_folder = $_SESSION["UPLOAD_FOLDER"];

$dS = DIRECTORY_SEPARATOR;
require_once($core."Helpers".$dS."Modal.php");
$modal = new Modal;
$params = $modal->getConfig();
$UID_ENTREPRISE = $_SESSION[$params["GENERAL"]["ENVIRENMENT"]]["USER"]["entreprise_UID"];

$filesDirectory = $upload_folder.$UID_ENTREPRISE.$dS.'clients'.$dS.$_POST['client_UID'].$dS.'contrats'.$dS;


$nbr = 0;

if(file_exists($filesDirectory)){
	$images = "";
	
	foreach(scandir($filesDirectory) as $k=>$v){
		
		$showImage = "";
		
		if($v <> "." and $v <> ".." and strpos($v, '.') !== false){
			$ext = explode(".",$v);
			$file_name = $ext[1];
			if ($ext[1] == "doc" || $ext[1] == "docx"){
				$link = $statics."public/icon_word.png";
				$showImage = "download";
			}elseif($ext[1] == "pdf"){
				$link = $statics."public/icon_pdf.png";
				$showImage = "download";
			}else{
				$link = $statics.$UID_ENTREPRISE."/clients/".$_POST['client_UID']."/contrats/".$v;
				$showImage = "showImage";
			}
			
			$file = $statics.$UID_ENTREPRISE."/clients/".$_POST['client_UID']."/contrats/".$v;
			
			$images .= "<div style='display:inline-block; margin:5px; text-align:center; border:1px solid #ededed; padding:5px'>";
			$images .= "	<img class='".$showImage."' style='width:130px; height:auto; display:block' src='".$link."'>";	
			$images .= "	<div class='file_name' style='width:130px; height:auto; font-weight:bold; font-size:12px; text-align:center; word-break: break-word; padding:7px 2px'>";
			$images .= "		<span>$ext[0]</span>";	
			$images .= "		<input style='font-size:12px; ' class='file_name_input hide' data-link='". $filesDirectory.$v."' type='text' value='".$ext[0]."'>";	
			$images .= "	</div>";
			$images .= "	<div class='btn-group'>";
			$images .= "		<button style='padding:8px 10px; font-size:18px' class='btn btn-small btn-red delete_file contrat' value='". $filesDirectory.$v."'><i class='fas fa-trash-alt'></i></button>";
			$images .= "		<button style='padding:8px 10px; font-size:18px' class='btn btn-small btn-green edit_file contrat' value='". $filesDirectory.$v."'><i class='fas fa-edit'></i></button>";
			
			$images .= "		<button style='padding:8px 20px; font-size:18px' class='btn btn-small btn-default show_file contrat' data-name='".$file_name."' value='". $file ."'><i class='fas fa-download'></i></button>";
			$images .= "	</div>";
			$images .= "</div>";
			
			
			$nbr++;
		}

		

	}	
	echo $images;
}


if($nbr==0){
	
	echo '<div class="info info-success"><div class="info-success-icon"><i class="fas fa-info-circle"></i></div><div class="info-message">Aucune contrat pour ce client ... <br>'.$filesDirectory.'</div></div>';
}
//var_dump(scandir($filesDirectory,1));
