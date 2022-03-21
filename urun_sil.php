<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {
	$urun_id=$_GET['urun_id'];
	$sql="select * from urun where urun_id='$urun_id'";
	$urunler = $db->get_row($sql,ARRAY_A);
	deleteFile($urunler["teknik_resim_buyuk"],'upload/product');
	deleteFile($urunler["teknik_resim_kucuk"],'upload/product');
	deleteFile($urunler["resim_kucuk"],'upload/product');
	deleteFile($urunler["resim_buyuk"],'upload/product');
	deleteFile($urunler["barcode"],'upload/product');

	$sql="select image,thumb from resim where tablo='urun' and tablo_id='$urun_id'";
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
	deleteTableData("urun",$where);
	header("location:admin.php?cmd=urun_listesi&result=guncellendi");}
?>