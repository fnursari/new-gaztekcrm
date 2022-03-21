<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {
	$sss_id=$_GET['sss_id'];
	$sql="select * from sss where sss_id='$sss_id'";
	$sssler = $db->get_row($sql,ARRAY_A);

	$where = [ "sss_id"	=>	$sss_id ];
	deleteTableData("sss",$where);
	header("location:admin.php?cmd=sss_listesi&result=guncellendi");}
?>
