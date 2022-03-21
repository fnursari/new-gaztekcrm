<?php
	session_start();
	header("Content-Type: text/html; charset=utf-8");
	DEFINE("_ADMIN_GIRDI","1");
	include_once "config.php";
	include_once $cfg["SiteRoot"]."db_connection.php";
	include_once $cfg["SiteRoot"]."functions.php";  
	if(canUserAccessAdminArea()) {
		$updateData = [
			"urun_aktif"          =>  ($_GET['urun_aktif']=="1") ? '0' : '1',
		];
		$where = [
			"urun_id"				=> $_GET["urun_id"],
		];

		updateTableData("urun",$updateData,$where);
		header("location:admin.php?cmd=urun_listesi&result=guncellendi");
	}
?>