<?php
	session_start();
	header("Content-Type: text/html; charset=utf-8");
	DEFINE("_ADMIN_GIRDI","1");
	include_once "config.php";
	include_once $cfg["SiteRoot"]."db_connection.php";
	include_once $cfg["SiteRoot"]."functions.php";  
	if(canUserAccessAdminArea()) {
		$tablo=$_GET['tablo'];
		$tablo_id=$_GET['tablo_id'];
		$updateData = [
			"dosya_aktif"          =>  ($_GET['dosya_aktif']=="1") ? '0' : '1',
		];
		$where = [
			"dosya_id"				=> $_GET["dosya_id"],
		];

		updateTableData("dosya",$updateData,$where);
		header("location:admin.php?cmd=dosya&tablo=$tablo&tablo_id=$tablo_id&result=guncellendi");
	}
?>