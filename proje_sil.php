<?
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {
	$proje_id=$_GET['proje_id'];
	$sql="select image,thumb from proje where proje_id='$proje_id'";
	$projeler = $db->get_row($sql,ARRAY_A);
	if (($projeler["image"]!="") and file_exists("../upload/".$projeler["image"])) unlink("../upload/".$projeler["image"]);
	
	$sql="select image,thumb from resim where tablo='proje' and tablo_id='$proje_id'";
	$galeriler = $db->get_results($sql,ARRAY_A);
	$galeri_x=0;
	if($db->num_rows > $galeri_x)
	{
		foreach ($galeriler as $galeri)  
		{
			if (($galeri["image"]!="") and file_exists("../upload/".$galeri["image"])) unlink("../upload/".$galeri["image"]);
			if (($galeri["thumb"]!="") and file_exists("../upload/".$galeri["thumb"])) unlink("../upload/".$galeri["thumb"]);
			$db->query("delete from resim where tablo='proje' and tablo_id='$proje_id'");
			$galeri_x++;
		}
	}
	$db->query("delete from proje where proje_id=$proje_id");
	header("location:admin.php?cmd=proje_listesi&result=silindi");
}
?>
