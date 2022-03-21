<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php"; 
if(canUserAccessAdminArea()) {
	$fuar_id=$_GET["fuar_id"];
	$defaultUpdateData = [];
	$updateData = [
		"fuar_tarih" 			=> $_POST["fuar_tarih"],
	];

	$uploadImageData_Big = [
		"image" 				=> $_FILES["resim"],
		"imagename"				=> postDefaultLangugage('fuar_baslik'),
		"resize"				=> true,
		"uploadfolder"			=> $hostcfg["SiteRoot"].'upload/fairs/',
		"resizedata" 			=> [ "width" => 800, "height" => 432 ],
	];
	if( ($resim_buyuk = uploadImage($uploadImageData_Big)) !==NULL) {
		$defaultUpdateData += array("resim_buyuk" => $resim_buyuk);
	}
	$uploadImageData_Small = [
		"image" 				=> $_FILES["resim"],
		"imagename" 			=> postDefaultLangugage('fuar_baslik'),
		"resize"				=> true,
		"uploadfolder"			=> $hostcfg["SiteRoot"].'upload/fairs/',
		"resizedata" 			=> [ "width" => 400, "height" => 216 ],
	];
	if( ($resim_kucuk = uploadImage($uploadImageData_Small)) !==NULL) {
		$defaultUpdateData += array("resim_kucuk" => $resim_kucuk);
	}
	
	$languageUpdateData = prepareLanguagePost(array("fuar_baslik","fuar_icerik"));
	$updateData += $defaultUpdateData + $languageUpdateData;
	$where 		= ["fuar_id"	=>	$fuar_id];
	updateTableData("fuar",$updateData,$where);
	header("location:admin.php?cmd=fuar_guncelle&fuar_id=$fuar_id&result=guncellendi");
}
?>