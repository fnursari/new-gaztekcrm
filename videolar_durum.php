<?
header("Content-Type: text/html; charset=utf-8"); session_start();
include_once "config.php";
include_once "../classes/ez_sql_core.php";  
include_once "../classes/ez_sql_mysql.php";  
$db = new ezSQL_mysql($cfg["DatabaseUsername"],$cfg["DatabasePassword"],$cfg["DatabaseName"],$cfg["DatabaseHost"]."");
$db->query("set names utf8");
if(canUserAccessAdminArea()) {
	$video_id=$_GET['video_id'];
	$tablo=$_GET['tablo'];
	$tablo_id=$_GET['tablo_id']; 
	$video_aktif=$_GET['video_aktif']; 
	if($video_aktif=="1")
	{
		$video_id_guncelle="update videolar set video_aktif='0'";
		$video_id_guncelle.=" where video_id=$video_id";
	}
	else
	{
		$video_id_guncelle="update videolar set video_aktif='1'";
		$video_id_guncelle.="  where video_id=$video_id";
	} 
	$db->query($video_id_guncelle);
	header("location:admin.php?cmd=video&tablo=$tablo&tablo_id=$tablo_id&result=guncellendi");
}
?>