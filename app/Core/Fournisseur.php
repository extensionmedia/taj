<?php
require_once('Helpers/Modal.php');

class Fournisseur extends Modal{

	private $columns = array(
		array("column" => "id", "label"=>"#ID", "style"=>"display:none", "display"=>0),
		array("column" => "created", "label"=>"CREATION", "style"=>"display:none", "display"=>0),
		array("column" => "fournisseur_name", "label"=>"FOURNISSEUR", "style"=>"font-weight:bold"),
		array("column" => "phone", "label"=>"CONTACT", "style"=>"min-width:150px; width:250px; font-size:16px"),
		array("column" => "nbr_produit", "label"=>"PRODUITS", "style"=>"min-width:130px; width:130px; text-align:center; color:#E91E63; font-size:20px"),
		array("column" => "is_default", "label"=>"PAR DEFAUT", "style"=>"min-width:130px; width:130px"),
		array("column" => "status", "label"=>"STATUS", "style"=>"min-width:80px; width:80px"),
		array("column" => "actions", "label"=>"", "style"=>"min-width:105px; width:105px")
	);
	
	private $tableName = "Fournisseur";
	
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
	
	
		
	public function _drawTable($args = null, $conditions = null, $useTableName = null){

		$showPerPage = array("20","50","100","200","500","1000");
		$status = array("<div class='label label-red'>Désactivé</div>", "<div class='label label-green'>Activé</div>");
		$remove_sort = array("actions","nbr","phone");
		
		
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
		
		$returned = '<div class="col_12" style="padding: 0">';
	
		$returned .= '	<div style="display: flex; flex-direction: row">';
		$returned .= '		<div style="flex: auto; padding: 15px 0 10px 5px; margin: 0; color: rgba(118,17,18,1.00)">';
		$returned .= '			Total : ('.count($values).' / '.$totalItems.') <span class="current hide">'.$current.'</span>';
		$returned .= '		</div>';
		$returned .= '		<div style="width: 10rem">';
		$returned .= '		<div style="flex-direction: row; display: flex">';
		$returned .= '			<div style="flex: 1">';
		$returned .= '				<select id="showPerPage">';
		
		foreach($showPerPage as $kk => $vv)
			$returned .= '				<option value="'.$vv.'" ' . ( $p_p == $vv ? "selected" : "") .'>'.$vv.'</option>';
		
		
		$returned .= '				</select>';
		$returned .= '					<span class="hide ' . $order . '" id="sort_by">'.$sort_by.'</span>';
		$returned .= '			</div>';
		$returned .= '			<div style="flex: 1; text-align: center">';
		$returned .= '				<div class="btn-group">';
		$returned .= '					<a style="padding: 12px 12px" id="btn_passive_preview"  title="Précédent"><i class="fa fa-chevron-left"></i></a>';
		$returned .= '					<a style="padding: 12px 12px" id="btn_passive_next" title="Suivant"><i class="fa fa-chevron-right"></i></a>';
		$returned .= '				</div>';
		$returned .= '			</div>';
		$returned .= '		</div>';
		$returned .= '		</div>';
		$returned .= '	</div>';	
	
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
					}elseif($columns[$key]["column"] == "fournisseur_name"){
								
						if($v["notes"] !== "" and isset($v["notes"])){
							$returned .= "<td style='".$style."'>" . strtoupper($v[$columns[$key]["column"]]) . " <span style='color:blue; font-size:12px'><i class='fas fa-info-circle'></i></span></td>";
						}else{
							$returned .= "<td style='".$style."'>" . strtoupper($v[$columns[$key]["column"]]) . "</td>";
						}
					}else{
						$returned .= "<td style='".$style."'>" . $v[ $columns[$key]["column"] ] . "</td>";
					}											
				}else{
					if($columns[$key]["column"] == "actions"){
						$returned .=   "<td style='".$style."'><button style='margin-right:10px' data-page='".$_t."' class='btn btn-red remove_ligne' value='".$v["id"]."'><i class='fas fa-trash-alt'></i></button><button data-page='".$_t."' class='btn btn-orange edit_ligne' value='".$v["id"]."'><i class='fas fa-edit'></i></button></td>";												
					}elseif($columns[$key]["column"] == "nbr"){
						$returned .=  "<td style='".$style."'>0</td>";
					}elseif($columns[$key]["column"] == "phone"){
						$ph_1 = ($v["telephone_1"]==="")? "-" : '<i class="fas fa-phone-square"></i> ' . $v["telephone_1"]."<br>";
						$ph_1 .= ($v["telephone_2"]==="")? "-" : '<i class="fas fa-phone-square"></i> ' . $v["telephone_2"];
						
						$returned .=  "<td style='".$style."'>" . $ph_1 . "</td>";
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

$fournisseur = new Fournisseur;