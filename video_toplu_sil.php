<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {

	$video_id=$_POST['sil'];
	$tablo=$_GET['tablo'];
	$tablo_id=$_GET['tablo_id'];
	foreach ($video_id as $sil) {
		$sql="select thumb,image from videolar where video_id='$sil'";
		$videoler = $db->get_row($sql,ARRAY_A);
		deleteFile($videoler["image"],'upload');
		deleteFile($videoler["thumb"],'upload');
		$where = [ "video_id"	=>	$sil ];
		deleteTableData("videolar",$where);
	}

	header("location:admin.php?cmd=video&tablo=$tablo&tablo_id=$tablo_id&result=silindi&sayfanum=$sayfanum");
}
?>