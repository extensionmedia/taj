<?php session_start();

if(!isset($_SESSION['CORE'])){die("Error!");}

$core = $_SESSION['CORE'];

require_once($core."Location_Status.php");
$colors = $location_status->fetchAll();
$envirenment = $location_status->config->get()["GENERAL"]["ENVIRENMENT"];
$first_step = $_SESSION[$envirenment]["first_step"];

//var_dump($first_step);
//die();
$data = "<div class='panel' style='width:100%; z-index: 999999'>";
$data .= "	<div class='panel-header' style='padding:0px 0 0 10px; height:55px; line-height:50px; font-size:18px'>";
$data .= "		<i class='fas fa-calendar-week'></i> Selectionnez une Date <span class='_close'><button class='btn btn-default btn-red'>Fermer</button></span>";
$data .= "	</div>";
$data .= "	<div class='panel-content' style='padding: 10px 0; width:100%; z-index: 999999'>";

$data .= "		<div class='row'>";
$data .= "			<div class='col_6-inline' style='margin:10px 0'>";
$data .= "				<label for='date__debut'> Date Début</label>";
$data .= "				<input style='font-size:18px; text-align:center' type='date' id='date___debut' value='".$_POST["date_debut"]."'>";
$data .= "			</div>";
$data .= "			<div class='col_6-inline' style='margin:10px 0'>";
$data .= "				<label for='date__debut'> Date Retour</label>";
$data .= "				<input readonly style='font-size:18px; text-align:center' type='date' id='date___fin' value='".$_POST["date_fin"]."'>";
$data .= "			</div>";	
$data .= "		</div>";

$data .= "		<div class='row'>";
$data .= "			<div class='col_6-inline'>";
$data .= "				<div class='btn-group'>";
$data .= "					<button style='font-size:22px' class='btn btn-red change___date' value='-'><i class='fas fa-minus'></i> </button>";
$data .= "					<button style='font-size:22px' class='btn btn-green change___date' value='+'><i class='fas fa-plus'></i> </button>";
$data .= "				</div>";
$data .= "			</div>";
$data .= "			<div class='col_6-inline'>";
$data .= "				<div class='' id='nbr___jours' style='width:100%; padding:5px 0; font-size:24px; color:white; background-color:green; text-align:center; border-radius:7px'>".$_POST["nbr_jours"]."</div>";
$data .= "			</div>";
$data .= "		</div>";

$data .= "		<div class='row' style='padding:15px 0'>";
$data .= "			<div class='col_12-inline'>";
$data .= "				<div class='btn-group-radio'>";

if($_POST["id_status"]==="1"){
$data .= "					<button style='font-size:14px; background-color:".$colors[0]["color"]."' class='btn btn-default checked location_status' data-id='1' data-color='".$colors[0]["color"]."' value='reservation'>RESERVATION</button>";
$data .= "					<button style='font-size:14px; background-color:".$colors[1]["color"]."' class='btn btn-default location_status' data-id='2' data-color='".$colors[1]["color"]."' value='location'>LOCATION</button>";
}else{
$data .= "					<button style='font-size:14px; background-color:".$colors[0]["color"]."' class='btn btn-default location_status' data-id='1' data-color='".$colors[0]["color"]."' value='reservation'>RESERVATION</button>";
$data .= "					<button style='font-size:14px; background-color:".$colors[1]["color"]."' class='btn btn-default checked location_status' data-id='2' data-color='".$colors[1]["color"]."' value='location'>LOCATION</button>";		
}

$data .= "				</div>";
$data .= "			</div>";
$data .= "		</div>";

$data .= "	</div>";

$data .= "	<div style='height:55px; line-height:50px; font-size:18px; border-top-right-radius: 3px; border-top-left-radius: 3px; border-top: #bbb 1px solid; padding-top:10px; padding-right:15px; text-align:right; background:#fafafa;'>";
$data .= "		<button style='font-size:14px' class='btn btn-green first_step_edit_save' value=''><span class='do'>Suivant <i class='fas fa-chevron-right'></i></span> <span class='is_doing hide'><i class='fas fa-cog fa-spin'></i> Chargement...</span></button>";
$data .= "	</div>";

$data .= "</div>";

$data .= "<div class='debug'></div>";

echo $data;
