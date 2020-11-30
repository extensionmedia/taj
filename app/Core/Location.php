<?php
require_once('Helpers/Modal.php');

class Location extends Modal{
	
	private $tableName = __CLASS__;
	
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
		foreach($l->getDefaultStyle($style, $columns)["data"] as $k=>$v){
			array_push($columns, array("column" => $v["column"], "label" => $v["label"], "style"=>$v["style"], "display"=>$v["display"], "format"=>$v["format"]) );
		}
		array_push($columns, array("column" => "actions", "label" => "", "style"=>"min-width:105px; width:105px", "display"=>1) );
		return $columns;
		
	}

	public function drawTable($args = null, $conditions = null, $useTableName = null){
		

		//var_dump($conditions);
		
		$showPerPage = array("20","50","100","200","500","1000");
		$is_default = array(
			0	=>	"", 
			1	=>	"<div style='background-color:#3E2723; color:white; border-radius:5px; padding:3px 7px 2px 5px; width:70px; font-size:10px'> <i class='fas fa-dot-circle'></i> Default </div>");
		
		$status = array(
			0	=>	"<div class='label label-red'>Désactivé</div>", 
			1	=>	"<div class='label label-green'>Activé</div>");
		
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
			//$totalItems = $this->getTotalItems();
			$totalItems = 0;
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
		$returned .= '		<div class="btn-group-radio style hide">';
		if($style === "list"){
		$returned .= '			<button class="btn btn-default checked" value="list" style="padding:9px 15px; font-size:18px"><i class="fas fa-list"></i></button>';
		$returned .= '			<button class="btn btn-default" value="grid" style="padding:9px 15px; font-size:18px"><i class="fas fa-th"></i></button>';			
		}else{
		$returned .= '			<button class="btn btn-default" value="list" style="padding:9px 15px; font-size:18px"><i class="fas fa-list"></i></button>';
		$returned .= '			<button class="btn btn-default checked" value="grid" style="padding:9px 15px; font-size:18px"><i class="fas fa-th"></i></button>';				
		}
		$returned .= '		</div>';
		$returned .= '	</div>';	
		
		$returned .= '	<div class="row" style="margin-bottom:15px">';
		$returned .= '		<div class="col_4-inline" style="padding:0">
								<div style="position:relative; background-color:rgba(255,255,0,0.2); color:#000; width:100%; height:60px; line-height:60px; text-align:center;border:1px solid #CDDC39;">
									<div style="position: absolute; top:-20px !important;">TOTAL</div>
									<div style="font-size:26px; font-weight:bold">[[total]]</div>
								</div>
							</div>';
		$returned .= '		<div class="col_4-inline" style="padding:0">
								<div style="position:relative; background-color:rgba(0,0,255,0.2); color:#000; width:100%; height:60px; line-height:60px; text-align:center;border:1px solid #7986CB;">
									<div style="position: absolute; top:-20px !important;">PAYE</div>
									<div style="font-size:26px; font-weight:bold">[[paye]]</div>
								</div>
							</div>';
		$returned .= '		<div class="col_4-inline" style="padding:0">
								<div style="position:relative; background-color:rgba(255,0,255,0.2); color:#000; width:100%; height:60px; line-height:60px; text-align:center;border:1px solid #F48FB1;">
									<div style="position: absolute; top:-20px !important;">RESTE</div>
									<div style="font-size:26px; font-weight:bold">[[reste]]</div>
								</div>
							</div>';
		$returned .= '	</div>';
		
		$returned .= '	<div class="panel" style="overflow: auto;">';
		$returned .= '		<div class="panel-content" style="padding: 0">';
		
		$ttl_reste = 0;
		$ttl_avoir_paiement = 0;
		$ttl_avoir = 0;
		$ttl_payer = 0;
		$ttl_remise = 0;
		$ttl_du = 0;
		

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
				$background = (isset($v["location_status_color"]))? $v["location_status_color"]: "";
				
				// Calculs
				$du = $v["total"];
				$ttl_du += $du;
				
				$remise = $v["remise"];
				$ttl_remise += $remise;
				
				$payer = !is_null($v["total_payement"])? $v["total_payement"]: 0;
				$ttl_payer += $payer;
				
				$avoir = !is_null($v["avoir"])? $v["avoir"]: 0;
				$ttl_avoir += $avoir;
				
				$avoir_paiement = !is_null($v["total_payement_avoir"])? $v["total_payement_avoir"]: 0;
				$ttl_avoir_paiement += $avoir_paiement;
				
				$reste = ($du - $remise) - ($payer + $avoir) - $avoir_paiement;
				$ttl_reste += $reste;
				
				
				$returned .= '					<tr style="background-color:'.$background.'" data-page="'.$_t.'">';
				foreach($columns as $key=>$value){
					$is_display = ( isset($value["display"]) )? ($value["display"])? "" : "hide" : "";
					$style = (isset($columns[$key]["style"]))? $columns[$key]["style"]:"";

					if(isset($v[ $columns[$key]["column"] ])){
						if($columns[$key]["column"] == "id"){
							$returned .= "<td class='".$is_display."' style='".$style."'><span class='id-ligne'>" . $v[ $columns[$key]["column"] ] . "</span></td>";
						}elseif($columns[$key]["column"] == "total"){
							$is_remise = ($remise > 0)? " (*)": "";
							
							$lbl_avoir = !is_null($v["avoir"])? " <div style='color:red; font-size:10px'>-".$this->format($avoir)."</div>": "";
							
							$returned .= "<td class='".$is_display."' style='".$style."'>" . $this->format($du-$remise) . $is_remise . $lbl_avoir."</td>";
						
						}elseif($columns[$key]["column"] == "total_payement"){
							$lbl_avoir = !is_null($v["avoir"])? " <div style='color:red; font-size:10px'>".$this->format($avoir_paiement)."</div>": "";
							$returned .= "<td class='".$is_display."' style='".$style."'>" . $this->format($payer) . $lbl_avoir."</td>";
							
						}elseif($columns[$key]["column"] == "nbr_jours"){
							$returned .= "<td class='".$is_display."' style='".$style."'>" . $v["nbr_jours"] . " </td>";		
							
						}elseif($columns[$key]["column"] == "client"){
							$notes = ($v["notes"] === "")? "": "<i style='color:blue' class='far fa-question-circle'></i>";
							$returned .= "<td class='".$is_display."' style='".$style."'>" . $v["client"] . " " . $notes . " </td>";		
						}elseif($columns[$key]["column"] == "USR"){
							$date = explode(" ", $v["created"])[0];
							$returned .= "<td class='".$is_display."' style='".$style."'> <i class='fas fa-user-alt'></i> " . $v["USR"] . " <div><i class='far fa-clock'></i> " . $date . "</div> </td>";	
						}else{
							if(isset($columns[$key]["format"])){
								if($columns[$key]["format"] === "money"){
									$returned .= "<td class='".$is_display."' style='".$style."'>" . $this->format($v[ $columns[$key]["column"] ]) . "</td>";
								}else if($columns[$key]["format"] === "on_off"){
									$returned .= "<td class='".$is_display."' style='".$style."'><div class='label label-red'>Désactive</div></td>";
								}else if($columns[$key]["format"] === "color"){
									$returned .= "<td class='".$is_display."' style='".$style."'> <span style='padding:10px 15px; background-color:".$v[ $columns[$key]["column"] ]."'>".$v[ $columns[$key]["column"] ] . "</span></td>";
								}else if($columns[$key]["format"] === "date"){
									$date = explode(" ", $v[ $columns[$key]["column"] ]);
									if(count($date)>1){
										$_date = "<div style='min-width:105px'><i class='fas fa-calendar-alt'></i> ".$date[0]."</div><div style='min-width:105px'><i class='far fa-clock'></i> ".$date[1]."</div>";
									}else{
										$_date = "<div><i class='fas fa-calendar-alt'></i> ".$date[0]."</div>";
									}
									$returned .= "<td class='".$is_display."' style='".$style.";'>".$_date."</td>";

								}else{
									$returned .= "<td class='".$is_display."' style='".$style."'>".$v[ $columns[$key]["column"] ]. "</td>";
								}
							}else{
								$returned .= "<td class='".$is_display."' style='".$style."'>".$v[ $columns[$key]["column"] ]."</td>";
							}
						}										
					}else{
						if($v["location_status"] === "RESERVATION"){
							$buttons = '<div class="btn-group location">
								<button style="font-size:12px; padding:8px 5px" class="btn edit" data-UID="'.$v["UID"].'"><i class="fas fa-pen"></i></button>
								<button style="font-size:12px; padding:8px 5px" class="btn ticket" data-id="'.$v["id"].'"><i class="fas fa-print"></i></button>
								<button style="font-size:12px; padding:8px 5px" class="btn paiement" data-id="'.$v["id"].'"><i class="fas fa-cash-register"></i></button>
								<button style="font-size:12px; padding:8px 5px" class="btn "><i class="fas fa-ban"></i></button>
								<button style="font-size:12px; padding:8px 5px" data-page="Location" class="btn btn-red remove_ligne" value="'.$v["id"].'"><i class="far fa-trash-alt"></i></button>
							</div>';							
						}elseif($v["location_status"] === "LOCATION"){
							$buttons = '<div class="btn-group location">
								<button style="font-size:12px; padding:8px 5px" class="btn edit" data-UID="'.$v["UID"].'"><i class="fas fa-pen"></i></button>
								<button style="font-size:12px; padding:8px 5px" class="btn ticket" data-id="'.$v["id"].'"><i class="fas fa-print"></i></button>
								<button style="font-size:12px; padding:8px 5px" class="btn paiement" data-id="'.$v["id"].'"><i class="fas fa-cash-register"></i></button>
								<button style="font-size:12px; padding:8px 5px" class="btn terminer" data-id="'.$v["id"].'"><i class="fas fa-calendar-week"></i></button>	
							</div>';
						}else{
							$buttons = '<div class="btn-group location">
								<button style="font-size:12px; padding:8px 5px" class="btn edit" data-UID="'.$v["UID"].'"><i class="fas fa-pen"></i></button>
								<button style="font-size:12px; padding:8px 5px" class="btn ticket" data-id="'.$v["id"].'"><i class="fas fa-print"></i></button>
							</div>';
						}

						
						if($columns[$key]["column"] === "actions"){
							//$returned .=   "<td style='width:50px; min-width:50px; margin:0'><button data-page='".$_t."' class='btn btn-default show_edit_ligne' data-status='".$v["location_status"]."' value='".$v["id"]."'><i class='fas fa-ellipsis-h'></i></button></td>";	
							$returned .= "<td style='width:135px; min-width:135px; margin:0'>".$buttons."</td>";
						}elseif($columns[$key]["column"] === "reste"){
							$returned .= "<td class='".$is_display."' style='".$style."'>" . $this->format($reste) . "</td>";
						}elseif($columns[$key]["column"] == "date"){
							$returned .= "<td class='".$is_display."' style='".$style."'>";
							$returned .= "<div style='font-size:12px;color:green'> <i class='fas fa-arrow-circle-right'></i> ".$v["date_debut"]."</div>";
							$returned .= "<div style='font-size:12px;color:black'> <i class='fas fa-arrow-circle-left'></i> ".$v["date_fin"]."</div>";
							$returned .= "</td>";
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
		
		
		$to_replace = array("[[total]]", "[[paye]]", "[[reste]]" );
		$replace_by = array($this->format($ttl_du), $this->format($ttl_payer), $this->format($ttl_reste));
		$returned = str_replace($to_replace, $replace_by, $returned);
		echo $returned;
		

	}
	
	public function getFiles($UID, $options=null){
		
		$upload_folder = $_SESSION["UPLOAD_FOLDER"];
		$statics = $_SESSION["STATICS"];
		
		$dS = DIRECTORY_SEPARATOR;
		$params = $this->getConfig();
		$UID_ENTREPRISE = $_SESSION[$params["GENERAL"]["ENVIRENMENT"]]["USER"]["entreprise_UID"];

		$filesDirectory = $upload_folder.$UID_ENTREPRISE.$dS.'vehicules'.$dS.$UID.$dS;
		
		$links = array();
		$i = 0;
		
		
		if(file_exists($filesDirectory)){
			
			//var_dump($options);
			foreach(scandir($filesDirectory) as $k=>$v){
				if($v <> "." and $v <> ".." and strpos($v, '.') !== false){
					if( is_null($options) ){
						$links[$i] = array(
							"src"	=>	$statics.$UID_ENTREPRISE."/vehicules/".$UID."/".$v,
							"path"	=>	$filesDirectory.$v
						);						
					}elseif(is_array($options)){
						if( in_array("default",$options)){
							if(strpos($v, 'default')){
								$links[$i] = array(
									"src"	=>	$statics.$UID_ENTREPRISE."/vehicules/".$UID."/".$v,
									"path"	=>	$filesDirectory.$v
								);
							}
						}
					}

				}
				$i++;
			}	
		}
		
		
		return $links;
		
		
		
	}
	
	public function isDisponible($id_vehicule, $date_debut, $date_fin){
		$return = false;
		$vehicules = $this->find("", array("conditions AND"=>array("id_vehicule_status<>"=>2, "id="=>$id_vehicule)), "v_vehicule");
		if(count($vehicules) > 0){
			$request = "SELECT * FROM location where date_debut <= CAST('".$date_debut."' AS DATE) AND date_fin >= CAST('".$date_fin."' AS DATE) AND id_vehicule=".$id_vehicule;
			if(count($this->execute($request)) === 0) $return = true;
		}
		echo $request;
		return $return;
		
	}
	
	public function GetByUID($UID){
		$data = $this->find("", array("conditions"=>array("UID="=>$UID)), "v_location");
		if(count($data)>0) return $data; else return array();
	}
	
	public function GetProduitsByLocation($id_location){
		$data = $this->find("", array("conditions"=>array("id_location="=>$id_location)), "v_location_detail");
		if(count($data)>0) return $data; else return array();
	}

}
$location = new Location;