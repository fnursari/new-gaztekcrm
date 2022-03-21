<?php
	session_start();
	header("Content-Type: text/html; charset=utf-8");
	DEFINE("_ADMIN_GIRDI","1");
	include_once "config.php";
	include_once $cfg["SiteRoot"]."db_connection.php";
	include_once $cfg["SiteRoot"]."functions.php"; 
	if(canUserAccessAdminArea()) {
		$hesap_id=$_GET["hesap_id"];
		$updateData = [
			"hesap_url"         => $_POST['account_url'],
			"hesap_name"        => $_POST['account_name'],
			"hesap_state"       => 1,
		];
		$where 		= ["hesap_id"	=>	$hesap_id];
		updateTableData("sosyal_medya",$updateData,$where);
	}
?>