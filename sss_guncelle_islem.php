<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php"; 
if(canUserAccessAdminArea()) {
	$sss_id=$_GET["sss_id"];

	$languageUpdateData = prepareLanguagePost(array("sss_soru","sss_cevap"));
	$updateData =  $languageUpdateData;
	$where 		= ["sss_id"	=>	$sss_id];
	updateTableData("sss",$updateData,$where);
	header("location:admin.php?cmd=sss_guncelle&sss_id=$sss_id&result=guncellendi");
}
?>