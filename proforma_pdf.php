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
	$firma_web 			     = $details["firma_web"] != "" ? $details['firma_web'] : "-";
	$firma_yetkili  	     = $details["firma_yetkili"] != "" ? $details['firma_yetkili'] : "-";
	$firma_ceptelefon	     = $details["firma_ceptelefon"] != "" ? $details['firma_ceptelefon'] : "-";
	$firma_email		     = $details["firma_email"] != "" ? $details['firma_email'] : "-";
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

$para_birimi=getParameter($details["para_birimi"]);
$para_sembol=$para_birimi["para_sembol"];
$para_birim=$para_birimi["parametre_deger_tr"];

$today=date("Y-m-d");


	$html.='<html>';
	$html.='<head>';
	$html.='<style>';
	/** Define the margins of your page **/
	$html.='@page {';
	$html.='margin: 15px 25px;';
	$html.='width: 100%;';
	$html.='font-family: arial, opensans-regular, DejaVu Sans, sans-serif';
	$html.='font-size: 12px';
	$html.='}';

	$html.='body {';
	$html.='margin-top:11%;';
	$html.='margin-left:0 px;';
	$html.='margin-right:0 px;';
	$html.='margin-bottom:20 px;';
	$html.='font-size: 12px';
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
	$html.='padding:0 15px;';

	$html.='}';

	$html.='body table tr.machine_details td{';
	$html.='font-size:11px;';
	$html.='line-height:12 px;';
	$html.='padding:2px 5px;';
	$html.='}';

	$html.='body table tr.bank_details td{';
	/*	$html.='font-size:11px;';*/
	$html.='line-height:12 px;';
	$html.='padding:2px 15px;';
	$html.='}';


	$html.='header {';
	$html.='position: fixed;';
	$html.='top: 20 px;';
	$html.='left: 0 px;';
	$html.='right: 0 px;';
	$html.='height: 100px;';
	$html.='width: 100%;';
	$html.='}';



	$html.='header img {';
	$html.='width:350px;';
	$html.='height:auto;';
	$html.='display:inline-block;';
	$html.='vertical-align:middle;';
	$html.='}';

	$html.='header div.info-top {';
	$html.='text-align:center;';
	$html.='font-size:11px;';
	$html.='}';

	$html.='header div.info-top p {';
	$html.='margin:0;';
	$html.='}';

	$html.='footer {';
	$html.='position: fixed; ';
	$html.='bottom: 0px; ';
	$html.='left: 0px; ';
	$html.='right: 0px;';
	$html.='height: 50px;'; 
	$html.='text-align: center;';
	$html.='line-height: 15px;';
	$html.='}';

	$html.='footer p{';
	$html.='padding: 0; ';
	$html.='margin: 0; ';
	$html.='font-weight: 400; ';

	$html.='}';

	$html.='</style>';

	$html.='</head>';
	$html.='<body>';

	$html.='<header>';
	$html.='<div class="row">';

	$html.='<div style="width:50%;display:inline-block">';
	$html.='<img src="'.$cfg["SiteUrl"].'upload/company/'.$config['logo1'].'">';
	$html.='</div>';

	$html.='<div class="info-top" style="width:50%;display:inline-block;page-break-after: always;">';
	$html.='<p>'.$config["company_name"].'</p>';
	$html.='<p>'.$config["address"].'</p>';
	$html.='<p>'.$lang["RegistrationNumber"].' : '.$config["registration_number"].' / '.$config["tax_office"].' : '.$config["tax_number"].'</p>';
	$html.='<p>'.$lang["Tel"].': '.$config["phone"].' '.$lang["Fax"].': '.$config["fax"].'</p>';

	$html.='</div>';

	$html.='</div>';
	$html.='</header>';

	$html.='<footer>';
	$html.='<p>'.$config_proforma["proforma_bilgi_yazi1_$dil"].'</p>';
	$html.='<p>'.$config_proforma["proforma_bilgi_yazi2_$dil"].'</p>';
	$html.='</footer>';




	$html.='<main style="margin-top:40px">';
	$html.='<div style="page-break-after: always;">';

	$html.='<table style="font-size:11px;width:100%;">';

	$html.='<tr rowspan="2">';
	$html.='<td rowspan="2" style="border-top:1.5px solid #000;border-left:1.5px solid #000;width:75px"><b>'.$lang["Dear"].' :</b> </td>';
	$html.='<td rowspan="2" colspan="4" style="text-align:left;border-top:1.5px solid #000;border-right:1.5px solid #000">'.$details["firma_ad"].'</td>';
	$html.='<td rowspan="2" colspan="2" style="width:150px"></td>';
	$html.='<td colspan="2" style="text-align:center;background-color:#e3e3e3;border-top:1.5px solid #000;border-left:1.5px solid #000;border-right:1.5px solid #000;width:100px"><b>'.$lang["Date"].'</b></td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="2" style="text-align:center;border-left:1.5px solid #000;border-bottom:1.5px solid #000;border-right:1.5px solid #000;">'.pdfTarih($today,$dil).'</td>';
	$html.='</tr>';

	$html.='<tr rowspan="2">';
	$html.='<td style="width:75px;border-left:1.5px solid #000;"><b>'.strtoupper($lang["Address"]).' : </b></td>';
	$html.='<td colspan="4" style="text-align:left;border-right:1.5px solid #000"">'.$details["firma_adres"].'</td>';
	$html.='<td colspan="2" style="width:150px"></td>';
	$html.='<td colspan="2"></td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td rowspan="2" style="border-left:1.5px solid #000;border-bottom:1.5px solid #000;width:75px"><b>'.$lang["TaxOfficeNo"].' :</b> </td>';
	$html.='<td rowspan="2" colspan="2" style="text-align:left;border-bottom:1.5px solid #000">'.$config["tax_office"].'</td>';
	$html.='<td rowspan="2" colspan="2" style="text-align:left;border-right:1.5px solid #000;border-bottom:1.5px solid #000">'.$config["tax_number"].'</td>';
	$html.='<td rowspan="2" colspan="2" style="width:150px"></td>';
	$html.='<td colspan="2" style="text-align:center;background-color:#e3e3e3;border-left:1.5px solid #000;border-top:1.5px solid #000;border-right:1.5px solid #000;width:100px"><b>'.$lang["NumberNo"].'</b></td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="2" style="text-align:center;border-left:1.5px solid #000;border-bottom:1.5px solid #000;border-right:1.5px solid #000;">'.$details["teklif_no"].'</td>';
	$html.='</tr>';


	$html.='<tr>';
	$html.='<td colspan="9" style="height:20px"></td>';
	$html.='</tr>';

	$html.='<tr rowspan="3">';
	$html.='<td colspan="9" style="height:40px;text-align:center;background-color:#e3e3e3;border:1.5px solid #000;font-size:15px"><b>'.$lang["ProformaBill"].'</b></td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="9" style="height:20px"></td>';
	$html.='</tr>';

	$html.='<tr rowspan="3" style="text-align:center;background-color:#e3e3e3;border-bottom:1.5px solid #000;border-top:1.5px solid #000;border-left:1.5px solid #000;">';
	$html.='<td style="border-right:1.5px solid #000;text-align:center;width:5%"><b>'.$lang["SiraNo"].'</b></td>';
	$html.='<td colspan="4" style="border-right:1.5px solid #000;text-align:center;width:45%"><b>'.$lang["MachineSpecification"].'</b></td>';
	$html.='<td style="border-right:1.5px solid #000;text-align:center;width:10%"><b>'.$lang["Quantity"].'</b></td>';
	$html.='<td style="border-right:1.5px solid #000;text-align:center;width:10%"><b>'.$lang["Unit"].'</b></td>';
	$html.='<td style="border-right:1.5px solid #000;text-align:center;width:15%"><b>'.$lang["Price"].'</b></td>';
	$html.='<td style="text-align:center;width:15%;border-right:1.5px solid #000;"><b>'.$lang["Amount"].'</b></td>';
	$html.='</tr>';

	$html.='<tr class="machine_details" style="border-right:1.5px solid #000;border-left:1.5px solid #000;">';
	$html.='<td rowspan="2" style="border-right:1.5px solid #000;text-align:center;vertical-align:middle"><b>1</b></td>';
	$html.='<td colspan="4" style="border-right:1.5px solid #000;text-align:center"></td>';
	$html.='<td style="border-right:1.5px solid #000;text-align:center"></td>';
	$html.='<td style="border-right:1.5px solid #000;text-align:center"></td>';
	$html.='<td style="border-right:1.5px solid #000;text-align:center"></td>';
	$html.='<td style="text-align:center;"></td>';
	$html.='</tr>';

	$html.='<tr class="machine_details" style="border-right:1.5px solid #000;border-left:1.5px solid #000;">';
	$html.='<td colspan="4" style="border-right:1.5px solid #000;text-align:center">'.$mak_model.'</td>';
	$html.='<td style="border-right:1.5px solid #000;text-align:center">'.$makina_adet.'</td>';
	$html.='<td style="border-right:1.5px solid #000;text-align:center">'.$details["makina_adet_yazi"].'</td>';
	$html.='<td style="border-right:1.5px solid #000;text-align:right"><b>'.$makina_fiyati.' '.$para_sembol.'</b></td>';
	$html.='<td style="text-align:right;"><b>'.$makina_toplam_fiyati.' '.$para_sembol.'</b></td>';
	$html.='</tr>';

	$table_margin=160;

	if($details["kesim_olcusu"] != 0){
		$html.='<tr class="machine_details" style="border-right:1.5px solid #000;border-left:1.5px solid #000;">';
		$html.='<td style="text-align:right;border-right:1.5px solid #000;"></td>';
		$html.='<td colspan="4" style="border-right:1.5px solid #000;text-align:center">'.$kesim_olcusu.'</td>';
		$html.='<td style="border-right:1.5px solid #000;text-align:center"></td>';
		$html.='<td style="border-right:1.5px solid #000;text-align:center"></td>';
		$html.='<td style="border-right:1.5px solid #000;text-align:right"></td>';
		$html.='<td style="text-align:right;"></td>';
		$html.='</tr>';
	}


	if($details["tezgah_olcusu"] != ""){
		$html.='<tr class="machine_details" style="border-right:1.5px solid #000;border-left:1.5px solid #000;">';
		$html.='<td style="text-align:right;border-right:1.5px solid #000;"></td>';
		$html.='<td colspan="4" style="border-right:1.5px solid #000;text-align:center">'.$tezgah_olcusu.'</td>';
		$html.='<td style="border-right:1.5px solid #000;text-align:center"></td>';
		$html.='<td style="border-right:1.5px solid #000;text-align:center"></td>';
		$html.='<td style="border-right:1.5px solid #000;text-align:right"></td>';
		$html.='<td style="text-align:right;"></td>';
		$html.='</tr>';
		$table_margin-=10;
	}

	if($details["plazma_kesim"] != 0){
		$html.='<tr class="machine_details" style="border-right:1.5px solid #000;border-left:1.5px solid #000;">';
		$html.='<td style="text-align:right;border-right:1.5px solid #000;"></td>';
		$html.='<td colspan="4" style="border-right:1.5px solid #000;text-align:center">'.$plazma_kesim.'</td>';
		$html.='<td style="border-right:1.5px solid #000;text-align:center"></td>';
		$html.='<td style="border-right:1.5px solid #000;text-align:center"></td>';
		$html.='<td style="border-right:1.5px solid #000;text-align:right"></td>';
		$html.='<td style="text-align:right;"></td>';
		$html.='</tr>';
		$table_margin-=10;
	}

	if($details["kesim_kalinligi"] != ""){
		$html.='<tr class="machine_details" style="border-right:1.5px solid #000;border-left:1.5px solid #000;">';
		$html.='<td style="text-align:right;border-right:1.5px solid #000;"></td>';
		$html.='<td colspan="4" style="border-right:1.5px solid #000;text-align:center">'.$kesim_kalinligi.'</td>';
		$html.='<td style="border-right:1.5px solid #000;text-align:center"></td>';
		$html.='<td style="border-right:1.5px solid #000;text-align:center"></td>';
		$html.='<td style="border-right:1.5px solid #000;text-align:right"></td>';
		$html.='<td style="text-align:right;"></td>';
		$html.='</tr>';
		$table_margin-=10;
	}

	if($details["raylar"] != 0){
		$html.='<tr class="machine_details" style="border-right:1.5px solid #000;border-left:1.5px solid #000;">';
		$html.='<td style="text-align:right;border-right:1.5px solid #000;"></td>';
		$html.='<td colspan="4" style="border-right:1.5px solid #000;text-align:center">'.$raylar.'</td>';
		$html.='<td style="border-right:1.5px solid #000;text-align:center"></td>';
		$html.='<td style="border-right:1.5px solid #000;text-align:center"></td>';
		$html.='<td style="border-right:1.5px solid #000;text-align:right"></td>';
		$html.='<td style="text-align:right;"></td>';
		$html.='</tr>';
		$table_margin-=10;
	}

	if($details["kramiyer"] != 0){
		$html.='<tr class="machine_details" style="border-right:1.5px solid #000;border-left:1.5px solid #000;">';
		$html.='<td style="text-align:right;border-right:1.5px solid #000;"></td>';
		$html.='<td colspan="4" style="border-right:1.5px solid #000;text-align:center">'.$kramiyer.'</td>';
		$html.='<td style="border-right:1.5px solid #000;text-align:center"></td>';
		$html.='<td style="border-right:1.5px solid #000;text-align:center"></td>';
		$html.='<td style="border-right:1.5px solid #000;text-align:right"></td>';
		$html.='<td style="text-align:right;"></td>';
		$html.='</tr>';
	}

	if($details["motor_tipi"] != 0){
		$html.='<tr class="machine_details" style="border-right:1.5px solid #000;border-left:1.5px solid #000;">';
		$html.='<td style="text-align:right;border-right:1.5px solid #000;"></td>';
		$html.='<td colspan="4" style="border-right:1.5px solid #000;text-align:center">'.$motor_tipi.'</td>';
		$html.='<td style="border-right:1.5px solid #000;text-align:center"></td>';
		$html.='<td style="border-right:1.5px solid #000;text-align:center"></td>';
		$html.='<td style="border-right:1.5px solid #000;text-align:right"></td>';
		$html.='<td style="text-align:right"></td>';
		$html.='</tr>';
		$table_margin-=10;
	}

	if($details["cnc_kontrol"] != 0){
		$html.='<tr class="machine_details" style="border-right:1.5px solid #000;border-left:1.5px solid #000;">';
		$html.='<td style="text-align:right;border-right:1.5px solid #000;"></td>';
		$html.='<td colspan="4" style="border-right:1.5px solid #000;text-align:center">'.$cnc_kontrol.'</td>';
		$html.='<td style="border-right:1.5px solid #000;text-align:center"></td>';
		$html.='<td style="border-right:1.5px solid #000;text-align:center"></td>';
		$html.='<td style="border-right:1.5px solid #000;text-align:right"></td>';
		$html.='<td style="text-align:right;"></td>';
		$html.='</tr>';
		$table_margin-=10;
	}

	if($details["yukseklik_kontrol"] != 0){
		$html.='<tr class="machine_details" style="border-right:1.5px solid #000;border-left:1.5px solid #000;">';
		$html.='<td style="text-align:right;border-right:1.5px solid #000;"></td>';
		$html.='<td colspan="4" style="border-right:1.5px solid #000;text-align:center">'.$yukseklik_kontrol.'</td>';
		$html.='<td style="border-right:1.5px solid #000;text-align:center"></td>';
		$html.='<td style="border-right:1.5px solid #000;text-align:center"></td>';
		$html.='<td style="border-right:1.5px solid #000;text-align:right"></td>';
		$html.='<td style="text-align:right;"></td>';
		$html.='</tr>';
		$table_margin-=10;
	}

	if($details["oksijen"] != 0){
		$html.='<tr class="machine_details" style="border-right:1.5px solid #000;border-left:1.5px solid #000;">';
		$html.='<td style="text-align:right;border-right:1.5px solid #000;"></td>';
		$html.='<td colspan="4" style="border-right:1.5px solid #000;text-align:center">'.$oksijen.'</td>';
		$html.='<td style="border-right:1.5px solid #000;text-align:center"></td>';
		$html.='<td style="border-right:1.5px solid #000;text-align:center"></td>';
		$html.='<td style="border-right:1.5px solid #000;text-align:right"></td>';
		$html.='<td style="text-align:right;"></td>';
		$html.='</tr>';
		$table_margin-=10;
	}

	if($details["ups_guc_kaynagi"] != 0){
		$html.='<tr class="machine_details" style="border-right:1.5px solid #000;border-left:1.5px solid #000;">';
		$html.='<td style="text-align:right;border-right:1.5px solid #000;"></td>';
		$html.='<td colspan="4" style="border-right:1.5px solid #000;text-align:center">'.$ups_guc_kaynagi.'</td>';
		$html.='<td style="border-right:1.5px solid #000;text-align:center">'.$details["ups_adet"].'</td>';
		$html.='<td style="border-right:1.5px solid #000;text-align:center">'.$details["ups_adet_yazi"].'</td>';
		$html.='<td style="border-right:1.5px solid #000;text-align:right"><b>'.$ups_fiyati.' '.$para_sembol.'</b></td>';
		$html.='<td style="text-align:right"><b>'.$ups_toplam_fiyati.' '.$para_sembol.'</b></td>';
		$html.='</tr>';
		$table_margin-=10;
	}

	if($details["fan"] != 0){
		$html.='<tr class="machine_details" style="border-right:1.5px solid #000;border-left:1.5px solid #000;">';
		$html.='<td style="text-align:right;border-right:1.5px solid #000;"></td>';
		$html.='<td colspan="4" style="border-right:1.5px solid #000;text-align:center">'.$fan.'</td>';
		$html.='<td style="border-right:1.5px solid #000;text-align:center">'.$details["fan_adet"].'</td>';
		$html.='<td style="border-right:1.5px solid #000;text-align:center">'.$details["fan_adet_yazi"].'</td>';
		$html.='<td style="border-right:1.5px solid #000;text-align:right"><b>'.$fan_fiyati.' '.$para_sembol.'</b></td>';
		$html.='<td style="text-align:right"><b>'.$fan_toplam_fiyati.' '.$para_sembol.'</b></td>';
		$html.='</tr>';
		$table_margin-=10;
	}

	if($details["kompresor"] != 0){
		$html.='<tr class="machine_details" style="border-right:1.5px solid #000;border-left:1.5px solid #000;">';
		$html.='<td style="text-align:right;border-right:1.5px solid #000;"></td>';
		$html.='<td colspan="4" style="border-right:1.5px solid #000;text-align:center">'.$kompresor.'</td>';
		$html.='<td style="border-right:1.5px solid #000;text-align:center">'.$details["kompresor_adet"].'</td>';
		$html.='<td style="border-right:1.5px solid #000;text-align:center">'.$details["kompresor_adet_yazi"].'</td>';
		$html.='<td style="border-right:1.5px solid #000;text-align:right"><b>'.$kompresor_fiyati.' '.$para_sembol.'</b></td>';
		$html.='<td style="text-align:right"><b>'.$kompresor_toplam_fiyati.' '.$para_sembol.'</b></td>';
		$html.='</tr>';
		$table_margin-=10;
	}

	if($details["kurutucu"] != 0){
		$html.='<tr class="machine_details" style="border-right:1.5px solid #000;border-left:1.5px solid #000;">';
		$html.='<td style="text-align:right;border-right:1.5px solid #000;"></td>';
		$html.='<td colspan="4" style="border-right:1.5px solid #000;text-align:center">'.$kurutucu.'</td>';
		$html.='<td style="border-right:1.5px solid #000;text-align:center">'.$details["kurutucu_adet"].'</td>';
		$html.='<td style="border-right:1.5px solid #000;text-align:center">'.$details["kurutucu_adet_yazi"].'</td>';
		$html.='<td style="border-right:1.5px solid #000;text-align:right"><b>'.$kurutucu_fiyati.' '.$para_sembol.'</b></td>';
		$html.='<td style="text-align:right"><b>'.$kurutucu_toplam_fiyati.' '.$para_sembol.'</b></td>';
		$html.='</tr>';
		$table_margin-=10;
	}

	if($config_proforma["proforma_yazi1_$dil"] != ""){
		$html.='<tr class="machine_details" style="border-right:1.5px solid #000;border-left:1.5px solid #000;">';
		$html.='<td style="text-align:right;border-right:1.5px solid #000;"></td>';
		$html.='<td colspan="4" style="border-right:1.5px solid #000;text-align:center">'.$config_proforma["proforma_yazi1_$dil"].'</td>';
		$html.='<td style="border-right:1.5px solid #000;text-align:center"></td>';
		$html.='<td style="border-right:1.5px solid #000;text-align:center"></td>';
		$html.='<td style="border-right:1.5px solid #000;text-align:right"></td>';
		$html.='<td style="text-align:right"></td>';
		$html.='</tr>';
		$table_margin-=10;
	}

	if($config_proforma["gtip_kodu_$dil"] != ""){
		$html.='<tr class="machine_details" style="border-right:1.5px solid #000;border-left:1.5px solid #000;">';
		$html.='<td style="text-align:right;border-right:1.5px solid #000;"></td>';
		$html.='<td colspan="4" style="border-right:1.5px solid #000;text-align:center">'.$lang["GtipKodu"].' '.$config_proforma["gtip_kodu_$dil"].'</td>';
		$html.='<td style="border-right:1.5px solid #000;text-align:center"></td>';
		$html.='<td style="border-right:1.5px solid #000;text-align:center"></td>';
		$html.='<td style="border-right:1.5px solid #000;text-align:right"></td>';
		$html.='<td style="text-align:right"></td>';
		$html.='</tr>';
		$table_margin-=10;
	}

	$html.='<tr style="border-bottom:1.5px solid #000;border-right:1.5px solid #000;border-left:1.5px solid #000;">';
	$html.='<td style="text-align:right;border-right:1.5px solid #000;"></td>';
	$html.='<td colspan="4" style="border-right:1.5px solid #000;text-align:center;padding-top:'.$table_margin.'px;"></td>';
	$html.='<td style="border-right:1.5px solid #000;text-align:center;padding-top:'.$table_margin.'px;"></td>';
	$html.='<td style="border-right:1.5px solid #000;text-align:center;padding-top:'.$table_margin.'px;"></td>';
	$html.='<td style="border-right:1.5px solid #000;text-align:right;padding-top:'.$table_margin.'px;"></td>';
	$html.='<td style="text-align:right;padding-top:'.$table_margin.'px;"></td>';
	$html.='</tr>';


	$html.='<tr>';
	$html.='<td colspan="7"></td>';
	$html.='<td style="border-left:1.5px solid #000;border-right:1.5px solid #000;border-bottom:1.5px solid #000;background-color:#e3e3e3;padding: 0 5px"><b>'.$lang["Total"].'</b></td>';
	$html.='<td style="border-left:1.5px solid #000;border-right:1.5px solid #000;border-bottom:1.5px solid #000;padding: 0 5px;text-align:right"><b>'.$genel_toplam.' '.$para_sembol.'</b></td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="7"></td>';
	$html.='<td style="border-left:1.5px solid #000;border-right:1.5px solid #000;border-bottom:1.5px solid #000;background-color:#e3e3e3;padding: 0 5px"><b>'.$lang["KDV"].' %'.$details["kdv_orani"].'</b></td>';
	$html.='<td style="border-left:1.5px solid #000;border-right:1.5px solid #000;border-bottom:1.5px solid #000;padding: 0 5px;text-align:right"><b>'.$kdv.' '.$para_sembol.'</b></td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="7"></td>';
	$html.='<td style="border-left:1.5px solid #000;border-right:1.5px solid #000;border-bottom:1.5px solid #000;background-color:#e3e3e3;padding: 0 5px"><b>'.$lang["GenelToplam"].'</b></td>';
	$html.='<td style="border-left:1.5px solid #000;border-right:1.5px solid #000;border-bottom:1.5px solid #000;padding: 0 5px;text-align:right"><b>'.$toplam_tutar.' '.$para_sembol.'</b></td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="9" style="height:20px"></td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="5"></td>';
	$html.='<td rowspan="10" colspan="4" style="text-align:center"><img style="width:250px" src="'.$cfg["SiteUrl"].'upload/company/'.$config['signature'].'"></td>';
	$html.='</tr>';

	$bankalar=getBanks();
	if (!is_null($bankalar)) {
		foreach($bankalar as $banka){
			$html.='<tr class="bank_details">';
			$html.='<td><b>'.$lang["Bank"].' :</b></td>';
			$html.='<td colspan="4">'.$banka["banka_ad"].'</td>';
			$html.='</tr>';
			$html.='<tr class="bank_details">';
			$html.='<td><b>'.$lang["Branch"].':</b></td>';
			$html.='<td colspan="4">'.$banka["banka_sube"].'</td>';
			$html.='</tr>';
			$html.='<tr class="bank_details">';
			$html.='<td><b>'.$lang["AccountNo"].':</b></td>';
			$html.='<td colspan="4">'.$banka["hesap_no"].'</td>';
			$html.='</tr>';
			$html.='<tr class="bank_details">';
			$html.='<td><b>'.$lang["IBAN"].':</b></td>';
			$html.='<td colspan="4">'.$banka["iban"].'</td>';
			$html.='</tr>';

			if ($dil != "tr") {
				$html.='<tr class="bank_details">';
				$html.='<td><b>'.$lang["SWIFT"].':</b></td>';
				$html.='<td colspan="4">'.$banka["swift"].'</td>';
				$html.='</tr>';
			}

			$html.='<tr>';
			$html.='<td colspan="9" style="height:20px"></td>';
			$html.='</tr>';

		}

	}


	$html.='<tr>';
	$html.='<td colspan="9" style="height:20px"></td>';
	$html.='</tr>';



	$html.='</table>';
	$html.='</div>';

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
if(($detailsteklif["proforma_pdf_$dil"] != "") && (file_exists('upload/'.$file))){
	$path = 'upload/pdfs/proforma/'.$detailsteklif["proforma_pdf_$dil"].'';
	$pathData = $detailsteklif["proforma_pdf_$dil"];

}else{
	$file=permayap($details["firma_ad"]).'_proforma_'.$dil."_" . rand() . '.pdf';
	$path = 'upload/pdfs/proforma/'.$file;
	$pathData = $file;
}

file_put_contents($path, $output);

$updateData=[
	"proforma_pdf_$dil" => $pathData,
];

$teklif_id=$detailsteklif["teklif_id"];
$where = [ "teklif_id"	=> $teklif_id ];
updateTableData("teklifler",$updateData,$where);

header("location:admin.php?cmd=pdf_goster&pdf=proforma&bilgi_giris_id=$bilgi_giris_id&dil=$dil&result=proforma");

}

