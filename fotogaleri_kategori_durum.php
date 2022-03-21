<?
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if($_SESSION["user"]["auth"]==md5(session_id()."vizyoner"))  {
	$kategori_id=$_GET['kategori_id'];
	$kategori_aktif=$_GET['kategori_aktif'];
	if($kategori_aktif=="1"){
		$kategori_guncelle="update fotogaleri_kategori set kategori_aktif='0'";
		$kategori_guncelle.=" where kategori_id=$kategori_id";
	}
	else {
		$kategori_guncelle="update fotogaleri_kategori set kategori_aktif='1'";
		$kategori_guncelle.="  where kategori_id=$kategori_id";
	} 
	$db->query($kategori_guncelle);
	header("location:admin.php?cmd=fotogaleri_kategori_ekle&result=guncellendi");
}
?>