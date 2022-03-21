<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php"; 
if(canUserAccessAdminArea() && $_SESSION["user"]["group"]=='root')  {
	$banka_id=$_POST['banka_id'];
	$banka_ad=makeSafe($_POST['banka_ad']);
	$banka_sube=makeSafe($_POST['banka_sube']);
	$hesap_no=makeSafe($_POST['hesap_no']);
	$iban=makeSafe($_POST['iban']);
	$swift=makeSafe($_POST['swift']);

	$sql="select * from banka where banka_id='$banka_id'";
	$user_detail = $db->get_row($sql,ARRAY_A); 
	if($db->num_rows>0)
	{
		header("location:admin.php?cmd=bankalar&result=kullanici_hata");
	} else {

		$insertData = [
			"banka_ad" 		=> $banka_ad,
			"banka_sube"	=> $banka_sube,
			"hesap_no"		=> $hesap_no,
			"iban" 			=> $iban,
			"swift" 		=> $swift,

		];
		$banka_id=insertDatatoTable("banka",$insertData);
		$updateData = ["sira"	=> $banka_id];
		$where		= ["banka_id" 	=> $banka_id];

		header("location:admin.php?cmd=bankalar&result=eklendi");
	}
}
?>