<?
header("Content-Type: text/html; charset=utf-8"); session_start();
include_once "config.php";
include_once "../classes/ez_sql_core.php";  
include_once "../classes/ez_sql_mysql.php";  
$db = new ezSQL_mysql($cfg["DatabaseUsername"],$cfg["DatabasePassword"],$cfg["DatabaseName"],$cfg["DatabaseHost"]."");
$db->query("set names utf8");
if($_SESSION["user"]["auth"]==md5(session_id()."vizyoner"))  {
	require("pictureprocess.php");
	$blog_baslik_tr=makeSafe($_POST['blog_baslik_tr']);
	$blog_baslik_en=makeSafe($_POST['blog_baslik_en']);
	$blog_baslik_ru=makeSafe($_POST['blog_baslik_ru']);
	$blog_baslik_fr=makeSafe($_POST['blog_baslik_fr']);
	$blog_baslik_ar=makeSafe($_POST['blog_baslik_ar']);
	$blog_baslik_de=makeSafe($_POST['blog_baslik_de']);
	$blog_tarih=$_POST['blog_tarih'];
	$blog_icerik_tr=makeSafe($_POST['blog_icerik_tr']);
	$blog_icerik_en=makeSafe($_POST['blog_icerik_en']);	
	$blog_icerik_ru=makeSafe($_POST['blog_icerik_ru']);
	$blog_icerik_fr=makeSafe($_POST['blog_icerik_fr']);
	$blog_icerik_ar=makeSafe($_POST['blog_icerik_ar']);
	$blog_icerik_de=makeSafe($_POST['blog_icerik_de']);

	$resimdir = '../upload/';
	$resim=$_FILES["resim"]["name"];
	$tmp_resim=$_FILES["resim"]["tmp_name"];
	if($resim!="") {
		$image = new SimpleImage();
		$resized_thumb="bk_".permayap($blog_baslik_tr)."_".time().".".$image->getFileExtension($resim);
		$resized_image="bb_".permayap($blog_baslik_tr)."_".time().".".$image->getFileExtension($resim);
		$image->load($tmp_resim);
		$image->resizeToFit(400,300);
		$image->save($resimdir.$resized_thumb);
		$image->load($tmp_resim);
		$image->resizeToFit(800,600);
		$image->save($resimdir.$resized_image);
	}
	$blog_ekle="insert into blog (blog_baslik_tr,blog_baslik_en,blog_baslik_fr,blog_baslik_ru, blog_baslik_ar,blog_baslik_de, blog_tarih,blog_icerik_tr,blog_icerik_en,blog_icerik_fr,blog_icerik_ru, blog_icerik_ar,blog_icerik_de,resim_kucuk, resim_buyuk) values ";
	$blog_ekle.="('$blog_baslik_tr','$blog_baslik_en', '$blog_baslik_fr','$blog_baslik_ru', '$blog_baslik_ar','$blog_baslik_de','$blog_tarih','$blog_icerik_tr','$blog_icerik_en', '$blog_icerik_fr','$blog_icerik_ru' ,'$blog_icerik_ar','$blog_icerik_de', '$resized_thumb', '$resized_image')";
	$db->query($blog_ekle);
	$blog_id=$db->insert_id;
	$db->query("update blog set sira='$blog_id' where blog_id='$blog_id'");
	header("location:admin.php?cmd=blog_ekle&result=eklendi");
}
?>