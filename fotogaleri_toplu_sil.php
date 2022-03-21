<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {

	$fotogaleri_id=$_POST['sil'];
	$tablo=$_GET['tablo'];
	$tablo_id=$_GET['tablo_id'];
	foreach ($fotogaleri_id as $sil) {
		$sql="select thumb,image from fotogaleri where fotogaleri_id='$sil'";
		$resimler = $db->get_row($sql,ARRAY_A);
		deleteFile($resimler["image"],'upload/photogallery');
		deleteFile($resimler["thumb"],'upload/photogallery');
		$where = [ "fotogaleri_id"	=>	$sil ];
		deleteTableData("fotogaleri",$where);
	}

	header("location:admin.php?cmd=fotogaleri_listesi");
}
?>