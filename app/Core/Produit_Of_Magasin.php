<?php
require_once('Helpers/Modal.php');

class Produit_Of_Magasin extends Modal{
	
	private $tableName = "Produit_Of_Magasin";
	
// construct
	public function __construct(){
		try{
			parent::__construct();
			$this->setTableName(strtolower($this->tableName));
		}catch(Exception $e){
			die($e->getMessage());
		}
	}	
	
		
	public function getColumns(){
		
		if ( isset($this->columns) ){
			return $this->columns;
		}else{
			$columns = array();
			//var_dump($this->getColumnsName("client"));
			foreach($this->getColumnsName(strtolower($this->tableName)) as $k=>$v){
				//var_dump($v["Field"]);
				array_push($columns, array("column" => $v["Field"], "label" => $v["Field"]) );
			}
			array_push($columns, array("column" => "actions", "label" => "", "style"=>"min-width:105px; width:105px") );
			return $columns;
		}
		
	}
	

}

$produit_of_magasin = new Produit_Of_Magasin;