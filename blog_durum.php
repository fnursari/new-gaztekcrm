<?
header("Content-Type: text/html; charset=utf-8"); session_start();
include_once "config.php";
include_once "../classes/ez_sql_core.php";  
include_once "../classes/ez_sql_mysql.php";  
$db = new ezSQL_mysql($cfg["DatabaseUsername"],$cfg["DatabasePassword"],$cfg["DatabaseName"],$cfg["DatabaseHost"]."");
$db->query("set names utf8");
if($_SESSION["user"]["auth"]==md5(session_id()."vizyoner"))  {
	$blog_id=$_GET['blog_id'];
	$blog_aktif=$_GET['blog_aktif'];
	$sayfanum=$_GET['sayfanum'];
	if($blog_aktif=="1") {
		$blog_guncelle="update blog set blog_aktif='0'";
		$blog_guncelle.=" where blog_id=$blog_id";
	}
	else {
		$blog_guncelle="update blog set blog_aktif='1'";
		$blog_guncelle.="  where blog_id=$blog_id";
	} 
	$db->query($blog_guncelle);
	header("location:admin.php?cmd=blog_listesi&result=guncellendi");
}
?>
