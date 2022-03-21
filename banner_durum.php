<?php
	session_start();
	header("Content-Type: text/html; charset=utf-8");
	DEFINE("_ADMIN_GIRDI","1");
	include_once "config.php";
	include_once $cfg["SiteRoot"]."db_connection.php";
	include_once $cfg["SiteRoot"]."functions.php";  
	if(canUserAccessAdminArea()) {
		$updateData = [
			"banner_aktif"          =>  ($_GET['banner_aktif']=="1") ? '0' : '1',
		];
		$where = [
			"banner_id"				=> $_GET["banner_id"],
		];

		updateTableData("banner",$updateData,$where);
		header("location:admin.php?cmd=banner_listesi&result=guncellendi");
	}
?>