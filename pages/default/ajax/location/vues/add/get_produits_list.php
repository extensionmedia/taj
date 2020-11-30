<?php session_start();

if(!isset($_SESSION['CORE'])){die("Error!");}

$core = $_SESSION['CORE'];
$UID =  $_POST["UID"];

require_once($core."Produit.php");
$envirenment = $produit->config->get()["GENERAL"]["ENVIRENMENT"];
$data = isset($_SESSION[$envirenment]["LOCATION"][$UID])? $_SESSION[$envirenment]["LOCATION"][$UID]: array();
$counter = 0;
$return = '';
$total = 0;

$empty = '<table class="table">
			<thead>
				<tr>
					<th class="hide">ID</th>
					<th>CODE</th>
					<th>LIBELLE</th>
					<th style="width:102px; max-width:102px; text-align:right">PRIX</th>
					<th style="width:50px; max-width:50px"></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="6" style="padding:10px 7px;"> 
						<div style="position:relative; width:100%; height:45px; line-height:45px; text-align:center">
							<button class="btn btn-default location_add_produit" value="'.$UID.'"><i class="fas fa-search-plus"></i> Ajouter Produits </button>
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="5" style="text-align:right; font-size:24px; padding:10px 7px; background-color: white ; color:#015A5D; font-weight:bold"> <div class="total_location" data-value="0">  Total : 0.00 Dh </div> </td>
				</tr>
				<tr>
					<td colspan="5" style="text-align:right; font-size:24px; padding:10px 7px; background-color: white ; color:#015A5D; font-weight:bold"> <div class="total_location" data-value="0">  Avance : 0.00 Dh </div> </td>
				</tr>
				<tr>
					<td colspan="5" style="text-align:right; font-size:24px; padding:10px 7px; background-color: white ; color:#015A5D; font-weight:bold"> <div class="total_location" data-value="0">  Reste : 0.00 Dh </div> </td>
				</tr>
			</tbody>
		</table>';


$return = '<table class="table">';
$return .= '<thead><tr><th class="hide">ID</th><th>CODE</th><th>LIBELLE</th><th style="width:102px; max-width:102px; text-align:right">PRIX</th><th style="width:50px; max-width:50px"></th></tr></thead>';
$return .= '<tbody>';




foreach($data as $k=>$v){

	$return .= '<tr class="_produit_add">
					<td class="hide produit_id">'.$v["id"].'</td>
					<td style="width:102px; max-width:102px;">'.$v["code"].'<div style="font-size:8px; color:red">'.$v["barcode"].'</div></td>
					<td>'.$v["libelle"].' <span style="font-size:10px; font-weight:bold; color:black">Taille : '.$v["taille"].'</span></td>
					<td style="width:102px; max-width:102px;"><input data-UID="'.$UID.'" data-produit_id="'.$v["id"].'" class="produit_prix_location" style="text-align:right" type="number" value="'.$v["prix_location"].'"></td>
					<td ><button class="btn btn-red remove_this_produit" data-UID="'.$UID.'" data-produit-id="'.$v["id"].'"><i class="fas fa-minus-circle"></i></button></td>
				</tr>';
	$counter++;
	$total += $v["prix_location"];
}
$return .= '	<tr>
					<td colspan="6" style="padding:10px 7px;"> 
						<div style="position:relative; width:100%; height:45px; line-height:45px; text-align:center">
							<button class="btn btn-default location_add_produit" value="'.$UID.'"><i class="fas fa-search-plus"></i> Ajouter Produits </button>
						</div>
					</td>
				</tr>
				<tr><td colspan="6" style="text-align:right; font-size:24px; padding:10px 7px 5px 0; background-color: #e1f5fe ; color:#015A5D; font-weight:bold"><div class="total_location" data-value="'.$total.'"> Total : <input style="width:150px; text-align:right; font-weight:bold; padding-right:16px" id="total_location" readonly type="text" value="'.$produit->format($total, false).'"></div></td></tr>
				<tr><td colspan="6" style="text-align:right; font-size:24px; padding:10px 7px 5px 0;; background-color:#f1f8e9 ; color:#015A5D; font-weight:bold"><div class="total_location" data-value="'.$total.'"> Avance : <input style="width:150px; text-align:right; font-weight:bold" type="number" id="total_avance" value="0.00" step="15"></div></td></tr>
				<tr><td colspan="6" style="text-align:right; font-size:24px; padding:10px 7px 5px 0; ; color:#015A5D; font-weight:bold; background-color:#fbe9e7"><div class="total_location" data-value="'.$total.'"> Reste : <input style="width:150px; text-align:right; font-weight:bold; padding-right:16px" readonly id="total_reste" type="text" value="'.$produit->format($total, false).'"></div></td></tr>';
$return .= '	</tbody>';
$return .= '</table>';	

if($counter === 0) echo $empty; else echo $return;