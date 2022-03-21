<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";   
if(canUserAccessAdminArea()) {

	$insertData = [
		"haber_tarih" 			=> $_POST["haber_tarih"],
	];

	$languageinsertData = prepareLanguagePost(array("haber_baslik","haber_icerik"));

	$uploadImageData_Big = [
		"image" 				=> $_FILES["resim"],
		"imagename"				=> postDefaultLangugage('haber_baslik'),
		"resize"				=> true,
		"uploadfolder"			=> $hostcfg["SiteRoot"].'upload/news/',
		"resizedata" 			=> [ "width" => 800, "height" => 600 ],
	];
	$uploadImageData_Small = [
		"image" 				=> $_FILES["resim"],
		"imagename" 			=> postDefaultLangugage('haber_baslik'),
		"resize"				=> true,
		"uploadfolder"			=> $hostcfg["SiteRoot"].'upload/news/',
		"resizedata" 			=> [ "width" => 400, "height" => 300 ],
	];
	$defaultinsertData = [
		"resim_buyuk"			=> uploadImage($uploadImageData_Big),
		"resim_kucuk"			=> uploadImage($uploadImageData_Small),
	];
	$insertData +=$defaultinsertData +  $languageinsertData;

	$haber_id=insertDatatoTable("haber",$insertData);
	$updateData = ["sira"	=> $haber_id];
	$where		= ["haber_id" 	=> $haber_id];
	updateTableData("haber",$updateData,$where);
	header("location:admin.php?cmd=haber_ekle&result=eklendi");
}
?>