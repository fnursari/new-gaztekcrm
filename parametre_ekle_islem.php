<?
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea() && $_SESSION["user"]["group"]=='root') {
	$tip_id=$_GET['tip_id'];
	$insertData = [
		"tip_id"          => $_GET['tip_id'],
		"kdv_orani"       => intval($_POST['kdv_orani']),
		"para_sembol"     => $_POST['para_sembol'],
	];

	$languageinsertData = prepareLanguagePost(array("parametre_deger","tezgah_olcusu","kesim_kalinligi","kdv_yazi","masraf_sahibi"));
	$insertData +=$insertData +  $languageinsertData;
	insertDatatoTable("parametreler",$insertData);
	header("location:admin.php?cmd=parametreler&tip_id=$tip_id&result=eklendi");
}