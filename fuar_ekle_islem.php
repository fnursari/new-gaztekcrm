<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";   
if(canUserAccessAdminArea()) {

	$insertData = [
		"fuar_tarih" 			=> $_POST["fuar_tarih"],
	];

	$languageinsertData = prepareLanguagePost(array("fuar_baslik","fuar_icerik"));

	$uploadImageData_Big = [
		"image" 				=> $_FILES["resim"],
		"imagename"				=> postDefaultLangugage('fuar_baslik'),
		"resize"				=> true,
		"uploadfolder"			=> $hostcfg["SiteRoot"].'upload/fairs/',
		"resizedata" 			=> [ "width" => 800, "height" => 432 ],
	];
	$uploadImageData_Small = [
		"image" 				=> $_FILES["resim"],
		"imagename" 			=> postDefaultLangugage('fuar_baslik'),
		"resize"				=> true,
		"uploadfolder"			=> $hostcfg["SiteRoot"].'upload/fairs/',
		"resizedata" 			=> [ "width" => 400, "height" => 216 ],
	];
	$defaultinsertData = [
		"resim_buyuk"			=> uploadImage($uploadImageData_Big),
		"resim_kucuk"			=> uploadImage($uploadImageData_Small),
	];
	$insertData +=$defaultinsertData +  $languageinsertData;

	$fuar_id=insertDatatoTable("fuar",$insertData);
	$updateData = ["sira"	=> $fuar_id];
	$where		= ["fuar_id" 	=> $fuar_id];
	updateTableData("fuar",$updateData,$where);
	header("location:admin.php?cmd=fuar_ekle&result=eklendi");
}
?>