<?
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {
	$hizmet_id=$_GET['hizmet_id'];
	$hizmet_aktif=$_GET['hizmet_aktif'];
	$sayfanum=$_GET['sayfanum'];
		$ana_id=$_GET['ana_id'];
	$str=$_GET['str'];
	if($hizmet_aktif=="1")
	{
		$hizmet_guncelle="update hizmet set hizmet_aktif='0'";
		$hizmet_guncelle.=" where hizmet_id=$hizmet_id";
	}
	else
	{
		$hizmet_guncelle="update hizmet set hizmet_aktif='1'";
		$hizmet_guncelle.="  where hizmet_id=$hizmet_id";
	} 
	$db->query($hizmet_guncelle);
	header("location:admin.php?cmd=hizmet_listesi&result=guncellendi");
}
?>