<?
header("Content-Type: text/html; charset=utf-8"); session_start();
include_once "config.php";
include_once "../classes/ez_sql_core.php";  
include_once "../classes/ez_sql_mysql.php";  
$db = new ezSQL_mysql($cfg["DatabaseUsername"],$cfg["DatabasePassword"],$cfg["DatabaseName"],$cfg["DatabaseHost"]."");
$db->query("set names utf8");
if(canUserAccessAdminArea()) {
	$urunvideo_id=$_GET['urunvideo_id'];
	$sayfanum=$_GET['sayfanum'];
	$tablo=$_GET['tablo'];
	$tablo_id=$_GET['tablo_id']; 
	$urunvideo_aktif=$_GET['urunvideo_aktif']; 
	if($urunvideo_aktif=="1")
	{
		$urunvideo_id_guncelle="update urunvideo set urunvideo_aktif='0'";
		$urunvideo_id_guncelle.=" where urunvideo_id=$urunvideo_id";
	}
	else
	{
		$urunvideo_id_guncelle="update urunvideo set urunvideo_aktif='1'";
		$urunvideo_id_guncelle.="  where urunvideo_id=$urunvideo_id";
	} 
	$db->query($urunvideo_id_guncelle);
	header("location:admin.php?cmd=urunvideo&tablo=$tablo&tablo_id=$tablo_id&result=guncellendi&sayfanum=$sayfanum");
}
?>