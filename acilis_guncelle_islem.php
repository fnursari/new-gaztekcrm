<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php"; 
if(canUserAccessAdminArea()) {
  $acilis_id=$_GET["acilis_id"];
  $defaultUpdateData = [];
  $updateData = [
    "aktif"   =>$_POST['aktif'],
  ];
  $languageUpdateData = prepareLanguagePost(array("link"));

  $diller=getLanguages();
  if(count($diller)>0) {
    foreach ($diller as $dil) {
      $code=$dil["language_code"];
      $uploadImageData_Big = [
        "image"           => $_FILES["resim_$code"],
        "imagename"       => 'popup_'.$code,
        "resize"          => true,
        "uploadfolder"    => $hostcfg["SiteRoot"].'upload/banner/',
        "resizedata"      => [ "width" => 800, "height" => 450, "type" =>'' ],
      ];
      if( ($resim = uploadImage($uploadImageData_Big)) !==NULL) {
        $defaultUpdateData += array("resim_".$code => $resim);
      }
    }
  }        

  $updateData += $defaultUpdateData + $languageUpdateData;
  $where    = ["acilis_id"  =>  $acilis_id];
  updateTableData("acilis",$updateData,$where);
  header("location:admin.php?cmd=acilis_guncelle&acilis_id=$acilis_id&result=guncellendi");
}
?>