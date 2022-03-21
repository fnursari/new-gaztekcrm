<?php
	session_start();
	header("Content-Type: text/html; charset=utf-8");
	DEFINE("_ADMIN_GIRDI","1");
	include_once "config.php";
	include_once $cfg["SiteRoot"]."db_connection.php";
	include_once $cfg["SiteRoot"]."functions.php";  
	if(canUserAccessAdminArea()) {
		$language_id=$_POST['id'];
		$language_state=$_POST['state'];
		$updateData = [
			"language_state"        =>  $language_state,
		];
		$where = [
			"language_id"				=> $language_id,
		];

		updateTableData("languages",$updateData,$where);
		echo "true";
	}
?>