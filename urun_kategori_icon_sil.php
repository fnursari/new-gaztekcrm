<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {
	$kategori_id=$_GET['kategori_id'];
	$sql="select kategori_icon from urun_kategori where kategori_id='$kategori_id'";
	$resimler = $db->get_row($sql,ARRAY_A);
	deleteFile($resimler["kategori_icon"],'upload/category');
	$updateData = [
    "kategori_icon" => NULL,
    ];
	$where = [ "kategori_id"	=>	$kategori_id ];
	updateTableData("urun_kategori",$updateData,$where);
	header("location:admin.php?cmd=urun_kategori_guncelle&kategori_id=$kategori_id&result=silindi");
}
?>