<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";   
if(canUserAccessAdminArea()) {
	$insertData  =[
		"firma_id"				=> $_POST['firma_id'],
		"ziyaret_tarihi"		=> $_POST['ziyaret_tarihi'],
		"ziyaret_konusu"		=> beautifyName($_POST['ziyaret_konusu']),
		"gorusulen_kisi"		=> beautifyName($_POST['gorusulen_kisi']),
		"gorusme_notlari"		=> $_POST['gorusme_notlari'],
		"ziyaret_kayit_tarihi"	=> date('Y-m-d H:i:s'),
		"kullanici_id"			=> $_SESSION["user"]["user_id"],
	];
	$ziyaret_id=insertDatatoTable("ziyaret",$insertData);
	header("location:admin.php?cmd=ziyaret_listesi&result=eklendi");
}