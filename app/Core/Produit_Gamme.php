<?php
require_once('Helpers/Modal.php');

class Produit_Gamme extends Modal{

	private $columns_ = array(
		array("column" => "id", "label"=>"#ID", "style"=>"display:none", "display"=>0),
		array("column" => "created", "label"=>"CREATION", "style"=>"display:none", "display"=>0),
		array("column" => "produit_category", "label"=>"CATEGORIE", "style"=>"font-weight:bold"),
		array("column" => "parent", "label"=>"PARENT", "style"=>"min-width:150px; width:250px; background-color:#EEEEEE; color:black; font-weight:bold; border-bottom:#9E9E9E 1px solid"),
		array("column" => "nbr_produit", "label"=>"PRODUITS", "style"=>"min-width:130px; width:130px; text-align:center; color:#E91E63; font-size:20px"),
		array("column" => "is_default", "label"=>"PAR DEFAUT", "style"=>"min-width:130px; width:130px"),
		array("column" => "status", "label"=>"STATUS", "style"=>"min-width:80px; width:80px"),
		array("column" => "actions", "label"=>"", "style"=>"min-width:105px; width:105px")
	);
	
	private $tableName = "Produit_Gamme";
	
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
	
	
	public function drawTable($args = null, $conditions = null, $useTableName = null){

		$showPerPage = array("20","50","100","200","500","1000");
		$status = array("<div class='label label-red'>Désactivé</div>", "<div class='label label-green'>Activé</div>");
		$remove_sort = array("actions","nbr");
		
		
		$p_p = (isset($args['p_p']))? $args['p_p']: $showPerPage[0];
		$current = (isset($args['current']))? $args['current']: 0;
		$sort_by = (isset($args['sort_by']))? $args['sort_by']: "created";
		$temp = explode(" ", $sort_by );
		$order = "";
		if(count( $temp ) > 1 ){ $order =  $temp[1]; }
		
		$values = array("Error : " . $this->tableName);
		$t_n = ($useTableName===null)? strtolower($this->tableName): $useTableName;
		
		if($conditions === null){
			$values = $this->find(null,array("order"=>$sort_by,"limit"=>array($current*$p_p,$p_p)),$t_n);
			$totalItems = $this->getTotalItems();
		}else{
			$conditions["order"] = $sort_by;
			$totalItems = count($this->find(null,$conditions,$t_n));
			$conditions["limit"] = array($current*$p_p,$p_p);
			$values = $this->find(null,$conditions,$t_n);
		}
		
		$returned = '<div class="col_12" style="padding: 0 10px">';	
		$returned .= '	<div class="panel" style="overflow: auto;">';
		$returned .= '		<div class="panel-content" style="padding: 0">';
		
		$returned .= '			<table class="table">';
		$returned .= '				<thead>';
		$returned .= '					<tr>';
		
		$columns = $this->getColumns();
	
		

		foreach($columns as $key=>$value){

			$style = ""; 
			$is_sort = ( in_array($value["column"], $remove_sort) )? "" : "sort_by";
			$is_display = ( isset($value["display"]) )? "hide" : "";
			if($is_sort === ""){
				$returned .= "<th class='".$is_sort. " ". $is_display . "' data-sort='" . $value['column'] . "'> " . $value['label'] . "</th>";
			}else{
				$returned .= "<th class='".$is_sort. " ". $is_display . "' data-sort='" . $value['column'] . "'> <i class='fas fa-sort'></i> " . $value['label'] . "</th>";
			}
			

		}
		$returned .= '					</tr>';
		$returned .= '				</thead>';
		$returned .= '				<tbody>';
		
		
		$content = '<div class="info info-success"><div class="info-success-icon"><i class="fa fa-info" aria-hidden="true"></i> </div><div class="info-message">Liste vide ...</div></div>';
		$i = 0;
		
		$t = explode("_",$this->tableName);
		$_t = "";
		foreach ($t as $k=>$v){
			$_t .= ($_t==="")? ucfirst($v): "_".ucfirst($v) ;
		}
		
		foreach($values as $k=>$v){
			$returned .= '					<tr class="edit_ligne" data-page="'.$_t.'">';
			foreach($columns as $key=>$value){
				
				$style = (isset($columns[$key]["style"]))? $columns[$key]["style"]:"";
				
				if(isset($v[ $columns[$key]["column"] ])){
					if($columns[$key]["column"] == "is_default"){
						$returned .= ($v[ $columns[$key]["column"] ] == 0)? "<td style='".$style."'></td>": "<td style='".$style."; font-size:10px; color:green'> <i class='fas fa-check'></i> <span>Par Défaut</span></td>";
					}elseif($columns[$key]["column"] == "id"){
						$returned .= "<td style='".$style."'><span class='id-ligne'>" . $v[ $columns[$key]["column"] ] . "</span></td>";
					}elseif($columns[$key]["column"] == "status"){
						$returned .= "<td style='".$style."'>".$status[$v["status"]]."</td>";
					}elseif($columns[$key]["column"] == "first_name"){
								
						if($v["notes"] !== "" and isset($v["notes"])){
							$returned .= "<td style='".$style."'>" . $v["first_name"] . " " . $v["last_name"] . " <span style='color:blue; font-size:12px'><i class='fas fa-info-circle'></i></span></td>";
						}else{
							$returned .= "<td style='".$style."'>" . $v["first_name"] . " " . $v["last_name"] . "</td>";
						}
					}else{
						$returned .= "<td style='".$style."'>" . $v[ $columns[$key]["column"] ] . "</td>";
					}											
				}else{
					if($columns[$key]["column"] == "actions"){
						$returned .=   "<td style='".$style."'><button style='margin-right:10px' data-page='".$_t."' class='btn btn-red remove_ligne' value='".$v["id"]."'><i class='fas fa-trash-alt'></i></button><button data-page='".$_t."' class='btn btn-orange edit_ligne' value='".$v["id"]."'><i class='fas fa-edit'></i></button></td>";												
					}elseif($columns[$key]["column"] == "nbr"){
						$returned .=  "<td style='".$style."'>0</td>";
					}else{
						$returned .=  "<td style='".$style."'></td>";
					}

				}


			}
			$returned .= '					</tr>';
		$i++	;
		}
	
		if($i == 0){
			$returned .= "<tr><td colspan='" . (count($columns)+1) . "'>".$content."</td></tr>";
		}
		
	
		$returned .= '				</tbody>';
		$returned .= '			</table>';
		$returned .= '		</div>';
		$returned .= '	</div">';
		$returned .= '</div>';
		echo $returned;

	}

	
}

$produit_gamme = new Produit_Gamme;