<?php
	session_start();
	header("Content-Type: text/html; charset=utf-8");
	DEFINE("_ADMIN_GIRDI","1");
	include_once "config.php";
	include_once $cfg["SiteRoot"]."db_connection.php";
	include_once $cfg["SiteRoot"]."functions.php"; 
	if(canUserAccessAdminArea()) {
		$insertData = [
			"adres_content"         => $_POST['adres_content'],
			"adres_name"          	=> $_POST['adres_name'],
			"lang"          		=> $_POST['lang'],
			"adres_state"          	=> 1,
		];
		insertDatatoTable("adresler",$insertData);
	}
?>