<?
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {
	$sayfa_id=$_GET['sayfa_id'];
	$sayfa_aktif=$_GET['sayfa_aktif'];
	$sayfanum=$_GET['sayfanum'];
	if($sayfa_aktif=="1")
	{
		$sayfa_guncelle="update sayfa set sayfa_aktif='0'";
		$sayfa_guncelle.=" where sayfa_id=$sayfa_id";
	}
	else
	{
		$sayfa_guncelle="update sayfa set sayfa_aktif='1'";
		$sayfa_guncelle.="  where sayfa_id=$sayfa_id";
	} 
	$db->query($sayfa_guncelle);
	header("location:admin.php?cmd=sayfa_listesi&result=guncellendi&sayfanum=$sayfanum");
}
?>