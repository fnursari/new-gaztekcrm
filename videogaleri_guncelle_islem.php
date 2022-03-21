<?php
	session_start();
	header("Content-Type: text/html; charset=utf-8");
	DEFINE("_ADMIN_GIRDI","1");
	include_once "config.php";
	include_once $cfg["SiteRoot"]."db_connection.php";
	include_once $cfg["SiteRoot"]."functions.php";  
	if(canUserAccessAdminArea()) {
	$video_id=$_GET["video_id"];
	$defaultUpdateData = [];

	$updateData = [
		'embed' 	=> $_POST['embed'],
	];	

	$uploadImageData_Big = [
		"image" 				=> $_FILES["file"],
		"imagename"				=> postDefaultLangugage('video_ad'),
		"resize"				=> true,
		"uploadfolder"			=> $hostcfg["SiteRoot"].'upload/videogallery/',
		"resizedata" 			=> [ "width" => 800, "height" => 600 ],
	];
	if( ($resim = uploadImage($uploadImageData_Big)) !==NULL) {
		$defaultUpdateData += array("resim" => $resim);
	}
	$uploadImageData_Small = [
		"image" 				=> $_FILES["resim"],
		"imagename" 			=> postDefaultLangugage('video_ad'),
		"resize"				=> true,
		"uploadfolder"			=> $hostcfg["SiteRoot"].'upload/videogallery/',
		"resizedata" 			=> [ "width" => 400, "height" => 300 ],
	];
	if( ($thumb = uploadImage($uploadImageData_Small)) !==NULL) {
		$defaultUpdateData += array("thumb" => $thumb);
	}

	$languageUpdateData = prepareLanguagePost(array("video_ad"));

	$updateData += $defaultUpdateData + $languageUpdateData;
	$where 		= ["video_id"	=>	$video_id];
	updateTableData("video",$updateData,$where);
	header("location:admin.php?cmd=videogaleri_guncelle&video_id=$video_id&result=guncellendi");
}
?>
