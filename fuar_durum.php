<?php
	session_start();
	header("Content-Type: text/html; charset=utf-8");
	DEFINE("_ADMIN_GIRDI","1");
	include_once "config.php";
	include_once $cfg["SiteRoot"]."db_connection.php";
	include_once $cfg["SiteRoot"]."functions.php";  
	if(canUserAccessAdminArea()) {
		$updateData = [
			"fuar_aktif"          =>  ($_GET['fuar_aktif']=="1") ? '0' : '1',
		];
		$where = [
			"fuar_id"				=> $_GET["fuar_id"],
		];

		updateTableData("fuar",$updateData,$where);
		header("location:admin.php?cmd=fuar_listesi&result=guncellendi");
	}
?>