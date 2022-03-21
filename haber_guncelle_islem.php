<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php"; 
if(canUserAccessAdminArea()) {
	$haber_id=$_GET["haber_id"];
	$defaultUpdateData = [];
	$updateData = [
		"haber_tarih" 			=> $_POST["haber_tarih"],
	];

	$uploadImageData_Big = [
		"image" 				=> $_FILES["resim"],
		"imagename"				=> postDefaultLangugage('haber_baslik'),
		"resize"				=> true,
		"uploadfolder"			=> $hostcfg["SiteRoot"].'upload/news/',
		"resizedata" 			=> [ "width" => 800, "height" => 600 ],
	];
	if( ($resim_buyuk = uploadImage($uploadImageData_Big)) !==NULL) {
		$defaultUpdateData += array("resim_buyuk" => $resim_buyuk);
	}
	$uploadImageData_Small = [
		"image" 				=> $_FILES["resim"],
		"imagename" 			=> postDefaultLangugage('haber_baslik'),
		"resize"				=> true,
		"uploadfolder"			=> $hostcfg["SiteRoot"].'upload/news/',
		"resizedata" 			=> [ "width" => 400, "height" => 300 ],
	];
	if( ($resim_kucuk = uploadImage($uploadImageData_Small)) !==NULL) {
		$defaultUpdateData += array("resim_kucuk" => $resim_kucuk);
	}
	
	$languageUpdateData = prepareLanguagePost(array("haber_baslik","haber_icerik"));
	$updateData += $defaultUpdateData + $languageUpdateData;
	$where 		= ["haber_id"	=>	$haber_id];
	updateTableData("haber",$updateData,$where);
	header("location:admin.php?cmd=haber_guncelle&haber_id=$haber_id&result=guncellendi");
}
?>