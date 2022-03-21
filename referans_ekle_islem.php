<?
header("Content-Type: text/html; charset=utf-8"); session_start();
include_once "config.php";
include_once "../classes/ez_sql_core.php";  
include_once "../classes/ez_sql_mysql.php";  
$db = new ezSQL_mysql($cfg["DatabaseUsername"],$cfg["DatabasePassword"],$cfg["DatabaseName"],$cfg["DatabaseHost"]."");
$db->query("set names utf8");
if($_SESSION["user"]["auth"]==md5(session_id()."vizyoner"))  {
	require("pictureprocess.php");
	$referans_ad_tr=makeSafe($_POST['referans_ad_tr']);
	$referans_ad_en=makeSafe($_POST['referans_ad_en']);
	$referans_ad_ru=makeSafe($_POST['referans_ad_ru']);
	$referans_ad_ar=makeSafe($_POST['referans_ad_ar']);
	$referans_ad_fr=makeSafe($_POST['referans_ad_fr']);
	$referans_ad_de=makeSafe($_POST['referans_ad_de']);



	$referans_icerik_tr=makeSafe($_POST['referans_icerik_tr']);
	$referans_icerik_en=makeSafe($_POST['referans_icerik_en']);	
	$referans_icerik_ru=makeSafe($_POST['referans_icerik_ru']);
	$referans_icerik_ar=makeSafe($_POST['referans_icerik_ar']);
	$referans_icerik_fr=makeSafe($_POST['referans_icerik_fr']);
	$referans_icerik_de=makeSafe($_POST['referans_icerik_de']);

	$resimdir = '../upload/';
	$resim=$_FILES["resim"]["name"];
	$tmp_resim=$_FILES["resim"]["tmp_name"];
	if($resim!="")
	{
		$image = new SimpleImage();
		$resized_thumb="ak_".permayap($referans_ad_tr)."_".time().".".$image->getFileExtension($resim);
		$resized_image="ab_".permayap($referans_ad_tr)."_".time().".".$image->getFileExtension($resim);
		$image->load($tmp_resim);
		$image->resizeToFit(200,100);
		$image->save($resimdir.$resized_thumb);
		$image->load($tmp_resim);
		$image->resizeToFit(200,100);
		$image->save($resimdir.$resized_image);
	}

	$referans_ekle="insert into referans (referans_ad_tr,referans_ad_en,referans_ad_ru, referans_ad_ar, referans_ad_fr, referans_ad_de, referans_icerik_tr,referans_icerik_en,referans_icerik_ru, referans_icerik_ar,referans_icerik_fr,referans_icerik_de,thumb, image) values ";
	$referans_ekle.="('$referans_ad_tr','$referans_ad_en', '$referans_ad_ru', '$referans_ad_ar','$referans_ad_fr','$referans_ad_de','$referans_icerik_tr','$referans_icerik_en', '$referans_icerik_ru' ,'$referans_icerik_ar','$referans_icerik_fr','$referans_icerik_de', '$resized_thumb', '$resized_image')";
	$db->query($referans_ekle);
	$referans_id=$db->insert_id;
	$db->query("update referans set sira='$referans_id' where referans_id='$referans_id'");
	header("location:admin.php?cmd=referans_ekle&result=eklendi");
}
?>