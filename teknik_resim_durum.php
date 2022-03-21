<?
header("Content-Type: text/html; charset=utf-8"); session_start();
include_once "config.php";
include_once "../classes/ez_sql_core.php";  
include_once "../classes/ez_sql_mysql.php";  
$db = new ezSQL_mysql($cfg["DatabaseUsername"],$cfg["DatabasePassword"],$cfg["DatabaseName"],$cfg["DatabaseHost"]."");
$db->query("set names utf8");
if(canUserAccessAdminArea()) {
	$resim_id=$_GET['resim_id'];
	$tablo=$_GET['tablo'];
	$tablo_id=$_GET['tablo_id']; 
	$resim_aktif=$_GET['resim_aktif']; 
	if($resim_aktif=="1")
	{
		$resim_guncelle="update teknik_resim set resim_aktif='0'";
		$resim_guncelle.=" where resim_id=$resim_id";
	}
	else
	{
		$resim_guncelle="update teknik_resim set resim_aktif='1'";
		$resim_guncelle.="  where resim_id=$resim_id";
	} 
	$db->query($resim_guncelle);
	header("location:admin.php?cmd=teknik_resim&tablo=$tablo&tablo_id=$tablo_id&result=guncellendi");
}
?>