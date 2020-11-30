<?php session_start();

if(!isset($_SESSION['CORE'])){die(-1);}
if (!isset($_POST["param"])){die(-1);}

$core = $_SESSION['CORE'];
$D_S = DIRECTORY_SEPARATOR;
$path_to_config_file = $core."Helpers".$D_S."Config.php";
if(file_exists($path_to_config_file)){
	require_once($path_to_config_file);
	$config = new Config;
	$envirenment = $config->get()["GENERAL"]["ENVIRENMENT"];
	
	
}else{
	die("ERROR! : Config file not found!" );
}

if(isset($_POST["param"]["action"])){
	if($_POST["param"]["action"] == "login"){

		$isok = false;
		$message = "";

		if (isset($_POST['param']['args']['login'], $_POST["param"]['args']['password'])){					// Verifie si les valeurs sont envoyées
			if(!empty($_POST['param']['args']['login']) && !empty($_POST["param"]['args']['password'])){		// Verifie si les valeurs ne sont pas vide
				if(isset($_POST['param']['args']['formToken'])){							// Verifie si la variable Unique est définie
					if(isset($_SESSION[$envirenment]['formToken'])){
						if($_POST['param']['args']['formToken'] == $_SESSION[$envirenment]['formToken']){	// Vérifie si la variable touken est la même que celle envoyée
							//$login = $_POST['login'];
							$login = str_replace("/","",$_POST['param']['args']['login']);
							$login = str_replace("'","",$login); 
							$login = str_replace("=","",$login); 
							$login = str_replace("\\","",$login); 
							$password = md5($_POST['param']['args']['password']);

							if (strlen($login) > 3){

								$core = $_SESSION['CORE'];
								require_once($core.'Person.php');

								$data = $person->checkLogin(array($login,$password));

								if( is_array($data)){		// Login OR Paswword does not exist	
									$isok = true;
									unset($_SESSION[$envirenment]['formToken'], $_SESSION["ERRORS"]['USER']);
									$_SESSION[$envirenment]["USER"] = $data[0];
									
									$person->saveActivity("fr",$data[0]["id"],array("Log",1),"0");
									if(isset( $_POST['param']['args']['remember'])){
										if($_POST['param']['args']['remember'] == '1'){
											setcookie($envirenment."-REMEMBER_LOGIN", $login, time() + (86400 * 30), "/");
											setcookie($envirenment."-REMEMBER_PASSWORD", $_POST['param']['args']['password'], time() + (86400 * 30), "/");											
										}else{
											$expire = time() - 300;
											setcookie($envirenment."-REMEMBER_LOGIN", '', $expire);
											setcookie($envirenment."-REMEMBER_PASSWORD", '', $expire);
										}										
									}else{
										$expire = time() - 300;
										setcookie($envirenment."-REMEMBER_LOGIN", '', $expire);
										setcookie($envirenment."-REMEMBER_PASSWORD", '', $expire);
									}


								}else{
									$message .= "<b> Erreur!</b> Login / Password : incorrects!";
								}
							}else{
								$message .= "Longeur : ".strlen($login);	
							}

						}else{
							$message .= "Form Touken not match : ";	
						}						
					}else{
						$message .= "SESSION EROOR  ";
					}

				}else{
					$message .= "Form Touken unset: ".$_POST['formToken'];	
				}	
			}else{
				$message .= "Empty : ";
			}
		}else{
				$message .= "Unset : ";
		}

		if($isok){
			echo 1;
		}else{ 
			echo $message;
		}

	}else{
		$core = $_SESSION['CORE'];
		//require_once($core.'Person.php');
		//$person->saveActivity("fr",$_SESSION[$envirenment]["USER"]["id"],array("Log",0),"0");
		unset($_SESSION[$envirenment]["USER"]);
		echo 1;
	}
}else{
	echo -2;
}





