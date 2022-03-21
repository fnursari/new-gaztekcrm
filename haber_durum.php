<?php
	session_start();
	header("Content-Type: text/html; charset=utf-8");
	DEFINE("_ADMIN_GIRDI","1");
	include_once "config.php";
	include_once $cfg["SiteRoot"]."db_connection.php";
	include_once $cfg["SiteRoot"]."functions.php";  
	if(canUserAccessAdminArea()) {
		$updateData = [
			"haber_aktif"          =>  ($_GET['haber_aktif']=="1") ? '0' : '1',
		];
		$where = [
			"haber_id"				=> $_GET["haber_id"],
		];

		updateTableData("haber",$updateData,$where);
		header("location:admin.php?cmd=haber_listesi&result=guncellendi");
	}
?>