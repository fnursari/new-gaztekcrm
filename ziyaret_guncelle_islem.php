<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php"; 
if(canUserAccessAdminArea()) {
	$ziyaret_id=makeSafe($_GET["ziyaret_id"]);
	if($_SESSION["user"]["group"]=="root") {
		$sql="select * from ziyaret where ziyaret_id='$ziyaret_id' and ziyaret_silindi='0'";
	}
	else {
		$sql="select * from ziyaret where ziyaret_id='$ziyaret_id' and ziyaret_silindi='0' and kullanici_id='".$_SESSION["user"]["user_id"]."'";
	}
	$details = $db->get_row($sql,ARRAY_A);
	if(!is_null($details)) {
		$updateData  =[
			"firma_id"						=> $_POST['firma_id'],
			"ziyaret_tarihi"				=> $_POST['ziyaret_tarihi'],
			"ziyaret_konusu"				=> beautifyName($_POST['ziyaret_konusu']),
			"gorusulen_kisi"				=> beautifyName($_POST['gorusulen_kisi']),
			"gorusme_notlari"				=> $_POST['gorusme_notlari'],
			"ziyaret_guncellenme_tarihi"	=> date('Y-m-d H:i:s'),
			"ziyaret_guncelleyen_kullanici"	=> $_SESSION["user"]["user_id"],
		];
		$where 		= ["ziyaret_id"	=>	$ziyaret_id];
		updateTableData("ziyaret",$updateData,$where);
		header("location:admin.php?cmd=ziyaret_listesi&result=guncellendi");
	}
}