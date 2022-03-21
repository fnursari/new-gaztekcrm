<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {
	$banner_id=$_GET['banner_id'];
	$sql="select resim,banner_logo from banner where banner_id='$banner_id'";
	$bannerler = $db->get_row($sql,ARRAY_A);
	deleteFile($bannerler["resim"],'upload/banner');
	deleteFile($bannerler["banner_logo"],'upload/banner');
	$where = [ "banner_id"	=>	$banner_id ];
	deleteTableData("banner",$where);
	header("location:admin.php?cmd=banner_listesi&result=silindi");
}
?>