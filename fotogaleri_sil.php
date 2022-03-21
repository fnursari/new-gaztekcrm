<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {
	$fotogaleri_id=$_GET['fotogaleri_id'];
	$sql="select image,thumb from fotogaleri where fotogaleri_id='$fotogaleri_id'";
	$fotogaleriler = $db->get_row($sql,ARRAY_A);
	deleteFile($fotogaleriler["image"],'upload/photogallery');
	deleteFile($fotogaleriler["thumb"],'upload/photogallery');

	$where = [ "fotogaleri_id"	=>	$fotogaleri_id ];
	deleteTableData("fotogaleri",$where);
	header("location:admin.php?cmd=fotogaleri_listesi&result=guncellendi");
}	
?>
