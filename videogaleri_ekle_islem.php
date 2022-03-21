<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";   
if(canUserAccessAdminArea()) {

	$languageinsertData = prepareLanguagePost(array("video_ad"));

	$insertData = [
		'embed' 	=> $_POST['embed'],
	];


	$uploadImageData_Big = [
		"image" 				=> $_FILES["file"],
		"imagename"				=> postDefaultLangugage('video_ad'),
		"resize"				=> true,
		"uploadfolder"			=> $hostcfg["SiteRoot"].'upload/videogallery/',
		"resizedata" 			=> [ "width" => 800, "height" => 600 ],
	];
	$uploadImageData_Small = [
		"image" 				=> $_FILES["file"],
		"imagename" 			=> postDefaultLangugage('video_ad'),
		"resize"				=> true,
		"uploadfolder"			=> $hostcfg["SiteRoot"].'upload/videogallery/',
		"resizedata" 			=> [ "width" => 400, "height" => 300 ],
	];
	$defaultinsertData = [
		"resim"			=> uploadImage($uploadImageData_Big),
		"thumb"			=> uploadImage($uploadImageData_Small),
	];

	$insertData += $defaultinsertData +  $languageinsertData;

	$video_id=insertDatatoTable("video",$insertData);
	$updateData = ["sira"	=> $video_id];
	$where		= ["video_id" 	=> $video_id];
	updateTableData("video",$updateData,$where);
	header("location:admin.php?cmd=videogaleri_ekle&result=eklendi");
}
?>