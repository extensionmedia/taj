<?php session_start();

$response  = array("code"=>0, "msg"=>"Error");


if(!isset($_SESSION['CORE'])){die(json_encode($response));}
if(!isset($_POST['UID'])){$response["msg"]="Error Data"; die(json_encode($response));}


$core = $_SESSION['CORE'];
$UID = addslashes( $_POST["UID"] );


require_once($core."Location.php");
//var_dump($location->GetByUID($UID));
$colors = $location->fetchAll("location_status");
$response["code"] = 1;
$data = $location->GetByUID($UID)[0];


$html = "<div class='panel' style='width:100%; z-index: 999999'>";
$html .= "	<div class='panel-header' style='padding:0px 0 0 10px; height:45px; line-height:40px; font-size:18px'>";
$html .= "		<i class='fas fa-calendar-week'></i> Modifier <span class='_close'><button class='btn btn-default btn-red'>Fermer</button></span>";
$html .= "	</div>";
$html .= "	<div class='panel-content' style='padding: 10px 0; width:100%; z-index: 999999'>";

// --------------------------- 		DATE		----

$html .= "		<div class='row'>";
$html .= "			<div class='col_4-inline' style='margin:10px 0'>";
$html .= "				<label for='date__debut'> Date Début</label>";
$html .= "				<input style='font-size:18px; text-align:center' type='date' id='date__debut' value='".$data["date_debut"]."'>";

$html .= "				<input type='hidden' id='id' value='".$data["id"]."'>";
$html .= "				<input type='hidden' id='UID' value='".$data["UID"]."'>";

$html .= "			</div>";

$html .= "			<div class='col_2-inline' style='padding-top:21px; text-align:center'>";
$html .= "				<div class='btn-group'>";
$html .= "					<button style='font-size:22px' class='btn btn-red change__date' value='-'><i class='fas fa-minus'></i> </button>";
$html .= "					<button style='font-size:22px' class='btn btn-green change__date' value='+'><i class='fas fa-plus'></i> </button>";
$html .= "				</div>";
$html .= "			</div>";

$html .= "			<div class='col_4-inline' style='margin:10px 0'>";
$html .= "				<label for='date__debut'> Date Retour</label>";
$html .= "				<input readonly style='font-size:18px; text-align:center' type='date' id='date__fin' value='".$data["date_fin"]."'>";
$html .= "			</div>";	

$html .= "			<div class='col_2-inline' style='padding-top:21px'>";
$html .= "				<div class='error' id='nbr_jours' style='width:100%; padding:5px 0; font-size:24px; color:white; background-color: rgb(102, 187, 106); text-align:center; border-radius:7px'>".$data["nbr_jours"]."</div>";
$html .= "			</div>";

$html .= "		</div>";

$html .= "		<div class='row'>";
$html .= "			<div class='col_6-inline'>";
$html .= "				<div class='btn-group-radio'>";

if($data["location_status"] === "RESERVATION"){
	$html .= "					<button style='font-size:14px; background-color:".$colors[0]["color"]."' class='btn btn-default checked location_status' data-id='1' data-color='".$colors[0]["color"]."' value='reservation'>RESERVATION</button>";
	$html .= "					<button style='font-size:14px; background-color:".$colors[1]["color"]."' class='btn btn-default location_status' data-id='2' data-color='".$colors[1]["color"]."' value='location'>LOCATION</button>";	
}else{
	$html .= "					<button style='font-size:14px; background-color:".$colors[0]["color"]."' class='btn btn-default location_status' data-id='1' data-color='".$colors[0]["color"]."' value='reservation'>RESERVATION</button>";
	$html .= "					<button style='font-size:14px; background-color:".$colors[1]["color"]."' class='btn btn-default checked location_status' data-id='2' data-color='".$colors[1]["color"]."' value='location'>LOCATION</button>";	
}

$html .= "				</div>";
$html .= "			</div>";

$html .= "			<div class='col_6-inline' style='text-align:right; font-size:24px; font-weight:bold'>";
$html .= "				<span data-du='{{du}}' data-avoir='{{avoir}}' class='total_location'>{{total}}</span>";
$html .= "				<span class='total_avoir' style='color:red; text-decoration:line-through; font-size:12px; display:block'> Avoir : -{{avoir}} Dh</span>";
$html .= "			</div>";

$html .= "		</div>";

//---------------------------		Client			----

