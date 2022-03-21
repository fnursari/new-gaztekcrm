<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";   
if(canUserAccessAdminArea()) {



	$insertData  =[
		
		
	];
	

	$languageinsertData = prepareLanguagePost(array("departman_ad","departman_icerik"));
	
	$uploadImageData_Big = [
		"image" 				=> $_FILES["resim"],
		"imagename"				=> postDefaultLangugage('departman_ad'),
		"resize"				=> true,
		"uploadfolder"			=> $hostcfg["SiteRoot"].'upload/departments/',
		"resizedata" 			=> [ "width" => 800, "height" => 600 ],
	];
	$uploadImageData_Small = [
		"image" 				=> $_FILES["resim"],
		"imagename" 			=> postDefaultLangugage('departman_ad'),
		"resize"				=> true,
		"uploadfolder"			=> $hostcfg["SiteRoot"].'upload/departments/',
		"resizedata" 			=> [ "width" => 400, "height" => 300 ],
	];


	$defaultinsertData = [
		"resim_buyuk"			=> uploadImage($uploadImageData_Big),
		"resim_kucuk"			=> uploadImage($uploadImageData_Small),
	];

	$insertData +=$defaultinsertData +  $languageinsertData;
	$departman_id=insertDatatoTable("departman",$insertData);
	$updateData = ["sira"	=> $departman_id];
	$where		= ["departman_id" 	=> $departman_id];

	updateTableData("departman",$updateData,$where);
	header("location:admin.php?cmd=departman_ekle&result=eklendi");
}
?>