<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php"; 
if(canbankaAccessAdminArea()) {
	$banka_id=$_GET['banka_id'];

	$where = [ "banka_id"	=>	$banka_id ];
	deleteTableData("banka",$where);
	header("location:admin.php?cmd=bankalar&result=silindi");
}
?>