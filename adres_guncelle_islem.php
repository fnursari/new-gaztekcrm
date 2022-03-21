<?php
	session_start();
	header("Content-Type: text/html; charset=utf-8");
	DEFINE("_ADMIN_GIRDI","1");
	include_once "config.php";
	include_once $cfg["SiteRoot"]."db_connection.php";
	include_once $cfg["SiteRoot"]."functions.php"; 
	if(canUserAccessAdminArea()) {
		$adres_id=$_GET["adres_id"];
		$updateData = [
			"adres_content"         => $_POST['address_content'],
			"adres_name"          	=> $_POST['address_name'],
			"adres_state"          	=> 1,
		];
		$where 		= ["adres_id"	=>	$adres_id];
		updateTableData("adresler",$updateData,$where);
	}
?>