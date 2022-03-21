<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea() && $_SESSION["user"]["group"]=='root')   {
	$user_id=$_GET["user_id"];
	$group_id=$_POST["group_id"];
	$name=makeSafe($_POST['name']);
	$user_email=makeSafe($_POST['user_email']);
	$user_pass=md5(trim($_POST['user_pass']));

	$updateData = [
		"user_pass"			=> $user_pass,
		"user_email"		=> $user_email,
		"name" 				=> $name,
		"group_id" 			=> $group_id,

	];
	$where 		= ["user_id"	=>	$user_id];
	
	updateTableData("u1s9e2r6",$updateData,$where);
	header("location:admin.php?cmd=kullanicilar&result=guncellendi");
}
?>