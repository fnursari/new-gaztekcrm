<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {
	$fuar_id=$_GET['fuar_id'];
	$sql="select resim_buyuk,resim_kucuk from fuar where fuar_id='$fuar_id'";
	$resimler = $db->get_row($sql,ARRAY_A);
	deleteFile($resimler["resim_buyuk"],'upload/fairs');
	deleteFile($resimler["resim_kucuk"],'upload/fairs');
	$updateData = [
    "resim_buyuk" => NULL,
    "resim_kucuk" => NULL,
    ];
	$where = [ "fuar_id"	=>	$fuar_id ];
	updateTableData("fuar",$updateData,$where);
	header("location:admin.php?cmd=fuar_guncelle&fuar_id=$fuar_id&result=silindi");
}
?>