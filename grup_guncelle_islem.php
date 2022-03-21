<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {
	$group_id=$_GET["group_id"];
	$group_name=makeSafe($_POST['group_name']);

	$updateData = [
		"group_name" 			=> $group_name,
	];
	$where 		= ["group_id"	=>	$group_id];
	
	updateTableData("u1s9e2r6_group",$updateData,$where);
	header("location:admin.php?cmd=kullanicilar&result=guncellendi");
}
?>