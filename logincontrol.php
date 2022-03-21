<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(md5(session_id()."mersoy")==$_POST["token_login"]) {
	$user_name=makeSafe($_POST["user_name"]);
	$user_pass=makeSafe($_POST["user_pass"]);
	$usercontrol = controlUserLogin($user_name,$user_pass);
	if(count($usercontrol)>0) {
		$last_online = $usercontrol["last_online"]!="" ? $usercontrol["last_online"] : date("Y-m-d H:i:s");
		$_SESSION["user"]["auth"]					= sha1(md5(session_id()."vizyoner"));
		$_SESSION["user"]["user_id"]				= $usercontrol["user_id"];
		$_SESSION["user"]["name"]					= $usercontrol["name"];
		$_SESSION["user"]["user_email"]				= $usercontrol["user_email"];
		$_SESSION["user"]["last_online"]			= $last_online;
		$_SESSION["user"]["group"]					= getUserGroupName($usercontrol["group_id"]);
		updateLastLogin($usercontrol["user_id"]);
		if(canUserAccessAdminArea()) {
			header("location:admin.php");
		}
		else {
			header("location:../");
		}
	}
	else {
		header("location:loginform.php?err=1");
	}
}
?>
