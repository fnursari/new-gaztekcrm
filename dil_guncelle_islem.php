<?
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {
	$language_id=$_GET["language_id"];
	$language=explode("-", $_POST["lang_code"]);
	$language_code=$language[0];
	$language_name=$language[1];

	$updateData  =[
		"language_code"		=> $language_code,
		"language_name"		=> $language_name,

	];

	$where 		= ["language_id"	=>	$language_id];
	updateTableData("languages",$updateData,$where);
	header("location:admin.php?cmd=site_ayarlari&result=guncellendi");
}
?>