<?php if (session_status() == PHP_SESSION_NONE) { session_start(); } 

$core = $_SESSION["CORE"];
$table_name = "Person_Activity";
require_once($core.$table_name.".php");  
$ob = new $table_name();
?>

<div class="row page_title">
	<div class="col_6-inline icon">
		<i class="fas fa-address-card"></i> Activité(s)
	</div>
	<div class="col_6-inline actions">
		<button class="btn btn-default refresh" value="<?= $table_name ?>"><i class="fas fa-sync-alt"></i></button>
		<button class="btn btn-orange showSearchBar"><i class="fas fa-search-plus"></i></button>
	</div>
</div>
<hr>
<div class="row searchBar hide" style="background-color: rgba(241,241,241,1.00); padding: 10px 0; margin: 10px 0px">
	<div class="col_6">

		<div class="input-group" style="overflow: hidden; margin-top: 10px">
			<input type="text" placeholder="Chercher" class="suf" name="" id="request">
			<div class="input-suf"><button title="Chercher" id="a_u_s" class="_propriete" data="_request"><i class="fa fa-search"></i></button></div>
		</div>

	</div>
	<div class="col_6">

		<div class="row _select" style="margin-top: 10px">
			<div class="col_3-inline">
				<select id="urilisateur" data="urilisateur">
					<option selected value="-1"> --  Utilisateur  -- </option>
						<?php require_once($core."Person.php"); 
							foreach( $person->find("", array(), "") as $k=>$v){
						?>	
					<option value="<?= $v["id"] ?>"> <?= $v["first_name"] . " " . $v["last_name"] ?> </option>
						<?php } ?>
				</select>
			</div>
			<div class="col_3-inline">
				<select id="action" data="action">
					<option selected value="-1"> --  Actions  -- </option>
					<option value="Ajouter"> Ajouter </option>
					<option value="Modifier"> Modifier </option>
					<option value="Supprimer"> Supprimer </option>
					<option value="Consulter"> Consulter </option>
					<option value="LogIn"> Connexion </option>
				</select>
			</div>
			<div class="col_3-inline">

			</div>
			<div class="col_3-inline">

			</div>

		</div>



	</div>

	<div class="col_12 _choices" style="padding-top: 15px"></div>


</div>

<div class="row <?= $table_name ?>">
<?= $ob->drawTable(null, null, "person_activity"); ?>		
</div>

<div class="debug"></div>
