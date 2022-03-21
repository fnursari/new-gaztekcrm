<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";   
if(canUserAccessAdminArea()) {
	$insertData  =[
		"deger"				=> $_POST['deger'],
		"birim"			=> $_POST['birim'],
	];
	$languageinsertData = prepareLanguagePost(array("baslik"));
	$insertData +=  $languageinsertData;

	$banner_id=insertDatatoTable("istatistik",$insertData);
	$updateData = ["sira"	=> $banner_id];
	$where		= ["id" 	=> $banner_id];
	updateTableData("istatistik",$updateData,$where);
	header("location:admin.php?cmd=istatistik_ekle&result=eklendi");
}
?>
