<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {
	$resim_id=$_GET['resim_id'];
	$tablo=$_GET['tablo'];
	$tablo_id=$_GET['tablo_id'];
	$sql="select thumb,image from resim where resim_id='$resim_id'";
	$resimler = $db->get_row($sql,ARRAY_A);
	deleteFile($resimler["image"],'upload');
	deleteFile($resimler["thumb"],'upload');
	$where = [ "resim_id"	=>	$resim_id ];
	deleteTableData("resim",$where);
	header("location:admin.php?cmd=resim&tablo=$tablo&tablo_id=$tablo_id&result=silindi&sayfanum=$sayfanum");
}
?>