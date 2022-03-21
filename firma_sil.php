<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {
	$firma_id=makeSafe($_GET['firma_id']);
	$updateData  =[
		"firma_silindi"					=> 1,
		"firma_silinme_tarihi"			=> date('Y-m-d H:i:s'),
		"firma_silen_kullanici"			=> $_SESSION["user"]["user_id"],
	];
	$where 		= ["firma_id"	=>	$firma_id];
	updateTableData("firma",$updateData,$where);
	header("location:admin.php?cmd=firma_listesi&result=silindi");
}