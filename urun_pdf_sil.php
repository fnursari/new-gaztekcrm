<?
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {
	$dil=$_GET['dil'];
	$urun_id=$_GET['urun_id'];
	$sql="select pdf_$dil from urun where urun_id='$urun_id'";
	$pdfler = $db->get_row($sql,ARRAY_A);
	if (($pdfler["pdf_$dil"]!="") and file_exists("../upload/urun/".$pdfler["pdf_$dil"])) unlink("../upload/urun/".$pdfler["pdf_$dil"]);
	$db->query("update urun set pdf_$dil='' where urun_id=$urun_id");
	header("location:admin.php?cmd=urun_guncelle&urun_id=$urun_id");
}
?>

