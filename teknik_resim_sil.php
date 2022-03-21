<?
header("Content-Type: text/html; charset=utf-8"); session_start();
include_once "config.php";
include_once "../classes/ez_sql_core.php";  
include_once "../classes/ez_sql_mysql.php";  
$db = new ezSQL_mysql($cfg["DatabaseUsername"],$cfg["DatabasePassword"],$cfg["DatabaseName"],$cfg["DatabaseHost"]."");
$db->query("set names utf8");
if(canUserAccessAdminArea()) {
	$resim_id=$_GET['resim_id'];
	$tablo=$_GET['tablo'];
	$tablo_id=$_GET['tablo_id']; 
	$sql="select thumb,image from teknik_resim where resim_id='$resim_id'";
	$resimler = $db->get_row($sql,ARRAY_A);
	if (($resimler["thumb"]!="") and file_exists("../upload/".$resimler["thumb"])) unlink("../upload/".$resimler["thumb"]);
	if (($resimler["image"]!="") and file_exists("../upload/".$resimler["image"])) unlink("../upload/".$resimler["image"]);
	$db->query("delete from teknik_resim where resim_id='$resim_id'");
	header("location:admin.php?cmd=teknik_resim&tablo=$tablo&tablo_id=$tablo_id&result=silindi");
}
?>