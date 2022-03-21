<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {
	$fuar_id=$_GET['fuar_id'];
	$sql="select * from fuar where fuar_id='$fuar_id'";
	$fuarler = $db->get_row($sql,ARRAY_A);
	deleteFile($fuarler["resim_kucuk"],'upload/fairs');
	deleteFile($fuarler["resim_buyuk"],'upload/fairs');

	$sql="select image,thumb from resim where tablo='fuar' and tablo_id='$fuar_id'";
	$galeriler = $db->get_results($sql,ARRAY_A);
	$galeri_x=0;
	if($db->num_rows > $galeri_x)
	{
		foreach ($galeriler as $galeri)  
		{
			deleteFile($galeri["image"],'upload');
			deleteFile($galeri["thumb"],'upload');
			$where = [ "tablo_id"	=>	$fuar_id ];
			deleteTableData("resim",$where);
			$galeri_x++;
		}
	}

	$where = [ "fuar_id"	=>	$fuar_id ];
	deleteTableData("fuar",$where);
	header("location:admin.php?cmd=fuar_listesi&result=guncellendi");}
?>
