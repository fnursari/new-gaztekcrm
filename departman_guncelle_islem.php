<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php"; 
if(canUserAccessAdminArea()) {
	$departman_id=makeSafe($_GET["departman_id"]);
	$defaultUpdateData = [];


	$updateData  =[
		

	];


	
	$uploadImageData_Big = [
		"image" 				=> $_FILES["resim"],
		"imagename"				=> postDefaultLangugage('departman_ad'),
		"resize"				=> true,
		"uploadfolder"			=> $hostcfg["SiteRoot"].'upload/departments/',
		"resizedata" 			=> [ "width" => 800, "height" => 600 ],
	];
	if( ($resim_buyuk = uploadImage($uploadImageData_Big)) !==NULL) {
		$defaultUpdateData += array("resim_buyuk" => $resim_buyuk);
	}
	$uploadImageData_Small = [
		"image" 				=> $_FILES["resim"],
		"imagename" 			=> postDefaultLangugage('departman_ad'),
		"resize"				=> true,
		"uploadfolder"			=> $hostcfg["SiteRoot"].'upload/departments/',
		"resizedata" 			=> [ "width" => 400, "height" => 300 ],
	];
	if( ($resim_kucuk = uploadImage($uploadImageData_Small)) !==NULL) {
		$defaultUpdateData += array("resim_kucuk" => $resim_kucuk);
	}
	
	$languageUpdateData = prepareLanguagePost(array("departman_ad","departman_icerik"));
	$updateData += $defaultUpdateData + $languageUpdateData;
	$where 		= ["departman_id"	=>	$departman_id];
	updateTableData("departman",$updateData,$where);
	header("location:admin.php?cmd=departman_guncelle&departman_id=$departman_id&result=guncellendi");
}
?>