<?php
	session_start();
	header("Content-Type: text/html; charset=utf-8");
	DEFINE("_ADMIN_GIRDI","1");
	include_once "config.php";
	include_once $cfg["SiteRoot"]."db_connection.php";
	include_once $cfg["SiteRoot"]."functions.php";  
	if(canUserAccessAdminArea()) {
		$updateData = [
			"fotogaleri_aktif"          =>  ($_GET['fotogaleri_aktif']=="1") ? '0' : '1',
		];
		$where = [
			"fotogaleri_id"				=> $_GET["fotogaleri_id"],
		];

		updateTableData("fotogaleri",$updateData,$where);
		header("location:admin.php?cmd=fotogaleri_listesi&result=guncellendi");
	}
?>