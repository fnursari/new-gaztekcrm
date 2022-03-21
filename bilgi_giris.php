<?php
defined('_ADMIN_GIRDI') or die('Erişim engellendi.');
if(canUserAccessAdminArea()) {
	$kullanici_id=$_SESSION["user"]["user_id"];
	$kullanici_ad=$_SESSION["user"]["name"];
	$kullanici_email=$_SESSION["user"]["user_email"];

	$firma_id=makeSafe($_GET['firma_id']);
	$sql="select * from firma where firma_id='$firma_id' and firma_silindi='0'";
	$details = $db->get_row($sql,ARRAY_A);
	if(!is_null($details)) {
		?>
		<h1 class="page-title"></h1>
		<div class="row">
			<div class="col-md-12 ">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-plus font-dark"></i>
							<span class="caption-subject font-dark sbold uppercase">Bilgi Girişi - <?=$details["firma_ad"];?></span>
						</div>
					</div>
					<div class="portlet-body form">
						<? require("islemsonucu.php"); ?>
						<form action="bilgi_giris_islem.php?firma_id=<?=$firma_id?>" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
							<div class="tabbable-custom ">
								<ul class="nav nav-tabs ">
									<li class="active">
										<a href="#tab_genel" data-toggle="tab"> Müşteri ve Ödeme Bilgileri </a>
									</li>
									<li>
										<a href="#tab_makina" data-toggle="tab"> Makina Özellikleri </a>
									</li>
									
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="tab_genel">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-3 control-label">Firma Ünvanı</label>
													<div class="col-md-9">
														<input type="text" name="firma_ad" value="<?php echo $details["firma_ad"]?>" id="firma_ad" class="form-control">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Yetkili</label>
													<div class="col-md-9">
														<input type="text" name="firma_yetkili" value="<?php echo $details["firma_yetkili"]?>" id="firma_yetkili" class="form-control" >
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Adres</label>
													<div class="col-md-9">
														<textarea name="firma_adres" id="firma_adres" class="form-control" rows="3"><?php echo $details["firma_adres"]?></textarea>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Firma Vergi Daire</label>
													<div class="col-md-9">
														<input type="text" name="firma_vergidaire" value="<?php echo $details["firma_vergidaire"]?>" id="firma_vergidaire" class="form-control"  >
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Firma Vergi No</label>
													<div class="col-md-9">
														<input type="number" name="firma_vergino" value="<?php echo $details["firma_vergino"]?>" id="firma_vergino" class="form-control"  max="99999999999">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label"> Telefon</label>
													<div class="col-md-9">
														<input type="tel" name="firma_telefon" value="<?php echo $details["firma_telefon"]?>" id="firma_telefon" class="form-control phone-number" >
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Mobil</label>
													<div class="col-md-9">
														<input type="tel" name="firma_ceptelefon" value="<?php echo $details["firma_ceptelefon"]?>" id="firma_ceptelefon" class="form-control phone-number" >
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Fax</label>
													<div class="col-md-9">
														<input type="tel" name="firma_fax" value="<?php echo $details["firma_fax"]?>" id="firma_fax" class="form-control phone-number" >
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label"> Web</label>
													<div class="col-md-9">
														<input type="text" name="firma_web" value="<?php echo $details["firma_web"]?>" id="firma_web" class="form-control" >
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Email</label>
													<div class="col-md-9">
														<input type="email" name="firma_email" value="<?php echo $details["firma_email"]?>" id="firma_email" class="form-control" >
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Gönderen</label>
													<div class="col-md-9">
														<input type="text" name="gonderen" value="<?php echo $kullanici_ad?>" id="gonderen" class="form-control" readonly="" >
														
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Gönderen Email</label>
													<div class="col-md-9">
														<input type="email" name="gonderen_email" value="<?php echo $kullanici_email ?>" id="gonderen_email" class="form-control" readonly="" >
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Teklif No</label>
													<div class="col-md-9">
														<input type="text" name="teklif_no" value="<?php echo (getMaxTeklifNo()+1)?>" id="teklif_no" class="form-control" >
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Satış Tipi</label>
													<div class="col-md-9">
														<select class="form-control" name="satis_tipi" id="satis_tipi" required>
															<option value="">Seçiniz</option>
															<?
															$parameters = getParameters(22,true);
															if(!is_null($parameters)) {
																foreach ($parameters as $parameter) {
																	?>
																	<option data-kdv="<?php echo $parameter["kdv_orani"]?>" value="<?php echo $parameter["parametre_id"]?>"><?php echo $parameter["parametre_deger_tr"]?></option>
																	<?php
																}
															}
															?>
														</select>
													</div>
												</div>

												<div class="form-group">
													<label class="col-md-3 control-label">Sözleşme Yeri</label>
													<div class="col-md-9">
														<input type="text" name="sozlesme_yeri" value="Konya" id="sozlesme_yeri" class="form-control" >
													</div>
												</div>

												<div class="form-group">
													<label class="col-md-3 control-label">Satış Temsilcisi</label>
													<div class="col-md-9">
														<select class="form-control" name="satis_temsilcisi">
															<option value="">Seçiniz</option>
															<?
															$parameters = getParameters(17,true);
															if(!is_null($parameters)) {
																foreach ($parameters as $parameter) {
																	?>
																	<option value="<?php echo $parameter["parametre_id"]?>"><?php echo $parameter["parametre_deger_tr"]?></option>
																	<?php
																}
															}
															?>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Teslim Yeri</label>
													<div class="col-md-9">
														<select class="form-control" name="teslim_yeri">
															<option value="">Seçiniz</option>
															<?
															$parameters = getParameters(18,true);
															if(!is_null($parameters)) {
																foreach ($parameters as $parameter) {
																	?>
																	<option value="<?php echo $parameter["parametre_id"]?>"><?php echo $parameter["parametre_deger_tr"]?></option>
																	<?php
																}
															}
															?>
														</select>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-3 control-label">Teslim Günü</label>
													<div class="col-md-4">
														<input type="number" name="teslim_gunu" value="3" min="1" id="teslim_gunu" class="form-control">
													</div>
													<div class="col-md-5">
														<input type="text" name="teslim_gunu_gun" readonly="" value="GÜN" id="teslim_gunu_gun" class="form-control">
													</div>
													
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Para Birimi</label>
													<div class="col-md-9">
														<select class="form-control" name="para_birimi" id="para_birimi">
															<option value="">Seçiniz</option>
															<?
															$parameters = getParameters(23,true);
															if(!is_null($parameters)) {
																foreach ($parameters as $parameter) {
																	?>
																	<option data-para-birimi="<?php echo $parameter["para_sembol"] ?>" value="<?php echo $parameter["parametre_id"]?>"><?php echo $parameter["parametre_deger_tr"] ." - ".$parameter["para_sembol"]?></option>
																	<?php
																}
															}
															?>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Makina Fiyatı</label>
													<div class="col-md-4">
														<input type="text" name="makina_fiyati" value="0" id="makina_fiyati" class="form-control price">
													</div>
													<div class="col-md-2">
														<input type="number" name="makina_adet" value="1" min="1" id="makina_adet" class="form-control">
													</div>
													<div class="col-md-3">
														<input type="text" name="makina_adet_yazi" readonly="" value="ADET" id="makina_adet_yazi" class="form-control">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Kompresör Fiyatı</label>
													<div class="col-md-4">
														<input type="text" name="kompresor_fiyati" value="0" id="kompresor_fiyati" class="form-control price">
													</div>
													<div class="col-md-2">
														<input type="number" name="kompresor_adet" value="1" min="1" id="kompresor_adet" class="form-control">
													</div>
													<div class="col-md-3">
														<input type="text" name="kompresor_adet_yazi" readonly="" value="ADET" id="kompresor_adet_yazi" class="form-control">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Fan Fiyatı</label>
													<div class="col-md-4">
														<input type="text" name="fan_fiyati" value="0" id="fan_fiyati" class="form-control price">
													</div>
													<div class="col-md-2">
														<input type="number" name="fan_adet" value="1" min="1" id="fan_adet" class="form-control">
													</div>
													<div class="col-md-3">
														<input type="text" name="fan_adet_yazi" readonly="" value="ADET" id="fan_adet_yazi" class="form-control">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">UPS Güç Kaynağı Fiyatı</label>
													<div class="col-md-4">
														<input type="text" name="ups_fiyati" value="0" id="ups_fiyati" class="form-control price">
													</div>
													<div class="col-md-2">
														<input type="number" name="ups_adet" value="1" min="1" id="ups_adet" class="form-control">
													</div>
													<div class="col-md-3">
														<input type="text" name="ups_adet_yazi" readonly="" value="ADET" id="ups_adet_yazi" class="form-control">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Kurutucu Fiyatı</label>
													<div class="col-md-4">
														<input type="text" name="kurutucu_fiyati" value="0" id="kurutucu_fiyati" class="form-control price">
													</div>
													<div class="col-md-2">
														<input type="number" name="kurutucu_adet" value="1" min="1" id="kurutucu_adet" class="form-control">
													</div>
													<div class="col-md-3">
														<input type="text" name="kurutucu_adet_yazi" readonly="" value="ADET" id="kurutucu_adet_yazi" class="form-control">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">KDV Oranı</label>
													<div class="col-md-9">
														<input type="text" readonly="" name="kdv_orani" value="" id="kdv_orani" class="form-control"  >
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">KDV</label>
													<div class="col-md-9">
														<input type="text" readonly="" name="kdv" value="" id="kdv" class="form-control price"  >
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Genel Toplam</label>
													<div class="col-md-9">
														<input type="text" readonly="" name="genel_toplam" value="" id="genel_toplam" class="form-control price"  >
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Peşinat</label>
													<div class="col-md-9">
														<input type="text" readonly="" name="pesinat" value="" id="pesinat" class="form-control price"  >
													</div>
												</div>
												
												<div class="form-group">
													<label class="col-md-3 control-label">Taksit Sayısı</label>
													<div class="col-md-9">
														<select class="form-control" name="taksit_sayisi" required>
															<option value="">Seçiniz</option>
															<?
															$parameters = getParameters(20,true);
															if(!is_null($parameters)) {
																foreach ($parameters as $parameter) {
																	?>
																	<option value="<?php echo $parameter["parametre_deger_tr"]?>"><?php echo $parameter["parametre_deger_tr"]?></option>
																	<?php
																}
															}
															?>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Vade</label>
													<div class="col-md-5">
														<input type="number" name="vade" value="" id="vade" class="form-control" required>
													</div>
													<div class="col-md-4">
														<input type="text" name="vade_tarihi" value="" id="vade_tarihi" class="form-control" >
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Vade Başlangıç</label>
													<div class="col-md-5">
														<input type="number" name="vade_baslangic" value="" id="vade_baslangic" class="form-control" required>
													</div>
													<div class="col-md-4">
														<input type="text" name="vade_baslangic_tarihi" value="" id="vade_baslangic_tarihi" class="form-control" >
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Vade Türü</label>
													<div class="col-md-9">
														<select class="form-control" name="vade_turu" required>
															<option value="">Seçiniz</option>
															<?
															$parameters = getParameters(19,true);
															if(!is_null($parameters)) {
																foreach ($parameters as $parameter) {
																	?>
																	<option value="<?php echo $parameter["parametre_id"]?>"><?php echo $parameter["parametre_deger_tr"]?></option>
																	<?php
																}
															}
															?>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Adet</label>
													<div class="col-md-9">
														<input type="number" name="adet" id="adet" value="1" id="adet" class="form-control" >
													</div>
												</div>
												
											</div>
										</div>
									</div>
									<div class="tab-pane" id="tab_makina">
										<div class="row">
											<div class="col-md-6">
												
												<div class="form-group">
													<label class="col-md-3 control-label">Makina Modeli</label>
													<div class="col-md-9">
														<select class="form-control" name="makina_modeli">
															<option value="">Seçiniz</option>
															<?
															$parameters = getParameters(1,true);
															if(!is_null($parameters)) {
																foreach ($parameters as $parameter) {
																	?>
																	<option value="<?php echo $parameter["parametre_id"]?>"><?php echo $parameter["parametre_deger_tr"]?></option>
																	<?php
																}
															}
															?>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Plazma Kesim</label>
													<div class="col-md-9">
														<select class="form-control" name="plazma_kesim"  id="plazma_kesim">
															<option value="">Seçiniz</option>
															<?
															$parameters = getParameters(2,true);
															if(!is_null($parameters)) {
																foreach ($parameters as $parameter) {
																	?>
																	<option data-kesim-kalinligi="<?php echo $parameter["kesim_kalinligi_tr"]?>" value="<?php echo $parameter["parametre_id"]?>"><?php echo $parameter["parametre_deger_tr"]?></option>
																	<?php
																}
															}
															?>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Kesim Kalınlığı</label>
													<div class="col-md-9">
														<input type="text" name="kesim_kalinligi" value="" readonly=""  id="kesim_kalinligi" class="form-control" >
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Raylar</label>
													<div class="col-md-9">
														<select class="form-control" name="raylar">
															<option value="">Seçiniz</option>
															<?
															$parameters = getParameters(11,true);
															if(!is_null($parameters)) {
																foreach ($parameters as $parameter) {
																	?>
																	<option value="<?php echo $parameter["parametre_id"]?>"><?php echo $parameter["parametre_deger_tr"]?></option>
																	<?php
																}
															}
															?>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Kramiyer</label>
													<div class="col-md-9">
														<select class="form-control" name="kramiyer">
															<option value="">Seçiniz</option>
															<?
															$parameters = getParameters(10,true);
															if(!is_null($parameters)) {
																foreach ($parameters as $parameter) {
																	?>
																	<option value="<?php echo $parameter["parametre_id"]?>"><?php echo $parameter["parametre_deger_tr"]?></option>
																	<?php
																}
															}
															?>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Motor Tipi</label>
													<div class="col-md-9">
														<select class="form-control" name="motor_tipi">
															<option value="">Seçiniz</option>
															<?
															$parameters = getParameters(8,true);
															if(!is_null($parameters)) {
																foreach ($parameters as $parameter) {
																	?>
																	<option value="<?php echo $parameter["parametre_id"]?>"><?php echo $parameter["parametre_deger_tr"]?></option>
																	<?php
																}
															}
															?>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Oksijen</label>
													<div class="col-md-9">
														<select class="form-control" name="oksijen">
															<option value="">Seçiniz</option>
															<?
															$parameters = getParameters(13,true);
															if(!is_null($parameters)) {
																foreach ($parameters as $parameter) {
																	?>
																	<option value="<?php echo $parameter["parametre_id"]?>"><?php echo $parameter["parametre_deger_tr"]?></option>
																	<?php
																}
															}
															?>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Kompresör</label>
													<div class="col-md-9">
														<select class="form-control" name="kompresor">
															<option value="">Seçiniz</option>
															<?
															$parameters = getParameters(15,true);
															if(!is_null($parameters)) {
																foreach ($parameters as $parameter) {
																	?>
																	<option value="<?php echo $parameter["parametre_id"]?>"><?php echo $parameter["parametre_deger_tr"]?></option>
																	<?php
																}
															}
															?>
														</select>
													</div>
												</div>
												
											</div>
											<div class="col-md-6">
												
												<div class="form-group">
													<label class="col-md-3 control-label">Kesim Ölçüsü</label>
													<div class="col-md-9">
														<select class="form-control" name="kesim_olcusu" id="kesim_olcusu">
															<option value="">Seçiniz</option>
															<?
															$parameters = getParameters(4,true);
															if(!is_null($parameters)) {
																foreach ($parameters as $parameter) {
																	?>
																	<option data-tezgah-olcusu="<?php echo $parameter["tezgah_olcusu_tr"]?>" value="<?php echo $parameter["parametre_id"]?>"><?php echo $parameter["parametre_deger_tr"]?></option>
																	<?php
																}
															}
															?>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Tezgah Ölçüsü</label>
													<div class="col-md-9">
														<input type="text" name="tezgah_olcusu" value="" readonly=""  id="tezgah_olcusu" class="form-control" >
													</div>
												</div>

												<div class="form-group">
													<label class="col-md-3 control-label">Cnc Kontrol</label>
													<div class="col-md-9">
														<select class="form-control" name="cnc_kontrol">
															<option value="">Seçiniz</option>
															<?
															$parameters = getParameters(6,true);
															if(!is_null($parameters)) {
																foreach ($parameters as $parameter) {
																	?>
																	<option value="<?php echo $parameter["parametre_id"]?>"><?php echo $parameter["parametre_deger_tr"]?></option>
																	<?php
																}
															}
															?>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Yükseklik Kontrol</label>
													<div class="col-md-9">
														<select class="form-control" name="yukseklik_kontrol">
															<option value="">Seçiniz</option>
															<?
															$parameters = getParameters(7,true);
															if(!is_null($parameters)) {
																foreach ($parameters as $parameter) {
																	?>
																	<option value="<?php echo $parameter["parametre_id"]?>"><?php echo $parameter["parametre_deger_tr"]?></option>
																	<?php
																}
															}
															?>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Redüktör</label>
													<div class="col-md-9">
														<select class="form-control" name="reduktor">
															<option value="">Seçiniz</option>
															<?
															$parameters = getParameters(9,true);
															if(!is_null($parameters)) {
																foreach ($parameters as $parameter) {
																	?>
																	<option value="<?php echo $parameter["parametre_id"]?>"><?php echo $parameter["parametre_deger_tr"]?></option>
																	<?php
																}
															}
															?>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Fan</label>
													<div class="col-md-9">
														<select class="form-control" name="fan">
															<option value="">Seçiniz</option>
															<?
															$parameters = getParameters(12,true);
															if(!is_null($parameters)) {
																foreach ($parameters as $parameter) {
																	?>
																	<option value="<?php echo $parameter["parametre_id"]?>"><?php echo $parameter["parametre_deger_tr"]?></option>
																	<?php
																}
															}
															?>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">UPS Güç Kaynağı</label>
													<div class="col-md-9">
														<select class="form-control" name="ups_guc_kaynagi">
															<option value="">Seçiniz</option>
															<?
															$parameters = getParameters(14,true);
															if(!is_null($parameters)) {
																foreach ($parameters as $parameter) {
																	?>
																	<option value="<?php echo $parameter["parametre_id"]?>"><?php echo $parameter["parametre_deger_tr"]?></option>
																	<?php
																}
															}
															?>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Kurutucu</label>
													<div class="col-md-9">
														<select class="form-control" name="kurutucu">
															<option value="">Seçiniz</option>
															<?
															$parameters = getParameters(16,true);
															if(!is_null($parameters)) {
																foreach ($parameters as $parameter) {
																	?>
																	<option value="<?php echo $parameter["parametre_id"]?>"><?php echo $parameter["parametre_deger_tr"]?></option>
																	<?php
																}
															}
															?>
														</select>
													</div>
												</div>


												
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions">
									<div class="row">
										<div class="col-md-offset-2 col-md-9">
											<button type="submit" class="btn green">Kaydet</button>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<?php 

	} 
} 
