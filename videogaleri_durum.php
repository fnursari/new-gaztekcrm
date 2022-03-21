<?php
	session_start();
	header("Content-Type: text/html; charset=utf-8");
	DEFINE("_ADMIN_GIRDI","1");
	include_once "config.php";
	include_once $cfg["SiteRoot"]."db_connection.php";
	include_once $cfg["SiteRoot"]."functions.php";  
	if(canUserAccessAdminArea()) {
		$updateData = [
			"video_aktif"          =>  ($_GET['video_aktif']=="1") ? '0' : '1',
		];
		$where = [
			"video_id"				=> $_GET["video_id"],
		];

		updateTableData("video",$updateData,$where);
		header("location:admin.php?cmd=videogaleri_listesi&result=guncellendi");
	}
?>