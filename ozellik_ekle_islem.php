<?
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {

	$tablo=$_GET['tablo'];
	$tablo_id=$_GET['tablo_id'];

	$insertData = [
		"tablo"          => $_GET['tablo'],
		"tablo_id"       => $_GET['tablo_id'],

	];

	$languageinsertData = prepareLanguagePost(array("title","description"));

	$uploadImageData_Big = [
		"image" 				=> $_FILES["file"],
		"imagename"				=> postDefaultLangugage('title'),
		"resize"				=> true,
		"resizedata" 			=> [ "width" => 128, "height" => 128, "type" =>'' ],
	];
	
	
	
	$defaultinsertData = [
		"resim"			=> uploadImage($uploadImageData_Big),
	];
	
	
	$insertData += $defaultinsertData + $languageinsertData;
	$ozellik_id 	= insertDatatoTable("ozellik",$insertData);
	$updateData = ["sira"		=>	$ozellik_id];
	$where 		= ["ozellik_id"	=>	$ozellik_id];
	updateTableData("ozellik",$updateData,$where);

	header("location:admin.php?cmd=ozellik&tablo=$tablo&tablo_id=$tablo_id&result=eklendi");
}
?>