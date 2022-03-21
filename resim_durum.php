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
			"resim_aktif"          =>  ($_GET['resim_aktif']=="1") ? '0' : '1',
		];
		$where = [
			"resim_id"				=> $_GET["resim_id"],
		];

		updateTableData("resim",$updateData,$where);
		header("location:admin.php?cmd=resim&tablo=$tablo&tablo_id=$tablo_id&result=guncellendi");
	}
?>