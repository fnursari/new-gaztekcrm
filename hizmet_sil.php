<?
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {
	$hizmet_id=$_GET['hizmet_id'];
	$sql="select resim_kucuk,resim_buyuk from hizmet where hizmet_id='$hizmet_id'";
	$hizmetler = $db->get_row($sql,ARRAY_A);
	/*if (($hizmetler["pdf"]!="") and file_exists("../upload/".$hizmetler["pdf"])) unlink("../upload/".$hizmetler["pdf"]);
	if (($hizmetler["teknikresim"]!="") and file_exists("../upload/".$hizmetler["teknikresim"])) unlink("../upload/".$hizmetler["teknikresim"]);*/
	if (($hizmetler["resim_kucuk"]!="") and file_exists("../upload/hizmet/".$hizmetler["resim_kucuk"])) unlink("../upload/hizmet/".$hizmetler["resim_kucuk"]);
	if (($hizmetler["resim_buyuk"]!="") and file_exists("../upload/hizmet/".$hizmetler["resim_buyuk"])) unlink("../upload/hizmet/".$hizmetler["resim_buyuk"]);
	
	$sql="select image,thumb from resim where tablo='hizmet' and tablo_id='$hizmet_id'";
	$galeriler = $db->get_results($sql,ARRAY_A);
	$galeri_x=0;
	if($db->num_rows > $galeri_x)
	{
		foreach ($galeriler as $galeri)  
		{
			if (($galeri["image"]!="") and file_exists("../upload/".$galeri["image"])) unlink("../upload/".$galeri["image"]);
			if (($galeri["thumb"]!="") and file_exists("../upload/".$galeri["thumb"])) unlink("../upload/".$galeri["thumb"]);
			$db->query("delete from resim where tablo='hizmet' and tablo_id='$hizmet_id'");
			$galeri_x++;
		}
	}
	$db->query("delete from hizmet where hizmet_id=$hizmet_id");
	header("location:admin.php?cmd=hizmet_listesi&result=guncellendi");
}
?>
