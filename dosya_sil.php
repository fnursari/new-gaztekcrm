<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {
	$dosya_id=$_GET['dosya_id'];
	$tablo=$_GET['tablo'];
	$tablo_id=$_GET['tablo_id'];
	$sql="select dosya from dosya where dosya_id='$dosya_id'";
	$dosyaler = $db->get_row($sql,ARRAY_A);
	deleteFile($dosyaler["dosya"],'upload');
	$where = [ "dosya_id"	=>	$dosya_id ];
	deleteTableData("dosya",$where);
	header("location:admin.php?cmd=dosya&tablo=$tablo&tablo_id=$tablo_id&result=silindi&sayfanum=$sayfanum");
}
?>