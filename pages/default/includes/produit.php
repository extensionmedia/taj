<?php if (session_status() == PHP_SESSION_NONE) { session_start(); } 

$core = $_SESSION["CORE"];
$table_name = "Produit";
require_once($core.$table_name.".php");  
$ob = new $table_name();
?>

<div class="row page_title">
	<div class="col_6-inline icon">
		<i class="fas fa-tshirt"></i> Produit
	</div>
	<div class="col_6-inline actions">
		<button class="btn btn-green add" value="<?= $table_name ?>"><i class="fas fa-plus" aria-hidden="true"></i></button>
		<button class="btn btn-default refresh" value="<?= $table_name ?>"><i class="fas fa-sync-alt"></i></button>
		<button class="btn btn-orange showSearchBar"><i class="fas fa-search-plus"></i></button>
	</div>
</div>
<hr>
<div class="row searchBar" style="background-color: rgba(241,241,241,1.00); padding: 10px 0; margin: 10px 0px">
	<div class="col_4">

		<div class="input-group" style="overflow: hidden; margin-top: 10px">
			<input type="text" placeholder="Chercher" class="suf" name="" id="request">
			<div class="input-suf"><button title="Chercher" id="a_u_s" class="_propriete" data="_request"><i class="fa fa-search"></i></button></div>
		</div>

	</div>
	<div class="col_8">

		<div class="row _select" style="margin-top: 10px">
			<div class="col_2-inline">
				<select data="magasin">
					<option selected value="-1"> --  Magasin  -- </option>
						<?php require_once($core."Magasin.php"); 
							foreach( $magasin->find("", array("conditions" => array("status="=>1) ), "") as $k=>$v){
						?>	
					<option value="<?= $v["id"] ?>"> <?= $v["magasin_name"] ?> </option>
						<?php } ?>
				</select>
			</div>
			<div class="col_2-inline">
				<select data="fournisseur">
					<option selected value="-1"> --  Fournisseur  -- </option>
						<?php require_once($core."Fournisseur.php"); 
							foreach( $fournisseur->find("", array("conditions" => array("status="=>1) ), "") as $k=>$v){
						?>	
					<option value="<?= $v["id"] ?>"> <?= $v["fournisseur_name"] ?> </option>
						<?php } ?>
				</select>
			</div>
			<div class="col_3-inline">
				<select data="category">
					<option selected value="-1"> --  Catégorie  -- </option>
						<?php require_once($core."Produit_Category.php"); 
							foreach( $produit_category->find("", array("conditions" => array("status="=>1) ), "") as $k=>$v){
						?>	
					<option value="<?= $v["id"] ?>"> <?= $v["produit_category"] ?> </option>
						<?php } ?>
				</select>
			</div>
			<div class="col_1-inline">
				<select data="type">
					<option selected value="-1"> --  Type  -- </option>
						<?php require_once($core."Produit_Type.php"); 
							foreach( $produit_type->find("", array(), "produit_type") as $k=>$v){
						?>	
					<option value="<?= $v["id"] ?>"> <?= $v["produit_type"] ?> </option>
						<?php } ?>
				</select>
			</div>
			<div class="col_1-inline">
				<select data="status">
					<option selected value="-1"> --  Status  -- </option>
						<?php require_once($core."Produit_Status.php"); 
							foreach( $produit_status->find("", array(), "produit_status") as $k=>$v){
						?>	
					<option value="<?= $v["id"] ?>"> <?= $v["produit_status"] ?> </option>
						<?php } ?>
				</select>
			</div>
			<div class="col_1-inline">
				<select data="color">
					<option selected value="-1"> --  Couleur  -- </option>
						<?php require_once($core."Produit_Color.php"); 
							foreach( $produit_color->find("", array(), "produit_color") as $k=>$v){
						?>	
					<option value="<?= $v["id"] ?>"> <?= $v["produit_color"] ?> </option>
						<?php } ?>
				</select>
			</div>
			<div class="col_2-inline">
				<select data="marque">
					<option selected value="-1"> --  Marque  -- </option>
						<?php require_once($core."Produit_Marque.php"); 
							foreach( $produit_marque->find("", array(), "produit_marque") as $k=>$v){
						?>	
					<option value="<?= $v["id"] ?>"> <?= $v["produit_marque"] ?> </option>
						<?php } ?>
				</select>
			</div>
		</div>



	</div>

	<div class="col_12 _choices" style="padding-top: 15px"></div>
</div>
<div class="row <?= $table_name ?>">
	<?php 

	$args = array(
		"column_name"		=>		"v_produit",
		"sort_by"			=>		"code ASC",
		"style"				=>		"list",
				 );
	$args = ( isset($_SESSION["REQUEST"][$table_name]["args"]) )? $_SESSION["REQUEST"][$table_name]["args"]: $args;
	$ob->drawTable($args, null, "v_produit"); ?>		
</div>


<div class="debug"></div>
