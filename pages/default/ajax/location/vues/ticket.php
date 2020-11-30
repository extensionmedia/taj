<?php session_start() ;
if(!isset($_SESSION["STATICS"], $_SESSION["CORE"])) die("-1");

$statics = $_SESSION["STATICS"];
$core = $_SESSION["CORE"];	
$id_location = isset($_POST["id_location"])? $_POST["id_location"]: 0;

require_once($core."Location.php");
$data = $location->find("", array("conditions"=>array("id="=>$id_location)), "v_location");
if(count($data) === 0) die("-2");

$data = $data[0];
/*
var_dump($data);
*/
?>

<div class="ticket">
	<div class="logo">
		<div class="img">
			<img style="height: 100%; width: auto" src="<?= $statics.'public/images/taj-alaraiss.jpg' ?>">
		</div>

		<div class="txt">
			<h1>Taj AL ARAISS</h1>
			<h1>تاج العرائس</h1>
			<p>بيع و كراء لوازم الأفراح</p>
			<p>+212 6 61 09 89 84</p>
		</div>
	</div>
	<hr>
	<div class="header">
		<div class="number">
			<div class="label">Ticket N° :</div>
			<div class="value"><?= $data["id"] ?></div>
		</div>
		
		<div class="date">
			<div class="label">Date :</div>
			<div class="value"><?= $data["date_debut"] ?></div>
		</div>
		
		<div class="client">
			<div class="label">Client :</div>
			<div class="value"><?= $data["client"] ?> <?= $data["client_telephone"] ?> </div>
		</div>
	</div>
	
	<hr>

	<div style="display: flex; padding: 10px; border-bottom: 2px dashed black">
		<div style="font-size: 12; color: black">
			PRODUITS
		</div>
		<div style="font-size: 12; color: black; margin-left: auto">
			PRIX
		</div>
	</div>	
	<?php
	$produits = $location->find("",array("conditions"=>array("id_location="=>$id_location)), "v_location_detail");
	foreach($produits as $k=>$v){

	?>	
	<div style="display: flex; padding: 10px; border-bottom: 1px dashed rgba(106,106,106,1.00)">
		<div style="font-size: 12; color: black">
			<?= $v["libelle"] ?>
		</div>
		<div style="font-size: 12; color: black; margin-left: auto; min-width: 90px; text-align: right">
			<?= $location->format($v["pu"]) ?>
		</div>
	</div>
	<?php	
	}
	?>
	
	<div class="total">
		<div class="item">
			<div class="label"> Total : </div>
			<div class="value"> <?= $location->format($data["total"]) ?> </div>
		</div>
		
		<div class="item">
			<div class="label"> Payé : </div>
			<div class="value">  <?= $location->format($data["total_payement"]) ?> </div>
		</div>
		
		<div class="item">
			<div class="label"> Reste : </div>
			<div class="value"> <?= $location->format($data["total"] - $data["total_payement"]) ?> </div>
		</div>
		
	</div>
	
	<div style="padding: 5px 20px; text-align: center; display: block">
		المرجو الإحتفاظ بهاذا التوصيل و تقديمه أثناء إستلام ما تم إكتراءه
	</div>	
	
	<div style="padding: 20px; text-align: center">
		<button class="btn btn-default _close">Imprimer</button>
	</div>	
	
</div>




