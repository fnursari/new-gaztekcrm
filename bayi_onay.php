<?
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {
	$bayi_id=$_GET['bayi_id'];
	$onay=$_GET['onay'];

	if($onay=="1")
	{
		$bayi_guncelle="update bayi_basvuru set onay='0'";
		$bayi_guncelle.=" where bayi_id=$bayi_id";
	}
	else
	{
		$bayi_guncelle="update bayi_basvuru set onay='1'";
		$bayi_guncelle.="  where bayi_id=$bayi_id";
	} 
	$db->query($bayi_guncelle);
	header("location:admin.php?cmd=main");
}
?>