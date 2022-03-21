<?
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if($_SESSION["user"]["auth"]==md5(session_id()."vizyoner"))  {
	$proje_id=$_GET['proje_id'];
	$db->query("update proje set  image='', thumb='' where proje_id=$proje_id");
	header("location:admin.php?cmd=proje_guncelle&proje_id=$proje_id&result=silindi");
}
?>