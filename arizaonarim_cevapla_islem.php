<?
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {

	$id=$_GET["id"];
	$geri_donus=makeSafe($_POST['geri_donus']);

	

	$arizaonarim_guncelle="update arizaonarim set geri_donus='$geri_donus', durum='1'  where id='$id'";
	$db->query($arizaonarim_guncelle);
	header("location:admin.php?cmd=main");
}
?>