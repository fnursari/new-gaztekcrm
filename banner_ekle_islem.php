<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";   
if(canUserAccessAdminArea()) {
	$defaultinsertData = [
	"yazi_renk1"	=> $_POST["yazi_renk1"],
	"yazi_renk2"	=> $_POST["yazi_renk2"],
	];

	$languageinsertData = prepareLanguagePost(array("slogan1","slogan2","slogan3","banner_link"));

	$uploadImageData_resim = [
		"image" 				=> $_FILES["resim"],
		"imagename" 			=> postDefaultLangugage('slogan1'),
		"resize"				=> true,
		"uploadfolder"			=> $hostcfg["SiteRoot"].'upload/banner/',
		"resizedata" 			=> [ "width" => 1920, "height" => 700, "type" =>'' ],
	];

	$defaultinsertData = [
		"resim"			=> uploadImage($uploadImageData_resim),
	];


	$insertData = $defaultinsertData +  $languageinsertData;

	$banner_id=insertDatatoTable("banner",$insertData);
	$updateData = ["sira"	=> $banner_id];
	$where		= ["banner_id" 	=> $banner_id];
	updateTableData("banner",$updateData,$where);
	header("location:admin.php?cmd=banner_ekle&result=eklendi");
}
?>
