<?
header("Content-Type: text/html; charset=utf-8"); session_start();
include_once "config.php";
include_once "../classes/ez_sql_core.php";  
include_once "../classes/ez_sql_mysql.php";  
$db = new ezSQL_mysql($cfg["DatabaseUsername"],$cfg["DatabasePassword"],$cfg["DatabaseName"],$cfg["DatabaseHost"]."");
$db->query("set names utf8");
if($_SESSION["user"]["auth"]==md5(session_id()."vizyoner"))  {
	$blog_id=$_GET['blog_id'];

	$sql="select resim_kucuk,resim_buyuk from blog where blog_id='$blog_id'";
	$blogler = $db->get_row($sql,ARRAY_A);
	if (($blogler["resim_kucuk"]!="") and file_exists("../upload/".$blogler["resim_kucuk"])) unlink("../upload/".$blogler["resim_kucuk"]);
	if (($blogler["resim_buyuk"]!="") and file_exists("../upload/".$blogler["resim_buyuk"])) unlink("../upload/".$blogler["resim_buyuk"]);

	$sql="select image,thumb from resim where tablo='blog' and tablo_id='$blog_id'";
	$galeriler = $db->get_results($sql,ARRAY_A);
	$galeri_x=0;
	if($db->num_rows > $galeri_x) {
		foreach ($galeriler as $galeri) {
			if (($galeri["image"]!="") and file_exists("../upload/".$galeri["image"])) unlink("../upload/".$galeri["image"]);
			if (($galeri["thumb"]!="") and file_exists("../upload/".$galeri["thumb"])) unlink("../upload/".$galeri["thumb"]);
			$db->query("delete from resim where tablo='blog' and tablo_id='$blog_id'");
			$galeri_x++;
		}
	}
	$db->query("delete from blog where blog_id=$blog_id");
	header("location:admin.php?cmd=blog_listesi&result=silindi");
}
?>
