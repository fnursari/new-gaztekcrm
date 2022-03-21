<?php
	session_start();
	header("Content-Type: text/html; charset=utf-8");
	DEFINE("_ADMIN_GIRDI","1");
	include_once "config.php";
	include_once $cfg["SiteRoot"]."db_connection.php";
	include_once $cfg["SiteRoot"]."functions.php";  
	if(canUserAccessAdminArea()) {
		$updateData = [
			"sss_aktif"          =>  ($_GET['sss_aktif']=="1") ? '0' : '1',
		];
		$where = [
			"sss_id"				=> $_GET["sss_id"],
		];

		updateTableData("sss",$updateData,$where);
		header("location:admin.php?cmd=sss_listesi&result=guncellendi");
	}
?>