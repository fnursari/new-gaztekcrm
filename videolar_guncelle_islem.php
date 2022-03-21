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
	$embed=makeSafe($_POST['embed']);
	$tablo=$_GET['tablo'];
	$tablo_id=$_GET['tablo_id']; 
	$video_id=$_GET['video_id']; 
	$videodir = '../upload/';
	$video=$_FILES["video"]["name"];
	$tmp_video=$_FILES["video"]["tmp_name"];
	if($video!="")
	{
		$image = new SimpleImage();
		$resized_image="i_".permayap($ad_tr)."_".time().".".$image->getFileExtension($video);
		$resized_thumb="t_".permayap($ad_tr)."_".time().".".$image->getFileExtension($video);
		$image->load($tmp_video);
		$image->resizeToWidth(800);
		$image->save($videodir.$resized_image);
		$image->resizeToWidth(floor(800/2));
		$image->save($videodir.$resized_thumb);
	}

	$video_guncelle="update videolar set ad_tr='$ad_tr', embed='$embed', tablo='$tablo', tablo_id='$tablo_id'";
	if($video!="") $video_guncelle.=" ,image='$resized_image',thumb='$resized_thumb'";
	$video_guncelle.="where video_id='$video_id'";
	$db->query($video_guncelle);
	header("location:admin.php?cmd=video&tablo=$tablo&tablo_id=$tablo_id&result=guncellendi");
}
?>