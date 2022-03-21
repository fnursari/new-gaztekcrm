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

	];

	$languageinsertData = prepareLanguagePost(array("ad"));


	if ($tablo=="sayfa" && $tablo_id==6) {
		$imgw	= 514;
		$imgh	= 552;
		$thmbw	= 514;
		$thmbh	= 552;
	}
	elseif ($tablo=="urun") {
		$imgw	= 1000;
		$imgh	= 1000;
		$thmbw	= 500;
		$thmbh	= 500;
	}

	else {
		$imgw	= 800;
		$imgh	= 600;
		$thmbw	= 400;
		$thmbh	= 300;
	}

	$uploadImageData_Big = [
	"image" 				=> $_FILES["file"],
	"imagename"				=> postDefaultLangugage('ad'),
	"resize"				=> true,
	"resizedata" 			=> [ "width" => $imgw, "height" => $imgh],
	];
	$uploadImageData_Small = [
	"image" 				=> $_FILES["file"],
	"imagename" 			=> postDefaultLangugage('ad'),
	"resize"				=> true,
	"resizedata" 			=> [ "width" => $thmbw, "height" => $thmbh],
	];

	
	$defaultinsertData = [
	"image"			=> uploadImage($uploadImageData_Big),
	"thumb"			=> uploadImage($uploadImageData_Small)
	];
	
	
	$insertData += $defaultinsertData + $languageinsertData;
	$resim_id 	= insertDatatoTable("resim",$insertData);
	$updateData = ["sira"		=>	$resim_id];
	$where 		= ["resim_id"	=>	$resim_id];
	updateTableData("resim",$updateData,$where);

	header("location:admin.php?cmd=resim&tablo=$tablo&tablo_id=$tablo_id&result=eklendi");
}
?>