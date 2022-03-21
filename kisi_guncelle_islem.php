<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php"; 
if(canUserAccessAdminArea()) {
	$defaultUpdateData = [];
	$id=$_GET["id"];
	$languageUpdateData = prepareLanguagePost(array("bayi_ad"));

	$updateData  =[
		"firma_ad"			=> $_POST['firma_ad'],
		"kisi_ad"			=> $_POST['kisi_ad'],
		"telefon"			=> $_POST['telefon'],
		"email"				=> $_POST['email'],
		"adres"				=> $_POST['adres'],
		

	];



	$updateData += $languageUpdateData;
	$where 		= ["id"	=>	$id];
	updateTableData("kisi_iletisim",$updateData,$where);
	header("location:admin.php?cmd=kisi_guncelle&id=$id&result=guncellendi");
}
?>