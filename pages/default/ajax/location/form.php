<?php session_start(); 
if(!isset($_SESSION['CORE'])){ die("-1"); }
if(!isset($_POST["page"])){ die("-2"); }
$core = $_SESSION['CORE']; 
$action = "add";
$table_name = $_POST["page"];
if(!file_exists($core.$table_name.".php")){ die("-3"); }
$formToken = md5( uniqid('auth', true) );
$id = 0;
require_once($core.$table_name.".php");
$ob = new $table_name();
if(isset($_POST["id"])){

	$id = $_POST["id"];
	$data_temp = $ob->find(null, array("conditions"=>array("id="=>$id)), "v_location");
	
	if( count( $data_temp ) < 1){ die("-4"); }
	$data = $data_temp[0];
	$action = "edit";
	
}else{
	$envirenment = $ob->config->get()["GENERAL"]["ENVIRENMENT"];
	$temp_location = $_SESSION[$envirenment]["first_step"];
}

?>
<div class="row page_title">
	<div class="col_6-inline icon">
		<i class="fas fa-person-booth"></i> Location(s)
		<div style="font-size: 10px;color: rgba(17,68,148,1.00); text-transform: lowercase"> <span class="UID"><?= ($action==="edit")? $data["UID"]: $formToken ?></span></div>
	</div>
	<div class="col_6-inline actions">
		<?php 
	if($action === "edit"){
		echo '<button class="btn btn-red remove_ligne and_exit"  value="' . $id . '" data-page="' . $table_name . '"><i class="fas fa-trash-alt"></i> Supprimer</button>';
	}
		?>
		<button class="btn btn-green save_form_location <?= ($action === "edit")? "edit" : "" ?>" data-id="<?= $id ?>" data-table="<?= $table_name ?>"><i class="fas fa-save"></i> Enregistrer</button>
		<button class="btn btn-default close" value="<?= $table_name ?>"><i class="fas fa-times"></i></button>
	</div>
</div>
<hr>

