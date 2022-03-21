<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php"; 
if(canUserAccessAdminArea()) {
	$urun_id=makeSafe($_GET["urun_id"]);
	$ana_id=$_POST["ana_id"];
	$defaultUpdateData = [];


	$updateData  =[
		"kategori_id"			=> $ana_id,
		/*"grm_no"				=> $_POST['grm_no'],
		"oem_no"				=> $_POST['oem_no'],
		"cross_no"				=> $_POST['cross_no'],
		"year"					=> $_POST['year'],
		"position"				=> $_POST['position'],
		"marka"					=> $_POST['marka'],
		"model"					=> $_POST['model'],*/
		

	];


	
	$uploadImageData_Big = [
		"image" 				=> $_FILES["resim"],
		"imagename"				=> postDefaultLangugage('urun_ad'),
		"resize"				=> true,
		"uploadfolder"			=> $hostcfg["SiteRoot"].'upload/product/',
		"resizedata" 			=> [ "width" => 1000, "height" => 1000 ],
	];
	if( ($resim_buyuk = uploadImage($uploadImageData_Big)) !==NULL) {
		$defaultUpdateData += array("resim_buyuk" => $resim_buyuk);
	}
	$uploadImageData_Small = [
		"image" 				=> $_FILES["resim"],
		"imagename" 			=> postDefaultLangugage('urun_ad'),
		"resize"				=> true,
		"uploadfolder"			=> $hostcfg["SiteRoot"].'upload/product/',
		"resizedata" 			=> [ "width" => 500, "height" => 500 ],
	];
	if( ($resim_kucuk = uploadImage($uploadImageData_Small)) !==NULL) {
		$defaultUpdateData += array("resim_kucuk" => $resim_kucuk);
	}

	$languageUpdateData = prepareLanguagePost(array("urun_ad","urun_icerik","teknik_tablo"));
	$updateData += $defaultUpdateData + $languageUpdateData;
	$where 		= ["urun_id"	=>	$urun_id];
	updateTableData("urun",$updateData,$where);
	header("location:admin.php?cmd=urun_guncelle&urun_id=$urun_id&result=guncellendi");
}
?>