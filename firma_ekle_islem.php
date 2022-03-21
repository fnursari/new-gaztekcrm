<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";   
if(canUserAccessAdminArea()) {
	$insertData  =[
		"firma_ad"					=> beautifyName($_POST['firma_ad']),
		"firma_telefon"				=> $_POST['firma_telefon'],
		"firma_telefon1"			=> $_POST['firma_telefon1'],
		"firma_telefon2"			=> $_POST['firma_telefon2'],
		"firma_adres"				=> beautifyName($_POST['firma_adres']),
		"firma_ceptelefon"			=> $_POST['firma_ceptelefon'],
		"firma_ceptelefon1"			=> $_POST['firma_ceptelefon1'],
		"firma_ceptelefon2"			=> $_POST['firma_ceptelefon2'],
		"firma_yetkili"				=> beautifyName($_POST['firma_yetkili']),
		"firma_yetkili_telefon"		=> $_POST['firma_yetkili_telefon'],
		"firma_fax"					=> $_POST['firma_fax'],
		"firma_email"				=> $_POST['firma_email'],
		"firma_web"					=> $_POST['firma_web'],
		"firma_vergidaire"			=> $_POST['firma_vergidaire'],
		"firma_vergino"				=> $_POST['firma_vergino'],
		"firma_kayit_tarihi"		=> date('Y-m-d H:i:s'),
		"firma_ekleyen_kullanici"	=> $_SESSION["user"]["user_id"],
	];
	$firma_id=insertDatatoTable("firma",$insertData);
	header("location:admin.php?cmd=firma_listesi&result=eklendi");
}