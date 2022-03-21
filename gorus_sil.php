<?
header("Content-Type: text/html; charset=utf-8"); session_start();
include_once "config.php";
include_once "../classes/ez_sql_core.php";  
include_once "../classes/ez_sql_mysql.php";  
$db = new ezSQL_mysql($cfg["DatabaseUsername"],$cfg["DatabasePassword"],$cfg["DatabaseName"],$cfg["DatabaseHost"]."");
$db->query("set names utf8");
if($_SESSION["user"]["auth"]==md5(session_id()."vizyoner"))  {
	$id=$_GET['id'];
	$sayfanum=$_GET['sayfanum'];

	$db->query("delete from musteri_gorusleri where id=$id");
	header("location:admin.php?cmd=musteri_gorus_listesi&result=silindi&sayfanum=$sayfanum");
}
?>