$html .= "		<div class='row'>";
$html .= '			<div class="col_4">
						<div class="form-group-inline" style="width: 100%">
							<div class="element-1"><i class="far fa-user"></i></div>
							<div class="element-2">
								<input type="text" placeholder="Client" id="client" value="'.$data["client"].'">
							</div>
							<br clear="all">
						</div>				
					</div>				

					<div class="col_4">
						<div class="form-group-inline" style="width: 100%">
							<div class="element-1"><i class="fas fa-mobile-alt"></i></div>
							<div class="element-2">
								<input type="text" placeholder="+212661098984" id="telephone" value="'.$data["client_telephone"].'">
							</div>
							<br clear="all">
						</div>				
					</div>				

					<div class="col_4">
						<div class="form-group-inline" style="width: 100%">
							<div class="element-1"><i class="far fa-question-circle"></i></div>
							<div class="element-2">
								<input type="text" placeholder="Remarques" id="remarques" value="'.$data["notes"].'">
							</div>
							<br clear="all">
						</div>				
					</div>';
$html .= "		</div>";


$html .= "		<div class='row' style='padding:15px 0'>";
$html .= "			<div class='col_12-inline'>";

$html .= "			</div>";
$html .= "		</div>";

// --------------------------- 		PRODUITS		----

$html .= '<div class="row" style="padding: 0; margin: 0">';
$html .= '	<div class="col_12 location_list"  style="padding: 0; margin: 0">';
$html .= '		<table class="table">';
$html .= '			<thead>';
$html .= '				<tr>';
$html .= '					<th class="hide">ID</th>';
$html .= '					<th>CODE</th>';
$html .= '					<th style="text-align: left">LIBELLE</th>';
$html .= '					<th style="width:102px; max-width:102px; text-align:right">PRIX</th>';
$html .= '					<th style="width:70px; max-width:70px"></th>';
$html .= '				</tr>';
$html .= '			</thead>';

$produits = $location->GetProduitsByLocation($data["id"]);

$html .= '			<tbody>';

$total = 0;
$du = 0;
$avoir = 0;


foreach($produits as $k=>$v){
	
	$du += $v["status"]==="1"? $v["prix_location"]:0;
	$avoir += $v["status"]==="1"? 0: $v["prix_location"];
	$status = $v["status"]==="1"? "on": "off";
	
	$html .= '			<tr class="_produit">
							<td class="hide produit_id">'.$v["id_produit"].'</td>
							<td style="width:102px; max-width:102px;">'.$v["code"].'<div style="font-size:8px; color:red"><i class="fas fa-barcode"></i> '.$v["barcode"].'</div></td>
							<td>'.$v["libelle"].' <span style="font-size:10px; font-weight:bold; color:black">Taille : '.$v["taille"].'</span></td>
							<td style="width:102px; max-width:102px;"><input class="produit_prix_location" style="text-align:right" type="number" value="'.$v["prix_location"].'"></td>
							<td style="width:70px; max-width:70px"><div class="on_off '.$status.'"></div></td>
						</tr>';
	$total += $v["prix_location"];
}

$html = str_replace(array("{{total}}", "{{du}}", "{{avoir}}"), array($location->format($du), $du, $avoir), $html);

$html .= '				<tr>
							<td colspan="6" style="padding:10px 7px;"> 
								<div style="position:relative; width:100%; height:45px; line-height:45px; text-align:center">
									<button class="btn btn-default add_produit" value="'.$data["UID"].'"><i class="fas fa-search-plus"></i> Ajouter Produits </button>
								</div>
							</td>
						</tr>';

$html .= '			</tbody>';
$html .= '		</table>';
$html .= '	</div>';
$html .= '</div>';

// --------------------------- 		PAIEMENT		---- 

$html .= "	</div>";

$html .= "	<div style='height:55px; line-height:50px; font-size:18px; border-top-right-radius: 3px; border-top-left-radius: 3px; border-top: #bbb 1px solid; padding-top:10px; padding-right:15px; text-align:right; background:#fafafa;'>";
$html .= "		<button style='font-size:14px' class='btn btn-green location_save_edit' value=''><span class='do'>ENREGISTRER </span> <span class='is_doing hide'><i class='fas fa-cog fa-spin'></i> Chargement...</span></button>";
$html .= "	</div>";

$html .= "</div>";

$response["msg"] = $html;

echo json_encode($response);
