<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {
	$departman_id=$_GET['departman_id'];
	$sql="select resim_buyuk,resim_kucuk from departman where departman_id='$departman_id'";
	$resimler = $db->get_row($sql,ARRAY_A);
	deleteFile($resimler["resim_buyuk"],'upload/departments');
	deleteFile($resimler["resim_kucuk"],'upload/departments');
	$updateData = [
    "resim_buyuk" => NULL,
    "resim_kucuk" => NULL,
    ];
	$where = [ "departman_id"	=>	$departman_id ];
	updateTableData("departman",$updateData,$where);
	header("location:admin.php?cmd=departman_guncelle&departman_id=$departman_id&result=silindi");
}
?>