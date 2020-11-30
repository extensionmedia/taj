<?php
require_once('Helpers/Modal.php');

class Produit_Category extends Modal{

	private $columns = array(
		array("column" => "id", "label"=>"#ID", "style"=>"display:none", "display"=>0),
		array("column" => "created", "label"=>"CREATION", "style"=>"display:none", "display"=>0),
		array("column" => "produit_category", "label"=>"CATEGORIE", "style"=>"font-weight:bold"),
		array("column" => "parent", "label"=>"PARENT", "style"=>"min-width:150px; width:250px; background-color:#EEEEEE; color:black; font-weight:bold; border-bottom:#9E9E9E 1px solid"),
		array("column" => "nbr_produit", "label"=>"PRODUITS", "style"=>"min-width:130px; width:130px; text-align:center; color:#E91E63; font-size:20px"),
		array("column" => "is_default", "label"=>"PAR DEFAUT", "style"=>"min-width:130px; width:130px"),
		array("column" => "status", "label"=>"STATUS", "style"=>"min-width:80px; width:80px"),
		array("column" => "actions", "label"=>"", "style"=>"min-width:105px; width:105px")
	);
	
	private $tableName = "Produit_Category";
	
// construct
	public function __construct(){
		try{
			parent::__construct();
			$this->setTableName(strtolower($this->tableName));
			/*
			foreach($this->find("", array("conditions"=>array("UID="=>0)), "") as $k=>$v){
				$UID = md5( uniqid('auth', true) );
				$this->save(array("UID"=>$UID, "id"=>$v["id"]));
			}
			*/
		}catch(Exception $e){
			die($e->getMessage());
		}
	}	
	
	public function getColumns($style = null){
		
		$style = (is_null($style))? strtolower($this->tableName): $style;
		
		$columns = array();
		$l = new ListView();
		foreach($l->getDefaultStyle($style, $this->columns)["data"] as $k=>$v){
			array_push($columns, array("column" => $v["column"], "label" => $v["label"], "style"=>$v["style"], "display"=>$v["display"], "format"=>$v["format"]) );
		}
		array_push($columns, array("column" => "actions", "label" => "", "style"=>"min-width:105px; width:105px", "display"=>1) );
		return $columns;
		
	}
	
	public function getFiles($UID, $options=null){
		
		$upload_folder = $_SESSION["UPLOAD_FOLDER"];
		$statics = $_SESSION["STATICS"];
		
		$dS = DIRECTORY_SEPARATOR;
		$params = $this->getConfig();
		$UID_ENTREPRISE = $_SESSION[$params["GENERAL"]["ENVIRENMENT"]]["USER"]["entreprise_UID"];

		$filesDirectory = $upload_folder.$UID_ENTREPRISE.$dS.'category'.$dS.$UID.$dS;
		
		$links = array();
		$i = 0;
		
		if(file_exists($filesDirectory)){
			
			//var_dump($options);
			foreach(scandir($filesDirectory) as $k=>$v){
				if($v <> "." and $v <> ".." and strpos($v, '.') !== false){
					if( is_null($options) ){
						$links[$i] = array(
							"src"	=>	$statics.$UID_ENTREPRISE."/category/".$UID."/".$v,
							"path"	=>	$filesDirectory.$v
						);	
						$i++;
					}elseif(is_array($options)){
						$links[$i] = array(
							"src"	=>	$statics.$UID_ENTREPRISE."/category/".$UID."/".$v,
							"path"	=>	$filesDirectory.$v
						);
						$i++;
					}
				}
			}	
		}
		if($i === 0) $links = array(0=>array("name"=>"-1", "src"=>$statics."public/images/images.png"));
		
		return $links;
		
		
		
	}

	
}

$produit_category = new Produit_Category;