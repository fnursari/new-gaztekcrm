<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {

	$resim_id=$_POST['sil'];
	$tablo=$_GET['tablo'];
	$tablo_id=$_GET['tablo_id'];
	foreach ($resim_id as $sil) {
		$sql="select thumb,image from resim where resim_id='$sil'";
		$resimler = $db->get_row($sql,ARRAY_A);
		deleteFile($resimler["image"],'upload');
		deleteFile($resimler["thumb"],'upload');
		$where = [ "resim_id"	=>	$sil ];
		deleteTableData("resim",$where);
	}

	header("location:admin.php?cmd=resim&tablo=$tablo&tablo_id=$tablo_id&result=silindi&sayfanum=$sayfanum");
}
?>