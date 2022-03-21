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
	$db->query("delete from urunvideo where urunvideo_id='$urunvideo_id'");
	header("location:admin.php?cmd=urunvideo&tablo=$tablo&tablo_id=$tablo_id&result=silindi&sayfanum=$sayfanum");
}
?>