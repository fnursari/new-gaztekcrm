<?
header("Content-Type: text/html; charset=utf-8"); session_start();
include_once "config.php";
include_once "../classes/ez_sql_core.php";  
include_once "../classes/ez_sql_mysql.php";  
$db = new ezSQL_mysql($cfg["DatabaseUsername"],$cfg["DatabasePassword"],$cfg["DatabaseName"],$cfg["DatabaseHost"]."");
$db->query("set names utf8");
if($_SESSION["user"]["auth"]==md5(session_id()."vizyoner")) {
	require("pictureprocess.php");
	$id=$_GET["id"];
	$musteri_adi=makeSafe($_POST['musteri_adi']);
	$gorus_icerik_tr=makeSafe($_POST['gorus_icerik_tr']);
	$gorus_icerik_en=makeSafe($_POST['gorus_icerik_en']);
	$gorus_icerik_ru=makeSafe($_POST['gorus_icerik_ru']);
	$gorus_icerik_ar=makeSafe($_POST['gorus_icerik_ar']);


	$gorus_guncelle="update musteri_gorusleri set musteri_adi='$musteri_adi',gorus_icerik_tr='$gorus_icerik_tr'";
	$gorus_guncelle.=",gorus_icerik_en='$gorus_icerik_en',gorus_icerik_ru='$gorus_icerik_ru',gorus_icerik_ar='$gorus_icerik_ar'";
	$gorus_guncelle.=" where id='$id'";
	$db->query($gorus_guncelle);
	header("location:admin.php?cmd=gorus_guncelle&id=$id&result=guncellendi");
}
?>