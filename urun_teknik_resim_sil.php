<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {
	$urun_id=$_GET['urun_id'];
	$sql="select teknik_resim_buyuk,teknik_resim_kucuk from urun where urun_id='$urun_id'";
	$resimler = $db->get_row($sql,ARRAY_A);
	deleteFile($resimler["teknik_resim_buyuk"],'upload/urun');
	deleteFile($resimler["teknik_resim_kucuk"],'upload/urun');
	$updateData = [
    "teknik_resim_buyuk" => NULL,
    "teknik_resim_kucuk" => NULL,
    ];
	$where = [ "urun_id"	=>	$urun_id ];
	updateTableData("urun",$updateData,$where);
	header("location:admin.php?cmd=urun_guncelle&urun_id=$urun_id&result=silindi");
}
?>