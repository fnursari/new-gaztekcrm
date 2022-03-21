<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {

	$ana_id=$_POST['ana_id'];
	$insertData  =[
		"ana_id"			=> $ana_id,

	];
	$languageinsertData = prepareLanguagePost(array("kategori_ad","seo_baslik","seo_keyword","seo_description","aciklama"));

	$uploadImageData_Big = [
		"image" 				=> $_FILES["resim"],
		"imagename"				=> postDefaultLangugage('kategori_ad'),
		"resize"				=> true,
		"uploadfolder"			=> $hostcfg["SiteRoot"].'upload/category/',
		"resizedata" 			=> [ "width" => 800, "height" => 600, "type" => '' ],
	];
	$uploadImageData_Small = [
		"image" 				=> $_FILES["resim"],
		"imagename" 			=> postDefaultLangugage('kategori_ad'),
		"resize"				=> true,
		"uploadfolder"			=> $hostcfg["SiteRoot"].'upload/category/',
		"resizedata" 			=> [ "width" => 400, "height" => 300, "type" => '' ],
	];
	$uploadImageData_Icon = [
		"image" 				=> $_FILES["kategori_icon"],
		"imagename"				=> postDefaultLangugage('kategori_ad'),
		"resize"				=> false,
		"uploadfolder"			=> $hostcfg["SiteRoot"].'upload/category/',
		"resizedata" 			=> [ "width" => 150, "height" => 150, "type" =>'' ],
	];
	$uploadFileData = [
		"file" 					=> $_FILES["katalog"],
		"filename"				=> postDefaultLangugage('kategori_ad'),
		"uploadfolder"			=> $hostcfg["SiteRoot"].'upload/category/',
	];
	$defaultinsertData = [
		"kategori_resim"	=> uploadImage($uploadImageData_Big),
		"thumb"				=> uploadImage($uploadImageData_Small),
		"kategori_icon"		=> uploadImage($uploadImageData_Icon),
		"kategori_katalog"	=> uploadFile($uploadFileData),
	];
	$insertData += $defaultinsertData + $languageinsertData;
	$kategori_id 	= insertDatatoTable("urun_kategori",$insertData);
	$updateData = ["sira"		=>	$kategori_id];
	$where 		= ["kategori_id"	=>	$kategori_id];
	updateTableData("urun_kategori",$updateData,$where);
	
	header("location:admin.php?cmd=urun_kategori_ekle&result=eklendi&ana_id=$ana_id");
}
?>