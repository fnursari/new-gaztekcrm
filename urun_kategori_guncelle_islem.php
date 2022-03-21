<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {
	$kategori_id=$_GET["kategori_id"];
	$defaultupdateData=[];
	
	$updateData=[
		"ana_id" 				=> $_POST["ana_id"],
	];

	$resim=$_FILES["resim"]["name"]; 
	$icon=$_FILES["kategori_icon"]["name"]; 

	
	$languageUpdateData = prepareLanguagePost(array("kategori_ad","seo_baslik","seo_keyword","seo_description","aciklama"));

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
	if($resim!="") {
		$defaultupdateData += [
			"kategori_resim"	=> uploadImage($uploadImageData_Big),
			"thumb"				=> uploadImage($uploadImageData_Small)
		];
	}
	if($icon!="") {
		$defaultupdateData += [
			"kategori_icon"		=> uploadImage($uploadImageData_Icon)
		];
	}
	$uploadFileData = [
		"file" 					=> $_FILES["katalog"],
		"filename"				=> postDefaultLangugage('katalog_ad'),
		"uploadfolder"			=> $hostcfg["SiteRoot"].'upload/category/',
	];	
	if( ($kategori_katalog = uploadFile($uploadFileData)) !==NULL) {
		$defaultupdateData += array("kategori_katalog" => $kategori_katalog);
	}

	/*echo '<pre>';
	print_r($defaultupdateData);
	echo '</pre>';*/


	$updateData += $defaultupdateData + $languageUpdateData;
	$where 		= ["kategori_id"	=>	$kategori_id];
	updateTableData("urun_kategori",$updateData,$where);
	header("location:admin.php?cmd=urun_kategori_guncelle&kategori_id=$kategori_id&result=guncellendi");
}
?>