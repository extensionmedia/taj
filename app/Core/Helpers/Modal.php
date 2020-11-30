<?php
require_once('Config.php');
require_once('DataBase.php');
require_once('ListView.php');

class Modal{
	
	private $mysql;
	public $isConnected = false;
	public $err;
	private $tableName = "";
	private $table_preffix="";
	public $id="";
	public $totalItems = 0;
	public $isError = 0;
	public $config;
	private $params;

// construct
	public function __construct($config = null){
		
		try{
			$this->config = new Config;
			$this->params = $this->config->get();
			
			
			if(!isset($_SESSION["ERRORS"]["USER"])){
				$UID = $_SESSION[$this->params["GENERAL"]["ENVIRENMENT"]]["USER"]["entreprise_UID"];
				$this->config = new Config($UID);
				$this->params = $this->config->get();
				
				
			}
			
			if($config !== null){
				$this->config = new Config($config);
				$this->params = $this->config->get();
				
				
			}
			
			$this->mysql = new DataBase($this->params["DATA_BASE"][$this->config->getEnv()]);
			if ($this->mysql->isConnected){
				$this->isConnected = true;
			}else{
				$this->isConnected = false;
				$this->err = $this->mysql->err;
			}
			
		}catch(Exception $e){
			die($e->getMessage());
		}
	}
	
	public function getUsersByEntreprise($id_entreprise = null, $UID_entreprise = null){
			if(!is_null($id_entreprise) AND !is_null($UID_entreprise)){
				try { 

					$this->datab = new PDO(
						"mysql:host={$config["HOST"]};dbname={$config["DBNAME"]}", 
						$config["USERNAME"], 
						$config["PASSWORD"],
						array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')
					); 


					$this->datab->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
					$this->datab->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
					$this->isConnected = true;
				} 

				catch(Exception $e) { 
					$this->isConnected = false;
					$this->err =  $e->getMessage();
				}
			}
	}
	
	public function getConfig(){
		return $this->params;
	}
	
	public function setTableName($tableName){
		$this->tableName = $this->table_preffix.$tableName;
	}	
	
	public function setID($id){
		$this->id = $id;
	}
	
//**************************************
//********************* DATA BASE SCHEMA
//**************************************
	
	public function getTablesName(){
		try{
			$req = "SHOW TABLES";
			return $this->mysql->getTables($req);
			
		}catch(Exception $e){
			$this->err->save($this->tableName." -> getTablesName",$e->getMessage(),$req);
		}
	}

	public function getColumnsName($tableName){
		try{
			$req = "SHOW FULL COLUMNS FROM " . $tableName;
			return $this->mysql->getTables($req);
			
		}catch(Exception $e){
			return array();
			die($e->getMessage());
		}
	}

	public function fetchAll($use = null, $from = null, $to = null){
		try{
			$req = "";
			if($use==null){$req = "SELECT * FROM ".$this->tableName;}
			if($use!=null){$req = "SELECT * FROM ".$this->table_preffix.$use;}
			
			if($to!=null){$req = $req." LIMIT ".$from.",".$to;}
			return $this->mysql->getRows($req);
			
		}catch(Exception $e){
			die($e->getMessage());
		}
	}

	public function read($fields = null){
		if($fields == null){$fields = "*";}
		if ($this->id == ""){
			$sql = "SELECT ".$fields." FROM ".$this->tableName;
		}else{
			$sql = "SELECT ".$fields." FROM ".$this->tableName." WHERE id=". $this->id;
		}
		return $this->mysql->getRows($sql);	
	}
	
	public function execute($request = null){
		if(is_null($request)){
			return $this->fetchAll();
		}else{
			return $this->mysql->getRows($request); 
		}
	}
	
