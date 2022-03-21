<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php"; 
if(canUserAccessAdminArea()) {
	$fotogaleri_id=$_GET["fotogaleri_id"];
	$defaultUpdateData = [];

	$languageUpdateData = prepareLanguagePost(array("fotogaleri_ad"));

	$uploadImageData_Big = [
		"image" 				=> $_FILES["file"],
		"imagename"				=> postDefaultLangugage('fotogaleri_ad'),
		"resize"				=> true,
		"uploadfolder"			=> $hostcfg["SiteRoot"].'upload/photogallery/',
		"resizedata" 			=> [ "width" => 800, "height" => 600 ],
	];
	if( ($image = uploadImage($uploadImageData_Big)) !==NULL) {
		$defaultUpdateData += array("image" => $image);
	}
	$uploadImageData_Small = [
		"image" 				=> $_FILES["file"],
		"imagename" 			=> postDefaultLangugage('fotogaleri_ad'),
		"resize"				=> true,
		"uploadfolder"			=> $hostcfg["SiteRoot"].'upload/photogallery/',
		"resizedata" 			=> [ "width" => 400, "height" => 300 ],
	];
	if( ($thumb = uploadImage($uploadImageData_Small)) !==NULL) {
		$defaultUpdateData += array("thumb" => $thumb);
	}

	$updateData = $defaultUpdateData + $languageUpdateData;
	$where 		= ["fotogaleri_id"	=>	$fotogaleri_id];
	updateTableData("fotogaleri",$updateData,$where);
	header("location:admin.php?cmd=fotogaleri_guncelle&fotogaleri_id=$fotogaleri_id&result=guncellendi");
}
?>