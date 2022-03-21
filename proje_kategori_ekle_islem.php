<?
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if($_SESSION["user"]["auth"]==md5(session_id()."vizyoner"))  {
	require("pictureprocess.php");
	$ana_id=$_POST['ana_id'];
	$kategori_ad_tr=makeSafe($_POST['kategori_ad_tr']);
	$kategori_ad_en=makeSafe($_POST['kategori_ad_en']);
	$kategori_ad_ru=makeSafe($_POST['kategori_ad_ru']);
	$kategori_ad_ru=makeSafe($_POST['kategori_ad_ru']);
	$aciklama_en=makeSafe($_POST['aciklama_en']);	
	$aciklama_tr=makeSafe($_POST['aciklama_tr']);
	$aciklama_ru=makeSafe($_POST['aciklama_ru']);	
	$aciklama_ar=makeSafe($_POST['aciklama_ar']);	
	$resimdir = '../upload/';
	$resim=$_FILES["resim"]["name"];
	$tmp_resim=$_FILES["resim"]["tmp_name"];
	if($resim!="") {
		$image = new SimpleImage();
		$resized_thumb="pk_".permayap($kategori_ad_tr)."_".time().".".$image->getFileExtension($resim);
		$resized_image="pb_".permayap($kategori_ad_tr)."_".time().".".$image->getFileExtension($resim);
/*		$image->load($tmp_resim);
		$image->resizeToWidth(360);
		$image->save($resimdir.$resized_thumb);*/
		$image->load($tmp_resim);
		$image->resizeToWidth(800);
		$image->save($resimdir.$resized_image);
	}
	$kategori_ekle="insert into proje_kategori (kategori_ad_tr,kategori_ad_en,kategori_ad_ru,kategori_ad_ar,ana_id,aciklama_en,aciklama_tr,aciklama_ru,aciklama_ar,kategori_resim) values ";
	$kategori_ekle.="('$kategori_ad_tr','$kategori_ad_en','$kategori_ad_ru','$kategori_ad_ar','$ana_id','$aciklama_en','$aciklama_tr','$aciklama_ru','$aciklama_ar','$resized_image')";
	$db->query($kategori_ekle);	
	$kategori_id=$db->insert_id;
	$db->query("update proje_kategori set sira='$kategori_id' where kategori_id='$kategori_id'");
	header("location:admin.php?cmd=proje_kategori_ekle&result=eklendi");
}
?>