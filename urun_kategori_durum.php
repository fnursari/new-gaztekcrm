<?php
	session_start();
	header("Content-Type: text/html; charset=utf-8");
	DEFINE("_ADMIN_GIRDI","1");
	include_once "config.php";
	include_once $cfg["SiteRoot"]."db_connection.php";
	include_once $cfg["SiteRoot"]."functions.php";  
	if(canUserAccessAdminArea()) {
		$updateData = [
			"kategori_aktif"          =>  ($_GET['kategori_aktif']=="1") ? '0' : '1',
		];
		$where = [
			"kategori_id"				=> $_GET["kategori_id"],
		];

		updateTableData("urun_kategori",$updateData,$where);
		header("location:admin.php?cmd=urun_kategori_listesi&result=guncellendi&sayfanum=$sayfanum");
	}
?>