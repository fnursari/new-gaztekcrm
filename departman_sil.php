<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {
	$departman_id=$_GET['departman_id'];
	$sql="select * from departman where departman_id='$departman_id'";
	$departmanler = $db->get_row($sql,ARRAY_A);
	deleteFile($departmanler["resim_kucuk"],'upload/departments');
	deleteFile($departmanler["resim_buyuk"],'upload/departments');

	$sql="select image,thumb from resim where tablo='departman' and tablo_id='$departman_id'";
	$galeriler = $db->get_results($sql,ARRAY_A);
	$galeri_x=0;
	if($db->num_rows > $galeri_x)
	{
		foreach ($galeriler as $galeri)  
		{
			deleteFile($galeri["image"],'upload');
			deleteFile($galeri["thumb"],'upload');
			$where = [ "tablo_id"	=>	$departman_id ];
			deleteTableData("resim",$where);
			$galeri_x++;
		}
	}

	$where = [ "departman_id"	=>	$departman_id ];
	deleteTableData("departman",$where);
	header("location:admin.php?cmd=departman_listesi&result=guncellendi");}
?>