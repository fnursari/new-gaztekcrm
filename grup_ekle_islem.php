<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php"; 
if(canUserAccessAdminArea()) {
	$group_name=makeSafe($_POST['group_name']);

	$insertData = [
		"group_name" 		=> $group_name,

	];
	insertDatatoTable("u1s9e2r6_group",$insertData);
	header("location:admin.php?cmd=kullanicilar&result=eklendi");
}
?>