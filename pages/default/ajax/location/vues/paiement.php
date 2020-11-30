<?php session_start();

$response  = array("code"=>0, "msg"=>"Error");


if(!isset($_SESSION['CORE'])){die(json_encode($response));}
if(!isset($_POST['id_location'])){$response["msg"]="Error Data"; die(json_encode($response));}


$core = $_SESSION['CORE'];
$id_location = addslashes( $_POST["id_location"] );


require_once($core."Location.php");

$data = $location->find("", array("conditions"=>array("id="=>$id_location)), "v_location");

if(count($data)>0){
	
	$total_paye_avoir = is_null($data[0]["total_payement_avoir"])? 0: $data[0]["total_payement_avoir"];
	
	$html = "<div class='panel' style='width:100%; z-index: 999999'>";
	$html .= "	<div class='panel-header' style='padding:0px 0 0 10px; height:45px; line-height:40px; font-size:18px'>";
	$html .= "		<i class='fas fa-calendar-week'></i> Paiement <span class='_close'><button class='btn btn-default btn-red'>Fermer</button></span>";
	$html .= "	</div>";
	$html .= "	<div class='panel-content' style='padding: 10px 0; width:100%; z-index: 999999'>";	
	
	$html .= "		<div class='row'>";
	$html .= "			<div class='col_12' style='margin:10px 0'>";
	$html .= "				<label for='date_paiement'> Date Paiement</label>";
	$html .= "				<input style='font-size:18px; text-align:center' type='date' id='date_paiement' value='".date("Y-m-d")."'>";
	$html .= "			</div>";
	$html .= "		</div>";
	
	$html .= "		<div class='row' style='padding:15px 0'>";
	$html .= "			<div class='col_12-inline'>";
	$html .= "				<div class='btn-group-radio'>";
	$html .= "					<button style='font-size:14px;' class='btn btn-default checked type' data-id='1' value='entree'>Entrée</button>";
	$html .= "					<button style='font-size:14px;' class='btn btn-default type' data-id='0' value='sortie'>Sortie</button>";
	$html .= "				</div>";
	$html .= "			</div>";
	$html .= "		</div>";
	
	$html .= '		<div class="row">
						<div class="col_6">
							<div class="form-group-inline" style="width: 100%">
								<div class="element-1"><i class="fas fa-cash-register"></i></div>
								<div class="element-2">
									<input type="number" data-du="'.$data[0]["total"].'" data-avoir="'.$data[0]["avoir"].'" data-paye-avoir="'.$total_paye_avoir.'" data-paye="'.$data[0]["total_payement"].'" data-reste="'.($data[0]["total"]-$data[0]["total_payement"]-$data[0]["avoir"]).'" style="text-align:center" placeholder="0.00" id="avance" value="'.($data[0]["total"]-$data[0]["total_payement"]-$data[0]["avoir"]).'">
								</div>
								<br clear="all">
							</div>				
						</div>
						<div class="col_6">
							<div class="lbl_reste" style="width: 100%; color:red; padding-top:7px; font-weight:bold">
								0.00 Dh
							</div>				
						</div>
					</div><br>';
	$html .= "		<div style='height:55px; line-height:50px; font-size:18px; border-top-right-radius: 3px; border-top-left-radius: 3px; border-top: #bbb 1px solid; padding-top:10px; padding-right:15px; text-align:right; background:#fafafa;'>";
	$html .= "			<button style='font-size:14px' class='btn btn-green paiement_save' value='".$data[0]["id"]."'><span class='do'>ENREGISTRER </span> <span class='is_doing hide'><i class='fas fa-cog fa-spin'></i> Chargement...</span></button>";
	$html .= "		</div>";
	$html .= "	</div>";
	$html .= "</div>";
	$response["msg"] = $html;
	$response["code"] = 1;
}


echo json_encode($response);
