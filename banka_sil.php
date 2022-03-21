<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php"; 
if(canUserAccessAdminArea()) {
	$user_id=$_GET['user_id'];

	$where = [ "user_id"	=>	$user_id ];
	deleteTableData("u1s9e2r6",$where);
	header("location:admin.php?cmd=kullanicilar&result=silindi");
}
?>