<?
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if($_SESSION["user"]["auth"]==md5(session_id()."vizyoner"))  {
	require("pictureprocess.php");
	$kategori_ad_tr=makeSafe($_POST['kategori_ad_tr']);
	$kategori_ad_en=makeSafe($_POST['kategori_ad_en']);
	$kategori_ad_ru=makeSafe($_POST['kategori_ad_ru']);
	$kategori_ad_de=makeSafe($_POST['kategori_ad_de']);
	$kategori_ad_ar=makeSafe($_POST['kategori_ad_ar']);
	$kategori_ad_fr=makeSafe($_POST['kategori_ad_fr']);
	
	$kategori_ekle="insert into fotogaleri_kategori (kategori_ad_tr,kategori_ad_en,kategori_ad_ru,kategori_ad_ar,kategori_ad_de,kategori_ad_fr) values ";
	$kategori_ekle.="('$kategori_ad_tr','$kategori_ad_en','$kategori_ad_ru','$kategori_ad_ar' ,'$kategori_ad_de','$kategori_ad_fr')";
	$db->query($kategori_ekle);	
	$kategori_id=$db->insert_id;
	$db->query("update fotogaleri_kategori set sira='$kategori_id' where kategori_id='$kategori_id'");
	header("location:admin.php?cmd=fotogaleri_kategori_ekle&result=eklendi");
}
?>