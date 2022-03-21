<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {
	$urun_id=$_GET['urun_id'];
	$sql="select * from ikincielurun where urun_id='$urun_id'";
	$urunler = $db->get_row($sql,ARRAY_A);

	deleteFile($urunler["resim_kucuk"],'upload/usedproduct');
	deleteFile($urunler["resim_buyuk"],'upload/usedproduct');
	

	$sql="select image,thumb from resim where tablo='ikincielurun' and tablo_id='$urun_id'";
	$galeriler = $db->get_results($sql,ARRAY_A);
	$galeri_x=0;
	if($db->num_rows > $galeri_x)
	{
		foreach ($galeriler as $galeri)  
		{
			deleteFile($galeri["image"],'upload');
			deleteFile($galeri["thumb"],'upload');
			$where = [ "tablo_id"	=>	$urun_id ];
			deleteTableData("resim",$where);
			$galeri_x++;
		}
	}

	$where = [ "urun_id"	=>	$urun_id ];
	deleteTableData("ikincielurun",$where);
	header("location:admin.php?cmd=ikincielurun_listesi&result=guncellendi");}
?>