<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea() && $_SESSION["user"]["group"]=='root') {
	$parametre_id=$_GET['parametre_id'];
	$tip_id=$_GET['tip_id'];

	$updateData = [
		"parametre_silindi"          =>  '1',
	];
	$where = [
		"parametre_id"				=> $parametre_id,
	];
	updateTableData("parametreler",$updateData,$where);
	header("location:admin.php?cmd=parametreler&tip_id=$tip_id&result=silindi");
}