<?php session_start();

$response  = array("code"=>0, "msg"=>"Error");


if(!isset($_SESSION['CORE'])){die(json_encode($response));}
if(!isset($_POST['module'])){$response["msg"]="Error Data"; die(json_encode($response));}



$core = $_SESSION['CORE'];

$module = $_POST["module"];
switch ($module){

	case "select_produit_request":
		
		$request =  isset($_POST["params"]["request"])? addslashes( strtolower( $_POST["params"]["request"] ) ): "";
		$id_produit_category =  isset($_POST["params"]["id_produit_category"])? $_POST["params"]["id_produit_category"]: "";
		$is_edit =  isset($_POST["params"]["edit"])? true: false;

		$UID =  isset($_POST["params"]["UID"])? addslashes( $_POST["params"]["UID"] ): "";
		require_once($core."Produit.php");
		
		$counter = 0;
		$envirenment = $produit->config->get()["GENERAL"]["ENVIRENMENT"];
		
		$selected_produits = isset($_SESSION[$envirenment]["LOCATION"][$UID])? $_SESSION[$envirenment]["LOCATION"][$UID]: array();
		
		
		$empty = "	<div style='width:100%'>
						<div style='width:250px; margin:35px auto; text-align:center; font-size:20px; color:#827717; font-weight:bold'>	<i style='display:block; font-size:46px; color:#CDDC39' class='fas fa-exclamation-triangle'></i> Aucun Produit 	</div>
					</div>";
		
		$return = "";
		$conditions = array();
		if($request !== ""){
			$conditions["code like "] = $request . "%";
			$conditions["barcode like "] = $request . "%";
			$conditions["barcode_2 like "] = $request . "%";
		}
		
		if($id_produit_category !== ""){ $conditions["id_produit_category="] = $id_produit_category; }
		//var_dump($conditions);
		if( count($conditions) === 1 ){
			$temp = $produit->find("", array("conditions" => $conditions), "v_produit");
		}else{
			$temp = $produit->find("", array("conditions OR" => $conditions), "v_produit");
		}
		
		//var_dump($temp);
		foreach($temp as $k=>$v){
			if($is_edit){
				$btn_select = '<button style="padding:3px 10px" class="btn btn-green select_this_produit_edit" data-produit-UID="'.$v["UID"].'" data-produit-prix_location="'.$v["prix_location"].'" data-produit-taille="'.$v["taille"].'" data-produit-libelle="'.$v["libelle"].'" data-produit-code="'.$v["code"].'" data-env="'.$envirenment.'" data-produit-id="'.$v["id"].'" data-UID="'.$UID.'" data-produit-category="'.$v["produit_category"].'">Select</button>';					
			}else{
				$btn_select = '<button style="padding:3px 10px" class="btn btn-green select_this_produit" data-produit-UID="'.$v["UID"].'" data-produit-prix_location="'.$v["prix_location"].'" data-produit-taille="'.$v["taille"].'" data-produit-libelle="'.$v["libelle"].'" data-produit-code="'.$v["code"].'" data-env="'.$envirenment.'" data-produit-id="'.$v["id"].'" data-UID="'.$UID.'" data-produit-category="'.$v["produit_category"].'">Select</button>';				
			}

			
			foreach($selected_produits as $kk=>$vv){
				if ($vv["id"] === $v["id"]){
					$btn_select = '<button style="padding:3px 10px" class="btn btn-default"><i class="fas fa-lock"></i> ...</button>';
				}
			}
			
			
			$return .= '		<tr>
									<td style="width:102px; max-width:102px;">'.$v["code"].'<div style="font-size:8px; color:red">'. str_replace("°","",$v["barcode"]) .'</div></td>
									<td>'.$v["libelle"].' <span style="font-size:10px; font-weight:bold; color:black">Taille : '.$v["taille"].'</span></td>
									<td style="width:70px; max-width:70px; text-align:right">'.$produit->format( $v["prix_location"] ).'</td>
									<td style="width:65px; max-width:65px">'.$btn_select.'</td>
								</tr>';
			$counter++;
		}
		
		$return = ($counter === 0)? $empty: $return;
		
		$response  = array("code"=>1, "msg"=>$return);
		echo json_encode($response);
		
		
		
		
		
		

		//var_dump($_POST);
		//$response  = array("code"=>1, "msg"=>$data);

	break;
		
	case "select_produit":
		
		$UID =  isset($_POST["params"]["UID"])? addslashes( $_POST["params"]["UID"] ): "";	
		
		require_once($core."Produit_Category.php");
		$temp = $produit_category->find("", array("order"=>"produit_category"), "v_produit_category");
		
		$envirenment = $produit_category->config->get()["GENERAL"]["ENVIRENMENT"];
		$selected_produits = isset($_SESSION[$envirenment]["LOCATION"][$UID])? $_SESSION[$envirenment]["LOCATION"][$UID]: array();

		$data = "<div class='panel' style='width:100%; z-index: 999999'>";
		$data .= "	<div class='panel-header' style='padding:0px 0 0 10px; height:40px; line-height:40px; font-size:18px'>";
		$data .= "		<i class='fas fa-calendar-week'></i> Selectionnez un Produit <span class='_close'><button class='btn btn-default btn-red'>Fermer</button></span>";
		$data .= "	</div>";
		$data .= "	<div class='panel-content' style='padding: 10px 0; width:100%; z-index: 999999'>";

		$return = '		<div class="row">';
		
		$return .= '		<div class="col_4-inline" style="padding:0px">';
		
		$return .= '			<div class="row" style="padding:0px 0 10px 0">';
		$return .= '				<div class="col_12-inline" style="padding:0px 0 0 7px">';
		$return .= '					<div style="padding:0px; font-size:18px; font-weight:bold">Categories </div>';
		$return .= '				</div>';
		$return .= '			</div>';
		
		$return .= '			<ul class="produit_category_list">';
		
		require_once($core."Produit_Category.php");
		$temp = $produit_category->find("", array("order"=>"produit_category"), "v_produit_category");
		foreach($temp as $k=>$v){	
			$img = $produit_category->getFiles($v["UID"]);
			$return .= '				<li data-UID="'.$UID.'" data-id="'.$v["id"].'">
											<div style="width:80px; height:80px">
												<img src="'.$img[0]["src"].'" style="width:100%; height:auto">
											</div>
											'. strtoupper( $v["produit_category"] ) .' <span style="color:blue; font-weight:bold; font-size:12px">(' . $v["nbr_produit"] . ')</span>
										</li>';
			//$return .= '				<li data-UID="'.$UID.'" data-id="'.$v["id"].'">'. strtoupper( $v["produit_category"] ) ." <span style='color:blue; font-weight:bold; font-size:12px'>(" . $v["nbr_produit"] . ')</span></li>';
		}

		$return .= '			</ul>';
		$return .= '		</div>';
		
		$return .= '		<div class="col_8-inline produit_list" style="padding:0px">';
		
		$return .= "		<div class='row' style='padding:0px 0 10px 0'>";
		$return .= "			<div class='col_6-inline' style='padding:0px'>";
		$return .= "				<input style='border-radius:0px' id='request_select' type='text' placeholder='Chercher' data-UID='".$UID."'>";
		$return .= "			</div>";
		$return .= "			<div class='col_6-inline' style='text-align:right;padding:0px'>";
		$return .= "				<div class='btn-group-radio produit_style'>";
		$return .= "					<button class='btn btn-default checked' value='list' style='padding:4px 15px; font-size:18px'><i class='fas fa-list'></i></button>";
		$return .= "					<button class='btn btn-default' value='grid' style='padding:4px 15px; font-size:18px'><i class='fas fa-th'></i></button>";
		$return .= "				</div>";
		$return .= "			</div>";	
		$return .= "		</div>";	
		
		require_once($core."Produit.php");
		
		$return .= '			<table class="table">';
		$return .= '				<tbody>';
		$counter = 0;
		$envirenment = $produit->config->get()["GENERAL"]["ENVIRENMENT"];

		foreach($produit->find("", array("order" => "code"), "v_produit") as $k=>$v){
			
			$btn_select = '<button style="padding:3px 10px" class="btn btn-green select_this_produit" data-produit-UID="'.$v["UID"].'" data-produit-prix_location="'.$v["prix_location"].'" data-produit-taille="'.$v["taille"].'" data-produit-libelle="'.$v["libelle"].'" data-produit-code="'.$v["code"].'" data-env="'.$envirenment.'" data-produit-id="'.$v["id"].'" data-UID="'.$UID.'" data-produit-category="'.$v["produit_category"].'" data-barcode="'.$v["barcode"].'">Select</button>';
			
			foreach($selected_produits as $kk=>$vv){
				if ($vv["id"] === $v["id"]){
					$btn_select = '<button style="padding:3px 10px" class="btn btn-default"><i class="fas fa-lock"></i> ...</button>';
				}
			}
			
			$return .= '		<tr>
									<td style="width:102px; max-width:102px;">'.$v["code"].'<div style="font-size:8px; color:red">'. str_replace("°","",$v["barcode"]) .'</div></td>
									<td>'.$v["libelle"].' <span style="font-size:10px; font-weight:bold; color:black">Taille : '.$v["taille"].'</span></td>
									<td style="width:70px; max-width:70px; text-align:right">'.$produit->format( $v["prix_location"] ).'</td>
									<td style="width:65px; max-width:65px">'.$btn_select.'</td>
								</tr>';
			$counter++;
		}
		$return .= '				</tbody>';
		$return .= '			</table>';			
		$return .= ' 		</div>';
		$return .= ' 	</div>';
		$return .= ' </div>';
		
		$data .= $return;
		$data .= "	</div>";
		$data .= "</div>";

		
		$response  = array("code"=>1, "msg"=>$data);
		echo json_encode($response);

	break;
	
	
	case "search":
		$request =  isset($_POST["params"]["request"])? addslashes( strtolower( $_POST["params"]["request"] ) ): "";
		$UID =  isset($_POST["params"]["UID"])? addslashes( $_POST["params"]["UID"] ): "";
		require_once($core."Produit.php");
		$return = '<table class="table">';
		$return .= '<tbody>';
		$counter = 0;
		$envirenment = $produit->config->get()["GENERAL"]["ENVIRENMENT"];
		$selected_produits = isset($_SESSION[$envirenment]["LOCATION"][$UID])? $_SESSION[$envirenment]["LOCATION"][$UID]: array();
		
		
		foreach($produit->find("", array("conditions OR" => array("code like "=> $request . "%", "barcode like "=> $request . "%", "barcode_2 like "=> $request . "%")), "v_produit") as $k=>$v){
			
			$btn_select = '<button style="padding:3px 10px" class="btn btn-green select_this_produit" data-produit-UID="'.$v["UID"].'" data-produit-prix_location="'.$v["prix_location"].'" data-produit-taille="'.$v["taille"].'" data-produit-libelle="'.$v["libelle"].'" data-produit-code="'.$v["code"].'" data-env="'.$envirenment.'" data-produit-id="'.$v["id"].'" data-UID="'.$UID.'" data-produit-category="'.$v["produit_category"].'" data-barcode="'.$v["barcode"].'">Select</button>';
			
			foreach($selected_produits as $kk=>$vv){
				if ($vv["id"] === $v["id"]){
					$btn_select = '<button style="padding:3px 10px" class="btn btn-default"><i class="fas fa-lock"></i> ...</button>';
				}
			}
			
			
			$return .= '<tr>
							<td style="width:70px; max-width:70px">'.$v["code"].'</td>
							<td>'.$v["libelle"].' <span style="font-size:10px; font-weight:bold; color:black">Taille : '.$v["taille"].'</span></td>
							<td style="width:70px; max-width:70px; text-align:right">'.$produit->format( $v["prix_location"] ).'</td>
							<td style="width:65px; max-width:65px">'.$btn_select.'</td>
						</tr>';
			$counter++;
		}
		
		$return .= '	</tbody>';
		$return .= '</table>';
		echo $counter === 0? "": $return;
		//var_dump($_POST);
		//$response  = array("code"=>1, "msg"=>$data);

	break;

	case "refresh":
		$UID =  isset($_POST["params"]["UID"])? addslashes( $_POST["params"]["UID"] ): "";
		$style =  isset($_POST["params"]["style"])? addslashes( $_POST["params"]["style"] ): "list";
		
		require_once($core."Produit.php");
		$envirenment = $produit->config->get()["GENERAL"]["ENVIRENMENT"];
		$data = isset($_SESSION[$envirenment]["LOCATION"][$UID])? $_SESSION[$envirenment]["LOCATION"][$UID]: array();
		$counter = 0;
		$return = '';
		$total = 0;
		
		if($style === "list"){
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
							<tr><td colspan="6" style="text-align:right; font-size:24px; padding:10px 7px; background-color: white ; color:#015A5D; font-weight:bold"><div class="total_location" data-value="'.$total.'"> Total : '.$produit->format($total).'</div></td></tr>';
			$return .= '	</tbody>';
			$return .= '</table>';			
		}else{
			$empty = '<table class="table">
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
						</tbody>
					</table>';
			$return .= "<div style='vertical-align: text-top; border:1px solid black'>";

			
			$statics = $_SESSION["STATICS"];
			$upload_folder = $_SESSION["UPLOAD_FOLDER"];

			$dS = DIRECTORY_SEPARATOR;
			$params = $produit->getConfig();
			$UID_ENTREPRISE = $_SESSION[$params["GENERAL"]["ENVIRENMENT"]]["USER"]["entreprise_UID"];
			//var_dump($data);
			foreach($data as $k=>$v){
				
				
				$filesDirectory = $upload_folder.$UID_ENTREPRISE.$dS.'produits'.$dS.$v["produit_UID"].$dS;

				$link = $statics."public/images/images.png";
				if(file_exists($filesDirectory)){
					
					foreach(scandir($filesDirectory) as $kk=>$vv){
						if($vv <> "." and $vv <> ".." and strpos($vv, '.') !== false){
							$link = $statics.$UID_ENTREPRISE."/produits/".$v["produit_UID"]."/".$vv;
						}
					}	
				}
				

				$return .= '<div class="card" style="width:230px; max-width:230px; min-height:250px; display:inline-block; padding-bottom:17px">';
				$return .= '	<div class="img" style="position:relative">';
				$return .= '		<img src="'.$link.'">';
				$return .= '		<div style="position:absolute; top:0; right:0; font-size:16px;" class="label label-default">'.$v["produit_category"].'</div>';
				$return .= '	</div>';
				$return .= '	<div class="txt">';
				
				$return .= '		<h2>Code : '.$v["code"].'</h2>';
				$return .= '		<p>'.$v["libelle"].'</p>';
				$return .= '	</div>';
				$return .= '	<div style="padding:0 15px">';
				$return .= '		<label style="display:block; font-size:18px">Prix </label><input data-UID="'.$UID.'" data-produit_id="'.$v["id"].'" class="produit_prix_location" style="text-align:right" type="number" value="'.$v["prix_location"].'">';
				$return .= '	</div>';
				
				$return .= '</div>';
				
				$counter++;
				$total += $v["prix_location"];

			}
			
				$return .= '<table class="table">
								<tbody>
									<tr>
										<td colspan="5" style="text-align:right; font-size:24px; padding:10px 7px; background-color: white ; color:#015A5D; font-weight:bold"> <div class="total_location" data-value="0">  Total : '.$produit->format($total).' </div> </td>
									</tr>
								</tbody>
							</table>';	
			$return .= "</div>";
		}

		echo $counter === 0? $empty: $return;
		//var_dump($_POST);
		//$response  = array("code"=>1, "msg"=>$data);

	break;
		
	case "refresh_edit":
		$UID =  isset($_POST["params"]["UID"])? addslashes( $_POST["params"]["UID"] ): "";
		$style =  isset($_POST["params"]["style"])? addslashes( $_POST["params"]["style"] ): "list";
		
		require_once($core."Produit.php");
		$data = $produit->find("", array("conditions"=>array("UID="=>$UID)), "v_location_detail");
		$counter = 0;
		$return = '';
		$total = 0;
		
		
		if($style === "list"){
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
								<td colspan="5" style="font-size:18px; padding:10px 7px; background-color: white ; color:red; "> Liste est vide ...</td>
							</tr>
							<tr>
								<td colspan="5" style="text-align:right; font-size:24px; padding:10px 7px; background-color: white ; color:#015A5D; font-weight:bold"> Total : 0.00 Dh </td>
							</tr>
						</tbody>
					</table>';


			$return = '<table class="table">';
			$return .= '<thead><tr><th class="hide">ID</th><th>CODE</th><th>LIBELLE</th><th style="width:102px; max-width:102px; text-align:right">PRIX</th><th style="width:50px; max-width:50px"></th></tr></thead>';
			$return .= '<tbody>';
			

			

			foreach($data as $k=>$v){

				$return .= '<tr>
								<td class="hide produit_id">'.$v["id"].'</td>
								<td style="width:102px; max-width:102px;">'.$v["code"].'<div style="font-size:8px; color:red">'.$v["barcode"].'</div></td>
								<td>'.$v["libelle"].' <span style="font-size:10px; font-weight:bold; color:black">Taille : '.$v["taille"].'</span></td>
								<td style="width:102px; max-width:102px;"><input data-UID="'.$UID.'" data-produit_id="'.$v["id"].'" class="produit_prix_location" style="text-align:right" type="number" value="'.$v["prix_location"].'"></td>
								<td ><button class="btn btn-red remove_this_produit" data-UID="'.$UID.'" data-produit-id="'.$v["id"].'"><i class="fas fa-minus-circle"></i></button></td>
							</tr>';
				$counter++;
				$total += $v["prix_location"];
			}
			$return .= '	<tr><td colspan="6" style="text-align:right; font-size:24px; padding:10px 7px; background-color: white ; color:#015A5D; font-weight:bold"><div class="total_location"> Total : '.$produit->format($total).'</div></td></tr>';
			$return .= '	</tbody>';
			$return .= '</table>';			
		}else{
			$empty = '<table class="table">
						<tbody>
							<tr>
								<td colspan="5" style="font-size:18px; padding:10px 7px; background-color: white ; color:red; "> Liste est vide ...</td>
							</tr>
							<tr>
								<td colspan="5" style="text-align:right; font-size:24px; padding:10px 7px; background-color: white ; color:#015A5D; font-weight:bold"> Total : 0.00 Dh </td>
							</tr>
						</tbody>
					</table>';
			$return .= "<div style='vertical-align: text-top; border:1px solid black'>";

			
			$statics = $_SESSION["STATICS"];
			$upload_folder = $_SESSION["UPLOAD_FOLDER"];

			$dS = DIRECTORY_SEPARATOR;
			$params = $produit->getConfig();
			$UID_ENTREPRISE = $_SESSION[$params["GENERAL"]["ENVIRENMENT"]]["USER"]["entreprise_UID"];
			//var_dump($data);
			foreach($data as $k=>$v){
				
				
				$filesDirectory = $upload_folder.$UID_ENTREPRISE.$dS.'produits'.$dS.$v["produit_UID"].$dS;

				$link = $statics."public/images/images.png";
				if(file_exists($filesDirectory)){
					
					foreach(scandir($filesDirectory) as $kk=>$vv){
						if($vv <> "." and $vv <> ".." and strpos($vv, '.') !== false){
							$link = $statics.$UID_ENTREPRISE."/produits/".$v["produit_UID"]."/".$vv;
						}
					}	
				}
				

				$return .= '<div class="card" style="width:230px; max-width:230px; min-height:250px; display:inline-block; padding-bottom:17px">';
				$return .= '	<div class="img" style="position:relative">';
				$return .= '		<img src="'.$link.'">';
				$return .= '		<div style="position:absolute; top:0; right:0; font-size:16px;" class="label label-default">'.$v["produit_category"].'</div>';
				$return .= '	</div>';
				$return .= '	<div class="txt">';
				
				$return .= '		<h2>Code : '.$v["code"].'</h2>';
				$return .= '		<p>'.$v["libelle"].'</p>';
				$return .= '	</div>';
				$return .= '	<div style="padding:0 15px">';
				$return .= '		<label style="display:block; font-size:18px">Prix </label><input data-UID="'.$UID.'" data-produit_id="'.$v["id"].'" class="produit_prix_location" style="text-align:right" type="number" value="'.$v["prix_location"].'">';
				$return .= '	</div>';
				
				$return .= '</div>';
				
				$counter++;
				$total += $v["prix_location"];

			}
			
				$return .= '<table class="table">
								<tbody>
									<tr>
										<td colspan="5" style="text-align:right; font-size:24px; padding:10px 7px; background-color: white ; color:#015A5D; font-weight:bold"> Total : '.$produit->format($total).' </td>
									</tr>
								</tbody>
							</table>';	
			$return .= "</div>";
		}

		echo $counter === 0? $empty: $return;
		//var_dump($_POST);
		//$response  = array("code"=>1, "msg"=>$data);

	break;
		
	case "add":
		$UID =  isset($_POST["params"]["UID"])? addslashes( $_POST["params"]["UID"] ): "";
		require_once($core."Produit.php");
		$envirenment = $produit->config->get()["GENERAL"]["ENVIRENMENT"];
		
		$data = array(
			"id"				=>	$_POST["params"]["id"],
			"code"				=>	$_POST["params"]["code"],
			"taille"			=>	$_POST["params"]["taille"],
			"libelle"			=>	$_POST["params"]["libelle"],
			"prix_location"		=>	$_POST["params"]["prix"],
			"produit_UID"		=>	$_POST["params"]["produit_UID"],
			"produit_category"	=>	$_POST["params"]["produit_category"],
			"barcode"			=>	$_POST["params"]["barcode"],
		);
		
		if(isset($_SESSION[$envirenment]["LOCATION"][$UID])){
			array_push($_SESSION[$envirenment]["LOCATION"][$UID], $data);
		}else{
			$_SESSION[$envirenment]["LOCATION"][$UID][0] = $data;
		}
		//var_dump($_SESSION[$envirenment]["LOCATION"][$UID]);
		//unset($_SESSION[$envirenment]["LOCATION"][$UID]);
		//echo "1";

	break;
		
	case "remove":
		$UID =  isset($_POST["params"]["UID"])? addslashes( $_POST["params"]["UID"] ): "";
		$id =  isset($_POST["params"]["id"])? addslashes( $_POST["params"]["id"] ): "";
		require_once($core."Produit.php");
		$envirenment = $produit->config->get()["GENERAL"]["ENVIRENMENT"];
		
		foreach($_SESSION[$envirenment]["LOCATION"][$UID] as $k=>$v){
			if($v["id"] === $id){
				unset($_SESSION[$envirenment]["LOCATION"][$UID][$k]);
			}
		}

	break;
	
}


