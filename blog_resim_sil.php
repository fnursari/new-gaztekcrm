<?
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if($_SESSION["user"]["auth"]==md5(session_id()."vizyoner"))  {
	$blog_id=$_GET['blog_id'];
	$db->query("update blog set resim_kucuk='' , resim_buyuk='' where blog_id=$blog_id");
	header("location:admin.php?cmd=blog_guncelle&blog_id=$blog_id&result=silindi");
}
?>