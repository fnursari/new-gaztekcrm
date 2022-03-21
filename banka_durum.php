<?php
	session_start();
	header("Content-Type: text/html; charset=utf-8");
	DEFINE("_ADMIN_GIRDI","1");
	include_once "config.php";
	include_once $cfg["SiteRoot"]."db_connection.php";
	include_once $cfg["SiteRoot"]."functions.php";  
	if(canUserAccessAdminArea()) {
		$updateData = [
			"banka_aktif"          =>  ($_GET['banka_aktif']=="1") ? '0' : '1',
		];
		$where = [
			"banka_id"				=> $_GET["banka_id"],
		];

		updateTableData("banka",$updateData,$where);
		header("location:admin.php?cmd=bankalar&result=guncellendi");
	}
?>