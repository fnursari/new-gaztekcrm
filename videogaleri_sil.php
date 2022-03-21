<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {
	$video_id=$_GET['video_id'];
	$sql="select resim,thumb from video where video_id='$video_id'";
	$videoler = $db->get_row($sql,ARRAY_A);
	deleteFile($videoler["resim"],'upload/videogallery');
	deleteFile($videoler["thumb"],'upload/videogallery');

	$where = [ "video_id"	=>	$video_id ];
	deleteTableData("video",$where);
	header("location:admin.php?cmd=videogaleri_listesi&result=guncellendi");
}	
?>
