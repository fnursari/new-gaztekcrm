<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {
	$teklif_id=$_GET['teklif_id'];
	$sql="select * from teklifler where teklif_id='$teklif_id'";
	$teklifler = $db->get_row($sql,ARRAY_A);

	$sqlBilgi="select * from bilgi_giris where bilgi_giris_id='$teklifler[bilgi_giris_id]'";
	$bilgi_giris = $db->get_row($sqlBilgi,ARRAY_A);
	$bilgi_giris_id = $bilgi_giris["bilgi_giris_id"];

	$whereBilgi = [ "bilgi_giris_id"	=>	$bilgi_giris_id ];
	deleteTableData("bilgi_giris",$whereBilgi);

	$where = [ "teklif_id"	=>	$teklif_id ];
	deleteTableData("teklifler",$where);


	header("location:admin.php?cmd=teklif_listesi&result=silindi");
}
?>

