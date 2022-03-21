<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {
	$tablo=$_GET['tablo'];
	$tablo_id=$_GET['tablo_id']; 
	$video_id=$_GET['video_id'];


	$resim=$_FILES["file"]["name"]; 
	$defaultUpdateData = [];

	$languageUpdateData = prepareLanguagePost(array("ad"));

	$updateData  =[
		"video_link"	=> $_POST['video_link'],
		
	];

	$uploadImageData_Big = [
		"image" 				=> $_FILES["file"],
		"imagename"				=> postDefaultLangugage('ad'),
		"resize"				=> true,
		"resizedata" 			=> [ "width" => 800, "height" => 600],
	];
	$uploadImageData_Small = [
		"image" 				=> $_FILES["file"],
		"imagename" 			=> postDefaultLangugage('ad'),
		"resize"				=> true,
		"resizedata" 			=> [ "width" => 400, "height" => 300],
	];

	
	if($resim!="") {
		$defaultUpdateData = [
			"image"			=> uploadImage($uploadImageData_Big),
			"thumb"			=> uploadImage($uploadImageData_Small)
		];
	}	


	$updateData += $defaultUpdateData + $languageUpdateData;
	$where 		= ["video_id"	=>	$video_id];
	updateTableData("videolar",$updateData,$where);
	header("location:admin.php?cmd=video&tablo=$tablo&tablo_id=$tablo_id&result=guncellendi");
}
?>