<?
header("Content-Type: text/html; charset=utf-8"); session_start();
include_once "config.php";
include_once "../classes/ez_sql_core.php";  
include_once "../classes/ez_sql_mysql.php";  
$db = new ezSQL_mysql($cfg["DatabaseUsername"],$cfg["DatabasePassword"],$cfg["DatabaseName"],$cfg["DatabaseHost"]."");
$db->query("set names utf8");
if($_SESSION["user"]["auth"]==md5(session_id()."vizyoner"))  {
 require("pictureprocess.php");
 $film_id=$_GET["film_id"];
 $link_tr=$_POST['link_tr'];
 $link_en=$_POST['link_en'];
 $link_de=$_POST['link_de'];
 $link_ru=$_POST['link_ru'];
 $link_ar=$_POST['link_ar'];
 $aktif=$_POST['aktif'];
 

 $haber_guncelle="update tanitim_filmi set link_tr='$link_tr',link_en='$link_en',link_de='$link_de',link_ar='$link_ar',link_ru='$link_ru', aktif='$aktif'";

 $haber_guncelle.="where film_id='$film_id'";
 $db->query($haber_guncelle);
 header("location:admin.php?cmd=tanitim_guncelle&film_id=$film_id&result=guncellendi");
}
?>