	public function find($fields = null,$params = null, $use = null){
		try{
			$tableToUse = $this->tableName;
			
			if($use!=null){
				$tableToUse = $this->table_preffix.$use;
			}
			
			if(is_array($fields) and !empty($fields)){
				$req = "SELECT * FROM ".$tableToUse;
				if(is_array($params) and !empty($params)){
					$params = $fields;
				}
			}else{
				$fields = ($fields==null)?"*":($fields=="all")?"*":$fields;
				$req = "SELECT ".$fields." FROM ".$tableToUse;
			}
			$reqTemp = "";
			if(is_array($params) and !empty($params)){
				foreach($params as $k=>$v){
					if ($k == "conditions" OR $k == "conditions OR" OR $k == "conditions AND"){
						$reqTemp="";
						$p = explode(" ",$k);
						if(count($p) == 0){
							foreach($v as $k1=>$v1){
								$reqTemp .= ($reqTemp=="")?" WHERE ".$k1."'".$v1."'":" AND ".$k1."'".$v1."'";
							}
						}else{
							foreach($v as $k1=>$v1){
								$reqTemp .= ($reqTemp=="")?" WHERE ".$k1."'".$v1."'":" " . $p[1] . " ".$k1."'".$v1."'";
							}
						}

						$req.=$reqTemp;
					}
					if ($k == "order"){
						$reqTemp="";
						$reqTemp .= " ORDER BY ".$v;
						$req.=$reqTemp;
					}
					if ($k == "limit"){
						$reqTemp="";
						foreach($v as $k1=>$v1){
							$reqTemp .= ($reqTemp=="")?" LIMIT ".$v1:" , ".$v1;
						}$req.=$reqTemp;
					}
				}
			}return $this->mysql->getRows($req); 	
		}catch(Exception $e){
			$this->isError = 1;
		}
	}

	public function save($data, $tableName=null, $force_add=null){
		try{
			if(isset($data["id"]) && !empty($data["id"]) && $force_add===null){
				if($tableName===null){
					$sql = "UPDATE ".$this->tableName." SET";
				}else{
					$sql = "UPDATE ".$tableName." SET";
				}
				
				foreach($data as $k=>$v){
					if($k != "id"){
						$sql.=" ".$k."='".$v."',";	
					}
				}
				$sql = substr($sql,0,-1);
				$sql.= " WHERE id=".$data['id'];
			}else{
				if($tableName===null){
					$sql = "INSERT INTO ".$this->tableName."(";	
				}else{
					$sql = "INSERT INTO ".$tableName."(";	
				}
				
				foreach($data as $k=>$v){
					$sql.= $k.",";	
				}
				$sql = substr($sql,0,-1);
				$sql.=") VALUES(";
				foreach($data as $k=>$v){
					$sql.="'".$v."',";	
				}
				$sql = substr($sql,0,-1);
				$sql.=")";
			}
			//echo $sql;
			return $this->mysql->insertRow($sql);
		}catch(Exception $e){
			echo $e->getMessage(); echo "<br>".$sql;
		}
	}

	public function delete($id,$tName=null){
		try{
			if($id != "" && $id != null){
				if($tName != "" && $tName != null){
					$sql = "DELETE FROM ".$this->table_preffix.$tName." WHERE id=".$id;
				}else{
					$sql = "DELETE FROM ".$this->tableName." WHERE id=".$id;
				}
			}
			return $this->mysql->insertRow($sql);
		}catch(Exception $e){
			$this->err->save($this->tableName." -> Delete",$e->getMessage(),$sql);
		}
	}	

	public function getLastID(){
		try{
			$req = "SELECT id as lastID FROM ".$this->tableName." ORDER BY id DESC";
			$id = $this->mysql->getRows($req);
			if(count($id)>0){
				return $id[0]["lastID"];
			}else{
				return 0;
			}
		}catch(Exception $e){
			$this->err->save($this->tableName." -> getLastID",$e->getMessage(),$req);
		}		
	}

	public function getTotalItems(){
		try{
			$req = "SELECT id FROM ".$this->tableName;
			return count($this->mysql->getRows($req));
			
		}catch(Exception $e){
			die($e->getMessage());
		}
	}

