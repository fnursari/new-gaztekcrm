<?
header("Content-Type: text/html; charset=utf-8"); session_start();
include_once "config.php";
include_once "../classes/ez_sql_core.php";  
include_once "../classes/ez_sql_mysql.php";  
$db = new ezSQL_mysql($cfg["DatabaseUsername"],$cfg["DatabasePassword"],$cfg["DatabaseName"],$cfg["DatabaseHost"]."");
$db->query("set names utf8");
if($_SESSION["user"]["auth"]==md5(session_id()."vizyoner"))  {
	$id=$_GET['id'];
	$gorus_aktif=$_GET['gorus_aktif'];
	$sayfanum=$_GET['sayfanum'];
	if($gorus_aktif=="1") {
		$gorus_guncelle="update musteri_gorusleri set gorus_aktif='0'";
		$gorus_guncelle.=" where id=$id";
	}
	else {
		$gorus_guncelle="update musteri_gorusleri set gorus_aktif='1'";
		$gorus_guncelle.="  where id=$id";
	} 
	$db->query($gorus_guncelle);
	header("location:admin.php?cmd=musteri_gorus_listesi&result=guncellendi&sayfanum=$sayfanum");
}
?>
