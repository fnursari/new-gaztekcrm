<?
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {

	$language=explode("-", $_POST["language_code"]);
	$language_code=$language[0];
	$language_name=$language[1];

	$insertData  =[
		"language_name"		=> $language_name,
		"language_code"		=> $language_code,
		"language_state"	=> 1,

	];

	insertDatatoTable("languages",$insertData);
	header("location:admin.php?cmd=site_ayarlari&result=eklendi");
}
?>