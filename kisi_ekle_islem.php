<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";   
if(canUserAccessAdminArea()) {
	

	$insertData  =[
		"firma_ad"			=> $_POST['firma_ad'],
		"kisi_ad"			=> $_POST['kisi_ad'],
		"telefon"			=> $_POST['telefon'],
		"email"				=> $_POST['email'],
		"adres"				=> $_POST['adres'],
	];
	

	$languageinsertData = prepareLanguagePost(array("bayi_ad"));
	

	$insertData +=  $languageinsertData;

	$banner_id=insertDatatoTable("kisi_iletisim",$insertData);
	$updateData = ["sira"	=> $banner_id];
	$where		= ["id" 	=> $banner_id];
	updateTableData("kisi_iletisim",$updateData,$where);
	header("location:admin.php?cmd=kisi_ekle&result=eklendi");
}
?>
