<?
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if($_SESSION["user"]["auth"]==md5(session_id()."vizyoner"))  {
	$kategori_id=$_GET['kategori_id'];
	$sql="select kategori_resim from proje_kategori where kategori_id='$kategori_id'";
	$kategoriler = $db->get_row($sql,ARRAY_A);
	if (($kategoriler["kategori_resim"]!="") and file_exists("../upload/".$kategoriler["kategori_resim"])) unlink("../upload/".$kategoriler["kategori_resim"]);
	$db->query("delete from proje_kategori where kategori_id=$kategori_id");
	header("location:admin.php?cmd=proje_kategori_listesi&result=silindi");
}
?>