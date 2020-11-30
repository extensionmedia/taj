<?php
require_once('Helpers/Modal.php');
class Person_Activity extends Modal{

	private $columns = array(
		array("column" => "id", "label"=>"#ID", "style"=>"display:none", "display"=>0),
		array("column" => "created", "label"=>"DATE"),
		array("column" => "activity_action", "label"=>"ACTION"),
		array("column" => "activity_message", "label"=>"DESCRIPTION"),
		array("column" => "activity_ip", "label"=>"LOCATION"),
		array("column" => "module", "label"=>"MODULE", "width"=>80),
		array("column" => "actions", "label"=>"", "style"=>"min-width:55px; width:55px")
	);
	private $tableName = __CLASS__;
// construct
	public function __construct(){
		try{
			parent::__construct("config");
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
	
	
	public function _drawTable($columns = null, $conditions=null, $useTableName=null){
		if($columns == null){
			$columns = $this->getColumns();
		}
		$returned = '<table class="table">';
		$returned .= '	<thead>';
		$returned .= '		<tr>';
		
		foreach($columns as $key=>$value){
			if(isset($value["width"])){
				$returned .=  "<th style='width:" . $value["width"] . "'>" . $value["label"] . "</th>";
			}else{
				$returned .=  "<th>" . $value["label"] . "</th>";
			}
		}
		$returned .= '		</tr>';
		$returned .= '	</thead>';
		$returned .= '<tbody>';
		
		
		$values = $this->fetchAll();
		foreach($values as $k=>$v){
			$returned .= '	<tr>';
			foreach($columns as $key=>$value){
				if(isset($v[ $columns[$key]["column"] ])){
					$returned .= "<td>" . $v[ $columns[$key]["column"] ] . "</td>";
				}else{
					$returned .=  "<td>NaN</td>";
				}
			}	
			$returned .= '	</tr>';
		}
		$returned .= '</tbody>';	
		$returned .= '</table>';
		return $returned;
		
	}
	


	
}
$person_activity = new Person_Activity;