	public function strFilter($string){
		$string = str_replace("/","",$string);
		$string = str_replace("'","",$string); 
		$string = str_replace("=","",$string); 
		$string = str_replace("\\","",$string); 
		$string = str_replace(",","",$string);
		$string = str_replace("script","",$string);
		$string = str_replace("<","",$string);
		$string = str_replace(">","",$string);	
		
		return $string;	
	}

	function saveActivity($lang, $id_user, $code, $id_module, $notes=null){
		$activity = Util::getActionByCode($lang, $code[0]);
		$notes = ($notes === null)? "": " (".$notes.")";
		$data = array(
			"created_by"			=>	$id_user,
			"activity_action"		=>	$activity[$code[1]]["title"],
			"activity_module_id"	=>	$id_module,
			"activity_message"		=>	addslashes($activity[$code[1]]["message"].$notes),
			"activity_ip"			=>  Util::getIP(),
			"module"				=>	$code[0],
			"created"				=>	date("Y-m-d H:i:s")
		);
		$this->save($data, "person_activity");
	}
	
	public function format($number = 0, $show_currency=true){
		$currency = $this->params["GENERAL"]["CURRENCY"];
		if($show_currency){
			return number_format($number,2,",",".")." ".$currency;
		}else{
			return number_format($number,2,",",".");
		}
	}
	
	public function drawTable($args = null, $conditions = null, $useTableName = null){

		$showPerPage = array("20","50","100","200","500","1000");
		$is_default = array(
			0	=>	"", 
			1	=>	"<div style='background-color:#3E2723; color:white; border-radius:5px; padding:3px 7px 2px 5px; width:70px; font-size:10px'> <i class='fas fa-dot-circle'></i> Default </div>");
		
		$status = array(
			0	=>	"<div class='label label-red'>Désactivé</div>", 
			1	=>	"<div class='label label-green'>Activé</div>");
		
		$remove_sort = array("actions","nbr");
		
		
		$p_p = (isset($args['p_p']))? $args['p_p']: $showPerPage[0];
		$current = (isset($args['current']))? $args['current']: 0;
		$sort_by = (isset($args['sort_by']))? $args['sort_by']: "created";
		
		$temp = explode(" ", $sort_by );
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
		
		$t = explode("_",$this->tableName);
		$_t = "";
		foreach ($t as $k=>$v){
			$_t .= ($_t==="")? ucfirst($v): "_".ucfirst($v) ;
		}
		
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
		$background = (isset($v["color"]))? $v["color"]: "";
		$returned .= '					<tr style="background-color:'.$background.'" data-page="'.$_t.'">';
			foreach($columns as $key=>$value){
				$is_display = ( isset($value["display"]) )? ($value["display"])? "" : "hide" : "";
				$style = (isset($columns[$key]["style"]))? $columns[$key]["style"]:"";
				
				if(isset($v[ $columns[$key]["column"] ])){
					if($columns[$key]["column"] == "id"){
						$returned .= "<td class='".$is_display."' style='".$style."'><span class='id-ligne'>" . $v[ $columns[$key]["column"] ] . "</span></td>";
					}elseif($columns[$key]["column"] == "status"){
						$returned .= "<td class='".$is_display."' style='".$style."'>" . $status[ $v["status"] ] . "</td>";
					}elseif($columns[$key]["column"] == "is_default"){
						$returned .= "<td class='".$is_display."' style='".$style."'>" . $is_default[ $v["is_default"] ] . "</td>";
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
					if($columns[$key]["column"] === "actions"){
						$returned .=   "<td style='".$style."'><button style='margin-right:10px' data-page='".$_t."' class='btn btn-red remove_ligne' value='".$v["id"]."'><i class='fas fa-trash-alt'></i></button><button data-page='".$_t."' class='btn btn-orange edit_ligne' value='".$v["id"]."'><i class='fas fa-edit'></i></button></td>";												
					}elseif($columns[$key]["column"] === "nbr"){
						$returned .=  "<td class='".$is_display."' style='".$style."'>0</td>";
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
		$returned .= '		</div>';
		$returned .= '	</div>';
		$returned .= '</div>';
		echo $returned;

	}

	
}

//$modal = new Modal;

