<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php"; 
if(canUserAccessAdminArea()) {
	$firma_id           = makeSafe($_GET["firma_id"]);
	$makina_fiyati      = priceTrim($_POST['makina_fiyati']);
	$kompresor_fiyati   = priceTrim($_POST['kompresor_fiyati']);
	$fan_fiyati      	= priceTrim($_POST['fan_fiyati']);
	$ups_fiyati      	= priceTrim($_POST['ups_fiyati']);
	$kurutucu_fiyati    = priceTrim($_POST['kurutucu_fiyati']);
	$kdv      			= priceTrim($_POST['kdv']);
	$genel_toplam       = priceTrim($_POST['genel_toplam']);
	$pesinat      		= priceTrim($_POST['pesinat']);

	$insertData  =[
		"firma_id"						=> makeSafe($_GET["firma_id"]),
		"firma_ad"						=> beautifyName($_POST['firma_ad']),
		"firma_yetkili"					=> beautifyName($_POST['firma_yetkili']),
		"firma_adres"					=> beautifyName($_POST['firma_adres']),
		"firma_vergidaire"				=> $_POST['firma_vergidaire'],
		"firma_vergino"					=> $_POST['firma_vergino'],
		"firma_telefon"					=> $_POST['firma_telefon'],
		"firma_ceptelefon"				=> $_POST['firma_ceptelefon'],
		"firma_web"						=> $_POST['firma_web'],
		"firma_email"					=> $_POST['firma_email'],
		"firma_fax"						=> $_POST['firma_fax'],
		"gonderen_id"					=> $_SESSION["user"]["user_id"],
		"gonderen"						=> $_POST['gonderen'],
		"gonderen_email"				=> $_POST['gonderen_email'],
		"teklif_no"						=> $_POST['teklif_no'],
		"satis_tipi"					=> intval($_POST['satis_tipi']),
		"sozlesme_yeri"					=> $_POST['sozlesme_yeri'],
		"satis_temsilcisi"				=> intval($_POST['satis_temsilcisi']),
		"teslim_yeri"					=> intval($_POST['teslim_yeri']),
		"teslim_gunu"					=> $_POST['teslim_gunu'],
		"teslim_gunu_gun"				=> $_POST['teslim_gunu_gun'],
		"para_birimi"				    => $_POST['para_birimi'],
		"makina_fiyati"					=> tofloat($makina_fiyati),
		"makina_adet"					=> $_POST['makina_adet'],
		"makina_adet_yazi"				=> $_POST['makina_adet_yazi'],
		"kompresor_fiyati"				=> tofloat($kompresor_fiyati),
		"kompresor_adet"				=> $_POST['kompresor_adet'],
		"kompresor_adet_yazi"			=> $_POST['kompresor_adet_yazi'],
		"fan_fiyati"					=> tofloat($fan_fiyati),
		"fan_adet"						=> $_POST['fan_adet'],
		"fan_adet_yazi"					=> $_POST['fan_adet_yazi'],
		"ups_fiyati"					=> tofloat($ups_fiyati),
		"ups_adet"						=> $_POST['ups_adet'],
		"ups_adet_yazi"					=> $_POST['ups_adet_yazi'],
		"kurutucu_fiyati"				=> tofloat($kurutucu_fiyati),
		"kurutucu_adet"					=> $_POST['kurutucu_adet'],
		"kurutucu_adet_yazi"			=> $_POST['kurutucu_adet_yazi'],
		"kdv_orani"						=> $_POST['kdv_orani'],
		"kdv"							=> tofloat($kdv),
		"genel_toplam"					=> tofloat($genel_toplam),
		"pesinat"						=> tofloat($pesinat),
		"taksit_sayisi"					=> $_POST['taksit_sayisi'],
		"vade"							=> $_POST['vade'],
		"vade_tarihi"					=> $_POST['vade_tarihi'],
		"vade_baslangic"				=> $_POST['vade_baslangic'],
		"vade_baslangic_tarihi"			=> $_POST['vade_baslangic_tarihi'],
		"vade_turu"						=> intval($_POST['vade_turu']),
		"adet"							=> $_POST['adet'],
		"makina_modeli"					=> intval($_POST['makina_modeli']),
		"plazma_kesim"					=> intval($_POST['plazma_kesim']),
		"kesim_kalinligi"				=> $_POST['kesim_kalinligi'],
		"raylar"						=> intval($_POST['raylar']),
		"kramiyer"						=> intval($_POST['kramiyer']),
		"motor_tipi"					=> intval($_POST['motor_tipi']),
		"oksijen"						=> intval($_POST['oksijen']),
		"kompresor"						=> intval($_POST['kompresor']),
		"kesim_olcusu"					=> intval($_POST['kesim_olcusu']),
		"tezgah_olcusu"					=> $_POST['tezgah_olcusu'],
		"cnc_kontrol"					=> intval($_POST['cnc_kontrol']),
		"yukseklik_kontrol"				=> intval($_POST['yukseklik_kontrol']),
		"reduktor"						=> intval($_POST['reduktor']),
		"fan"							=> intval($_POST['fan']),
		"ups_guc_kaynagi"				=> intval($_POST['ups_guc_kaynagi']),
		"kurutucu"						=> intval($_POST['kurutucu']),

	];


	$bilgi_giris_id=insertDatatoTable("bilgi_giris",$insertData);

	$teklif_tarihi=date('Y-m-d H:i:s');



	$teklifInsertData=[
		"firma_id" => $firma_id,
		"bilgi_giris_id" => $bilgi_giris_id,
		"teklif_tarihi" => $teklif_tarihi,
		"gonderen_id" => $_SESSION["user"]["user_id"],
	];



	insertDatatoTable("teklifler",$teklifInsertData);


	/*$where 		= ["firma_id"	=>	$firma_id];
	updateTableData("firma",$updateData,$where);*/
/*	header("location:admin.php?cmd=bilgi_giris&bilgi_giris_id=$bilgi_giris_id&firma_id=$firma_id&result=eklendi");
*/	header("location:admin.php?cmd=bilgi_giris_guncelle&bilgi_giris_id=$bilgi_giris_id&result=eklendi");
}
?>