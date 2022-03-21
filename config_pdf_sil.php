<?
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php"; 
if(canUserAccessAdminArea()) {
	
	$sql="select katalog from config where config_id='1'";
	$pdfler = $db->get_row($sql,ARRAY_A);
	deleteFile($pdfler["katalog"],'upload');
	$updateData = [
		"katalog" => NULL,
	];
	$where      = ["config_id"   =>  1];
	updateTableData("config",$updateData,$where);
	header("location:admin.php?cmd=config_guncelle&result=guncellendi");
}
?>

