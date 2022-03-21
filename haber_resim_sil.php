<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {
	$haber_id=$_GET['haber_id'];
	$sql="select resim_buyuk,resim_kucuk from haber where haber_id='$haber_id'";
	$resimler = $db->get_row($sql,ARRAY_A);
	deleteFile($resimler["resim_buyuk"],'upload/news');
	deleteFile($resimler["resim_kucuk"],'upload/news');
	$updateData = [
    "resim_buyuk" => NULL,
    "resim_kucuk" => NULL,
    ];
	$where = [ "haber_id"	=>	$haber_id ];
	updateTableData("haber",$updateData,$where);
	header("location:admin.php?cmd=haber_guncelle&haber_id=$haber_id&result=silindi");
}
?>