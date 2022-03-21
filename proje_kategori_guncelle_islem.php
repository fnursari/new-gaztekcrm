<?
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if($_SESSION["user"]["auth"]==md5(session_id()."vizyoner"))  {
	require("pictureprocess.php");
	$kategori_id=$_GET["kategori_id"];
	$ana_id=$_POST["ana_id"];
	$kategori_ad_tr=makeSafe($_POST['kategori_ad_tr']);
	$kategori_ad_en=makeSafe($_POST['kategori_ad_en']);
	$kategori_ad_ru=makeSafe($_POST['kategori_ad_ru']);
	$kategori_ad_ar=makeSafe($_POST['kategori_ad_ar']);
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
	$kategori_guncelle="update proje_kategori set kategori_ad_tr='$kategori_ad_tr',kategori_ad_en='$kategori_ad_en',kategori_ad_ru='$kategori_ad_ru',kategori_ad_ar='$kategori_ad_ar',ana_id='$ana_id',aciklama_en='$aciklama_en',aciklama_tr='$aciklama_tr',aciklama_ru='$aciklama_ru',aciklama_ar='$aciklama_ar'";
	if($resim!="") $kategori_guncelle.=",kategori_resim='$resized_image'";
	$kategori_guncelle.=" where kategori_id='$kategori_id'";
	$db->query($kategori_guncelle);
	header("location:admin.php?cmd=proje_kategori_guncelle&kategori_id=$kategori_id&result=guncellendi");
}
?>