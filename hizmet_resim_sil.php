<?
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if($_SESSION["user"]["auth"]==md5(session_id()."vizyoner"))  {
	$hizmet_id=$_GET['hizmet_id'];
	$sql="select resim_buyuk,resim_kucuk from hizmet where hizmet_id='$hizmet_id'";
	$resimler = $db->get_row($sql,ARRAY_A);
	if (($resimler["resim_buyuk"]!="") and file_exists("../upload/hizmet/".$resimler["resim_buyuk"])) {
		unlink("../upload/hizmet/".$resimler["resim_buyuk"]);
		unlink("../upload/hizmet/".$resimler["resim_kucuk"]);
	}
	$db->query("update hizmet set resim_kucuk='' , resim_buyuk='' where hizmet_id=$hizmet_id");
	header("location:admin.php?cmd=hizmet_guncelle&hizmet_id=$hizmet_id&result=silindi");
}
?>