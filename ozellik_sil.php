<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {
	$ozellik_id=$_GET['ozellik_id'];
	$tablo=$_GET['tablo'];
	$tablo_id=$_GET['tablo_id'];
	$sql="select resim from ozellik where ozellik_id='$ozellik_id'";
	$ozellikler = $db->get_row($sql,ARRAY_A);
	deleteFile($ozellikler["resim"],'upload');
	$where = [ "ozellik_id"	=>	$ozellik_id ];
	deleteTableData("ozellik",$where);
	header("location:admin.php?cmd=ozellik&tablo=$tablo&tablo_id=$tablo_id&result=silindi&sayfanum=$sayfanum");
}
?>