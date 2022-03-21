<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";   
if(canUserAccessAdminArea()) {

	$fiyat=makeSafe($_POST['fiyat']);
	if($fiyat!="") {
		$fiyat=str_replace(' TL','',$fiyat); 
		$fiyat=str_replace(',','',$fiyat);
	}

	$insertData  =[
		"fiyat"				=> $fiyat,
		
	];
	

	$languageinsertData = prepareLanguagePost(array("urun_ad","aciklama"));
	
	$uploadImageData_Big = [
		"image" 				=> $_FILES["resim"],
		"imagename"				=> postDefaultLangugage('urun_ad'),
		"resize"				=> true,
		"uploadfolder"			=> $hostcfg["SiteRoot"].'upload/usedproduct/',
		"resizedata" 			=> [ "width" => 800, "height" => 600 ],
	];
	$uploadImageData_Small = [
		"image" 				=> $_FILES["resim"],
		"imagename" 			=> postDefaultLangugage('urun_ad'),
		"resize"				=> true,
		"uploadfolder"			=> $hostcfg["SiteRoot"].'upload/usedproduct/',
		"resizedata" 			=> [ "width" => 400, "height" => 300 ],
	];
	

	$defaultinsertData = [
		"resim_buyuk"			=> uploadImage($uploadImageData_Big),
		"resim_kucuk"			=> uploadImage($uploadImageData_Small),
	];

	$insertData +=$defaultinsertData +  $languageinsertData;
	$urun_id=insertDatatoTable("ikincielurun",$insertData);
	$updateData = ["sira"	=> $urun_id];
	$where		= ["urun_id" 	=> $urun_id];

	updateTableData("ikincielurun",$updateData,$where);
	header("location:admin.php?cmd=ikincielurun_ekle&ana_id=$ana_id&result=eklendi");
}
?>