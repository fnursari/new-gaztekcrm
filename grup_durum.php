<?php
	session_start();
	header("Content-Type: text/html; charset=utf-8");
	DEFINE("_ADMIN_GIRDI","1");
	include_once "config.php";
	include_once $cfg["SiteRoot"]."db_connection.php";
	include_once $cfg["SiteRoot"]."functions.php";  
	if(canUserAccessAdminArea()) {
		$updateData = [
			"group_state"          =>  ($_GET['group_state']=="1") ? '0' : '1',
		];
		$where = [
			"group_id"				=> $_GET["group_id"],
		];

		updateTableData("u1s9e2r6_group",$updateData,$where);
		header("location:admin.php?cmd=kullanicilar&result=guncellendi");
	}
?>