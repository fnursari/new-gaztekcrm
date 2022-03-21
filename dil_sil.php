<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";
if(canUserAccessAdminArea()) {
	$language_id=$_GET['language_id'];

	$where = [ "language_id"	=>	$language_id ];
	deleteTableData("languages",$where);
	header("location:admin.php?cmd=site_ayarlari&result=silindi");
}
?>