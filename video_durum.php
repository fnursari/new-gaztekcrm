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
			"video_aktif"          =>  ($_GET['video_aktif']=="1") ? '0' : '1',
		];
		$where = [
			"video_id"				=> $_GET["video_id"],
		];

		updateTableData("videolar",$updateData,$where);
		header("location:admin.php?cmd=video&tablo=$tablo&tablo_id=$tablo_id&result=guncellendi");
	}
?>