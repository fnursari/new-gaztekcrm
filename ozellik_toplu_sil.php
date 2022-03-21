<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {

	$ozelllik_id=$_POST['sil'];
	$tablo=$_GET['tablo'];
	$tablo_id=$_GET['tablo_id'];
	foreach ($ozelllik_id as $sil) {
		$sql="select resim from ozelllik where ozelllik_id='$sil'";
		$ozelllikler = $db->get_row($sql,ARRAY_A);
		deleteFile($ozelllikler["resim"],'upload');
		$where = [ "ozelllik_id"	=>	$sil ];
		deleteTableData("ozelllik",$where);
	}

	header("location:admin.php?cmd=ozelllik&tablo=$tablo&tablo_id=$tablo_id&result=silindi&sayfanum=$sayfanum");
}
?>