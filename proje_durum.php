<?
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {
	$proje_id=$_GET['proje_id'];
	$proje_aktif=$_GET['proje_aktif'];
	if($proje_aktif=="1")
	{
		$proje_guncelle="update proje set proje_aktif='0'";
		$proje_guncelle.=" where proje_id=$proje_id";
	}
	else
	{
		$proje_guncelle="update proje set proje_aktif='1'";
		$proje_guncelle.="  where proje_id=$proje_id";
	} 
	$db->query($proje_guncelle);
	header("location:admin.php?cmd=proje_listesi&result=guncellendi");
}
?>