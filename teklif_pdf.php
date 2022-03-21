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
$config_teklif = getConfigTeklif();

$options = new Options();
$options->set('defaultFont', 'Courier');
$options->set('isRemoteEnabled', TRUE);
$options->set('debugKeepTemp', TRUE);
$options->set('isHtml5ParserEnabled', true);
$dompdf = new Dompdf($options);


$html="";
if(!is_null($details)) {
	$firma_ad 			= $details["firma_ad"]!= "" ? $details['firma_ad'] : "-";
	$firma_adres 		= $details["firma_adres"] != "" ? $details['firma_adres'] : "-";
	$firma_telefon 		= $details["firma_telefon"] != "" ? $details['firma_telefon'] : "-";
	$firma_web 			= $details["firma_web"] != "" ? $details['firma_web'] : "-";
	$firma_yetkili  	= $details["firma_yetkili"] != "" ? $details['firma_yetkili'] : "-";
	$firma_ceptelefon	= $details["firma_ceptelefon"] != "" ? $details['firma_ceptelefon'] : "-";
	$firma_email		= $details["firma_email"] != "" ? $details['firma_email'] : "-";
	$teklif_tarihi		= $detailsteklif["teklif_tarihi"] != "" ? $detailsteklif['teklif_tarihi'] : "-";
	$makina_adet		= $details["makina_adet"] != "" ? $details['makina_adet'] : "0,00";
	$kdv 				= $details["kdv"] != "" ? number_format($details['kdv'], 2, ',', '.') : "0.00";
	$toplam_fiyat 		= $details["kdv"]+$details["makina_fiyati"] != "" ? number_format($details["kdv"]+$details["makina_fiyati"], 2, ',', '.') : "0,00";
	$gonderen 			= $details["gonderen"]!= "" ? $details['gonderen'] : "-";
	$makina_fiyati 		= number_format($details["makina_fiyati"] * ($details["makina_adet"]), 2, ',', '.');
	$kompresor_fiyati 	= number_format($details["kompresor_fiyati"] * floatval($details["kompresor_adet"]), 2, ',', '.');
	$fan_fiyati 		= number_format($details["fan_fiyati"] * floatval($details["fan_adet"]), 2, ',', '.');
	$ups_fiyati 		= number_format($details["ups_fiyati"] * floatval($details["ups_adet"]), 2, ',', '.');
	$kurutucu_fiyati 	= number_format($details["kurutucu_fiyati"] * floatval($details["kurutucu_adet"]), 2, ',', '.');
	$kalan_odeme 		= number_format($details["genel_toplam"]-$details["pesinat"], 2, ',', '.');
	$genel_toplam 		= number_format(($details["makina_fiyati"] * floatval($details["makina_adet"])+
		$details["kurutucu_fiyati"] * floatval($details["kurutucu_adet"])+
		$details["ups_fiyati"] * floatval($details["ups_adet"])+
		$details["fan_fiyati"] * floatval($details["fan_adet"])+
		$details["kompresor_fiyati"] * floatval($details["kompresor_adet"])), 2, ',', '.');



	$makina=getParameter($details["makina_modeli"]);
	$makina_modeli=str_replace("{#makina_modeli#}",$makina["parametre_deger_$dil"],$config_teklif["makina_modeli_$dil"]);


	$kesim_olcu=getParameter($details["kesim_olcusu"]);
	$kesim_olcusu=str_replace("{#kesim_alani#}",$kesim_olcu["parametre_deger_$dil"],$config_teklif["kesim_alani_$dil"]);

	$tezgah_olcusu=str_replace("{#tezgah_olculeri#}",$details["tezgah_olcusu"],$config_teklif["tezgah_olculeri_$dil"]);
	
	$plazma=getParameter($details["plazma_kesim"]);
	$plazma_kesim=str_replace("{#plazma_kesim#}",$plazma["parametre_deger_$dil"],$config_teklif["plazma_kesim_$dil"]);

	$kesim_kalinligi=str_replace("{#kesim_kalinligi#}",$details["kesim_kalinligi"],$config_teklif["kesim_kalinligi_$dil"]);
	
	$yukseklik=getParameter($details["yukseklik_kontrol"]);
	$yukseklik_kontrol=str_replace("{#yukseklik_kontrol#}",$yukseklik["parametre_deger_$dil"],$config_teklif["yukseklik_kontrol_$dil"]);

	$ray=getParameter($details["raylar"]);
	$raylar=str_replace("{#raylar#}",$ray["parametre_deger_$dil"],$config_teklif["raylar_$dil"]);

	$kramiyer_deger=getParameter($details["kramiyer"]);
	$kramiyer=str_replace("{#kramiyer#}",$kramiyer_deger["parametre_deger_$dil"],$config_teklif["kramiyer_$dil"]);

	$motor=getParameter($details["motor_tipi"]);
	$motor_tipi=str_replace("{#motor_tipi#}",$motor["parametre_deger_$dil"],$config_teklif["motor_tipi_$dil"]);

	$cnc_kontrol_deger=getParameter($details["cnc_kontrol"]);
	$cnc_kontrol=str_replace("{#cnc_kontrol#}",$cnc_kontrol_deger["parametre_deger_$dil"],$config_teklif["cnc_kontrol_$dil"]);

	$satis_tipi=getParameter($details["satis_tipi"]);
	$kdv_yazi_deger=$satis_tipi["kdv_yazi_$dil"];
	$kdv_yazi=str_replace("{#kdv_yazi#}",$kdv,$kdv_yazi_deger);

	$teslim_yeri=getParameter($details["teslim_yeri"]);
	$vade_turu=getParameter($details["vade_turu"]);

	$para_birimi=getParameter($details["para_birimi"]);
	$para_sembol=$para_birimi["para_sembol"];
	$para_birim=$para_birimi["parametre_deger_tr"];


	$html.='<table style="font-size:11px;width:100%">';
	$html.='<tr rowspan="2">';
	$html.='<td colspan="4" style="width:50%;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;"> <img style="width:165px;" src="'.$cfg["SiteUrl"].'upload/company/'.$config['logo2'].'"></td>';
	$html.='<td style="width:5%"></td>';
	$html.='<td colspan="4" style="text-align:right;font-size:25px;width:45%;font-family:arial,opensans-regular, DejaVu Sans, sans-serif;"> <b>'.$lang["Proposal"].'</b></td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="4"></td>';
	$html.='<td></td>';
	$html.='<td></td>';
	$html.='<td></td>';
	$html.='<td style="text-align:right;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$lang["No"].'</td>';
	$html.='<td style="text-align:right;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$details["teklif_no"].'</td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="4"></td>';
	$html.='<td></td>';
	$html.='<td colspan="4"><hr style="background: #000; height: 1px; margin: 5px 0; border: none;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;"></td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="4" style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$config['company_name'].'</td>';
	$html.='<td></td>';
	$html.='<td colspan="4" style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$lang["Customer"].'</td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="4" style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$config['address'].'</td>';
	$html.='<td></td>';
	$html.='<td style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$lang["CompanyName"].'</td>';
	$html.='<td colspan="3" style="text-align:left;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$firma_ad.'</td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="2" style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;padding-right:5px;">'.$lang["Tel"].' : '.$config['phone'].'</td>';
	$html.='<td colspan="2" style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$lang["Fax"].' : '.$config['fax'].'</td>';
	$html.='<td></td>';
	$html.='<td style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$lang["Address"].'</td>';
	$html.='<td colspan="3" style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$firma_adres.'</td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="4"></td>';
	$html.='<td></td>';
	$html.='<td style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$lang["Phone"].'</td>';
	$html.='<td colspan="3" style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$firma_telefon.'</td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="4"></td>';
	$html.='<td></td>';
	$html.='<td style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$lang["Web"].'</td>';
	$html.='<td colspan="3" style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$firma_web.'</td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="4"></td>';
	$html.='<td></td>';
	$html.='<td style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$lang["Authorized"].'</td>';
	$html.='<td colspan="3" style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$firma_yetkili.'</td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="4"></td>';
	$html.='<td></td>';
	$html.='<td style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$lang["Mobil"].'</td>';
	$html.='<td colspan="3" style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$firma_ceptelefon.'</td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="4"></td>';
	$html.='<td></td>';
	$html.='<td style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$lang["Email"].'</td>';
	$html.='<td colspan="3" style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$firma_email.'</td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="4"></td>';
	$html.='<td></td>';
	$html.='<td colspan="4"><hr style="background: #000; height: 1px; margin: 5px 0 ; border: none;"></td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="4"></td>';
	$html.='<td></td>';
	$html.='<td style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$lang["ProposalDate"].'</td>';
	$html.='<td colspan="3" style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.pdfTarih($today,$dil).'</td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="4"></td>';
	$html.='<td></td>';
	$html.='<td style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;width:100px">'.$lang["ValidityPeriod"].'</td>';
	$html.='<td colspan="3" style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$config_teklif["gecerlilik_suresi_$dil"].'</td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="4"></td>';
	$html.='<td></td>';
	$html.='<td colspan="4"><hr style="background: #000; height: 1px; margin: 5px 0; border: none;"></td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="4" style="padding-top:5px;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;width:60%">'.$lang["ServiceProduct"].'</td>';
	$html.='<td></td>';
	$html.='<td style="padding-top:5px;padding-right:10px;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;width:75px;text-align:center">'.$lang["Quantity"].'</td>';
	$html.='<td style="padding-top:5px;padding-right:10px;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;width:60px;text-align:center">'.$lang["UnitPrice"].'</td>';
	$html.='<td style="padding-top:5px;padding-right:10px;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;width:60px;text-align:center">'.$lang["KDV"].'<br>%'.$details["kdv_orani"].'</td>';
	$html.='<td style="padding-top:5px;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;width:75px;text-align:center">'.$lang["Total"].'</td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="9"><hr style="background: #000; height: 1px;margin: 5px 0; border: none;"></td>';
	$html.='</tr>';

	$mak_model= $details["makina_modeli"] != 0 ? $makina_modeli : "-";
	$html.='<tr>';
	$html.='<td colspan="5" style="padding-right:15px;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;width:60%">'.$mak_model.'</td>';
/*	$html.='<td></td>';*/
	$html.='<td style="padding-right:15px;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;text-align:center">'.$makina_adet.'</td>';
	$html.='<td style="padding-right:15px;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;text-align:center">'.$makina_fiyati.''.$para_sembol.'</td>';
	$html.='<td style="padding-right:15px;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;text-align:center">'.$kdv.''.$para_sembol.'</td>';
	$html.='<td style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;text-align:center">'.$toplam_fiyat.''.$para_sembol.'</td>';
	$html.='</tr>';

	$makina_margin=455;
	if($details["kesim_olcusu"] != 0){

		$html.='<tr>';
		$html.='<td colspan="9" style="padding-left:75px;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;font-size:10px">'.$kesim_olcusu.'</td>';
		$html.='</tr>';
		$makina_margin-=20;

	}

	if($details["tezgah_olcusu"] != ""){

		$html.='<tr>';
		$html.='<td colspan="9" style="padding-left:75px;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;font-size:10px">'.$tezgah_olcusu.'</td>';
		$html.='</tr>';
		$makina_margin-=20;

	}

	if($details["plazma_kesim"] != 0){

		$html.='<tr>';
		$html.='<td colspan="9" style="padding-left:75px;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;font-size:10px">'.$plazma_kesim.'</td>';
		$html.='</tr>';
		$makina_margin-=20;

	}

	if($details["kesim_kalinligi"] != ""){

		$html.='<tr>';
		$html.='<td colspan="9" style="padding-left:75px;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;font-size:10px">'.$kesim_kalinligi.'</td>';
		$html.='</tr>';
		$makina_margin-=20;

	}

	if($config_teklif["detay_yazi1_$dil"] != ""){

		$html.='<tr>';
		$html.='<td colspan="9" style="padding-left:75px;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;font-size:10px">'.$config_teklif["detay_yazi1_$dil"].'</td>';
		$html.='</tr>';
		$makina_margin-=20;

	}


	if($details["yukseklik_kontrol"] != 0){

		$html.='<tr>';
		$html.='<td colspan="9" style="padding-left:75px;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;font-size:10px">'.$yukseklik_kontrol.'</td>';
		$html.='</tr>';
		$makina_margin-=20;

	}

	if($config_teklif["detay_yazi2_$dil"] != ""){

		$html.='<tr>';
		$html.='<td colspan="9" style="padding-left:75px;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;font-size:10px">'.$config_teklif["detay_yazi2_$dil"].'</td>';
		$html.='</tr>';
		$makina_margin-=20;

	}

	if($config_teklif["detay_yazi3_$dil"] != ""){

		$html.='<tr>';
		$html.='<td colspan="9" style="padding-left:75px;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;font-size:10px">'.$config_teklif["detay_yazi3_$dil"].'</td>';
		$html.='</tr>';
		$makina_margin-=20;

	}

	if($details["raylar"] != 0){

		$html.='<tr>';
		$html.='<td colspan="9" style="padding-left:75px;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;font-size:10px">'.$raylar.'</td>';
		$html.='</tr>';
		$makina_margin-=20;

	}

	if($details["kramiyer"] != 0){

		$html.='<tr>';
		$html.='<td colspan="9" style="padding-left:75px;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;font-size:10px">'.$kramiyer.'</td>';
		$html.='</tr>';
		$makina_margin-=20;

	}

	if($details["motor_tipi"] != 0){

		$html.='<tr>';
		$html.='<td colspan="9" style="padding-left:75px;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;font-size:10px">'.$motor_tipi.'</td>';
		$html.='</tr>';
		$makina_margin-=20;

	}

	if($details["cnc_kontrol"] != 0){

		$html.='<tr>';
		$html.='<td colspan="9" style="padding-left:75px;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;font-size:10px">'.$cnc_kontrol.'</td>';
		$html.='</tr>';
		$makina_margin-=20;

	}

	if($config_teklif["detay_yazi4_$dil"] != ""){

		$html.='<tr>';
		$html.='<td colspan="9" style="padding-left:75px;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;font-size:10px">'.$config_teklif["detay_yazi4_$dil"].'</td>';
		$html.='</tr>';
		$makina_margin-=20;

	}
	if($config_teklif["detay_yazi5_$dil"] != ""){

		$html.='<tr>';
		$html.='<td colspan="9" style="padding-left:75px;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;font-size:10px">'.$config_teklif["detay_yazi5_$dil"].'</td>';
		$html.='</tr>';
		$makina_margin-=20;

	}
	if($config_teklif["detay_yazi6_$dil"] != ""){

		$html.='<tr>';
		$html.='<td colspan="9" style="padding-left:75px;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;font-size:10px">'.$config_teklif["detay_yazi6_$dil"].'</td>';
		$html.='</tr>';
		$makina_margin-=20;

	}
	if($config_teklif["detay_yazi7_$dil"] != ""){

		$html.='<tr>';
		$html.='<td colspan="9" style="padding-left:75px;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;font-size:10px">'.$config_teklif["detay_yazi7_$dil"].'</td>';
		$html.='</tr>';
		$makina_margin-=20;

	}
	if($config_teklif["detay_yazi8_$dil"] != ""){

		$html.='<tr>';
		$html.='<td colspan="9" style="padding-left:75px;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;font-size:10px">'.$config_teklif["detay_yazi8_$dil"].'</td>';
		$html.='</tr>';
		$makina_margin-=20;

	}
	if($config_teklif["detay_yazi9_$dil"] != ""){

		$html.='<tr>';
		$html.='<td colspan="9" style="padding-left:75px;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;font-size:10px">'.$config_teklif["detay_yazi9_$dil"].'</td>';
		$html.='</tr>';
		$makina_margin-=20;

	}
	if($config_teklif["detay_yazi10_$dil"] != ""){

		$html.='<tr>';
		$html.='<td colspan="9" style="padding-left:75px;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;font-size:10px">'.$config_teklif["detay_yazi10_$dil"].'</td>';
		$html.='</tr>';
		$makina_margin-=20;

	}
	if($config_teklif["detay_yazi11_$dil"] != ""){

		$html.='<tr>';
		$html.='<td colspan="9" style="padding-left:75px;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;font-size:10px">'.$config_teklif["detay_yazi11_$dil"].'</td>';
		$html.='</tr>';
		$makina_margin-=20;

	}
	if($config_teklif["detay_yazi12_$dil"] != ""){

		$html.='<tr>';
		$html.='<td colspan="9" style="padding-left:75px;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;font-size:10px">'.$config_teklif["detay_yazi12_$dil"].'</td>';
		$html.='</tr>';
		$makina_margin-=20;

	}
	if($config_teklif["detay_yazi13_$dil"] != ""){

		$html.='<tr>';
		$html.='<td colspan="9" style="padding-left:75px;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;font-size:10px">'.$config_teklif["detay_yazi13_$dil"].'</td>';
		$html.='</tr>';
		$makina_margin-=20;

	}

	$html.='<tr>';
	$html.='<td colspan="9" style="font-size:9px;padding-top:'.$makina_margin.'px;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$config_teklif["teklif_fan_yazi_$dil"].'</td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="9"><hr style="background: #000; height: 1px; margin: 0 0 5px 0; border: none;"></td>';		
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="4"></td>';
	$html.='<td></td>';
	$html.='<td style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$lang["SubTotal"].'</td>';
	$html.='<td colspan="3" style="text-align:right;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$makina_fiyati.' '.$para_birim.'</td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="4"></td>';
	$html.='<td></td>';
	$html.='<td colspan="4"><hr style="background: #000; height: 1px;border: none;margin: 0"></td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="4"></td>';
	$html.='<td></td>';
	$html.='<td style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$lang["KDV"].'</td>';
	$html.='<td colspan="3" style="text-align:right;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$kdv.' '.$para_birim.'</td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="4"></td>';
	$html.='<td></td>';
	$html.='<td colspan="4"><hr style="background: #000; height: 1px;border: none;margin: 0"></td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="4"></td>';
	$html.='<td></td>';
	$html.='<td style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$lang["GeneralTotal"].'</td>';
	$html.='<td colspan="3" style="text-align:right;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$toplam_fiyat.' '.$para_birim.'</td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="4"></td>';
	$html.='<td></td>';
	$html.='<td colspan="4"><hr style="background: #000; height: 1px;border: none;margin: 0"></td>';
	$html.='</tr>';

	$html.='<tr style="">';
	$html.='<td colspan="9" style="font-size:9px;text-align:right;bottom:0;padding:10px 0;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$lang["SubText"].'</td>';		
	$html.='</tr>';




		//ikinci sayfa




	$html.='<tr rowspan="2" style="page-break-before: always;">';
	$html.='<td colspan="4" style="width:50%;"> <img style="width:165px;" src="'.$cfg["SiteUrl"].'upload/company/'.$config['logo2'].'"></td>';
	$html.='<td style="width:5%"></td>';
	$html.='<td colspan="4" style="text-align: right;font-size:25px;width:45%;;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;"><b>'.$lang["CostDelivery"].'</b></td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="4"></td>';
	$html.='<td></td>';
	$html.='<td></td>';
	$html.='<td></td>';
	$html.='<td style="text-align: right;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$lang["No"].'</td>';
	$html.='<td style="text-align: right;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$details["teklif_no"].'</td>';	
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="4" style="padding-bottom:20px"></td>';
	$html.='<td></td>';
	$html.='<td colspan="4"><hr style="background: #000; height: 1px; margin-bottom: 10px; border: none;"></td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="4" style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$config['company_name'].'</td>';
	$html.='<td></td>';
	$html.='<td colspan="4" style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$lang["Bidder"].'</td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="4" style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$config['address'].'</td>';
	$html.='<td></td>';
	$html.='<td style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$lang["CompanyName"].'</td>';
	$html.='<td colspan="3" style="text-align: left;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$gonderen.'</td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="2" style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$lang["Tel"].' : '.$config['phone'].'</td>';
	$html.='<td colspan="2" style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$lang["Fax"].' : '.$config['fax'].'</td>';
	$html.='<td></td>';
	$html.='<td style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$lang["DeliveryDate"].'</td>';
	$html.='<td colspan="3" style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.teslimTarih($today,$details["teslim_gunu"],$dil).'</td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="4"></td>';
	$html.='<td></td>';
	$html.='<td style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$lang["PlaceOfDelivery"].'</td>';
	$html.='<td colspan="3" style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$teslim_yeri["parametre_deger_$dil"].'</td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="4"></td>';
	$html.='<td></td>';
	$html.='<td colspan="4"><hr style="background: #000; height: 1px; margin: 5px 0; border: none;"></td>';
	$html.='</tr>';

	$html.='<tr style="line-height:25px;">';
	$html.='<td colspan="4" style="padding-top:20px; text-align:center;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$lang["OtherEquipment"].'</td>';
	$html.='<td></td>';
	$html.='<td colspan="4" style="padding-top:20px; text-align:center;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$lang["Payments"].'</td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="4"><hr style="background: #000; height: 1px; margin: 5px 0; border: none;"></td>';
	$html.='<td></td>';
	$html.='<td colspan="4"><hr style="background: #000; height: 1px; margin: 5px 0; border: none;"></td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="2" style="padding-top:5px;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$lang["Machine"].'</td>';
	$html.='<td colspan="2" style="text-align:right;padding-top:5px;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$makina_fiyati.' '.$para_birim.'</td>';
	$html.='<td></td>';
	$html.='<td colspan="2" style="padding-top:5px;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$lang["InstallmentCount"].'</td>';
	$html.='<td colspan="2"  style="text-align:right;padding-top:5px;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$details["taksit_sayisi"].'</td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="2" style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$lang["Compressor"].'</td>';
	$html.='<td colspan="2" style="text-align:right;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$kompresor_fiyati.' '.$para_birim.'</td>';
	$html.='<td></td>';
	$html.='<td colspan="2" style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$lang["TotalPayment"].'</td>';
	$html.='<td colspan="2" style="text-align:right;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.number_format($details["genel_toplam"], 2, ',', '.').' '.$para_birim.'</td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="2" style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$lang["Fan"].'</td>';
	$html.='<td colspan="2" style="text-align:right;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$fan_fiyati.' '.$para_birim.'</td>';
	$html.='<td></td>';
	$html.='<td colspan="2" style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$lang["DownPayment"].'</td>';
	$html.='<td colspan="2"  style="text-align:right;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.number_format($details["pesinat"], 2, ',', '.').' '.$para_birim.'</td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="2" style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$lang["Ups"].'</td>';
	$html.='<td colspan="2" style="text-align:right;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$ups_fiyati.' '.$para_birim.'</td>';
	$html.='<td></td>';
	$html.='<td colspan="2" style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$lang["MaturityPeriod"].'</td>';
	$html.='<td colspan="2"  style="text-align:right;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$vade_turu["parametre_deger_$dil"].'</td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="2" style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$lang["Dryer"].'</td>';
	$html.='<td colspan="2" style="text-align:right;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$kurutucu_fiyati.' '.$para_birim.'</td>';
	$html.='<td></td>';
	$html.='<td colspan="2" style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$lang["MaturityStart"].'</td>';
	$html.='<td colspan="2"  style="text-align:right;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.pdfTarih($details["vade_baslangic_tarihi"],$dil).'</td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="2" style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$lang["Other"].'</td>';
	$html.='<td colspan="2" style="text-align:right;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">0,00 '.$para_birim.'</td>';
	$html.='<td></td>';
	$html.='<td colspan="2" style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;"><b>'.$lang["TheBalance"].'</b></td>';
	$html.='<td colspan="2" style="text-align:right;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;"><b>'.$kalan_odeme.' '.$para_birim.'</b></td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="2" style="padding-bottom:5px;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;"><b>'.ucwords($lang["Total"]).'</b></td>';
	$html.='<td colspan="2" style="text-align:right;padding-bottom:5px;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;"><b>'.$genel_toplam.' '.$para_birim.'</b></td>';
	$html.='<td style="padding-bottom:5px"></td>';
	$html.='<td colspan="2" style="padding-bottom:5px;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;"></td>';
	$html.='<td colspan="2" style="text-align:right;padding-bottom:5px;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;"></td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="4"><hr style="background: #000; height: 1px; margin: 5px 0; border: none;"></td>';
	$html.='<td></td>';
	$html.='<td colspan="4"><hr style="background: #000; height: 1px; margin: 5px 0; border: none;"></td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="9" style="text-align:center;padding-top:30px;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$lang["PaymentPlan"].'</td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="9"><hr style="background: #000; height: 1px; margin: 5px 0; border: none;"></td>';
	$html.='</tr>';


	$taksit=$details["taksit_sayisi"];
	$t=explode("-",$details["vade_baslangic_tarihi"]);
	$month=$t[1];
	$taksitOdeme=($details["genel_toplam"]-$details["pesinat"])/ $taksit;
	$odeme=number_format($taksitOdeme, 2, ',', '.');

	$taksit_tarih=[];
	for($i=1;$i<=$taksit;$i++){

		$month=$month+1;

		if($month>12){
			$month=1;
			$t[0]+=1;
		}
		$taksit_tarih[$i]=$t[0]."-".$month."-".$t[2];

	}
	
	if($taksit%2==0){
		$tekmi=false;
		$last=$taksit/2+1;
	}else{
		$tekmi=true;
		$last=ceil($taksit/2)+1;
	}
	$end=$last;


	for($i=1;$i<=ceil($taksit/2);$i++){
		

		$html.='<tr>';

		$html.='<td style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$i.'. '.$lang["Installment"].'</td>';
		$html.='<td colspan="2"style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.pdfTarih($taksit_tarih[$i],$dil).'</td>';
		$html.='<td style="text-align:center;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$odeme.' '.$para_birim.'</td>';
		$html.='<td></td>';

		if($tekmi && ($i == ceil($taksit/2))){
			$html.='<td style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;"></td>';
			$html.='<td colspan="2"style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;"></td>';
			$html.='<td style="text-align:center;font-family: arial, opensans-regular, DejaVu Sans, sans-serif"></td>';
		}else{
			$html.='<td style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$last.'. '.$lang["Installment"].'</td>';
			$html.='<td colspan="2" style="font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.pdfTarih($taksit_tarih[$last],$dil).'</td>';
			$html.='<td style="width:100px;text-align:left;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$odeme.' '.$para_birim.'</td>';

		}
		$last++;

		$html.='</tr>';
	}


	$taksit_padding=120;
	for($i=$end;$i>1;$i--){
		if($taksit>2){
			$taksit_padding-=15;
		}
	}

	$html.='<tr>';
	$html.='<td colspan="9" style="text-align:center;padding-top:'.$taksit_padding.'px;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$config_teklif["teklif_yazi1_$dil"].'</td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="9" style="text-align:center;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$kdv_yazi.'</td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="9" style="text-align:center;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$config_teklif["teklif_yazi2_$dil"].'</td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="4" style="padding:33px 0 10px;"><hr style="background: #000; height: 1px; border: none;"></td>';
	$html.='<td></td>';
	$html.='<td colspan="4" style="padding:33px 0 10px;"><hr style="background: #000; height: 1px; border: none;"></td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="4" style="padding:33px 0 10px;"><hr style="background: #000; height: 1px;border: none;"></td>';
	$html.='<td></td>';
	$html.='<td colspan="4" style="padding:33px 0 10px;"><hr style="background: #000; height: 1px; border: none;"></td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="4" style="text-align:center;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$lang["CustomerAcknowledgment"].'</td>';
	$html.='<td></td>';
	$html.='<td colspan="4" style="text-align:center;font-family: arial, opensans-regular, DejaVu Sans, sans-serif;">'.$lang["CompanyAcknowledgment"].'</td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="4" style="text-align:center;padding-bottom:10px"></td>';
	$html.='<td></td>';
	$html.='<td colspan="4" style="text-align:center;padding-bottom:10px"><img style="width:205px" src="'.$cfg["SiteUrl"].'upload/company/'.$config['signature'].'"></td>';
	$html.='</tr>';

	$html.='<tr>';
	$html.='<td colspan="4"><hr style="background: #000; height: 1px;border: none;"></td>';
	$html.='<td></td>';
	$html.='<td colspan="4"><hr style="background: #000; height: 1px; border: none;"></td>';
	$html.='</tr>';

	$html.='</table>';



	//önizleme için
	$dompdf->set_option('isRemoteEnabled', TRUE);
	$dompdf->loadHtml($html);

	$dompdf->setPaper('A4');
	$dompdf->render();
    //$dompdf->stream("", array("Attachment" => false)); //önizleme için



    //kaydetme işlemi yapıyor
    $output = $dompdf->output();
    if(!is_null($detailsteklif["teklif_pdf_$dil"]) && $detailsteklif["teklif_pdf_$dil"] !=""){
    	if(file_exists('upload/pdfs/proposals/'.$detailsteklif["teklif_pdf_$dil"])){
    		$path = 'upload/pdfs/proposals/'.$detailsteklif["teklif_pdf_$dil"].'';
    		$pathData = $detailsteklif["teklif_pdf_$dil"];
    	}
    }else{
    	$file=permayap($details["firma_ad"]).'_teklif_'.$dil."_" . rand() . '.pdf';
    	$path = 'upload/pdfs/proposals/'.$file;
    	$pathData = $file;
    }
    file_put_contents($path, $output);

  $updateData=[
  	"teklif_pdf_$dil" => $pathData,
  ];

  $teklif_id=$detailsteklif["teklif_id"];
  $where = [ "teklif_id"	=> $teklif_id ];
  updateTableData("teklifler",$updateData,$where);

header("location:admin.php?cmd=pdf_goster&pdf=teklif&bilgi_giris_id=$bilgi_giris_id&dil=$dil&result=teklif");


}

