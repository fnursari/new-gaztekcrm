<?php
	session_start();
	header("Content-Type: text/html; charset=utf-8");
	DEFINE("_ADMIN_GIRDI","1");
	include_once "config.php";
	include_once $cfg["SiteRoot"]."db_connection.php";
	include_once $cfg["SiteRoot"]."functions.php";  
	if(canUserAccessAdminArea()) {
		$updateData = [
			"departman_aktif"          =>  ($_GET['departman_aktif']=="1") ? '0' : '1',
		];
		$where = [
			"departman_id"				=> $_GET["departman_id"],
		];

		updateTableData("departman",$updateData,$where);
		header("location:admin.php?cmd=departman_listesi&result=guncellendi");
	}
?>