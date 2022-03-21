<?
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if($_SESSION["user"]["auth"]==md5(session_id()."vizyoner"))  {
	$banner_id=$_GET['banner_id'];
	$db->query("update banner set video='' where banner_id=$banner_id");
	header("location:admin.php?cmd=banner_guncelle&banner_id=$banner_id&result=silindi");
}
?>