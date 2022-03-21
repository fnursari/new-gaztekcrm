<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea() && $_SESSION["user"]["group"]=='root')  {
	$updateData = [
		"company_name"          => $_POST['company_name'],
		"phone"          		=> $_POST['phone'],
		"fax"          			=> $_POST['fax'],
		"address"          		=> $_POST['address'],
		"gsm"          			=> $_POST['gsm'],
		"email"       			=> $_POST['email'],
		"web"       			=> $_POST['web'],
		"registration_number"   => $_POST['registration_number'],
		"tax_office"            => $_POST['tax_office'],
		"tax_number"            => $_POST['tax_number'],
		"smtp_host"     		=> $_POST['smtp_host'],
		"smtp_username"     	=> $_POST['smtp_username'],
		"smtp_password"     	=> $_POST['smtp_password'],
		"mail_address"     		=> $_POST['mail_address'],
		"mail_name"     		=> $_POST['mail_name'],

	];

	$updateTeklifData = [];
	$updateProformaData = [];



	$uploadLogoData1 = [
		"image" 				=> $_FILES["logo1"],
		"imagename"				=> "logo1_".$_POST['company_name'],
		"resize"				=> false,
		"uploadfolder"			=> $hostcfg["SiteRoot"].'upload/company/',
	];
	if( ($logo1 = uploadImage($uploadLogoData1)) !==NULL) {
		$updateData += array("logo1" => $logo1);
	}
	$uploadLogoData2 = [
		"image" 				=> $_FILES["logo2"],
		"imagename"				=> "logo2_".$_POST['company_name'],
		"resize"				=> false,
		"uploadfolder"			=> $hostcfg["SiteRoot"].'upload/company/',
	];
	if( ($logo2 = uploadImage($uploadLogoData2)) !==NULL) {
		$updateData += array("logo2" => $logo2);
	}

	$uploadSignatueData = [
		"image" 				=> $_FILES["signature"],
		"imagename"				=> "signature_".$_POST['company_name'],
		"resize"				=> false,
		"uploadfolder"			=> $hostcfg["SiteRoot"].'upload/company/',
	];
	if( ($signature = uploadImage($uploadSignatueData)) !==NULL) {
		$updateData += array("signature" => $signature);
	}

	$uploadSignatueData = [
		"image" 				=> $_FILES["sozlesme_resim"],
		"imagename"				=> "sozlesme_resim_".$_POST['company_name'],
		"resize"				=> false,
		"uploadfolder"			=> $hostcfg["SiteRoot"].'upload/company/',
	];
	if( ($sozlesme_resim = uploadImage($uploadSignatueData)) !==NULL) {
		$updateData += array("sozlesme_resim" => $sozlesme_resim);
	}

	$languageUpdateData = prepareLanguagePost(array("sozlesme_konusu","teslim_suresi","odeme","odeme_yazi","teslim_yeri","kurulum","egitim","mucbir_sebepler","garanti","genel_hukum"));


	$languageTeklifUpdateData = prepareLanguagePost(array("gecerlilik_suresi","teklif_yazi1","teklif_yazi2","teklif_fan_yazi","makina_modeli","kesim_alani","tezgah_olculeri","plazma_kesim","kesim_kalinligi","detay_yazi1","yukseklik_kontrol","detay_yazi2","raylar","kramiyer","motor_tipi","cnc_kontrol","detay_yazi3","detay_yazi4","detay_yazi5","detay_yazi6","detay_yazi7","detay_yazi8","detay_yazi9","detay_yazi10","detay_yazi11","detay_yazi12","detay_yazi13"));

	$languageProformaUpdateData = prepareLanguagePost(array("proforma_makina_modeli","proforma_kesim_alani","proforma_tezgah_olculeri","proforma_plazma_kesim","proforma_kesim_kalinligi","proforma_raylar","proforma_kramiyer","proforma_motor_tipi","proforma_cnc_kontrol","proforma_yukseklik_kontrol","proforma_oksijen","proforma_ups","proforma_fan","proforma_kompresor","proforma_kurutucu","proforma_yazi1","gtip_kodu","proforma_bilgi_yazi1","proforma_bilgi_yazi2"));
	
	$updateData += $languageUpdateData;	
	$updateTeklifData += $languageTeklifUpdateData;
	$updateProformaData += $languageProformaUpdateData;


	$where = [ "config_id"	=> 1 ];
	updateTableData("config",$updateData,$where);

	$whereTeklif = [ 
						"config_id"	=> 1,
						"config_teklif_id" => 1 
					];
	updateTableData("config_teklif",$updateTeklifData,$whereTeklif);

	$whereProforma = [ 
						"config_id"	=> 1,
						"config_proforma_id" => 1 
					];
	updateTableData("config_proforma",$updateProformaData,$whereProforma);

	header("location:admin.php?cmd=config_guncelle&result=eklendi");
}
?>