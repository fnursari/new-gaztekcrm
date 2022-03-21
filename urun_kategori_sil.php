<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {
	$kategori_id=$_GET['kategori_id'];
	$sql="select * from urun_kategori where kategori_id='$kategori_id'";
	$kategoriler = $db->get_row($sql,ARRAY_A);
	deleteFile($kategoriler["kategori_resim"],'upload/category');
	deleteFile($kategoriler["thumb"],'upload/category');
	deleteFile($kategoriler["kategori_icon"],'upload/category');
	$where = [ "kategori_id"	=>	$kategori_id ];
	deleteTableData("urun_kategori",$where);
	header("location:admin.php?cmd=urun_kategori_listesi&result=silindi&sayfanum=$sayfanum");
}
?>