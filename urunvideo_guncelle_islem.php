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
	$embed=makeSafe($_POST['embed']);
	$tablo=$_GET['tablo'];
	$tablo_id=$_GET['tablo_id']; 
	$urunvideo_id=$_GET['urunvideo_id']; 
	$urunvideodir = '../upload/';
	$urunvideo=$_FILES["urunvideo"]["name"];
	$tmp_urunvideo=$_FILES["urunvideo"]["tmp_name"];
	if($urunvideo!="")
	{
		$image = new SimpleImage();
		$resized_image="i_".permayap($ad_tr)."_".time().".".$image->getFileExtension($urunvideo);
		$resized_thumb="t_".permayap($ad_tr)."_".time().".".$image->getFileExtension($urunvideo);
		$image->load($tmp_urunvideo);
		$image->resizeToWidth(800);
		$image->save($urunvideodir.$resized_image);
		$image->resizeToWidth(400);
		$image->save($urunvideodir.$resized_thumb);
	}

	$urunvideo_guncelle="update urunvideo set ad_tr='$ad_tr', ad_en='$ad_en' , embed='$embed', tablo='$tablo', tablo_id='$tablo_id'";
	if($urunvideo!="") $urunvideo_guncelle.=" ,image='$resized_image',thumb='$resized_thumb'";
	$urunvideo_guncelle.="where urunvideo_id='$urunvideo_id'";
	$db->query($urunvideo_guncelle);
	header("location:admin.php?cmd=urunvideo&tablo=$tablo&tablo_id=$tablo_id&result=guncellendi");
}
?>