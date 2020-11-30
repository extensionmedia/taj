<?php session_start();

$response  = array("code"=>0, "msg"=>"Error");


if(!isset($_SESSION['CORE'])){die(json_encode($response));}
if(!isset($_POST['UID'])){$response["msg"]="Error Data"; die(json_encode($response));}

$core = $_SESSION['CORE'];
require_once($core."Produit_Category.php");
require_once($core."Produit.php");


$UID =  isset($_POST["UID"])? addslashes( $_POST["UID"] ): "";	
		

$temp = $produit_category->find("", array("order"=>"produit_category"), "v_produit_category");

$envirenment = $produit_category->config->get()["GENERAL"]["ENVIRENMENT"];
$selected_produits = isset($_SESSION[$envirenment]["LOCATION"][$UID])? $_SESSION[$envirenment]["LOCATION"][$UID]: array();

$data = "<div class='panel' style='width:100%; z-index: 999999'>";
$data .= "	<div class='panel-content' style='padding: 10px 0; width:100%; z-index: 999999'>";

$return = '		<div class="row">';

$return .= '		<div class="col_4-inline" style="padding:0px">';

$return .= '			<div class="row" style="padding:0px 0 10px 0">';
$return .= '				<div class="col_12-inline" style="padding:0px 0 0 7px">';
$return .= '					<div style="padding:0px; font-size:18px; font-weight:bold">Categories </div>';
$return .= '				</div>';
$return .= '			</div>';

$return .= "			<div class='row' style='max-height:450px; overflow:auto'>";
$return .= '				<ul class="produit_category_list edit">';

require_once($core."Produit_Category.php");
$temp = $produit_category->find("", array("order"=>"produit_category"), "v_produit_category");
foreach($temp as $k=>$v){	
	$return .= '				<li data-UID="'.$UID.'" data-id="'.$v["id"].'">'. strtoupper( $v["produit_category"] ) ." <span style='color:blue; font-weight:bold; font-size:12px'>(" . $v["nbr_produit"] . ')</span></li>';
}
$return .= '				</ul>';
$return .= ' 			</div>';
$return .= '		</div>';

$return .= '		<div class="col_8-inline produit_list" style="padding:0px;">';

$return .= "			<div class='row' style='padding:0px 0 10px 0'>";
$return .= "				<div class='col_6-inline' style='padding:0px'>";
$return .= "					<input style='border-radius:0px' class='edit' id='request_select' type='text' placeholder='Chercher' data-UID='".$UID."'>";
$return .= "				</div>";
$return .= "				<div class='col_6-inline' style='text-align:right;padding:0px'>";
$return .= "					<div class='btn-group-radio produit_style'>";
$return .= "						<button class='btn btn-default checked' value='list' style='padding:4px 15px; font-size:18px'><i class='fas fa-list'></i></button>";
$return .= "						<button class='btn btn-default' value='grid' style='padding:4px 15px; font-size:18px'><i class='fas fa-th'></i></button>";
$return .= "					</div>";
$return .= "				</div>";	
$return .= "			</div>";	


$return .= "			<div class='row' style='max-height:450px;overflow:hidden; overflow-y:scroll;'>";
$return .= '				<table class="table">';
$return .= '					<tbody>';
$counter = 0;
$envirenment = $produit->config->get()["GENERAL"]["ENVIRENMENT"];

foreach($produit->find("", array("order" => "code"), "v_produit") as $k=>$v){

	$btn_select = '<button style="padding:3px 10px" class="btn btn-green select_this_produit_edit" data-produit-UID="'.$v["UID"].'" data-produit-prix_location="'.$v["prix_location"].'" data-produit-taille="'.$v["taille"].'" data-produit-libelle="'.$v["libelle"].'" data-produit-code="'.$v["code"].'" data-env="'.$envirenment.'" data-produit-id="'.$v["id"].'" data-UID="'.$UID.'" data-produit-category="'.$v["produit_category"].'" data-barcode="'.$v["barcode"].'">Select</button>';

	foreach($selected_produits as $kk=>$vv){
		if ($vv["id"] === $v["id"]){
			$btn_select = '<button style="padding:3px 10px" class="btn btn-default"><i class="fas fa-lock"></i> ...</button>';
		}
	}

	$return .= '					<tr>
										<td style="width:102px; max-width:102px;">'.$v["code"].'<div style="font-size:8px; color:red">'. str_replace("°","",$v["barcode"]) .'</div></td>
										<td>'.$v["libelle"].' <span style="font-size:10px; font-weight:bold; color:black">Taille : '.$v["taille"].'</span></td>
										<td style="width:70px; max-width:70px; text-align:right">'.$produit->format( $v["prix_location"] ).'</td>
										<td style="width:65px; max-width:65px">'.$btn_select.'</td>
									</tr>';
	$counter++;
}
$return .= '					</tbody>';
$return .= '				</table>';	
$return .= "			</div>";
$return .= ' 		</div>';
$return .= ' 	</div>';
$return .= ' </div>';

$data .= $return;
$data .= "	</div>";
$data .= "</div>";


$response  = array("code"=>1, "msg"=>$data);
echo json_encode($response);