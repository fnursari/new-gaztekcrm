<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {
	$id=$_GET['id'];
	$where = [ "id"	=>	$id ];
	deleteTableData("kisi_iletisim",$where);
	header("location:admin.php?cmd=kisi_listesi&result=silindi");
}
?>