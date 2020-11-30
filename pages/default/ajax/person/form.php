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
		<i class="fas fa-address-card"></i> Utilisateur
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
			<a href=""><i class="far fa-clock"></i> Droit</a>
			<a  href=""><i class="fas fa-images"></i> Activités</a>
		</div>
	</div>
	<div class="panel-content" style="padding: 0px">
		<div class="tab-content">
			<div class="row <?= $table_name ?>">
				<input type="hidden" id="UID" class="form-element" value="<?= ($action === "edit")? $data["UID"] : substr($formToken,0,8) ?>">
				<?= ($action === "edit")? "<input class='form-element' type='hidden' id='id' value='".$id."'>" : "" ?>
				
				<div class="col_4" style="background-color: rgba(102,100,100,1.00); padding: 10px 0">
					<button class="show_files hide person" value="<?= ($action === "edit")? $data["UID"] : substr($formToken,0,8) ?>">show</button>
					<div class="person_image" style="max-width: 250px; margin: 0 auto; height: auto; text-align: center">
						<div class="image" style="margin: 10px 0">
							<img src="http://<?= $_SESSION["HOST"] ?>templates/default/images/user.png" style="width: 100%; height: auto">
						</div>
						
						<div class="row person_actions">
							<div class="col_6-inline">
								<button class="btn btn-orange upload_btn" style="position: relative; overflow: hidden">
								<i class="fas fa-upload"></i> Choisir
								<input type="file" id="upload_file_person" data="<?= ($action === "edit")? $data["UID"] : substr($formToken,0,8) ?>" class="" name="image" accept="image/*" capture style="position: absolute; top: 0; left: 0; background-color: aqua; padding: 10px 0; opacity: 0">
								</button>
							</div>
							<div class="col_6-inline" style="text-align: right">
								<button class="btn btn-red remove"><i class="fas fa-redo-alt"></i> Initialiser</button>
							</div>
							
							
							
						</div>						
					</div>
					<div id="progress" class="progress hide"><div id="progress-bar" class="progress-bar"></div></div>
				</div>
				
				
				
				<div class="col_8">
					<h3 style="margin-left: 6px">Fiche Utilisateur</h3>

					<div class="row" style="margin-bottom: 20px">
						<div class="col_6-inline">
							<label for="first_name">Prénom</label>
							<input type="text" id="first_name" placeholder="Prénom" class="form-element required" value="<?= ($action === "edit")? $data["first_name"]:"" ?>">
						</div>				
						<div class="col_6-inline">
							<label for="person_last_name">Nom</label>
							<input type="text" id="last_name" placeholder="Nom" class="form-element required" value="<?= ($action === "edit")? $data["last_name"]:"" ?>">
						</div>
					</div>
					<div class="row" style="margin-bottom: 20px">
						<div class="col_6-inline">
							<label for="person_profile">Profile</label>
							<select class="form-element required" id="id_profil">
								<option selected value="-1"></option>
									<?php require_once($core."Person_Profile.php"); 
										foreach( $person_profile->fetchAll() as $k=>$v){
									?>	
								<option <?= ($action === "edit")? ($v["id"] === $data["id_profil"])? "selected" : "" : ($v["is_default"])? "selected" : "" ?>  value="<?= $v["id"] ?>"> <?= $v["person_profile"] ?> </option>
									<?php } ?>
							</select>
						</div>
					</div>	


					<div class="row" style="margin-bottom: 20px; border-bottom: 1px solid rgba(197,197,197,1.00)">
						<div class="col_8-inline">
							<h3 style="margin-left: 6px">CONTACT</h3>					
						</div>
					</div>

					<div class="row" style="margin-bottom: 20px;">
						<div class="col_6-inline">
							<label for="telephone">Téléphone </label>
							<input class="form-element required" type="text" placeholder="Téléphone" id="telephone" value="<?= ($action === "edit")? $data["telephone"]:"" ?>">
						</div>	
						<div class="col_6-inline">
							<label for="email">E-Mail </label>
							<input class="form-element required" type="text" placeholder="E-Mail" id="email" value="<?= ($action === "edit")? $data["email"]:"" ?>">
						</div>	

					</div>	

					<div class="row">
						<div class="col_12">
							<div class="row" style="margin-bottom: 20px; border-bottom: 1px solid rgba(197,197,197,1.00)">
								<div class="col_12-inline">
									<h3 style="margin-left: 6px">CONNEXION</h3>					
								</div>
							</div>						
						</div>
					</div>
					<?php
						if($action === "edit"){
							$d = $ob->find(null, array("conditions"=>array("id_person="=>$id)), "person_login");
							
						}
					?>
					<div class="row" style="margin-bottom: 20px;">
						<div class="col_6-inline">
							<label for="login">Login </label>
							<input type="text" class="form-element required" placeholder="Login" id="login" value="<?= ($action === "edit")? $d[0]["login"]:"" ?>">
						</div>	
						<div class="col_6-inline">
							<label for="person_login">Password </label>
							
							<div class="input-group">
								<input type="text" placeholder="Password" id="password" class="form-element <?= ($action === "edit")? "":"required" ?>">
								<?php if($action==="edit"){ ?>
								<div class="input-suf">
									<button value="<?= ($action === "edit")? $data["id"]:"" ?>" class="person_password_reset" style="background-color: red; color: white; border-radius: 0; padding: 12px 10px; margin-right: 0px; border-top-right-radius: 7px;border-bottom-right-radius: 7px;">Initialiser</button>
								</div>
								<?php }  ?>
							</div>
						</div>		
					</div>
					
					<div class="row" style="margin-bottom: 20px">
						<div class="col_6-inline">
							<div class="" style="position: relative; width: 125px">
								<div class="on_off <?= ($action === "edit")? ($data["status"])? "on" : "off" : "off" ?> form-element" id="status"></div>
								<span style="position: absolute; right: 0; top: 10px; font-weight: bold; font-size: 12px">
									  Status
								</span>
							</div>
						</div>						
					</div>				
				</div> <!-- COL-8 -->
			</div> <!-- ROW-->
		</div>

	
		<div class="tab-content" style="display: none">
			<div class="location_form">
				<div class="row">
					<div class="col_4-inline">
						<h3 style="margin-left: 6px">Droits</h3>
					</div>
					<div class="col_8-inline" style="text-align: right; padding: 10px 5px">
						<button class="btn btn-default refresh_droit" value="0"><i class="fas fa-sync-alt"></i></button>
					</div>
				</div>
				<div class="location_form_content">
					<?php 
	/*
					require_once($core."Propriete_Proprietaire_Location.php"); 
					echo $propriete_proprietaire_location->drawTable("", array("conditions" => array("id_propriete=" => 0 )) );
					*/
					?>				
				</div>

			</div>
		</div>
	
		<div class="tab-content" style="display: none" >

			<div class="row">
				<div class="col_4-inline">
					<h3 style="margin-left: 6px">Activités</h3>
				</div>
				<div class="col_8-inline" style="text-align: right; padding: 10px 5px">
					<button class="btn btn-default refresh_droit" value="0"><i class="fas fa-sync-alt"></i></button>
				</div>
			</div>
			<div class="person_activity">
				<?php 
				require_once($core."Person_Activity.php"); 
				echo $person_activity->drawTable("", array("conditions" => array("created_by=" => $data["id"] )) );
				?>				
			</div>

		</div>
	</div>	<!-- END PANEL CONTENT -->

</div>

<div class="debug"></div>

