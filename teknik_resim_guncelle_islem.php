<?
header("Content-Type: text/html; charset=utf-8"); session_start();
include_once "config.php";
include_once "../classes/ez_sql_core.php";  
include_once "../classes/ez_sql_mysql.php";  
$db = new ezSQL_mysql($cfg["DatabaseUsername"],$cfg["DatabasePassword"],$cfg["DatabaseName"],$cfg["DatabaseHost"]."");
$db->query("set names utf8");
if(canUserAccessAdminArea()) {
	require("pictureprocess.php");
	$ad_tr=makeSafe($_POST['ad_tr']);
	$ad_en=makeSafe($_POST['ad_en']);
	$ad_ru=makeSafe($_POST['ad_ru']);
	$ad_ar=makeSafe($_POST['ad_ar']);
	$ad_fr=makeSafe($_POST['ad_fr']);
	$tablo=$_GET['tablo'];
	$tablo_id=$_GET['tablo_id']; 
	$resim_id=$_GET['resim_id']; 
	$resimdir = '../upload/';
	$resim=$_FILES["file"]["name"];
	$tmp_resim=$_FILES["file"]["tmp_name"];
	/*if($resim!=""  && $tablo=="proje")
	{
		$image = new SimpleImage();
		$resized_image="i_".permayap($ad_tr)."_".uniqid().".".$image->getFileExtension($resim);
		$resized_thumb="t_".permayap($ad_tr)."_".uniqid().".".$image->getFileExtension($resim);
		$image->load($tmp_resim);
		$image->resizeToFit(848,440);
		$image->save($resimdir.$resized_image);
		$image->load($tmp_resim);
		$image->resizeToFit(424,220);
		$image->save($resimdir.$resized_thumb);

	}*/
	if($resim!="")
	{
		$image = new SimpleImage();
		$resized_image="i_".permayap($ad_tr)."_".uniqid().".".$image->getFileExtension($resim);
		$resized_thumb="t_".permayap($ad_tr)."_".uniqid().".".$image->getFileExtension($resim);
		$image->load($tmp_resim);
		$image->resizeToFit(800,600);
		$image->save($resimdir.$resized_image);
		$image->load($tmp_resim);
		$image->resizeToFit(400,300);
		$image->save($resimdir.$resized_thumb);

	}
	$resim_guncelle="update teknik_resim set ad_tr='$ad_tr', ad_en='$ad_en',ad_ru='$ad_ru', ad_ar='$ad_ar', ad_fr='$ad_fr', tablo='$tablo', tablo_id='$tablo_id'";
	if($resim!="") $resim_guncelle.=" ,image='$resized_image',thumb='$resized_thumb'";
	$resim_guncelle.="where resim_id='$resim_id'";
	$db->query($resim_guncelle);
	header("location:admin.php?cmd=teknik_resim&tablo=$tablo&tablo_id=$tablo_id&result=guncellendi");
}
?>