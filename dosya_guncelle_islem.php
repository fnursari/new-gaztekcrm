<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {
	$tablo=$_GET['tablo'];
	$tablo_id=$_GET['tablo_id']; 
	$dosya_id=$_GET['dosya_id'];

	$dosya=$_FILES["file"]["name"]; 
	$defaultUpdateData = [];


	$languageUpdateData = prepareLanguagePost(array("ad"));
	$uploadImageData_Big = [
		"file" 				=> $_FILES["file"],
		"filename"			=> postDefaultLangugage('ad'),
	];

	/*if($dosya!="") {
		$defaultUpdateData = [
			"dosya"			=> uploadFile($uploadImageData_Big),
		];
	}*/

	$defaultUpdateData = [];
	$diller=getLanguages();
	if ($db->num_rows > 0) {
		$x=0;
		foreach ($diller as $d) {
			$code=$d["language_code"];
			$uploadImageData_Big = [
			"file" 				=> $_FILES["file_$code"],
			"filename"			=> $_POST["ad_$code"],
			];
			if( ($uploaded_file = uploadFile($uploadImageData_Big)) !==NULL) {
				$defaultUpdateData += array("dosya_$code" => $uploaded_file);
			}

			
		}
	}



	$updateData = $defaultUpdateData + $languageUpdateData;
	$where 		= ["dosya_id"	=>	$dosya_id];
	updateTableData("dosya",$updateData,$where);
	header("location:admin.php?cmd=dosya&tablo=$tablo&tablo_id=$tablo_id&result=guncellendi");
}
?>