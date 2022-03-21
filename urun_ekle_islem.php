<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";   
if(canUserAccessAdminArea()) {

	$ana_id=$_POST['ana_id'];
	/*$embed=$_POST['embed'];*/

	$insertData  =[
		"kategori_id"			=> $ana_id,
/*		"grm_no"				=> $_POST['grm_no'],
		"oem_no"				=> $_POST['oem_no'],
		"cross_no"				=> $_POST['cross_no'],
		"year"					=> $_POST['year'],
		"position"				=> $_POST['position'],
		"marka"					=> $_POST['marka'],
		"model"					=> $_POST['model'],*/
		
	];
	

	$languageinsertData = prepareLanguagePost(array("urun_ad","urun_icerik","teknik_tablo"));
	
	$uploadImageData_Big = [
		"image" 				=> $_FILES["resim"],
		"imagename"				=> postDefaultLangugage('urun_ad'),
		"resize"				=> true,
		"uploadfolder"			=> $hostcfg["SiteRoot"].'upload/product/',
		"resizedata" 			=> [ "width" => 1000, "height" => 1000 ],
	];
	$uploadImageData_Small = [
		"image" 				=> $_FILES["resim"],
		"imagename" 			=> postDefaultLangugage('urun_ad'),
		"resize"				=> true,
		"uploadfolder"			=> $hostcfg["SiteRoot"].'upload/product/',
		"resizedata" 			=> [ "width" => 500, "height" => 500 ],
	];


	$defaultinsertData = [
		"resim_buyuk"			=> uploadImage($uploadImageData_Big),
		"resim_kucuk"			=> uploadImage($uploadImageData_Small),
	];

	$insertData +=$defaultinsertData +  $languageinsertData;
	$urun_id=insertDatatoTable("urun",$insertData);
	$updateData = ["sira"	=> $urun_id];
	$where		= ["urun_id" 	=> $urun_id];

	updateTableData("urun",$updateData,$where);
	header("location:admin.php?cmd=urun_ekle&ana_id=$ana_id&result=eklendi");
}
?>