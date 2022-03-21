<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {
	$sayfa_id = $_GET["sayfa_id"];
	if($_SESSION["user"]["group"]=='root')  {
    	$updateData = prepareLanguagePost(array("sayfa_ad","icerik","sayfa_link","sayfa_etiket"));
    } else {
    	$updateData = prepareLanguagePost(array("icerik"));
    }
	$where 		= ["sayfa_id"	=>	$sayfa_id];
	updateTableData("sayfa",$updateData,$where);
	header("location:admin.php?cmd=sayfa_guncelle&result=guncellendi&sayfa_id=".$sayfa_id);
}
?>