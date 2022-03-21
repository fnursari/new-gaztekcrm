<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php"; 
if(canUserAccessAdminArea()) {
	$urun_id=makeSafe($_GET["urun_id"]);
	$defaultUpdateData = [];

	$fiyat=makeSafe($_POST['fiyat']);
	if($fiyat!="") {
		$fiyat=str_replace(' TL','',$fiyat); 
		$fiyat=str_replace(',','',$fiyat);
	}


	$updateData  =[
		"fiyat"			=> $fiyat,
		

	];


	$uploadImageData_Big = [
		"image" 				=> $_FILES["resim"],
		"imagename"				=> postDefaultLangugage('urun_ad'),
		"resize"				=> true,
		"uploadfolder"			=> $hostcfg["SiteRoot"].'upload/usedproduct/',
		"resizedata" 			=> [ "width" => 800, "height" => 600 ],
	];
	if( ($resim_buyuk = uploadImage($uploadImageData_Big)) !==NULL) {
		$defaultUpdateData += array("resim_buyuk" => $resim_buyuk);
	}
	$uploadImageData_Small = [
		"image" 				=> $_FILES["resim"],
		"imagename" 			=> postDefaultLangugage('urun_ad'),
		"resize"				=> true,
		"uploadfolder"			=> $hostcfg["SiteRoot"].'upload/usedproduct/',
		"resizedata" 			=> [ "width" => 400, "height" => 300 ],
	];
	if( ($resim_kucuk = uploadImage($uploadImageData_Small)) !==NULL) {
		$defaultUpdateData += array("resim_kucuk" => $resim_kucuk);
	}
	
	$languageUpdateData = prepareLanguagePost(array("urun_ad","aciklama"));
	$updateData += $defaultUpdateData + $languageUpdateData;
	$where 		= ["urun_id"	=>	$urun_id];
	updateTableData("ikincielurun",$updateData,$where);
	header("location:admin.php?cmd=ikincielurun_guncelle&urun_id=$urun_id&result=guncellendi");
}
?>