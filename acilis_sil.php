<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {
	$acilis_id=$_GET['acilis_id'];
	$dil=$_GET['dil'];
	$sql="select resim_$dil from acilis where acilis_id='$acilis_id'";
	$resimler = $db->get_row($sql,ARRAY_A);
	deleteFile($resimler["resim_$dil"],'upload/banner');
	$updateData = [
    "resim_$dil" => NULL,
    ];
	$where = [ "acilis_id"	=>	$acilis_id ];
	updateTableData("acilis",$updateData,$where);
	header("location:admin.php?cmd=acilis_guncelle&acilis_id=$acilis_id&result=silindi");
}
?>

