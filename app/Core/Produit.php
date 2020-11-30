<?php
require_once('Helpers/Modal.php');

class Produit extends Modal{

	private $tableName = __CLASS__;
	
// construct
	public function __construct(){
		try{
			parent::__construct();
			$this->setTableName(strtolower($this->tableName));
			
			foreach ($this->fetchAll() as $k=>$v){
				$this->save(
					array(
						"id"		=>	$v["id"], 
						"barcode"	=>	str_replace("°","",$v["barcode"]),
						"barcode_2"	=>	str_replace("°","",$v["barcode_2"]),
					));
			}
			
		}catch(Exception $e){
			die($e->getMessage());
		}
	}	
	
	public function getColumns($style = null){
		
		$style = (is_null($style))? strtolower($this->tableName): $style;
		
		$columns = array();
		$l = new ListView();
		foreach($l->getDefaultStyle($style, $columns)["data"] as $k=>$v){
			array_push($columns, array("column" => $v["column"], "label" => $v["label"], "style"=>$v["style"], "display"=>$v["display"], "format"=>$v["format"]) );
		}
		array_push($columns, array("column" => "actions", "label" => "", "style"=>"min-width:105px; width:105px", "display"=>1) );
		return $columns;
		
	}
	

	public function drawTable($args = null, $conditions = null, $useTableName = null){

		$showPerPage = array("20","50","100","200","500","1000");
		
		$remove_sort = array("actions","nbr","permis");
		
		
		$p_p = (isset($args['p_p']))? $args['p_p']: $showPerPage[2];
		$current = (isset($args['current']))? $args['current']: 0;
		$sort_by = (isset($args['sort_by']))? $args['sort_by']: "created";
		
		$temp = explode(" ", $sort_by );
		$style = (isset($args['style']))? $args['style']: "list";
		
		$order = "";
		if(count( $temp ) > 1 ){ $order =  $temp[1]; }
		
		$values = array("Error : " . $this->tableName);
		$t_n = ($useTableName===null)? strtolower($this->tableName): $useTableName;
		$column_style = (isset($args['column_style']))? $args['column_style']: $t_n;
		
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
		
		$returned .= '	<div class="" style="display:flex; justify-content:flex-end; height:45px; line-height: 45px;">';
		$returned .= '		<div class="" style="margin-right:auto">Total : ('.count($values).' / '.$totalItems.') <span class="current hide">'.$current.'</span></div>';
		$returned .= '		<div class="" style="padding-top:2px; padding-right:5px">';
		$returned .= '			<select id="showPerPage" style="padding:8px 5px">';
		foreach($showPerPage as $kk => $vv)
			$returned .= '			<option value="'.$vv.'" ' . ( $p_p == $vv ? "selected" : "") .'>'.$vv.'</option>';
		$returned .= '			</select>';
		$returned .= '			<span class="hide ' . $order . '" id="sort_by">'.$sort_by.'</span>';
		$returned .= '		</div>';
		$returned .= '		<div class="" style="padding-top:1px; padding-right:5px">';
		$returned .= '			<div class="btn-group">';
		$returned .= '				<a style="padding: 10px 12px" id="btn_passive_preview"  title="Précédent"><i class="fa fa-chevron-left"></i></a>';
		$returned .= '				<a style="padding: 10px 12px" id="btn_passive_next" title="Suivant"><i class="fa fa-chevron-right"></i></a>';
		$returned .= '			</div>';
		$returned .= '		</div>';
		$returned .= '		<div class="btn-group-radio style">';
		if($style === "list"){
		$returned .= '			<button class="btn btn-default checked" value="list" style="padding:9px 15px; font-size:18px"><i class="fas fa-list"></i></button>';
		$returned .= '			<button class="btn btn-default" value="grid" style="padding:9px 15px; font-size:18px"><i class="fas fa-th"></i></button>';			
		}else{
		$returned .= '			<button class="btn btn-default" value="list" style="padding:9px 15px; font-size:18px"><i class="fas fa-list"></i></button>';
		$returned .= '			<button class="btn btn-default checked" value="grid" style="padding:9px 15px; font-size:18px"><i class="fas fa-th"></i></button>';				
		}
		$returned .= '		</div>';
		$returned .= '	</div>';	
	
		$returned .= '	<div class="panel" style="overflow: auto;">';
		$returned .= '		<div class="panel-content" style="padding: 0">';
		
		if($style === "list"){
			$returned .= '			<table class="table">';
			$returned .= '				<thead>';
			$returned .= '					<tr>';

			$l = new ListView();
			$defaultStyleName = $l->getDefaultStyleName($column_style);

			$columns = $this->getColumns($column_style);

			foreach($columns as $key=>$value){

				$style = ""; 
				$is_sort = ( in_array($value["column"], $remove_sort) )? "" : "sort_by";
				$is_display = ( isset($value["display"]) )? ($value["display"])? "" : "hide" : "";

				$label = ($value['column'] === "actions")? "<button data-default='".$defaultStyleName."' value='".$column_style."' class='show_list_options' style='float:right; background:none; border:none; color:white; '><i class='fas fa-ellipsis-h'></i></button>": $value['label'];

				if($is_sort === ""){
					$returned .= "<th class='".$is_sort. " ". $is_display . "' data-sort='" . $value['column'] . "'> " . $label. "</th>";
				}else{
					$returned .= "<th class='".$is_sort. " ". $is_display . "' data-sort='" . $value['column'] . "'> <i class='fas fa-sort'></i> " . $label . "</th>";
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
				//$background = (isset($v["color"]))? $v["color"]: "";
				$background = "";
				$returned .= '					<tr style="background-color:'.$background.'" data-page="'.$_t.'">';
				foreach($columns as $key=>$value){
					$is_display = ( isset($value["display"]) )? ($value["display"])? "" : "hide" : "";
					$style = (isset($columns[$key]["style"]))? $columns[$key]["style"]:"";

					if(isset($v[ $columns[$key]["column"] ])){
						if($columns[$key]["column"] == "id"){
							$returned .= "<td class='".$is_display."' style='".$style."'><span class='id-ligne'>" . $v[ $columns[$key]["column"] ] . "</span></td>";
						}elseif($columns[$key]["column"] == "numero_matricule"){
							$remarque = ($v["remarque"])? '<i style="color:blue;border-radius:50%;" class="fas fa-info-circle"></i>': '';

							$returned .= "<td class='".$is_display."' style='".$style."'>" . $v["numero_matricule"] . " " . $remarque . "</td>";
						}else{
							if(isset($columns[$key]["format"])){
								if($columns[$key]["format"] === "money"){
									$returned .= "<td class='".$is_display."' style='".$style."'>" . $this->format($v[ $columns[$key]["column"] ]) . "</td>";
								}else if($columns[$key]["format"] === "on_off"){
									$returned .= "<td class='".$is_display."' style='".$style."'><div class='label label-red'>Désactive</div></td>";
								}else if($columns[$key]["format"] === "color"){
									$returned .= "<td class='".$is_display."' style='".$style."'> <span style='padding:10px 15px; background-color:".$v[ $columns[$key]["column"] ]."'>".$v[ $columns[$key]["column"] ] . "</span></td>";
								}else{
									$returned .= "<td class='".$is_display."' style='".$style."'>".$v[ $columns[$key]["column"] ]. " " . $columns[$key]["format"] . "</td>";
								}
							}else{
								$returned .= "<td class='".$is_display."' style='".$style."'>".$v[ $columns[$key]["column"] ]."</td>";
							}
						}										
					}else{
						if($columns[$key]["column"] === "actions"){
							$returned .=   "<td style='width:50px; min-width:50px; margin:0'><button data-page='".$_t."' class='btn btn-orange edit_ligne' value='".$v["id"]."'><i class='fas fa-edit'></i></button></td>";												
						}elseif($columns[$key]["column"] === "voiture"){
							$returned .= "<td class='".$is_display."' style='".$style."'>";
							
							$color = "<div style='padding:3px 10px;-webkit-box-shadow: 0px 0px 2px 0px rgba(0,0,0,0.75);-moz-box-shadow: 0px 0px 2px 0px rgba(0,0,0,0.75);box-shadow: 0px 0px 2px 0px rgba(0,0,0,0.75); display:inline-block; border-radius:50%; margin-right:7px; background-color:" . str_replace("0.5", "1", $v["vehicule_color_code"]) . "'>.</div>";
							
							$matricule = ($v["numero_matricule"] === "")? ($v["numero_matricule_w"] === "")? "Aucune": $v["numero_matricule_w"]: $v["numero_matricule"];
							$matricule = "<div style='display:inline-block; font-weight:bold; color:black; font-size:16px'>" . $matricule . "</div>";
							
							$marque = $v["vehicule_marque"] . " " . $v["vehicule_marque_serie"];
							$marque = "<div style='display:block'>" . $marque . "</div>";
							
							$returned .= "<div>" . $color . $matricule . "<br>" . $marque . "</div>" ;
							$returned .= "</td>";
							
						}elseif($columns[$key]["column"] == "prix_location"){
							$returned .= "<td class='".$is_display."' style='".$style."'>" . $this->format($v["jr_1"]) . " </td>";
						}else{
							if(isset($columns[$key]["format"])){
								if($columns[$key]["format"] === "money"){
									$returned .= "<td class='".$is_display."' style='".$style."'>" . $this->format(0) . "</td>";
								}else if($columns[$key]["format"] === "on_off"){
									$returned .= "<td class='".$is_display."' style='".$style."'><div class='label label-red'>Désactive</div></td>";
								}else if($columns[$key]["format"] === "color"){
									$returned .= "<td class='".$is_display."' style='".$style."'></td>";
								}else{
									$returned .= "<td class='".$is_display."' style='".$style."'></td>";
								}
							}else{
								$returned .= "<td class='".$is_display."' style='".$style."'></td>";
							}
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
		}else{
			
			$t = explode("_",$this->tableName);
			$_t = "";
			foreach ($t as $k=>$v){
				$_t .= ($_t==="")? ucfirst($v): "_".ucfirst($v) ;
			}	
			
			$statics = $_SESSION["STATICS"];
			$i = 0;
			$j = 0;	
			$counter = 1;
			$total = count($values);
			$find = array("{src}","{libelle}","{category}","{code}","{produit_color}","{id}");
			
			$item = '			<div class="col_6-inline item" style="position:relative">';
			$item .= '				<span class="image"><img src="{src}"></span>';
			$item .= '				<div class="name" >{libelle} ({category})</div>';
			$item .= '				<div class="matricule">{code}</div>';
			$item .= '				<button data-page="'.$_t.'" class="btn btn-orange edit_ligne" value="{id}"><i class="fas fa-edit"></i></button>';	
			$item .= '			</div>';
			
			foreach($values as $k=>$v){

				
				$img = $statics."public/images/images.png";
				

				foreach($this->getFiles($v["UID"]) as $index=>$image){	$img = $image["src"]; }
				
				$replace = array($img,$v["libelle"],$v["produit_category"],$v["code"],$v["produit_color"],$v["id"]);
				
				if($i === 0 && $j === 0){ 
					$returned .= '<div class="row">';
					$returned .= '	<div class="col_6">';
					$returned .= '		<div class="row cars">';
					$returned .= str_replace($find,$replace,$item);
					if($counter===$total){
					$returned .= '		</div>';
					$returned .= '	</div>';
					$returned .= '</div>';
					}
					$j=1;
				}elseif($i === 0 && $j === 1){ 
					$returned .= str_replace($find,$replace,$item);
					$returned .= '		</div>';
					$returned .= '	</div>';

					if($counter===$total){
					$returned .= '</div>';
					}

					$j=0;
					$i=1;

				}elseif($i === 1 && $j === 0){ 

					$returned .= '	<div class="col_6">';
					$returned .= '		<div class="row cars">';
					$returned .= str_replace($find,$replace,$item);
					if($counter===$total){
					$returned .= '		</div>';
					$returned .= '	</div>';
					$returned .= '</div>';
					}
					$j=1;
					$i=1;
				}else{
					$returned .= str_replace($find,$replace,$item);
					$returned .= '		</div>';
					$returned .= '	</div>';
					$returned .= '</div>';
					$j=0;
					$i=0;
				}
				$counter++;				
			}	
			
		}
		echo $returned;

		

	}
	
	public function getFiles($UID, $options=null){
		
		$upload_folder = $_SESSION["UPLOAD_FOLDER"];
		$statics = $_SESSION["STATICS"];
		
		$dS = DIRECTORY_SEPARATOR;
		$params = $this->getConfig();
		$UID_ENTREPRISE = $_SESSION[$params["GENERAL"]["ENVIRENMENT"]]["USER"]["entreprise_UID"];

		$filesDirectory = $upload_folder.$UID_ENTREPRISE.$dS.'produits'.$dS.$UID.$dS;
		
		$links = array();
		$i = 0;
		
		if(file_exists($filesDirectory)){
			
			//var_dump($options);
			foreach(scandir($filesDirectory) as $k=>$v){
				if($v <> "." and $v <> ".." and strpos($v, '.') !== false){
					if( is_null($options) ){
						$links[$i] = array(
							"src"	=>	$statics.$UID_ENTREPRISE."/produits/".$UID."/".$v,
							"path"	=>	$filesDirectory.$v
						);						
					}elseif(is_array($options)){
						$links[$i] = array(
							"src"	=>	$statics.$UID_ENTREPRISE."/produits/".$UID."/".$v,
							"path"	=>	$filesDirectory.$v
						);
					}

				}
				$i++;
			}	
		}
		
		
		return $links;
		
		
		
	}

}

$produit = new Produit;