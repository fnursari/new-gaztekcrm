<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php"; 
if(canUserAccessAdminArea() && $_SESSION["user"]["group"]=='root')  {
	$group_id=$_POST['group_id'];
	$name=makeSafe($_POST['name']);
	$user_name=makeSafe($_POST['user_name']);
	$user_pass=md5(trim($_POST['user_pass']));

	$sql="select * from u1s9e2r6 where user_name='$user_name'";
    $user_detail = $db->get_row($sql,ARRAY_A); 
    if($db->num_rows>0)
	{
		header("location:admin.php?cmd=kullanicilar&result=kullanici_hata");
	} else {

		$insertData = [
			"user_name" 		=> $user_name,
			"user_pass"			=> $user_pass,
			"user_email"		=> $user_email,
			"name" 				=> $name,
			"group_id" 			=> $group_id,

		];
		insertDatatoTable("u1s9e2r6",$insertData);
	
		header("location:admin.php?cmd=kullanicilar&result=eklendi");
	}
}
?>