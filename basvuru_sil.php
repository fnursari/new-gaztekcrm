<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {
	$basvuru_id=$_GET['basvuru_id'];
	$sql="select * from is_basvurusu where basvuru_id='$basvuru_id'";
	$basvuru = $db->get_row($sql,ARRAY_A);
	deleteFile($basvuru["dosya"],'upload');


	$where = [ "basvuru_id"	=>	$basvuru_id ];
	deleteTableData("is_basvurusu",$where);
	header("location:admin.php?cmd=main&result=silindi");
}
?>

