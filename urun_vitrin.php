<?
header("Content-Type: text/html; charset=utf-8"); 
session_start();
include_once "config.php";
include_once "../classes/ez_sql_core.php";  
include_once "../classes/ez_sql_mysql.php";  
$db = new ezSQL_mysql($cfg["DatabaseUsername"],$cfg["DatabasePassword"],$cfg["DatabaseName"],$cfg["DatabaseHost"]."");
if(canUserAccessAdminArea()) {
	require("pictureprocess.php");
	$urun_id=makeSafe($_GET['urun_id']);
	$urun_vitrin=$_GET['urun_vitrin'];
	$sayfanum=$_GET['sayfanum'];
	$kategori_ana=makeSafe($_GET['kategori_ana']);
	$urun_ad=makeSafe($_GET['urun_ad']);
	$urun_kod=makeSafe($_GET['urun_kod']);
	if($urun_vitrin=="1")
 	{
  		$urun_guncelle="update urun set urun_vitrin='0'";
  		$urun_guncelle.=" where urun_id=$urun_id";
  	}
 	else
 	{
  		$urun_guncelle="update urun set urun_vitrin='1'";
 		 $urun_guncelle.="  where urun_id=$urun_id";
 	} 
 	$db->query($urun_guncelle);
	header("location:admin.php?cmd=urun_listesi&result=guncellendi&sayfanum=$sayfanum&kategori_ana=$kategori_ana&urun_ad=$urun_ad&urun_kod=$urun_kod");
}
?>