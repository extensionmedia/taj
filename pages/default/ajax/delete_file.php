<?php session_start();

if(!isset($_SESSION['CORE'])){die("-1");}
if(!isset($_POST['link'])){die("-2");}
$core = $_SESSION['CORE'];
require_once($core."Helpers/Config.php");
require_once($core."Person_Activity.php");
$config = new Config;
$env = $config->get()["GENERAL"]["ENVIRENMENT"];

$link = $_POST['link'];
echo unlink($link);

$id = isset($_POST["id"])? $_POST["id"]:0;

$person_activity->saveActivity("fr",$_SESSION[$env]["USER"]["id"],array("Image","-1"),$id, $link);
//var_dump($_POST);
