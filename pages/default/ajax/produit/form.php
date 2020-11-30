<?php session_start(); 
if(!isset($_SESSION['CORE'])){ die("-1"); }
if(!isset($_POST["page"])){ die("-2"); }

$core = $_SESSION['CORE']; 
$action = "add";
$table_name = $_POST["page"];

if(!file_exists($core.$table_name.".php")){ die("-3"); }
$formToken = md5( uniqid('auth', true) );
$id = 0;

if(isset($_POST["id"])){
	require_once($core.$table_name.".php");
	$ob = new $table_name();
	$ob->id = $_POST["id"];
	$id = $_POST["id"];
	if( count( $ob->read() ) < 1){ die("-4"); }
	$data = $ob->read()[0];
	$action = "edit";
	
}


?>
<div class="row page_title">
	<div class="col_6-inline icon">
		<i class="fas fa-tshirt"></i> Produit(s) <span style="font-size: 9px"><?= ($action === "edit")? "<span style='color:red'>" . $data["code"] . "</span>" : substr($formToken,0,8) ?></span>
	</div>
	<div class="col_6-inline actions">
		<button class="btn btn-green save_form <?= ($action === "edit")? "edit" : "" ?>" data-table="<?= $table_name ?>"><i class="fas fa-save"></i></button>
		<button class="btn btn-default close" value="<?= $table_name ?>"><i class="fas fa-times"></i></button>
	</div>
</div>
<hr>

