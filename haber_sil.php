<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {
	$haber_id=$_GET['haber_id'];
	$sql="select * from haber where haber_id='$haber_id'";
	$haberler = $db->get_row($sql,ARRAY_A);
	deleteFile($haberler["resim_kucuk"],'upload/news');
	deleteFile($haberler["resim_buyuk"],'upload/news');

	$sql="select image,thumb from resim where tablo='haber' and tablo_id='$haber_id'";
	$galeriler = $db->get_results($sql,ARRAY_A);
	$galeri_x=0;
	if($db->num_rows > $galeri_x)
	{
		foreach ($galeriler as $galeri)  
		{
			deleteFile($galeri["image"],'upload');
			deleteFile($galeri["thumb"],'upload');
			$where = [ "tablo_id"	=>	$haber_id ];
			deleteTableData("resim",$where);
			$galeri_x++;
		}
	}

	$where = [ "haber_id"	=>	$haber_id ];
	deleteTableData("haber",$where);
	header("location:admin.php?cmd=haber_listesi&result=guncellendi");}
?>
