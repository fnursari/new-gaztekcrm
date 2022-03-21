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

	$defaultinsertData = [];
	$diller=getLanguages();
	if ($db->num_rows > 0) {
		$x=0;
		foreach ($diller as $d) {
			$code=$d["language_code"];
			$uploadImageData_Big = [
			"file" 				=> $_FILES["file_$code"],
			"filename"			=> $_POST["ad_$code"],
			];
			$defaultinsertData += [
			"dosya_$code"			=> uploadFile($uploadImageData_Big),
			];
		}
	}

	/*dd($defaultinsertData);*/
	
	
	
	$insertData += $defaultinsertData + $languageinsertData;
	$dosya_id 	= insertDatatoTable("dosya",$insertData);
	$updateData = ["sira"		=>	$dosya_id];
	$where 		= ["dosya_id"	=>	$dosya_id];
	updateTableData("dosya",$updateData,$where);

	header("location:admin.php?cmd=dosya&tablo=$tablo&tablo_id=$tablo_id&result=eklendi");
}
?>