<div class="row">
	
	<div class="col_4">
		<!-- Date -->
		<div class="row">
			<div class="col_12" style="margin-bottom: 9px">
				<div class="panel" style="background-color: #FFEBEE">
					<div class="panel-header">
						<i class='fas fa-calendar-week'></i> Date 
						<div class="panel-header-actions">
							<button class="first_step_edit"><i class="far fa-edit"></i></button>
						</div>
					</div>
					
					<div class="panel-content" style="padding: 7px">
						<div class="row">
							<div class="col_6-inline" style="padding: 0">
								<div class="row">
									<div class="col_12" style="padding: 0">
										<input readonly type="date" id="date_debut" data-date-format='YYYY-MM-DD' placeholder='AAAA-MM-DD' value='<?= $action === "edit"? $data["date_debut"]: $temp_location["date_debut"] ?>'>
									</div>
									<div class="col_12" style="padding: 0">
										<input readonly type="date" id="date_fin" data-date-format='YYYY-MM-DD' placeholder='AAAA-MM-DD' value='<?= $action === "edit"? $data["date_fin"]: $temp_location["date_fin"] ?>'>
									</div>
								</div>
							</div>
							<div class="col_6-inline" style="padding: 0">
								<div id="nbr_jours" style="height: 65px; line-height: 65px; color: white; background-color: #6C6C6C; text-align: center; font-size: 35px; font-weight: bold; border-radius: 7px"><?= $action === "edit"? $data["nbr_jours"]: $temp_location["nbr_jours"] ?></div>
							</div>
						</div>
						<div class="hide" id="id_location_status"><?= $action === "edit"? 0: $temp_location["id_status"] ?></div>
						<div class="row" style="padding: 0px">
							<div class="col_12" style="padding: 0px">
								<?php 
									if($action === "edit"){
										$status = $ob->find("", array("conditions"=>array("id_location="=>$id),"order"=>"date_status"), "v_status_of_location");
										echo '<table class="table status"><tbody>';
										foreach($status as $k=>$v){
											echo '<tr style="height:45px; background-color:'.$v["location_status_color"].'"><td style="width:95px; min-width:65px">'.$v["date_status"].'</td><td>'.$v["location_status"].'</td><td style="width:55px; min-width:55px;"><div class="label label-default">'.$v["USR"].'</div></td></tr>';
										}
										echo '</tbody></table>';

									}else{
										echo '<table class="table status"><tbody>';
										echo '<tr style="height:45px; background-color:'.$temp_location["color"].'"><td style="width:95px; min-width:65px">'.date("Y-m-d").'</td><td>'. strtoupper($temp_location["location_status"]).'</td></tr>';
										echo '</tbody></table>';
									}
								?>			
							</div>				
						</div>
						
					</div>
				</div>
			</div>
		</div>
	
		<!-- Client -->
		<div class="row">
			<div class="col_12" style="margin-bottom: 9px">
				<div class="panel" style="background-color: #E1F5FE">
					<div class="panel-header"><i class="fas fa-restroom"></i> Client</div>
					<div class="panel-content" style="padding: 7px">
						<div class="row">
							<div class="col_12">
								<div class="form-group-inline" style="width: 100%">
									<div class="element-1"><i class="far fa-user"></i></div>
									<div class="element-2">
										<input type="text" placeholder="Client" id="client" value="<?= $action === "edit"? $data["client"]: "" ?>">
									</div>
									<br clear="all">
								</div>				
							</div>				
						</div>

						<div class="row">
							<div class="col_12">
								<div class="form-group-inline" style="width: 100%">
									<div class="element-1"><i class="fas fa-mobile-alt"></i></div>
									<div class="element-2">
										<input type="text" placeholder="+212661098984" id="telephone" value="<?= $action === "edit"? $data["client_telephone"]: "" ?>">
									</div>
									<br clear="all">
								</div>				
							</div>				
						</div>

						<div class="row">
							<div class="col_12">
								<div class="form-group-inline" style="width: 100%">
									<div class="element-1"><i class="far fa-question-circle"></i></div>
									<div class="element-2">
										<input type="text" placeholder="Remarques" id="remarques" value="<?= $action === "edit"? $data["notes"]: "" ?>">
									</div>
									<br clear="all">
								</div>				
							</div>				
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</div>
	
	<div class="col_8">
		<!-- PRODUITS -->
		<div class="row" style="">
			<div class="col_12">
				<div class="panel">
					<div class="panel-header">
						<div class="row" style="line-height: 35px">
							<div class="col_6">
								Produits
							</div>
							<div class="col_6" style="text-align: right; margin-top: 4px">
								<div class="btn-group-radio style">
									<button class="btn btn-default checked" value="list" style="padding:4px 15px; font-size:18px"><i class="fas fa-list"></i></button>
									<button class="btn btn-default" value="grid" style="padding:4px 15px; font-size:18px"><i class="fas fa-th"></i></button>	
								</div>
								
								<div class="btn-group">
									<button class="btn btn-default location_refresh <?= $action==="edit"? "edit": "" ?>" style="padding: 6px 7px" value="<?= ($action==="edit")? $data["UID"]: $formToken ?>"><i class="fas fa-sync-alt"></i></button>
								</div>
							</div>
						</div>
					</div>
					
					<div class="panel-content" style="padding: 0">
						<div class="row" style="padding: 0; margin: 0">
							<div class="col_12 location_list"  style="padding: 0; margin: 0">
								<table class="table">
									<thead>
										<tr>
											<th class="hide">ID</th>
											<th>CODE</th>
											<th style="text-align: left">LIBELLE</th>
											<th style="width:102px; max-width:102px; text-align:right">PRIX</th>
											<th style="width:70px; max-width:70px"></th>
										</tr>
									</thead>
									<?php
										if($action==="edit"){
											$status = $ob->find("", array("conditions"=>array("id_location="=>$id)), "v_location_detail");
											$total = 0;
											echo '<tbody>';

											$envirenment = $ob->config->get()["GENERAL"]["ENVIRENMENT"];
											if(isset($_SESSION[$envirenment]["first_step"])) unset($_SESSION[$envirenment]["first_step"]);

											$_SESSION[$envirenment]["first_step"] = $status;

											foreach($status as $k=>$v){
												echo '	<tr class="_produit">
															<td class="hide produit_id">'.$v["id"].'</td>
															<td style="width:102px; max-width:102px;">'.$v["code"].'<div style="font-size:8px; color:red"><i class="fas fa-barcode"></i> '.$v["barcode"].'</div></td>
															<td>'.$v["libelle"].' <span style="font-size:10px; font-weight:bold; color:black">Taille : '.$v["taille"].'</span></td>
															<td style="width:102px; max-width:102px;"><input class="produit_prix_location" style="text-align:right" type="number" value="'.$v["prix_location"].'"></td>
															<td style="width:70px; max-width:70px"><div class="on_off on"></div></td>
														</tr>';
												$total += $v["prix_location"];
											}
											$UID = ($action==="edit")? $data["UID"]: $formToken;
												echo '	<tr>
															<td colspan="6" style="padding:10px 7px;"> 
																<div style="position:relative; width:100%; height:45px; line-height:45px; text-align:center">
																	<button class="btn btn-default location_add_produit" value="' . $UID . '"><i class="fas fa-search-plus"></i> Ajouter Produits </button>
																</div>
															</td>
														</tr>';
												echo '	<tr>
															<td colspan="6" style="text-align:right; font-size:24px; padding:10px 7px; background-color: white ; color:#015A5D; font-weight:bold"> <div class="total_location" data-value="'.$total.'">  Total : '.$ob->format($total).' </div></td>
														</tr>';
											echo '</tbody></table>';
											//var_dump($_SESSION[$envirenment]["first_step"]);
										}else{
									?>
									<tbody>
										<tr>
											<td colspan="6" style="padding:10px 7px;"> 
												<div style="position:relative; width:100%; height:45px; line-height:45px; text-align:center">
													<button class="btn btn-default location_add_produit" value="<?= ($action==="edit")? $data["UID"]: $formToken ?>"><i class="fas fa-search-plus"></i> Ajouter Produits </button>
												</div>
											</td>
										</tr>
										<tr>
											<td colspan="6" style="text-align:right; font-size:24px; padding:10px 7px; background-color: white ; color:#015A5D; font-weight:bold"> <div class="total_location" data-value='0'>  Total : 0.00 Dh </div></td>
										</tr>
									</tbody>
									<?php } ?>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>		

<div class="debug"></div>

