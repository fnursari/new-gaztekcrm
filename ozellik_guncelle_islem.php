<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {
	$tablo=$_GET['tablo'];
	$tablo_id=$_GET['tablo_id']; 
	$ozellik_id=$_GET['ozellik_id'];

	$resim=$_FILES["file"]["name"]; 
	$defaultUpdateData = [];


	$languageUpdateData = prepareLanguagePost(array("title","description"));
	
	$uploadImageData_Big = [
		"image" 				=> $_FILES["file"],
		"imagename"				=> postDefaultLangugage('title'),
		"resize"				=> true,
		"resizedata" 			=> [ "width" => 128, "height" => 128, "type" =>'' ],
	];

	if($resim!="") {
		$defaultUpdateData = [
			"resim"			=> uploadImage($uploadImageData_Big),
		];
	}	


	$updateData = $defaultUpdateData + $languageUpdateData;
	$where 		= ["ozellik_id"	=>	$ozellik_id];
	updateTableData("ozellik",$updateData,$where);
	header("location:admin.php?cmd=ozellik&tablo=$tablo&tablo_id=$tablo_id&result=guncellendi");
}
?>