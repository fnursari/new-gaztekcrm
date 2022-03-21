<?
header("Content-Type: text/html; charset=utf-8"); session_start();
include_once "config.php";
include_once "../classes/ez_sql_core.php";  
include_once "../classes/ez_sql_mysql.php";  
$db = new ezSQL_mysql($cfg["DatabaseUsername"],$cfg["DatabasePassword"],$cfg["DatabaseName"],$cfg["DatabaseHost"]."");
$db->query("set names utf8");
if($_SESSION["user"]["auth"]==md5(session_id()."vizyoner"))  {
	$referans_id=$_GET['referans_id'];
	$referans_aktif=$_GET['referans_aktif'];
	$sayfanum=$_GET['sayfanum'];
	if($referans_aktif=="1") {
		$referans_guncelle="update referans set referans_aktif='0'";
		$referans_guncelle.=" where referans_id=$referans_id";
	}
	else {
		$referans_guncelle="update referans set referans_aktif='1'";
		$referans_guncelle.="  where referans_id=$referans_id";
	} 
	$db->query($referans_guncelle);
	header("location:admin.php?cmd=referans_listesi&result=guncellendi&sayfanum=$sayfanum");
}
?>
