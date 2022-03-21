<?php
	session_start();
	header("Content-Type: text/html; charset=utf-8");
	DEFINE("_ADMIN_GIRDI","1");
	include_once "config.php";
	include_once $cfg["SiteRoot"]."db_connection.php";
	include_once $cfg["SiteRoot"]."functions.php"; 
	if(canUserAccessAdminArea()) {
		$insertData = [
			"hesap_url"         => $_POST['hesap_url'],
			"hesap_name"        => $_POST['hesap_name'],
			"hesap_state"       => 1,
		];
		insertDatatoTable("sosyal_medya",$insertData);
	}
?>