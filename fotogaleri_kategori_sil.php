<?
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if($_SESSION["user"]["auth"]==md5(session_id()."vizyoner"))  {
	$kategori_id=$_GET['kategori_id'];
	
	
	
	$db->query("delete from fotogaleri_kategori where kategori_id=$kategori_id");
	header("location:admin.php?cmd=fotogaleri_kategori_ekle&result=silindi");
}
?>