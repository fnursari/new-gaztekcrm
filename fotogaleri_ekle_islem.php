<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";   
if(canUserAccessAdminArea()) {

	$languageinsertData = prepareLanguagePost(array("fotogaleri_ad"));

	$uploadImageData_Big = [
		"image" 				=> $_FILES["file"],
		"imagename"				=> postDefaultLangugage('fotogaleri_ad'),
		"resize"				=> true,
		"uploadfolder"			=> $hostcfg["SiteRoot"].'upload/photogallery/',
		"resizedata" 			=> [ "width" => 800, "height" => 600 ],

	];
	$uploadImageData_Small = [
		"image" 				=> $_FILES["file"],
		"imagename" 			=> postDefaultLangugage('fotogaleri_ad'),
		"resize"				=> true,
		"uploadfolder"			=> $hostcfg["SiteRoot"].'upload/photogallery/',
		"resizedata" 			=> [ "width" => 400, "height" => 300 ],
	];
	$defaultinsertData = [
		"image"			=> uploadImage($uploadImageData_Big),
		"thumb"			=> uploadImage($uploadImageData_Small),
	];

	$insertData =$defaultinsertData +  $languageinsertData;

	$fotogaleri_id=insertDatatoTable("fotogaleri",$insertData);
	$updateData = ["sira"	=> $fotogaleri_id];
	$where		= ["fotogaleri_id" 	=> $fotogaleri_id];
	updateTableData("fotogaleri",$updateData,$where);
	header("location:admin.php?cmd=fotogaleri_ekle&result=eklendi");
}
?>