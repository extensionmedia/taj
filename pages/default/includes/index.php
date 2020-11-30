<?php 

if (session_status() == PHP_SESSION_NONE) { session_start(); } 
$core = $_SESSION["CORE"];
$host = $_SESSION["HOST"];
require_once($core."Calendar.php"); 
$months = array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
?>

<!-- Numbers -->
<div class="row">
	<div class="col_12">
		<div class="panel" style="margin-top: 11px; padding-top: 11px">
			<div class="panel-content">
				<div class="row">
					<div style="flex-direction: row; display: flex">
						<div style="flex: 1; text-align: right">
							<div style="flex-direction: row; display: flex" class="">
								<div style="display: table-cell; margin-right: 7px" class="">
									<div class="btn-group calendar">
										<a style="padding: 12px 12px" data-counter="0" class="cl_refresh" title="Ajourd'hui"><i class="fas fa-sync-alt"></i> </a>
									</div>											
								</div>				
								<div style="display: table-cell; margin-right: 7px" class="">
									<div class="btn-group calendar">
										<a style="padding: 12px 12px" class="direction" data-action="preview" data-counter="0" title="Précédent"><i class="fa fa-chevron-left"></i></a>
										<a style="padding: 12px 12px" class="direction" data-action="next" data-counter="0"  title="Suivant"><i class="fa fa-chevron-right"></i></a>
									</div>											
								</div>
								<div style="display: table-cell; margin-right: 7px" class="">
									<div class="btn-group calendar">
										<a style="padding: 12px 12px"><i class="far fa-calendar-alt"></i> <span class="calendar_current_interval tohide"><?= date("M") . " " . date("Y") ?></span></a>
									</div>											
								</div>	
							</div>
						</div>	
					</div>
				</div>

				<div class="row report">

					<div class="col_6">
						<div class="row">
							<div class="col_6-inline item red">
								<div class="title">
									<i class="fas fa-person-booth"></i> Location(s)
								</div>
								<div class="number">
									<?= 84 //count($calendar->fetchAll("v_location")) ?>
								</div>
							</div>

							<div class="col_6-inline item yellow">
								<div class="title">
									<i class="fas fa-bell"></i> Notifications(s) 
								</div>
								<div class="number">
									3
								</div>
							</div>			
						</div>
					</div>

					<div class="col_6">
						<div class="row">
							<div class="col_6-inline item green">
								<div class="title">
									<i class="fas fa-cash-register"></i> Recette(s) 
								</div>
								<div class="number">
									<?= "7 458,00 Dh" //count($calendar->fetchAll("v_client")) ?>
								</div>
							</div>

							<div class="col_6-inline item blue">
								<div class="title">
									<i class="fab fa-creative-commons-nc"></i> Credit(s) 
								</div>
								<div class="number">
									<?= "458,00 Dh"  //count($calendar->fetchAll("v_vehicule")) ?>
								</div>
							</div>			
						</div>
					</div>

				</div>		

			</div>
		</div>		
	</div>
</div>


<!-- Actions -->
<div class="row">
	<div class="col_12">
		<div class="panel" style="margin-top: 11px; padding-top: 11px">
			
			<ul class="links inline">
				<li>
					<a href="http://<?= $host ?>#location" class="click" data-table="Location">
						<i class="fas fa-person-booth"></i> LOCATION 
						<span class="badge">9</span>
					</a>
				</li>
				
				<li>
					<a href="http://<?= $host ?>#vente">
						<i class="fas fa-tshirt"></i> VENTES 
					</a>
				</li>
				
				<li>
					<a href="http://<?= $host ?>#produit" class="click" data-table="Produit">
						<i class="fas fa-restroom"></i> PRODUITS 
					</a>
				</li>

				<li>
					<a href="http://<?= $host ?>#caisse_mouvement" class="click" data-table="Caisse_Mouvement">
						<i class="fas fa-cash-register"></i> CAISSE 
						<span class="badge">2</span>
					</a>
				</li>
				
				<li>
					<a href="">
						<i class="fab fa-creative-commons-nc"></i> CREDITS
					</a>
				</li>
				
				<li>
					<a href="">
						<i class="fas fa-concierge-bell"></i> ALERTS
						<span class="badge">7</span>
					</a>
				</li>
				
				<li>
					<a href="">
						<i class="fas fa-code-branch"></i> ACTIVITES
						<span class="badge">+10</span>
					</a>
				</li>
			</ul>
			
		</div>	
	</div>
</div>


<div class="row ">
	
	<div class="col_8">
		<div class="panel" style="margin-top: 11px; padding-top: 11px">
			<div class="panel-content">

			</div>
		</div>
	</div>	
	
	<div class="col_4">
		<div class="panel" style="margin-top: 11px;">
			<div class="panel-content" style="padding: 0; margin: 0">
				<div style="display: flex; padding: 5px">
					<div style="padding-top: 7px">File d'actualités</div>
					<div style="margin-left: auto">
						<button class="btn btn-green">
							<i class="fas fa-sync-alt"></i>
						</button>
					</div>
				</div>
<?php 
	require_once($core."Person.php");
	echo $person->getPersonActivities(array("limit"=>array("0,10")));
?>
			</div>
		</div>
	</div>
	

	
</div>

<div class="debug"></div>


