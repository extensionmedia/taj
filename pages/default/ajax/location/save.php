<?php session_start();

if(!isset($_SESSION['CORE'])){die("-1");}
if(!isset($_POST['t_n'])){die("-2");}

if(!isset($_POST['columns'])){die("-3");}


$table_name = $_POST['t_n'];

if(file_exists($_SESSION['CORE'].$table_name.".php")){
	
	require_once($_SESSION['CORE'].$table_name.".php");
	$ob = new $table_name();
	require_once($_SESSION['CORE']."Person_Activity.php");

	
	
	$data = array(
		"UID"				=>	$_POST['columns']['UID'],
		"date_debut"		=>	$_POST['columns']['date_debut'],
		"date_fin"			=>	$_POST['columns']['date_fin'],
		"client"			=>	$_POST['columns']['client'],
		"client_telephone"	=>	$_POST['columns']['telephone'],
		"remise"			=>	0,
		"notes"				=>	$_POST['columns']['remarques']
	);
	
	$envirenment = $ob->config->get()["GENERAL"]["ENVIRENMENT"];
	
	$created_by = $_SESSION[$envirenment]["USER"]["id"];
	$now = date("Y-m-d H:i:s");
	$lastID = 0;
	
	if(isset($_POST["columns"]["id"])){
		
		// Save data first
		$data["id"] = $_POST["columns"]["id"];
		$ob->save($data);
		$lastID = $_POST["columns"]["id"];
		
		// Check if product has been modified
		foreach($_POST['produits'] as $k=>$v){
			
			$temp = $ob->find("", array("conditions AND"=>array("id_location="=>$_POST["columns"]["id"], "id_produit="=>$v["id"])), "location_detail");
			if (count($temp) > 0){
				$data = array(
					"id_location"	=>	$lastID,
					"id_produit"	=>	$v["id"],
					"pu"			=>	$v["prix"],
					"status"		=>	$v["status"],
					"id"			=>	$temp[0]["id"]
					);				
				
			}else{
				$data = array(
					"id_location"	=>	$lastID,
					"id_produit"	=>	$v["id"],
					"pu"			=>	$v["prix"],
					"status"		=>	$v["status"],
					);
			}

			$ob->save($data, 'location_detail');
		}
		
		// Check Caisse paiement
		
		$temp = $ob->find("", array("conditions AND"=>array("id_source="=>$_POST["columns"]["id"], "source="=>"location")), "caisse_mouvement");
		
		$person_activity->saveActivity("fr",$created_by,array("Location","0"),$lastID, "");
		
		
	}else{
		
		$data["created_by"]=$created_by;
		$ob->save($data);
		$lastID = $ob->getLastID();
		
		foreach($_POST['produits'] as $k=>$v){
			$data = array(
				"id_location"	=>	$lastID,
				"id_produit"	=>	$k,
				"pu"			=>	$v
				);
			$ob->save($data, 'location_detail');
		}
		
		$data = array(
				"id_location"			=>	$lastID,
				"id_location_status"	=>	$_POST['columns']['location_status'],
				"created_by"			=>	$created_by
				);
		$ob->save($data, 'status_of_location');
		
		if($_POST['columns']['avance'] !== "0"){
			$data = array(
						"date_caisse"			=>	date("Y-m-d"),
						"entree"				=>	$_POST['columns']['avance'],
						"source"				=>	"location",
						"id_source"				=>	$lastID,
						"created_by"			=>	$created_by
				);
			$ob->save($data, 'caisse_mouvement');
			$operation = "+" . $ob->format($_POST['columns']['avance']);
			// Tracking
			$person_activity->saveActivity("fr",$created_by,array("Caisse","1"),$lastID, $operation);			
		}
		

		
	}

	echo 1;
	
}else{
	echo "File not exists : " . $_SESSION['CORE'].$table_name.".php";
}
