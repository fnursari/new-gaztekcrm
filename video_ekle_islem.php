<?
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {
	$tablo=$_GET['tablo'];
	$tablo_id=$_GET['tablo_id'];

	$insertData = [
		"tablo"          => $_GET['tablo'],
		"tablo_id"       => $_GET['tablo_id'],
		"video_link"     => $_POST['video_link'],

	];

	$languageinsertData = prepareLanguagePost(array("ad"));
	$uploadImageData_Big = [
		"image" 				=> $_FILES["file"],
		"imagename"				=> postDefaultLangugage('ad'),
		"resize"				=> true,
		"resizedata" 			=> [ "width" => 800, "height" => 600],
	];
	$uploadImageData_Small = [
		"image" 				=> $_FILES["file"],
		"imagename" 			=> postDefaultLangugage('ad'),
		"resize"				=> true,
		"resizedata" 			=> [ "width" => 400, "height" => 300],
	];
	$defaultinsertData = [
		"image"			=> uploadImage($uploadImageData_Big),
		"thumb"			=> uploadImage($uploadImageData_Small)
	];

	$insertData += $defaultinsertData + $languageinsertData;
	$video_id 	= insertDatatoTable("videolar",$insertData);
	$updateData = ["sira"		=>	$video_id];
	$where 		= ["video_id"	=>	$video_id];
	updateTableData("videolar",$updateData,$where);

	header("location:admin.php?cmd=video&tablo=$tablo&tablo_id=$tablo_id&result=eklendi");
}
?>