<div class="panel">
	<div class="panel-header" style="padding: 0px">
		<div class="panel-header-tab ">
			<a href="" class="active"><i class="fas fa-file-invoice"></i> Détails</a>
			<a href=""><i class="far fa-clock"></i> Location</a>
			<a  href="" class="show_files produit" data="<?= ($action === "edit")? $data["UID"] : substr($formToken,0,8) ?>"><i class="fas fa-images"></i> Images</a>
		</div>
	</div>
	<div class="panel-content" style="padding: 0px">
		<div class="tab-content">
			<div class="row  <?= strtolower($table_name) ?>" style="margin-top: 25px">
				<?= ($action === "edit")? "<input class='form-element' type='hidden' id='id' value='".$id."'>" : "" ?>
				<input class='form-element' type='hidden' id='UID' value='<?= ($action === "edit")? $data["UID"] : substr($formToken,0,8) ?>'>
				
				<div class="row" style="margin-bottom: 20px">
					<div class="col_6-inline">
						<label for="code">Code :</label>
						<input type="text" id="code" placeholder="Code Produit" class="form-element required" value="<?= ($action === "edit")? $data["code"] : "" ?>">
					</div>				
					<div class="col_6-inline">
						<label for="date_reception">Date Reception :</label>
						<input type="date" id="date_reception" placeholder="jj/mm/aaaa" class="form-element required" value="<?= ($action === "edit")? date('Y-m-d', strtotime($data["date_reception"])) : date('Y-m-d') ?>">
					</div>
				</div>
				
				<div class="row" style="margin-bottom: 20px">

					<div class="col_3-inline">
						<label for="barcode">Code A Barre (A):</label>
						<input type="text" id="barcode" placeholder="barcode" class="form-element" value="<?= ($action === "edit")? $data["barcode"] : "" ?>">
					</div>
					<div class="col_3-inline">
						<label for="barcode_2">Code A Barre (B):</label>
						<input type="text" id="barcode_2" placeholder="barcode (2)" class="form-element" value="<?= ($action === "edit")? $data["barcode_2"] : "" ?>">
					</div>
					<div class="col_2-inline">
						<label for="id_marque">Marque :</label>
						<select id="id_marque" class="form-element">
							<option selected value="-1"></option>
							<?php 
								require_once($core."Produit_Marque.php");
								foreach($produit_marque->find(null, array("conditions"=>array("status="=>1), "order"=>"produit_marque"), null) as $k=>$v){
							?>
							<option <?= ($action === "edit")? ($v["id"] === $data["id_marque"])? "selected" : "" : ($v["is_default"])? "selected" : "" ?>  value="<?= $v["id"] ?>"> <?= $v["produit_marque"] ?> </option>
							<?php } ?>
						</select>
					</div>
					<div class="col_2-inline">
						<label for="id_color">Couleur :</label>
						<select id="id_color" class="form-element">
							<option selected value="-1"></option>
							<?php 
								require_once($core."Produit_Color.php");
								foreach($produit_color->find(null, array("conditions"=>array("status="=>1), "order"=>"produit_color"), null) as $k=>$v){
							?>
							<option <?= ($action === "edit")? ($v["id"] === $data["id_color"])? "selected" : "" : ($v["is_default"])? "selected" : "" ?>  value="<?= $v["id"] ?>"> <?= $v["produit_color"] ?> </option>
							<?php } ?>
						</select>
					</div>
					<div class="col_2-inline">
						<label for="taille">Taille :</label>
						<input type="number" id="taille" class="form-element required" placeholder="Taille" value="<?= ($action === "edit")? $data["taille"] : "" ?>">
					</div>
				</div>
				
				<div class="row" style="margin-bottom: 20px">
					<div class="col_12-inline">
						<label for="libelle">Libelle :</label>
						<input type="text" id="libelle" placeholder="Produit Designation" class="form-element required" value="<?= ($action === "edit")? $data["libelle"] : "" ?>">
					</div>
				</div>
				<div class="row" style="margin-bottom: 20px">
					<div class="col_3-inline">
						<label for="id_produit_category">Catégorie</label>
						<select id="id_produit_category" class="form-element">
							<option selected value="-1"></option>
							<?php 
								require_once($core."Produit_Category.php");
								foreach($produit_category->find(null, array("conditions AND"=>array("status="=>1,"id_parent<"=>1), "order"=>"produit_category"), null) as $k=>$v){
							?>
							<option <?= ($action === "edit")? ($v["id"] === $data["id_produit_category"])? "selected" : "" : "" ?>  value="<?= $v["id"] ?>"> <?= $v["produit_category"] ?> </option>
							<?php } ?>
						</select>
					</div>	
					<div class="col_3-inline">
						<label for="id_produit_sous_category">Sous Catégorie</label>
						<select id="id_produit_sous_category" class="form-element">
							<option selected value="-1"></option>
							<?php 
								require_once($core."Produit_Category.php");
								foreach($produit_category->find(null, array("conditions AND"=>array("status="=>1,"id_parent>"=>0), "order"=>"produit_category"), null) as $k=>$v){
							?>
							<option <?= ($action === "edit")? ($v["id"] === $data["id_produit_category"])? "selected" : "" : "" ?>  value="<?= $v["id"] ?>"> <?= $v["produit_category"] ?> </option>
							<?php } ?>
						</select>
					</div>
					<div class="col_3-inline">
						<label for="id_produit_type">Type</label>
						<select id="id_produit_type" class="form-element">
							<option selected value="-1"></option>
							<?php 
								require_once($core."Produit_Type.php");
								foreach($produit_type->find(null, array("conditions"=>array("status="=>1), "order"=>"produit_type"), null) as $k=>$v){
							?>
							<option <?= ($action === "edit")? ($v["id"] === $data["id_produit_type"])? "selected" : "" : ($v["is_default"])? "selected" : "" ?>  value="<?= $v["id"] ?>"> <?= $v["produit_type"] ?> </option>
							<?php } ?>
						</select>
					</div>
					<div class="col_3-inline">
						<label for="id_produit_status">Status</label>
						<select id="id_produit_status" class="form-element">
							<option selected value="-1"></option>
							<?php 
								require_once($core."Produit_Status.php");
								foreach($produit_status->find(null, array("conditions"=>array("status="=>1), "order"=>"produit_status"), null) as $k=>$v){
							?>
							<option <?= ($action === "edit")? ($v["id"] === $data["id_produit_status"])? "selected" : "" : ($v["is_default"])? "selected" : "" ?>  value="<?= $v["id"] ?>"> <?= $v["produit_status"] ?> </option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="row" style="margin-bottom: 20px">
					<div class="col_3-inline">
						<label for="qte">Qté.</label>
						<input type="number" class="form-element required" value="<?= ($action === "edit")? $data["qte"] : "0" ?>" id="qte">
					</div>	
					<div class="col_3-inline">
						<label for="prix_achat">Prix Achat</label>
						<input type="number" class="form-element required" value="<?= ($action === "edit")? $data["prix_achat"] : "0.00" ?>" id="prix_achat">
					</div>
					<div class="col_3-inline">
						<label for="prix_location">Prix Location</label>
						<input type="number" class="form-element required" value="<?= ($action === "edit")? $data["prix_location"] : "0.00" ?>" id="prix_location">
					</div>
					<div class="col_3-inline">
						<label for="prix_vente">Prix Vente</label>
						<input type="number" class="form-element required" value="<?= ($action === "edit")? $data["prix_vente"] : "0.00" ?>" id="prix_vente">
					</div>
				</div>
				
				<div class="row">
					<div class="col_6">
						<div class="row" style="margin-bottom: 20px; border-bottom: 1px solid rgba(197,197,197,1.00)">
							<div class="col_12-inline">
								<h3>Fournisseur</h3>					
							</div>
						</div>
						<div class="row" style="margin-bottom: 20px;">
							<div class="col_12">
								<select id="id_fournisseur" class="form-element">
									<option selected value="-1"></option>
									<?php 
										require_once($core."Fournisseur.php");
										foreach($fournisseur->find(null, array("conditions"=>array("status="=>1), "order"=>"fournisseur_name"), null) as $k=>$v){
									?>
									<option <?= ($action === "edit")? ($v["id"] === $data["id_fournisseur"])? "selected" : "" : ($v["is_default"])? "selected" : "" ?>  value="<?= $v["id"] ?>"> <?= $v["fournisseur_name"] ?> </option>
									<?php } ?>
								</select>
							</div>
						</div>					
					</div>
					
					<div class="col_6">
						<div class="row" style="margin-bottom: 20px; border-bottom: 1px solid rgba(197,197,197,1.00)">
							<div class="col_12-inline">
								<h3>Magasin</h3>					
							</div>
						</div>
						<div class="row" style="margin-bottom: 20px;">
							<?php 

								require_once($core."Magasin.php");
								if($action === "add"){
									foreach($magasin->fetchAll() as $k=>$v){
										if($v["is_default"]){
											echo "<div class='col_12'><label><input data-table='magasin' class='form-element collection' checked type='checkbox' value='".$v['id']."'>".$v["magasin_name"]." <span style='font-size:10px; font-weight:bold; color:blue'>[default]</span></label></div>";
										}else{
											echo "<div class='col_12'><label><input data-table='magasin' class='form-element collection' type='checkbox' value='".$v['id']."'>".$v["magasin_name"]."</label></div>";
										}	
									}
								}else{
									$options = $magasin->find("",array("conditions"=>array("id_produit="=>$data["id"])),"produit_of_magasin");
									$options = (is_null($options))? array() : $options;
									$allOptions = $magasin->fetchAll();	
									$isExist = false;
									foreach($allOptions as $k=>$v){
										$isExist = false;
										foreach($options as $kk=>$vv){
										if($v["id"] == $vv["id_magasin"]){
											$isExist = true;
										}

										}
										if($isExist){
											echo "<div class='col_12'><label><input data-table='magasin' class='form-element collection' checked type='checkbox' value='".$v['id']."'>".$v["magasin_name"]."</label></div>";
										}else{
											echo "<div class='col_12'><label><input data-table='magasin' class='form-element collection' type='checkbox' value='".$v['id']."'>".$v["magasin_name"]."</label></div>";
										}	


									}							
								}

							?>
						</div>
					</div>
					
				</div>
				
				<div class="row" style="margin-bottom: 20px; border-bottom: 1px solid rgba(197,197,197,1.00)">
					<div class="col_12-inline">
						<h3 style="margin-left: 6px">NOTES</h3>					
					</div>
				</div>
				<div class="row" style="margin-bottom: 20px;">
					<div class="col_12">
						<textarea class="form-element" id="notes" style="max-width: 100%; height: 150px"><?= ($action === "edit")? $data["notes"] : "" ?></textarea>					
					</div>

				</div>
			</div> <!-- ROW-->		
		</div>

		<div class="tab-content" style="display: none">
			<div class="location_form">
				<div class="row">
					<div class="col_4-inline">
						<h3 style="margin-left: 6px">Location</h3>
					</div>
					<div class="col_8-inline" style="text-align: right; padding: 10px 5px">
						<button class="btn btn-green add_location" value="0"><i class="fas fa-plus-square"></i> Ajouter</button>
						<button class="btn btn-default refresh_location" value="0"><i class="fas fa-sync-alt"></i></button>
					</div>
				</div>
			</div>
		</div>

		<div class="tab-content" style="display: none" >
			<div class="row upload">
				<div class="col_4-inline">
					<h3>Images</h3>
				</div>

				<div class="col_8-inline" style="text-align: right; padding-top: 10px">
					<button class="btn btn-orange upload_btn" style="position: relative; overflow: hidden">
					<i class="fas fa-upload"></i> Choisir
					<input type="file" id="upload_file_produit" data="<?= ($action === "edit")? $data["UID"] : substr($formToken,0,8) ?>" class="" name="image" capture style="position: absolute; z-index: 9999; top: 0; left: 0; background-color: aqua; padding: 10px 0; opacity: 0">
					</button>	
					<button class="btn btn-blue show_files produit" value="<?= ($action === "edit")? $data["UID"] : substr($formToken,0,8) ?>"> Actualiser </button>					
				</div>

				<div class="col_12">
					<div id="progress" class="progress hide"><div id="progress-bar" class="progress-bar"></div></div>
				</div>
			</div>

			<div class="show_files_result"></div>
		</div>

	</div>	<!-- END PANEL CONTENT -->

</div>

<div class="debug"></div>

