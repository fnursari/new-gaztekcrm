<?php

namespace Dompdf;
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");

require_once "dompdf/autoload.inc.php";
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php"; 


$dil=$_GET["dil"];
if ($dil=='') $dil='tr';
if(!file_exists('languages/'.$dil.'.php')) { $dil='tr';}
include_once "languages/".$dil.".php";


define("DOMPDF_ENABLE_REMOTE", true);

$bilgi_giris_id=makeSafe($_GET['bilgi_giris_id']);

$sql="select * from bilgi_giris where bilgi_giris_id='$bilgi_giris_id' and bilgi_giris_aktif='1'";
$details = $db->get_row($sql,ARRAY_A);

$sqlteklif="select * from teklifler where bilgi_giris_id='$bilgi_giris_id'";
$detailsteklif = $db->get_row($sqlteklif,ARRAY_A);

$today=date("Y-m-d");

$config = getConfig();
$config_proforma = getConfigProforma();
$config_teklif = getConfigTeklif();



$options = new Options();
$options->set('defaultFont', 'Courier');
$options->set('isRemoteEnabled', TRUE);
$options->set('debugKeepTemp', TRUE);
$options->set('isHtml5ParserEnabled', true);
$dompdf = new Dompdf($options);


$html="";
if(!is_null($details)) {
	$firma_ad 			     = $details["firma_ad"]!= "" ? $details['firma_ad'] : "-";
	$firma_adres 		     = $details["firma_adres"] != "" ? $details['firma_adres'] : "-";
	$firma_telefon 		     = $details["firma_telefon"] != "" ? $details['firma_telefon'] : "-";
	$firma_fax 		    	 = $details["firma_fax"] != "" ? $details['firma_fax'] : "-";
	$firma_web 			     = $details["firma_web"] != "" ? $details['firma_web'] : "-";
	$firma_yetkili  	     = $details["firma_yetkili"] != "" ? $details['firma_yetkili'] : "-";
	$firma_ceptelefon	     = $details["firma_ceptelefon"] != "" ? $details['firma_ceptelefon'] : "-";
	$firma_email		     = $details["firma_email"] != "" ? $details['firma_email'] : "-";
	$firma_vergidaire		 = $details["firma_vergidaire"] != "" ? $details['firma_vergidaire'] : "-";
	$firma_vergino		     = $details["firma_vergino"] != "" ? $details['firma_vergino'] : "-";
	$teklif_tarihi		     = $detailsteklif["teklif_tarihi"] != "" ? $detailsteklif['teklif_tarihi'] : "-";
	$makina_adet		     = $details["makina_adet"] != "" ? $details['makina_adet'] : "-";
	$makina_fiyati		     = $details["makina_fiyati"] != "" ? number_format($details['makina_fiyati'], 2, ',', '.') : "0,00";
	$makina_toplam_fiyati    = number_format($details["makina_fiyati"] * floatval($details["makina_adet"]), 2, ',', '.');
	$kdv 				     = $details["kdv"] != "" ? number_format($details['kdv'], 2, ',', '.') : "0.00";
	$toplam_fiyat 		     = $details["kdv"]+$details["makina_fiyati"] != "" ? number_format($details["kdv"]+$details["makina_fiyati"], 2, ',', '.') : "0,00";
	$gonderen 			     = $details["gonderen"]!= "" ? $details['gonderen'] : "-";
	$kompresor_fiyati 	     = $details["kompresor_fiyati"] != "" ? number_format($details['kompresor_fiyati'], 2, ',', '.') : "0,00";
	$kompresor_toplam_fiyati = number_format($details["kompresor_fiyati"] * floatval($details["kompresor_adet"]), 2, ',', '.');

	$fan_fiyati 		     = $details["fan_fiyati"] != "" ? number_format($details['fan_fiyati'], 2, ',', '.') : "0,00";
	$fan_toplam_fiyati 	     = number_format($details["fan_fiyati"] * floatval($details["fan_adet"]), 2, ',', '.');

	$ups_fiyati 		     = $details["ups_fiyati"] != "" ? number_format($details['ups_fiyati'], 2, ',', '.') : "0,00";
	$ups_toplam_fiyati 	     = number_format($details["ups_fiyati"] * floatval($details["ups_adet"]), 2, ',', '.');

	$kurutucu_fiyati 	     = $details["kurutucu_fiyati"] != "" ? number_format($details['kurutucu_fiyati'], 2, ',', '.') : "0,00";
	$kurutucu_toplam_fiyati  = number_format($details["kurutucu_fiyati"] * floatval($details["kurutucu_adet"]), 2, ',', '.');

	$kalan_odeme 		     = number_format($details["genel_toplam"]-$details["pesinat"], 2, ',', '.');
	$toplam_tutar 		     = number_format($details["genel_toplam"], 2, ',', '.');
	$genel_toplam 		     = number_format($details["makina_fiyati"]+
		$details["kurutucu_fiyati"]+
		$details["ups_fiyati"]+
		$details["fan_fiyati"]+
		$details["kompresor_fiyati"], 2, ',', '.');

	$makina=getParameter($details["makina_modeli"]);

	$makina_modeli=str_replace("{#makina_modeli#}",$makina["parametre_deger_$dil"],$config_proforma["proforma_makina_modeli_$dil"]);
	$mak_model= $details["makina_modeli"] != 0 ? $makina_modeli : "-";

	$kesim_olcu=getParameter($details["kesim_olcusu"]);
	$kesim_olcusu=str_replace("{#kesim_alani#}",$kesim_olcu["parametre_deger_$dil"],$config_proforma["proforma_kesim_alani_$dil"]);

	$tezgah_olcusu=str_replace("{#tezgah_olculeri#}",$details["tezgah_olcusu"],$config_proforma["proforma_tezgah_olculeri_$dil"]);

	$plazma=getParameter($details["plazma_kesim"]);
	$plazma_kesim=str_replace("{#plazma_kesim#}",$plazma["parametre_deger_$dil"],$config_proforma["proforma_plazma_kesim_$dil"]);

	$kesim_kalinligi=str_replace("{#kesim_kalinligi#}",$details["kesim_kalinligi"],$config_proforma["proforma_kesim_kalinligi_$dil"]);

	$yukseklik=getParameter($details["yukseklik_kontrol"]);
	$yukseklik_kontrol=str_replace("{#yukseklik_kontrol#}",$yukseklik["parametre_deger_$dil"],$config_proforma["proforma_yukseklik_kontrol_$dil"]);

	$ray=getParameter($details["raylar"]);
	$raylar=str_replace("{#raylar#}",$ray["parametre_deger_$dil"],$config_proforma["proforma_raylar_$dil"]);

	$kramiyer_deger=getParameter($details["kramiyer"]);
	$kramiyer=str_replace("{#kramiyer#}",$kramiyer_deger["parametre_deger_$dil"],$config_proforma["proforma_kramiyer_$dil"]);

	$motor=getParameter($details["motor_tipi"]);
	$motor_tipi=str_replace("{#motor_tipi#}",$motor["parametre_deger_$dil"],$config_proforma["proforma_motor_tipi_$dil"]);

	$cnc_kontrol_deger=getParameter($details["cnc_kontrol"]);
	$cnc_kontrol=str_replace("{#cnc_kontrol#}",$cnc_kontrol_deger["parametre_deger_$dil"],$config_proforma["proforma_cnc_kontrol_$dil"]);

	$oksijen_deger=getParameter($details["oksijen"]);
	$oksijen=str_replace("{#oksijen#}",$oksijen_deger["parametre_deger_$dil"],$config_proforma["proforma_oksijen_$dil"]);

	$ups=getParameter($details["ups_guc_kaynagi"]);
	$ups_guc_kaynagi=str_replace("{#ups#}",$ups["parametre_deger_$dil"],$config_proforma["proforma_ups_$dil"]);

	$fan_deger=getParameter($details["fan"]);
	$fan=str_replace("{#fan#}",$fan_deger["parametre_deger_$dil"],$config_proforma["proforma_fan_$dil"]);

	$kompresor_deger=getParameter($details["kompresor"]);
	$kompresor=str_replace("{#kompresor#}",$kompresor_deger["parametre_deger_$dil"],$config_proforma["proforma_kompresor_$dil"]);

	$kurutucu_deger=getParameter($details["kurutucu"]);
	$kurutucu=str_replace("{#kurutucu#}",$kurutucu_deger["parametre_deger_$dil"],$config_proforma["proforma_kurutucu_$dil"]);

	$satis_tipi=getParameter($details["satis_tipi"]);
	$kdv_yazi_deger=$satis_tipi["kdv_yazi_$dil"];
	$kdv_yazi=str_replace("{#kdv_yazi#}",$kdv,$kdv_yazi_deger);

	$teslim_yeri=getParameter($details["teslim_yeri"]);
	$vade_turu=getParameter($details["vade_turu"]);
	$satis_temsilcisi=getParameter($details["satis_temsilcisi"]);

	$para_birimi=getParameter($details["para_birimi"]);
	$para_sembol=$para_birimi["para_sembol"];
	$para_birim=$para_birimi["parametre_deger_tr"];

	if($config["sozlesme_konusu_$dil"] != ""){
		$sozlesme_konusu=str_replace("{#satici#}",$config["company_name"] ,$config["sozlesme_konusu_$dil"]);
		$sozlesme_konusu=str_replace("{#alici#}",$firma_ad ,$sozlesme_konusu);

	}else{
		$sozlesme_konusu="-";
	}

	if($config["teslim_suresi_$dil"] != ""){
		$teslim_suresi=str_replace("{#teslim_gunu#}",$details["teslim_gunu"] ,$config["teslim_suresi_$dil"]);
	}else{
		$teslim_suresi="-";
	}

	$vade_turu=getParameter($details["vade_turu"]);
	if($config["odeme_$dil"] != ""){
		$odeme=str_replace("{#odeme_miktar#}",$kalan_odeme ,$config["odeme_$dil"]);
		$odeme=str_replace("{#para_birimi#}",$para_birim ,$odeme);
		$odeme=str_replace("{#odeme_tipi#}",$vade_turu["parametre_deger_$dil"] ,$odeme);
		$odeme=str_replace("{#taksit#}",$details["taksit_sayisi"] ,$odeme);
	}else{
		$odeme="-";
	}

	$teslim_yeri_deger=getParameter($details["teslim_yeri"]);
	$masraf_sahibi=$teslim_yeri_deger["masraf_sahibi_$dil"];
	if($config["odeme_$dil"] != ""){
		$teslim_yeri=str_replace("{#teslim_yeri#}",$teslim_yeri_deger["parametre_deger_$dil"] ,$config["teslim_yeri_$dil"]);
		$teslim_yeri=str_replace("{#masraf_sahibi#}",$masraf_sahibi ,$teslim_yeri);

	}else{
		$teslim_yeri="-";
	}


	

	$today=date("Y-m-d");


	$html.='<html>';
	$html.='<head>';
	$html.='<style>';

	$html.='@page {';
	$html.='margin: 15px 25px;';
	$html.='width: 100%;';
	$html.='font-family: arial, opensans-regular, DejaVu Sans, sans-serif';
	$html.='font-size: 11px';
	$html.='}';

	$html.='body {';
	$html.='margin-top:11%;';
	$html.='margin-left:0 px;';
	$html.='margin-right:0 px;';
	$html.='margin-bottom:20 px;';
	$html.='font-size: 11px';
	$html.='font-weight: 600';
	$html.='}';

	$html.='body table{';
	$html.='margin-left:0 px;';
	$html.='padding-left:0 px;';
	$html.='border-spacing:0 px;';
	$html.='border-collapse: collapse;';
	$html.='}';

	$html.='body table tr,td{';
	$html.='border-spacing:0 px;';
	$html.='line-height:18 px;';
	$html.='vertical-align:middle;';
	$html.='padding:0 10px;';
	$html.='}';

	$html.='body table td.info-header{';
	$html.='padding:0 5px;';
	$html.='vertical-align:middle;';
	$html.='}';

	$html.='body .general_rules{';
	$html.='font-size:11px;';
	$html.='padding:15px 0;';
	$html.='vertical-align:middle;';
	$html.='margin-bottom:200px;';
	$html.='margin-top:10px;';
	$html.='}';

	$html.='body .payment_details{';
	$html.='padding:15px 0;';
	$html.='vertical-align:middle;';
	$html.='margin-bottom:180px;';
	$html.='margin-top:10px;';
	$html.='}';



	$html.='body .general_rules tr ol li{';
	$html.='margin-bottom:12px;';
	$html.='}';

	$html.='::marker{';
	$html.='font-weight:600;';
	$html.='font-size:12px;';
	$html.='color:red;';
	$html.='}';


	$html.='header {';
	$html.='position: fixed;';
	$html.='top: 20 px;';
	$html.='left: 0 px;';
	$html.='right: 0 px;';
	$html.='height: 100px;';
	$html.='width: 100%;';
	$html.='}';


	$html.='header .top-img img {';
	$html.='position: fixed; ';
	$html.='width:300px;';
	$html.='height:auto;';
	$html.='float:right;';	
	$html.='vertical-align:middle;';
	$html.='}';

	$html.='header img.logo {';
	$html.='position: fixed; ';
	$html.='width:300px;';
	$html.='margin-top:15px;';
	$html.='height:auto;';
	$html.='vertical-align:middle;';
	$html.='}';


	$html.='footer {';
	$html.='position: fixed; ';
	$html.='bottom: 0px; ';
	$html.='left: 0px; ';
	$html.='right: 0px;';
	$html.='height: 200px;'; 
	$html.='text-align: center;';
	$html.='line-height: 0px;';
	$html.='margin-bottom: 20px;';
	$html.='margin-top: 20px;';
	$html.='}';



	$html.='</style>';

	$html.='</head>';
	$html.='<body>';

	$html.='<header>';
	$html.='<div class="row">';

	$html.='<div style="width:50%;display:inline-block;page-break-after: always;">';
	$html.='<img class="logo" src="'.$cfg["SiteUrl"].'upload/company/'.$config['logo2'].'">';
	$html.='</div>';
	$html.='<div class="top-img" style="width:50%;display:inline-block;page-break-after: always;">';
	$html.='<img src="'.$cfg["SiteUrl"].'upload/company/'.$config['sozlesme_resim'].'">';
	$html.='</div>';


	$html.='</div>';
	$html.='</header>';

	$html.='<footer>';
	$html.='<table style="width:100%">';
	$html.='<tr>';

	$html.='<td colspan="5" style="text-align:center;font-size:13px;width:45%;line-height:14px"><b>'.$lang["SellerSignature"].'</b></td>';
	$html.='<td style="width:5%"></td>';
	$html.='<td colspan="5" style="text-align:center;font-size:13px;width:45%;line-height:14px"><b>'.$lang["BuyerSignature"].'</b></td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="5" style="text-align:center;width:45%;line-height:14px">'.$satis_temsilcisi["parametre_deger_$dil"].'</td>';
	$html.='<td style="width:5%"></td>';
	$html.='<td colspan="5" style="text-align:center;width:45%;line-height:14px">'.$firma_ad.'</td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="5" style="text-align:center;width:45%;line-height:14px"></td>';
	$html.='<td style="width:5%"></td>';
	$html.='<td colspan="5" style="text-align:center;width:45%;line-height:14px">'.$firma_yetkili.'</td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="5" style="text-align:center;width:45%;line-height:14px"><img style="width:240px;padding-top:0;margin-top:0" src="'.$cfg["SiteUrl"].'upload/company/'.$config['signature'].'"></td>';
	$html.='<td style="width:5%"></td>';
	$html.='<td colspan="5" style="text-align:center;width:45%;line-height:14px"></td>';
	$html.='</tr>';

	$html.='</table>';
	$html.='</footer>';




	$html.='<main style="margin-top:20px">';
	$html.='<div style="page-break-after: always;">';

	$html.='<table style="width:100%;">';


	$html.='<tr>';
	$html.='<td colspan="11" style="height:25px;text-align:center;background-color:#e3e3e3;font-size:14px;vertical-align:middle"><b>'.$lang["SaleContract"].'</b></td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="4" class="info-header" style="text-align:right"><b>'.$lang["SubjectOfTheContract"].' : </b></td>';
	$html.='<td colspan="7" rowspan="3" style="text-align:left;">'.$sozlesme_konusu.'</td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="4" class="info-header" style="text-align:right"></td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="4" class="info-header" style="text-align:right"></td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="4" class="info-header" style="text-align:right"><b>'.$lang["DateOfTheContract"].' : </b></td>';
	$html.='<td colspan="2" style="text-align:left;">'.$details["sozlesme_yeri"].'</td>';
	$html.='<td colspan="2" style="text-align:left;">'.pdfTarih($today,$dil).'</td>';
	$html.='<td colspan="3" style="text-align:left;"></td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="4" class="info-header" style="text-align:right"><b>'.$lang["PlaceOfPerformance"].' : </b></td>';
	$html.='<td colspan="2" style="text-align:left;">'.$details["sozlesme_yeri"].'</td>';
	$html.='<td colspan="5" style="text-align:left;"></td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="11" style="height:25px;text-align:center;background-color:#e3e3e3;font-size:13px;vertical-align:middle"><b><u>'.$lang["VendorInfo"].'</u></b></td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="4" class="info-header" style="text-align:right"><b>'.$lang["NameSurname"].' : </b></td>';
	$html.='<td colspan="7" style="text-align:left;">'.$config["company_name"].'</td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="4" class="info-header" style="text-align:right"><b>'.$lang["VendorAdress"].' : </b></td>';
	$html.='<td colspan="7" style="text-align:left;">'.$config["address"].'</td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="4" class="info-header" style="text-align:right"><b>'.$lang["Contact"].' : </b></td>';
	$html.='<td colspan="3" style="text-align:left;">'.$config["gsm"].'</td>';
	$html.='<td colspan="2" class="info-header" style="text-align:right;"><b>'.$lang["Tel1"].' : </b></td>';
	$html.='<td colspan="2" style="text-align:left;">'.$config["phone"].'</td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="4" class="info-header" style="text-align:right"><b>'.$lang["EmailAddress"].' : </b></td>';
	$html.='<td colspan="3" style="text-align:left;">'.$config["mail_address"].'</td>';
	$html.='<td colspan="2" class="info-header" style="text-align:right;"><b>'.$lang["FaxAddress"].' : </b></td>';
	$html.='<td colspan="2" style="text-align:left;">'.$config["fax"].'</td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="4" class="info-header" style="text-align:right"><b>'.$lang["TaxOffice"].' : </b></td>';
	$html.='<td colspan="3" style="text-align:left;">'.$config["tax_office"].'</td>';
	$html.='<td colspan="2" class="info-header" style="text-align:right;"><b>'.$lang["TaxNo"].' : </b></td>';
	$html.='<td colspan="2" style="text-align:left;">'.$config["tax_number"].'</td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="4" class="info-header" style="text-align:right"><b>'.$lang["AuthorizedName"].' : </b></td>';
	$html.='<td colspan="3" style="text-align:left;">'.$details["gonderen"].'</td>';
	$html.='<td colspan="2" class="info-header" style="text-align:right;"></td>';
	$html.='<td colspan="2" style="text-align:left;"></td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="4" class="info-header" style="text-align:right"><b>'.$lang["Salesman"].' : </b></td>';
	$html.='<td colspan="3" style="text-align:left;">'.$satis_temsilcisi["parametre_deger_$dil"].'</td>';
	$html.='<td colspan="2" class="info-header" style="text-align:right;"></td>';
	$html.='<td colspan="2" style="text-align:left;"></td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="11" style="height:25px;text-align:center;background-color:#e3e3e3;font-size:13px;vertical-align:middle"><b><u>'.$lang["BuyerInfo"].'</u></b></td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="4" class="info-header" style="text-align:right"><b>'.$lang["NameSurname"].' : </b></td>';
	$html.='<td colspan="7" style="text-align:left;">'.$firma_ad.'</td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="4" class="info-header" style="text-align:right"><b>'.$lang["VendorAdress"].' : </b></td>';
	$html.='<td colspan="7" style="text-align:left;">'.$firma_adres.'</td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="4" class="info-header" style="text-align:right"><b>'.$lang["Contact"].' : </b></td>';
	$html.='<td colspan="3" style="text-align:left;">'.$firma_ceptelefon.'</td>';
	$html.='<td colspan="2" class="info-header" style="text-align:right;"><b>'.$lang["Tel"].' : </b></td>';
	$html.='<td colspan="2" style="text-align:left;">'.$firma_telefon.'</td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="4" class="info-header" style="text-align:right"><b>'.$lang["EmailAddress"].' : </b></td>';
	$html.='<td colspan="3" style="text-align:left;">'.$firma_email.'</td>';
	$html.='<td colspan="2" class="info-header" style="text-align:right;"><b>'.$lang["FaxAddress"].' : </b></td>';
	$html.='<td colspan="2" style="text-align:left;">'.$firma_fax.'</td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="4" class="info-header" style="text-align:right"><b>'.$lang["TaxOffice"].' : </b></td>';
	$html.='<td colspan="3" style="text-align:left;">'.$firma_vergidaire.'</td>';
	$html.='<td colspan="2" class="info-header" style="text-align:right;"><b>'.$lang["TaxNo"].' : </b></td>';
	$html.='<td colspan="2" style="text-align:left;">'.$firma_vergino.'</td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="4" class="info-header" style="text-align:right"><b>'.$lang["AuthorizedName"].' : </b></td>';
	$html.='<td colspan="3" style="text-align:left;">'.$firma_yetkili.'</td>';
	$html.='<td colspan="2" class="info-header" style="text-align:right;"></td>';
	$html.='<td colspan="2" style="text-align:left;"></td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="11" style="height:25px;text-align:center;background-color:#e3e3e3;font-size:13px;vertical-align:middle"><b><u>'.$lang["ProductInfo"].'</u></b></td>';
	$html.='</tr>';

	if($mak_model != "" || $cnc_kontrol != ""){
		$html.='<tr>';
		$html.='<td colspan="5" style="text-align:center;width:45%;">'.$mak_model.'</td>';
		$html.='<td style="width:5%;"></td>';
		$html.='<td colspan="5" style="text-align:center;width:45%;">'.$cnc_kontrol.'</td>';
		$html.='</tr>';
	}

	if($kesim_olcusu != "" || $yukseklik_kontrol != ""){
		$html.='<tr>';
		$html.='<td colspan="5" style="text-align:center;width:45%;">'.$kesim_olcusu.'</td>';
		$html.='<td style="width:5%;"></td>';
		$html.='<td colspan="5" style="text-align:center;width:45%;">'.$yukseklik_kontrol.'</td>';
		$html.='</tr>';
	}

	if($tezgah_olcusu != "" || $oksijen != ""){
		$html.='<tr>';
		$html.='<td colspan="5" style="text-align:center;width:45%;">'.$tezgah_olcusu.'</td>';
		$html.='<td style="width:5%;"></td>';
		$html.='<td colspan="5" style="text-align:center;width:45%;">'.$oksijen.'</td>';
		$html.='</tr>';
	}
	if($plazma_kesim != "" || $ups_guc_kaynagi != ""){
		$html.='<tr>';
		$html.='<td colspan="5" style="text-align:center;width:45%;">'.$plazma_kesim.'</td>';
		$html.='<td style="width:5%;"></td>';
		$html.='<td colspan="5" style="text-align:center;width:45%;">'.$ups_guc_kaynagi.'</td>';
		$html.='</tr>';
	}
	if($kesim_kalinligi != "" || $fan != ""){
		$html.='<tr>';
		$html.='<td colspan="5" style="text-align:center;width:45%;">'.$kesim_kalinligi.'</td>';
		$html.='<td style="width:5%;"></td>';
		$html.='<td colspan="5" style="text-align:center;width:45%;">'.$fan.'</td>';
		$html.='</tr>';
	}
	if($raylar != "" || $kompresor != ""){
		$html.='<tr>';
		$html.='<td colspan="5" style="text-align:center;width:45%;">'.$raylar.'</td>';
		$html.='<td style="width:5%;"></td>';
		$html.='<td colspan="5" style="text-align:center;width:45%;">'.$kompresor.'</td>';
		$html.='</tr>';
	}
	if($kramiyer != "" || $kurutucu != ""){
		$html.='<tr>';
		$html.='<td colspan="5" style="text-align:center;width:45%;">'.$kramiyer.'</td>';
		$html.='<td style="width:5%;"></td>';
		$html.='<td colspan="5" style="text-align:center;width:45%;">'.$kurutucu.'</td>';
		$html.='</tr>';
	}
	if($motor_tipi != "" || $config_proforma["proforma_yazi1_$dil"] != ""){
		$html.='<tr>';
		$html.='<td colspan="5" style="text-align:center;width:45%;">'.$motor_tipi.'</td>';
		$html.='<td style="width:5%;"></td>';
		$html.='<td colspan="5" style="text-align:center;width:45%;">'.$config_proforma["proforma_yazi1_$dil"].'</td>';
		$html.='</tr>';
	}
	if($config_proforma["gtip_kodu_$dil"] != ""){
		$html.='<tr>';
		$html.='<td colspan="11" style="text-align:center;width:45%;">'.$lang["GtipKodu"].' '.$config_proforma["gtip_kodu_$dil"].'</td>';
		$html.='</tr>';
	}

	$html.='</table>';
	$html.='</div>';

// Page 2-3 Start

	$html.='<div style="page-break-after: never;">';
	$html.='<table class="general_rules" style="width:100%;">';

	$html.='<tr>';
	$html.='<td colspan="11" style="height:25px;text-align:center;background-color:#e3e3e3;font-size:14px;vertical-align:middle"><b>'.$lang["GeneralRules"].'</b></td>';
	$html.='</tr>';

	$html.='<tr class="general_rules_details">';
	$html.='<td colspan="11">'.$config["genel_hukum_$dil"].'</td>';
	$html.='</tr>';


	$html.='</table>';
	$html.='</div>';

// Page 2-3 End


// Page 4 Start

	$html.='<div style="page-break-after: never;">';
	$html.='<table class="payment_details" style="width:100%;">';

	$html.='<tr>';
	$html.='<td colspan="11" style="height:25px;text-align:center;background-color:#e3e3e3;font-size:14px;vertical-align:middle"><b>'.$lang["PaymentAndDelivery"].'</b></td>';
	$html.='</tr>';


	$html.='<tr>';
	$html.='<td colspan="3" class="info-header" style="text-align:left"><b>'.$lang["MachinePrice"].' : </b></td>';
	$html.='<td colspan="2" style="text-align:right;">'.$makina_toplam_fiyati.' + '.$lang["KDV"].'</td>';
	$html.='<td colspan="6" style="text-align:left;"></td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="3" class="info-header" style="text-align:left"><b>'.$lang["CompressorPrice"].' : </b></td>';
	$html.='<td colspan="2" style="text-align:right;">'.$kompresor_toplam_fiyati.' + '.$lang["KDV"].'</td>';
	$html.='<td colspan="6" style="text-align:left;"></td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="3" class="info-header" style="text-align:left"><b>'.$lang["FanPrice"].' : </b></td>';
	$html.='<td colspan="2" style="text-align:right;">'.$fan_toplam_fiyati.' + '.$lang["KDV"].'</td>';
	$html.='<td colspan="6" style="text-align:left;"></td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="3" class="info-header" style="text-align:left"><b>'.$lang["UpsPrice"].' : </b></td>';
	$html.='<td colspan="2" style="text-align:right;">'.$ups_toplam_fiyati.' + '.$lang["KDV"].'</td>';
	$html.='<td colspan="6" style="text-align:left;"></td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="3" class="info-header" style="text-align:left"><b>'.$lang["DryerPrice"].' : </b></td>';
	$html.='<td colspan="2" style="text-align:right;">'.$kurutucu_toplam_fiyati.' + '.$lang["KDV"].'</td>';
	$html.='<td colspan="6" style="text-align:left;"></td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="3" class="info-header" style="text-align:left;background-color:#e3e3e3;vertical-align:middle"><b>'.$lang["TotalPrice"].' : </b></td>';
	$html.='<td colspan="2" style="text-align:right;background-color:#e3e3e3;">'.$genel_toplam.' + '.$lang["KDV"].'</td>';
	$html.='<td colspan="6" style="text-align:left;"></td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="3" class="info-header" style="text-align:left"><b>'.$lang["DeliveryTime"].' : </b></td>';
	$html.='<td colspan="8" style="text-align:left;">'.$teslim_suresi.'</td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="3" rowspan="2" class="info-header" style="text-align:left;vertical-align:top"><b>'.$lang["Payments"].' : </b></td>';
	$html.='<td colspan="8" style="text-align:left;">'.$odeme.'</td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="8" style="text-align:left;">'.$config["odeme_yazi_$dil"].'</td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="11" style="height:30px"></td>';
	$html.='</tr>';


	$html.='<tr rowspan="5">';
	$html.='<td colspan="3" class="info-header" style="text-align:right;vertical-align:top;width:530px;margin-bottom:15px"><b>'.$lang["DeliveryPlaceAndType"].' : </b></td>';
	$html.='<td colspan="8" style="text-align:left;vertical-align:top;margin-bottom:15px">'.$teslim_yeri.'</td>';
	$html.='</tr>';


	$html.='<tr rowspan="5">';
	$html.='<td colspan="3" class="info-header" style="text-align:right;vertical-align:top;width:530px;margin-bottom:15px"><b>'.$lang["Settings"].' : </b></td>';
	$html.='<td colspan="8" style="text-align:left;vertical-align:top;margin-bottom:15px">'.$config["kurulum_$dil"].'</td>';
	$html.='</tr>';


	$html.='<tr rowspan="5">';
	$html.='<td colspan="3" class="info-header" style="text-align:right;vertical-align:top;width:530px;margin-bottom:15px"><b>'.$lang["Training"].' : </b></td>';
	$html.='<td colspan="8" style="text-align:left;vertical-align:top;margin-bottom:15px">'.$config["egitim_$dil"].'</td>';
	$html.='</tr>';


	$html.='<tr rowspan="5">';
	$html.='<td colspan="3" class="info-header" style="text-align:right;vertical-align:top;width:530px;margin-bottom:15px"><b>'.$lang["ForceMajeure"].' : </b></td>';
	$html.='<td colspan="8" style="text-align:left;vertical-align:top;margin-bottom:15px">'.$config["mucbir_sebepler_$dil"].'</td>';
	$html.='</tr>';


	$html.='<tr rowspan="5">';
	$html.='<td colspan="3" class="info-header" style="text-align:right;vertical-align:top;width:530px;margin-bottom:15px"><b>'.$lang["Guarantee"].' : </b></td>';
	$html.='<td colspan="8" style="text-align:left;vertical-align:top;margin-bottom:15px">'.$config["garanti_$dil"].'</td>';
	$html.='</tr>';


	$html.='<tr>';
	$html.='<td colspan="11" style="height:20px"></td>';
	$html.='</tr>';


	$html.='<tr>';
	$html.='<td colspan="5" style="text-align:center;vertical-align:middle;border:1px solid #000;width:45%;background-color:#e3e3e3;"><b>'.$lang["Vendor"].'</b></td>';
	$html.='<td style="width:10%"></td>';
	$html.='<td colspan="5" style="text-align:center;vertical-align:middle;border:1px solid #000;width:45%;background-color:#e3e3e3;"><b>'.$lang["Buyer"].'</b></td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="5" style="text-align:center;vertical-align:middle;border-right:1px solid #000;border-left:1px solid #000;width:45%">'.$config["company_name"].'</td>';
	$html.='<td style="width:10%"></td>';
	$html.='<td colspan="5" style="text-align:center;vertical-align:middle;border-right:1px solid #000;border-left:1px solid #000;width:45%">'.$firma_ad.'</td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="2" style="text-align:right;vertical-align:middle;border-left:1px solid #000;"><b>'.$lang["Authorized"].' : </b></td>';
	$html.='<td colspan="3" style="text-align:left;vertical-align:middle;border-right:1px solid #000;">'.$gonderen.'</td>';
	$html.='<td style="width:10%"></td>';
	$html.='<td colspan="2" style="text-align:right;vertical-align:middle;border-left:1px solid #000;"><b>'.$lang["Authorized"].' : </b></td>';
	$html.='<td colspan="3" style="text-align:left;vertical-align:middle;border-right:1px solid #000;">'.$firma_yetkili.'</td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="2" style="text-align:right;vertical-align:middle;border-left:1px solid #000;"><b>'.$lang["TaxOffice"].' : </b></td>';
	$html.='<td colspan="3" style="text-align:left;vertical-align:middle;border-right:1px solid #000;">'.$config["tax_office"].'</td>';
	$html.='<td style="width:10%"></td>';
	$html.='<td colspan="2" style="text-align:right;vertical-align:middle;border-left:1px solid #000;"><b>'.$lang["TaxOffice"].' : </b></td>';
	$html.='<td colspan="3" style="text-align:left;vertical-align:middle;border-right:1px solid #000;">'.$firma_vergidaire.'</td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="2" style="text-align:right;vertical-align:middle;border-left:1px solid #000;border-bottom:1px solid #000;"><b>'.$lang["TaxNo"].' : </b></td>';
	$html.='<td colspan="3" style="text-align:left;vertical-align:middle;border-right:1px solid #000;border-bottom:1px solid #000;">'.$config["tax_number"].'</td>';
	$html.='<td style="width:10%"></td>';
	$html.='<td colspan="2" style="text-align:right;vertical-align:middle;border-left:1px solid #000;border-bottom:1px solid #000;"><b>'.$lang["TaxNo"].' : </b></td>';
	$html.='<td colspan="3" style="text-align:left;vertical-align:middle;border-right:1px solid #000;border-bottom:1px solid #000;">'.$firma_vergino.'</td>';
	$html.='</tr>';


	$html.='</table>';
	$html.='</div>';

// Page 4 End




	$html.='</main>';



	$html.='</body>';
	$html.='</html>';




//önizleme için
	$dompdf->set_option('isRemoteEnabled', TRUE);
	$dompdf->loadHtml($html);

	$dompdf->setPaper('A4');
	$dompdf->render();
//$dompdf->stream("", array("Attachment" => false)); //önizleme için

//kaydetme işlemi yapıyor
$output = $dompdf->output();
if(($detailsteklif["sozlesme_pdf_$dil"] != "") && (file_exists('upload/'.$file))){
	$path = 'upload/pdfs/contract/'.$detailsteklif["sozlesme_pdf_$dil"].'';
	$pathData = $detailsteklif["sozlesme_pdf_$dil"];

}else{
	$file=permayap($details["firma_ad"]).'_sozlesme_'.$dil."_" . rand() . '.pdf';
	$path = 'upload/pdfs/contract/'.$file;
	$pathData = $file;
}

file_put_contents($path, $output);

$updateData=[
	"sozlesme_pdf_$dil" => $pathData,
];

$teklif_id=$detailsteklif["teklif_id"];
$where = [ "teklif_id"	=> $teklif_id ];
updateTableData("teklifler",$updateData,$where);

header("location:admin.php?cmd=pdf_goster&pdf=sozlesme&bilgi_giris_id=$bilgi_giris_id&dil=$dil&result=sozlesme");

}

