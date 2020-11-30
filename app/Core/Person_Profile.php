<?php
require_once('Helpers/Modal.php');

class Person_Profile extends Modal{

	private $columns = array(
		array("column" => "id", "label"=>"#ID", "style"=>"display:none", "display"=>0),
		array("column" => "person_profile", "label"=>"PROFILE", "style"=>"font-weight:bold"),
		array("column" => "nbr", "label"=>"PERSON", "style"=>"min-width:130px; width:130px; text-align:center; color:#E91E63; font-size:20px"),
		array("column" => "is_default", "label"=>"PAR DEFAUT", "style"=>"min-width:130px; width:130px"),
		array("column" => "actions", "label"=>"", "style"=>"min-width:105px; width:105px")
	);
	
	private $tableName = "Person_Profile";
	
// construct
	public function __construct(){
		try{
			parent::__construct();
			$this->setTableName(strtolower($this->tableName));
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
}
$person_profile = new Person_Profile;