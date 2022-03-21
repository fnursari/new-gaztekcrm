<?
header("Content-Type: text/html; charset=utf-8"); session_start();
include_once "config.php";
include_once "../classes/ez_sql_core.php";  
include_once "../classes/ez_sql_mysql.php";  
$db = new ezSQL_mysql($cfg["DatabaseUsername"],$cfg["DatabasePassword"],$cfg["DatabaseName"],$cfg["DatabaseHost"]."");
$db->query("set names utf8");
if($_SESSION["user"]["auth"]==md5(session_id()."vizyoner"))  {
	require("pictureprocess.php");
	$musteri_adi=makeSafe($_POST['musteri_adi']);
	$gorus_icerik_tr=makeSafe($_POST['gorus_icerik_tr']);
	$gorus_icerik_en=makeSafe($_POST['gorus_icerik_en']);
	$gorus_icerik_ru=makeSafe($_POST['gorus_icerik_ru']);
	$gorus_icerik_ar=makeSafe($_POST['gorus_icerik_ar']);

	$gorus_ekle="insert into musteri_gorusleri (musteri_adi,gorus_icerik_tr,gorus_icerik_en,gorus_icerik_ru,gorus_icerik_ar) values ";
	$gorus_ekle.="('$musteri_adi','$gorus_icerik_tr','$gorus_icerik_en','$gorus_icerik_ru','$gorus_icerik_ar')";
	$db->query($gorus_ekle);
	$gorus_id=$db->insert_id;
	$db->query("update musteri_gorusleri set sira='$gorus_id' where id='$gorus_id'");
	header("location:admin.php?cmd=musteri_gorus_ekle&result=eklendi");
}
?>