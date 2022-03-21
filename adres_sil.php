<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {
	$adres_id=$_GET['adres_id'];
	$where = [ "adres_id"	=>	$adres_id ];
	deleteTableData("adresler",$where);
	header("location:admin.php?cmd=config_guncelle&result=silindi");
}
?>