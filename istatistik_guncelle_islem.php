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
	$languageUpdateData = prepareLanguagePost(array("baslik"));
	$updateData  =[
		"deger"				=> $_POST['deger'],
		"birim"				=> $_POST['birim'],
		"icon"				=> $_POST['icon'],
	];
	$updateData += $languageUpdateData;
	$where 		= ["id"	=>	$id];
	updateTableData("istatistik",$updateData,$where);
	header("location:admin.php?cmd=istatistik_guncelle&id=$id&result=guncellendi");
}
?>