<?
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {
	require("pictureprocess.php");
	$proje_ad_tr=makeSafe($_POST['proje_ad_tr']);
	$proje_ad_en=makeSafe($_POST['proje_ad_en']);
	$proje_ad_ru=makeSafe($_POST['proje_ad_ru']);
	$proje_ad_ar=makeSafe($_POST['proje_ad_ar']);

	$resimdir = '../upload/';
	$resim=$_FILES["resim"]["name"];
	$tmp_resim=$_FILES["resim"]["tmp_name"];
	if($resim!="")
	{
		$image = new SimpleImage();
		$resized_thumb="pk_".permayap($proje_ad_tr)."_".time().".".$image->getFileExtension($resim);
		$resized_image="pb_".permayap($proje_ad_tr)."_".time().".".$image->getFileExtension($resim);
		$image->load($tmp_resim);
		$image->resizeToFit(400,300);
		$image->save($resimdir.$resized_thumb);
		$image->load($tmp_resim);
		$image->resizeToFit(800,600);
		$image->save($resimdir.$resized_image);
	}
	$proje_ekle="insert into proje (proje_ad_tr,proje_ad_en,proje_ad_ru,proje_ad_ar,resim_kucuk,resim_buyuk) values ";
	$proje_ekle.="('$proje_ad_tr','$proje_ad_en','$proje_ad_ru','$proje_ad_ar','$resized_thumb','$resized_image' )";
	$db->query($proje_ekle);
	$proje_id=$db->insert_id;
	$db->query("update proje set sira='$proje_id' where proje_id='$proje_id'");
	header("location:admin.php?cmd=proje_ekle&ana_id=$ana_id&result=eklendi");
}
?>