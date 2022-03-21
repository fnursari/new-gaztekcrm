<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {
	$video_id=$_GET['video_id'];
	$tablo=$_GET['tablo'];
	$tablo_id=$_GET['tablo_id'];
	$sql="select thumb,image from videolar where video_id='$video_id'";
	$resimler = $db->get_row($sql,ARRAY_A);
	deleteFile($resimler["image"],'upload');
	deleteFile($resimler["thumb"],'upload');
	$where = [ "video_id"	=>	$video_id ];
	deleteTableData("videolar",$where);
	header("location:admin.php?cmd=video&tablo=$tablo&tablo_id=$tablo_id&result=silindi&sayfanum=$sayfanum");
}
?>