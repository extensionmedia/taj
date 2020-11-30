<?php if (session_status() == PHP_SESSION_NONE) { session_start(); } 

$core = $_SESSION["CORE"];
$table_name = "Location";
require_once($core.$table_name.".php");  
$ob = new $table_name();
$envirenment = $ob->config->get()["GENERAL"]["ENVIRENMENT"];
unset($_SESSION[$envirenment]["LOCATION"]);
unset($_SESSION[$envirenment]["first_step"]);
//var_dump($_SESSION);
?>

	<div class="row page_title">
		<div style="display: flex; justify-content:flex-end">
			<div class="icon" style="margin-right: auto"><i class="fas fa-person-booth"></i> Location(s)</div>
			<div class="actions">
				<button class="btn btn-green add_check" value="<?= $table_name ?>"><i class="fas fa-plus" aria-hidden="true"></i> Ajouter</button>
				<button class="btn btn-default refresh" value="<?= $table_name ?>"><i class="fas fa-sync-alt"></i></button>
				<button class="btn btn-orange showSearchBar"><i class="fas fa-search-plus"></i></button>
			</div>			
		</div>		
	</div>
	<hr>
	<div class="row searchBar hide" style="background-color: rgba(241,241,241,1.00); padding: 10px 0; margin: 10px 0px">
		<div class="col_6-inline">

			<div class="input-group" style="overflow: hidden">
				<input type="text" placeholder="Chercher" class="suf" name="" id="request">
				<div class="input-suf"><button title="Chercher" id="a_u_s"><i class="fa fa-search"></i></button></div>
			</div>

		</div>
		<div class="col_6-inline">

			<div class="row _select">
				<div class="col_6-inline">
					<select id="vehicule_marque" data="marque">
						<option selected value="-1"> --  Magasin  -- </option>
							<?php  
								foreach( $ob->find("", array("conditions" => array("status="=>1) ), "magasin") as $k=>$v){
							?>	
						<option value="<?= $v["id"] ?>"> <?= $v["magasin_name"]  ?> </option>;
							<?php } ?>
					</select>
				</div>
				<div class="col_6-inline">
					<select id="location_status" data="location_status">
						<option selected value="-1"> --  Status  -- </option>
							<?php  
								foreach( $ob->find("", array("order"=>"location_status asc" ), "location_status") as $k=>$v){
							?>	
						<option value="<?= $v["location_status"] ?>"> <?= $v["location_status"] ?> </option>;
							<?php } ?>
					</select>
				</div>
			</div>



		</div>

		<div class="col_12 _choices" style="padding-top: 15px"></div>
	</div>
	
	<div class="row <?= strtolower($table_name) ?>">
	<?php
		$args = array(
			"column_name"		=>		"v_location",
			"sort_by"			=>		"created desc",
			"style"				=>		"list",
					 );
		$args = ( isset($_SESSION["REQUEST"][$table_name]["args"]) )? $_SESSION["REQUEST"][$table_name]["args"]: $args;
		echo $ob->drawTable($args,null,"v_location");
	?>
		
	</div>
		
	<div class="debug"></div>
