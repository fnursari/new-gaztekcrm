<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php"; 
if(canUserAccessAdminArea()) {
	$defaultUpdateData = [
	"yazi_renk1"	=> $_POST["yazi_renk1"],
	"yazi_renk2"	=> $_POST["yazi_renk2"],
	];
	$banner_id=$_GET["banner_id"];
	$languageUpdateData = prepareLanguagePost(array("slogan1","slogan2","slogan3","banner_link"));


	$uploadImageData_resim = [
		"image" 				=> $_FILES["resim"],
		"imagename" 			=> postDefaultLangugage('slogan1'),
		"resize"				=> true,
		"uploadfolder"			=> $hostcfg["SiteRoot"].'upload/banner/',
		"resizedata" 			=> [ "width" => 1920, "height" => 700, "type" =>'' ],
	];
	if( ($logo = uploadImage($uploadImageData_resim)) !==NULL) {
		$defaultUpdateData += array("resim" => $logo);
	}



	$updateData = $defaultUpdateData + $languageUpdateData;
	$where 		= ["banner_id"	=>	$banner_id];
	updateTableData("banner",$updateData,$where);
	header("location:admin.php?cmd=banner_guncelle&banner_id=$banner_id&result=guncellendi");
}
?>