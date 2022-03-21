<?php

defined('_ADMIN_GIRDI') or die('Erişim engellendi.');
if(canUserAccessAdminArea()) {
	$kullanici_id=$_SESSION["user"]["user_id"];
	$kullanici_ad=$_SESSION["user"]["name"];
	$kullanici_email=$_SESSION["user"]["user_email"];

	$bilgi_giris_id=makeSafe($_GET['bilgi_giris_id']);
	$sql="select * from bilgi_giris where bilgi_giris_id='$bilgi_giris_id' and bilgi_giris_aktif='1'";
	$details = $db->get_row($sql,ARRAY_A);

	$sqlteklif="select * from teklifler where bilgi_giris_id='$bilgi_giris_id'";
	$detailsteklif = $db->get_row($sqlteklif,ARRAY_A);

	$config = getConfig();
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
						<form action="bilgi_giris_guncelle_islem.php?bilgi_giris_id=<?=$bilgi_giris_id?>" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
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
														<input type="text" name="gonderen" value="<?php echo $details["gonderen"]?>" id="gonderen" class="form-control" readonly="" >
														
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Gönderen Email</label>
													<div class="col-md-9">
														<input type="email" name="gonderen_email" value="<?php echo $details["gonderen_email"] ?>" id="gonderen_email" class="form-control" readonly="" >
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Teklif No</label>
													<div class="col-md-9">
														<input type="text" name="teklif_no" value="<?php echo $details["teklif_no"]?>" id="teklif_no" class="form-control" >
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Satış Tipi</label>
													<div class="col-md-9">
														<select class="form-control" name="satis_tipi" id="satis_tipi" required>
															<option value="">Seçiniz</option>
															<?
															$satis_tipi=getParameter($details["satis_tipi"]);
															$parameters = getParameters(22,true);
															if(!is_null($parameters)) {
																foreach ($parameters as $parameter) {
																	?>
																	<option <?php echo $parameter["parametre_id"]==$satis_tipi["parametre_id"] ? 'selected' : ''  ?> data-kdv="<?php echo $parameter["kdv_orani"]?>" value="<?php echo $parameter["parametre_id"]?>"><?php echo $parameter["parametre_deger_tr"]?></option>
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
														<input type="text" name="sozlesme_yeri" value="<?php echo $details["sozlesme_yeri"] ?>" id="sozlesme_yeri" class="form-control" >
													</div>
												</div>

												<div class="form-group">
													<label class="col-md-3 control-label">Satış Temsilcisi</label>
													<div class="col-md-9">
														<select class="form-control" name="satis_temsilcisi">
															<option value="">Seçiniz</option>
															<?
															$satis_temsilcisi=getParameter($details["satis_temsilcisi"]);
															$parameters = getParameters(17,true);
															if(!is_null($parameters)) {
																foreach ($parameters as $parameter) {
																	?>
																	<option <?php echo $parameter["parametre_id"]==$satis_temsilcisi["parametre_id"] ? 'selected' : ''  ?> value="<?php echo $parameter["parametre_id"]?>"><?php echo $parameter["parametre_deger_tr"]?></option>
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
														<select class="form-control" name="teslim_yeri" id="teslim_yeri">
															<option value="">Seçiniz</option>
															<?
															$teslim_yeri=getParameter($details["teslim_yeri"]);
															$parameters = getParameters(18,true);
															if(!is_null($parameters)) {
																foreach ($parameters as $parameter) {
																	?>
																	<option <?php echo $parameter["parametre_id"]==$teslim_yeri["parametre_id"] ? 'selected' : ''  ?> value="<?php echo $parameter["parametre_id"]?>"><?php echo $parameter["parametre_deger_tr"]?></option>
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
														<input type="number" name="teslim_gunu" value="<?php echo $details["teslim_gunu"] ?>" min="1" id="teslim_gunu" class="form-control">
													</div>
													<div class="col-md-5">
														<input type="text" name="teslim_gunu_gun" readonly="" value="<?php echo $details["teslim_gunu_gun"] ?>" id="teslim_gunu_gun" class="form-control">
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
																	<option data-para-birimi="<?php echo $parameter["para_sembol"] ?>"  <?php echo $parameter["parametre_id"]==$details["para_birimi"] ? 'selected' : ''  ?> value="<?php echo $parameter["parametre_id"]?>"><?php echo $parameter["parametre_deger_tr"] ." - ".$parameter["para_sembol"]?></option>
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
														<input type="text" name="makina_fiyati" value="<?php echo number_format($details["makina_fiyati"],2, ',', '.') ?>" id="makina_fiyati" class="form-control price">
													</div>
												
													<div class="col-md-2">
														<input type="number" name="makina_adet" value="<?php echo $details["makina_adet"] ?>" min="1" id="makina_adet" class="form-control">
													</div>
													<div class="col-md-3">
														<input type="text" name="makina_adet_yazi" readonly="" value="<?php echo $details["makina_adet_yazi"] ?>" id="makina_adet_yazi" class="form-control">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Kompresör Fiyatı</label>
													<div class="col-md-4">
														<input type="text" name="kompresor_fiyati" value="<?php echo number_format($details["kompresor_fiyati"],2, ',', '.') ?>" id="kompresor_fiyati" class="form-control price">
													</div>
													<div class="col-md-2">
														<input type="number" name="kompresor_adet" value="<?php echo $details["kompresor_adet"] ?>" min="1" id="kompresor_adet" class="form-control">
													</div>
													<div class="col-md-3">
														<input type="text" name="kompresor_adet_yazi" readonly="" value="<?php echo $details["kompresor_adet_yazi"] ?>" id="kompresor_adet_yazi" class="form-control">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Fan Fiyatı</label>
													<div class="col-md-4">
														<input type="text" name="fan_fiyati" value="<?php echo number_format($details["fan_fiyati"],2, ',', '.') ?>" id="fan_fiyati" class="form-control price">
													</div>
													<div class="col-md-2">
														<input type="number" name="fan_adet" value="<?php echo $details["fan_adet"] ?>" min="1" id="fan_adet" class="form-control">
													</div>
													<div class="col-md-3">
														<input type="text" name="fan_adet_yazi" readonly="" value="<?php echo $details["fan_adet_yazi"] ?>" id="fan_adet_yazi" class="form-control">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">UPS Güç Kaynağı Fiyatı</label>
													<div class="col-md-4">
														<input type="text" name="ups_fiyati" value="<?php echo number_format($details["ups_fiyati"],2, ',', '.') ?>" id="ups_fiyati" class="form-control price">
													</div>
													<div class="col-md-2">
														<input type="number" name="ups_adet" value="<?php echo $details["ups_adet"] ?>" min="1" id="ups_adet" class="form-control">
													</div>
													<div class="col-md-3">
														<input type="text" name="ups_adet_yazi" readonly="" value="<?php echo $details["ups_adet_yazi"] ?>" id="ups_adet_yazi" class="form-control">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Kurutucu Fiyatı</label>
													<div class="col-md-4">
														<input type="text" name="kurutucu_fiyati" value="<?php echo number_format($details["kurutucu_fiyati"],2, ',', '.') ?>" id="kurutucu_fiyati" class="form-control price">
													</div>
													<div class="col-md-2">
														<input type="number" name="kurutucu_adet" value="<?php echo $details["kurutucu_adet"] ?>" min="1" id="kurutucu_adet" class="form-control">
													</div>
													<div class="col-md-3">
														<input type="text" name="kurutucu_adet_yazi" readonly="" value="<?php echo $details["kurutucu_adet_yazi"] ?>" id="kurutucu_adet_yazi" class="form-control">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">KDV Oranı</label>
													<div class="col-md-9">
														<input type="text" readonly="" name="kdv_orani" value="<?php echo $details["kdv_orani"] ?>" id="kdv_orani" class="form-control"  >
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">KDV</label>
													<div class="col-md-9">
														<input type="text" readonly="" name="kdv" value="<?php echo number_format($details["kdv"],2, ',', '.') ?>" id="kdv" class="form-control price"  >
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Genel Toplam</label>
													<div class="col-md-9">
														<input type="text" readonly="" name="genel_toplam" value="<?php echo number_format($details["genel_toplam"],2, ',', '.') ?>" id="genel_toplam" class="form-control price"  >
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Peşinat</label>
													<div class="col-md-9">
														<input type="text" readonly="" name="pesinat" value="<?php echo number_format($details["pesinat"],2, ',', '.') ?>" id="pesinat" class="form-control price"  >
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
																	<option <?php echo $parameter["parametre_deger_tr"]==$details["taksit_sayisi"] ? 'selected' : ''  ?> value="<?php echo $parameter["parametre_deger_tr"]?>"><?php echo $parameter["parametre_deger_tr"]?></option>
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
														<input type="number" name="vade" value="<?php echo $details["vade"] ?>" id="vade" class="form-control" required>
													</div>
													<div class="col-md-4">
														<input type="text" name="vade_tarihi" value="<?php echo $details["vade_tarihi"] ?>" id="vade_tarihi" class="form-control" >
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Vade Başlangıç</label>
													<div class="col-md-5">
														<input type="number" name="vade_baslangic" value="<?php echo $details["vade_baslangic"] ?>" id="vade_baslangic" class="form-control" required>
													</div>
													<div class="col-md-4">
														<input type="text" name="vade_baslangic_tarihi" value="<?php echo $details["vade_baslangic_tarihi"] ?>" id="vade_baslangic_tarihi" class="form-control" >
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Vade Türü</label>
													<div class="col-md-9">
														<select class="form-control" name="vade_turu" required>
															<option value="">Seçiniz</option>
															<?
															$vade_turu=getParameter($details["vade_turu"]);
															$parameters = getParameters(19,true);
															if(!is_null($parameters)) {
																foreach ($parameters as $parameter) {
																	?>
																	<option <?php echo $parameter["parametre_id"]==$vade_turu["parametre_id"] ? 'selected' : ''  ?> value="<?php echo $parameter["parametre_id"]?>"><?php echo $parameter["parametre_deger_tr"]?></option>
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
														<input type="number" name="adet" id="adet" value="<?php echo $details["adet"] ?>" id="adet" class="form-control" >
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
															$makina_modeli=getParameter($details["makina_modeli"]);
															$parameters = getParameters(1,true);
															if(!is_null($parameters)) {
																foreach ($parameters as $parameter) {
																	?>
																	<option <?php echo $parameter["parametre_id"]==$makina_modeli["parametre_id"] ? 'selected' : ''  ?> value="<?php echo $parameter["parametre_id"]?>"><?php echo $parameter["parametre_deger_tr"]?></option>
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
															$plazma_kesim=getParameter($details["plazma_kesim"]);
															$parameters = getParameters(2,true);
															if(!is_null($parameters)) {
																foreach ($parameters as $parameter) {
																	?>
																	<option <?php echo $parameter["parametre_id"]==$plazma_kesim["parametre_id"] ? 'selected' : ''  ?> data-kesim-kalinligi="<?php echo $parameter["kesim_kalinligi_tr"]?>" value="<?php echo $parameter["parametre_id"]?>"><?php echo $parameter["parametre_deger_tr"]?></option>
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
														<input type="text" name="kesim_kalinligi" value="<?php echo $plazma_kesim["kesim_kalinligi_tr"] ?>" readonly=""  id="kesim_kalinligi" class="form-control" >
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label">Raylar</label>
													<div class="col-md-9">
														<select class="form-control" name="raylar">
															<option value="">Seçiniz</option>
															<?
															$raylar=getParameter($details["raylar"]);
															$parameters = getParameters(11,true);
															if(!is_null($parameters)) {
																foreach ($parameters as $parameter) {
																	?>
																	<option <?php echo $parameter["parametre_id"]==$raylar["parametre_id"] ? 'selected' : ''  ?> value="<?php echo $parameter["parametre_id"]?>"><?php echo $parameter["parametre_deger_tr"]?></option>
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
															$kramiyer=getParameter($details["kramiyer"]);
															$parameters = getParameters(10,true);
															if(!is_null($parameters)) {
																foreach ($parameters as $parameter) {
																	?>
																	<option <?php echo $parameter["parametre_id"]==$kramiyer["parametre_id"] ? 'selected' : ''  ?> value="<?php echo $parameter["parametre_id"]?>"><?php echo $parameter["parametre_deger_tr"]?></option>
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
															$motor_tipi=getParameter($details["motor_tipi"]);
															$parameters = getParameters(8,true);
															if(!is_null($parameters)) {
																foreach ($parameters as $parameter) {
																	?>
																	<option <?php echo $parameter["parametre_id"]==$motor_tipi["parametre_id"] ? 'selected' : ''  ?> value="<?php echo $parameter["parametre_id"]?>"><?php echo $parameter["parametre_deger_tr"]?></option>
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
															$oksijen=getParameter($details["oksijen"]);
															$parameters = getParameters(13,true);
															if(!is_null($parameters)) {
																foreach ($parameters as $parameter) {
																	?>
																	<option <?php echo $parameter["parametre_id"]==$oksijen["parametre_id"] ? 'selected' : ''  ?> value="<?php echo $parameter["parametre_id"]?>"><?php echo $parameter["parametre_deger_tr"]?></option>
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
															$kompresor=getParameter($details["kompresor"]);
															$parameters = getParameters(15,true);
															if(!is_null($parameters)) {
																foreach ($parameters as $parameter) {
																	?>
																	<option <?php echo $parameter["parametre_id"]==$kompresor["parametre_id"] ? 'selected' : ''  ?> value="<?php echo $parameter["parametre_id"]?>"><?php echo $parameter["parametre_deger_tr"]?></option>
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
															$kesim_olcusu=getParameter($details["kesim_olcusu"]);
															$parameters = getParameters(4,true);
															if(!is_null($parameters)) {
																foreach ($parameters as $parameter) {
																	?>
																	<option <?php echo $parameter["parametre_id"]==$kesim_olcusu["parametre_id"] ? 'selected' : ''  ?> data-tezgah-olcusu="<?php echo $parameter["tezgah_olcusu_tr"]?>" value="<?php echo $parameter["parametre_id"]?>"><?php echo $parameter["parametre_deger_tr"]?></option>
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
														<input type="text" name="tezgah_olcusu" value="<?php echo $kesim_olcusu["tezgah_olcusu_tr"] ?>" readonly=""  id="tezgah_olcusu" class="form-control" >
													</div>
												</div>

												<div class="form-group">
													<label class="col-md-3 control-label">Cnc Kontrol</label>
													<div class="col-md-9">
														<select class="form-control" name="cnc_kontrol">
															<option value="">Seçiniz</option>
															<?
															$cnc_kontrol=getParameter($details["cnc_kontrol"]);
															$parameters = getParameters(6,true);
															if(!is_null($parameters)) {
																foreach ($parameters as $parameter) {
																	?>
																	<option <?php echo $parameter["parametre_id"]==$cnc_kontrol["parametre_id"] ? 'selected' : ''  ?> value="<?php echo $parameter["parametre_id"]?>"><?php echo $parameter["parametre_deger_tr"]?></option>
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
															$yukseklik_kontrol=getParameter($details["yukseklik_kontrol"]);
															$parameters = getParameters(7,true);
															if(!is_null($parameters)) {
																foreach ($parameters as $parameter) {
																	?>
																	<option <?php echo $parameter["parametre_id"]==$yukseklik_kontrol["parametre_id"] ? 'selected' : ''  ?> value="<?php echo $parameter["parametre_id"]?>"><?php echo $parameter["parametre_deger_tr"]?></option>
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
															$reduktor=getParameter($details["reduktor"]);
															$parameters = getParameters(9,true);
															if(!is_null($parameters)) {
																foreach ($parameters as $parameter) {
																	?>
																	<option <?php echo $parameter["parametre_id"]==$reduktor["parametre_id"] ? 'selected' : ''  ?> value="<?php echo $parameter["parametre_id"]?>"><?php echo $parameter["parametre_deger_tr"]?></option>
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
															$fan=getParameter($details["fan"]);
															$parameters = getParameters(12,true);
															if(!is_null($parameters)) {
																foreach ($parameters as $parameter) {
																	?>
																	<option <?php echo $parameter["parametre_id"]==$fan["parametre_id"] ? 'selected' : ''  ?> value="<?php echo $parameter["parametre_id"]?>"><?php echo $parameter["parametre_deger_tr"]?></option>
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
															$ups_guc_kaynagi=getParameter($details["ups_guc_kaynagi"]);
															$parameters = getParameters(14,true);
															if(!is_null($parameters)) {
																foreach ($parameters as $parameter) {
																	?>
																	<option <?php echo $parameter["parametre_id"]==$ups_guc_kaynagi["parametre_id"] ? 'selected' : ''  ?> value="<?php echo $parameter["parametre_id"]?>"><?php echo $parameter["parametre_deger_tr"]?></option>
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
															$kurutucu=getParameter($details["kurutucu"]);
															$parameters = getParameters(16,true);
															if(!is_null($parameters)) {
																foreach ($parameters as $parameter) {
																	?>
																	<option <?php echo $parameter["parametre_id"]==$kurutucu["parametre_id"] ? 'selected' : ''  ?> value="<?php echo $parameter["parametre_id"]?>"><?php echo $parameter["parametre_deger_tr"]?></option>
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
								<div class="form-actions" style="padding: 20px 0 10px">
									<div class="row">
										<div class="col-md-offset-2 col-md-9">
											<button type="submit" class="btn green">Güncelle</button>
										</div>
									</div>
								</div>
							</div>
						</form>
						<?php
						$diller=getLanguages();
						if ($db->num_rows > 0) {
							$y=0; 
							?>
							<div class="row mb-3">
								<div class="col-md-offset-2 col-md-9">
									<?php
									foreach ($diller as $d) {
										$code=$d["language_code"];
										$name=$d["language_name"];

										?>

										<form action="teklif_pdf.php?bilgi_giris_id=<?=$bilgi_giris_id?>&dil=<?=$code?>" method="post" class="ml-2 mr-2" style="display: inline-block;">
											<button type="submit" name="submit_val" class="btn btn-primary mt-2">Teklif Çıkart <?php echo $name ?></button>
										</form>

										<?php $y++; 
									}  ?>
								</div>
							</div>
							<div class="row" style="margin-top: 15px;">
								<div class="col-md-offset-2 col-md-9">
									<?php
									foreach ($diller as $d) {
										$code=$d["language_code"];
										$name=$d["language_name"];

										?>

										<form action="proforma_pdf.php?bilgi_giris_id=<?=$bilgi_giris_id?>&dil=<?=$code?>" method="post" class="ml-2 mr-2" style="display: inline-block;">
											<button type="submit" name="submit_val" class="btn btn-primary mt-2">Proforma <?php echo $name ?></button>
										</form>



										<?php 
									}  
									?>
								</div>
							</div>
							<div class="row" style="margin-top: 15px;">
								<div class="col-md-offset-2 col-md-9">
									<?php
									foreach ($diller as $d) {
										$code=$d["language_code"];
										$name=$d["language_name"];

										?>

										<form action="sozlesme_pdf.php?bilgi_giris_id=<?=$bilgi_giris_id?>&dil=<?=$code?>" method="post" class="ml-2 mr-2" style="display: inline-block;">
											<button type="submit" name="submit_val" class="btn btn-primary mt-2">Sözleşme <?php echo $name ?></button>
										</form>



										<?php 
									}  
									?>
								</div>
							</div>

							<div class="row" style="margin-top: 15px;">
								<div class="col-md-offset-2 col-md-9">
									
									<?php
									foreach ($diller as $d) {
										$code=$d["language_code"];
										$name=$d["language_name"];
										?>
										<?php
										if(($detailsteklif["teklif_pdf_$code"] != "") && (file_exists('upload/pdfs/proposals/'.$detailsteklif["teklif_pdf_$code"]))){
											?>
											<a href="admin.php?cmd=pdf_goster&pdf=teklif&bilgi_giris_id=<?=$bilgi_giris_id?>&dil=<?=$code?>" class="btn btn-sm red" title="Teklif <?php echo $name ?>">
												<i class="fa fa-file-pdf-o"></i> Teklif <?php echo $name ?>
											</a>
											<?php
										}

									}  ?>
								</div>
							</div>

							<div class="row" style="margin-top: 15px;">
								<div class="col-md-offset-2 col-md-9">

									<?php
									foreach ($diller as $d) {
										$code=$d["language_code"];
										$name=$d["language_name"];
										?>
										<?php
										if(($detailsteklif["proforma_pdf_$code"] != "") && (file_exists('upload/pdfs/proforma/'.$detailsteklif["proforma_pdf_$code"]))){
											?>
											<a href="admin.php?cmd=pdf_goster&pdf=proforma&bilgi_giris_id=<?=$bilgi_giris_id?>&dil=<?=$code?>" class="btn btn-sm orange" title="Proforma <?php echo $name ?>">
												<i class="fa fa-file-pdf-o"></i> Proforma <?php echo $name ?>
											</a>
											<?php
										}
									}

									?>
								</div>
							</div>

							<div class="row" style="margin-top: 15px;">
								<div class="col-md-offset-2 col-md-9">

									<?php
									foreach ($diller as $d) {
										$code=$d["language_code"];
										$name=$d["language_name"];
										?>
										<?php
										if(($detailsteklif["sozlesme_pdf_$code"] != "") && (file_exists('upload/pdfs/contract/'.$detailsteklif["sozlesme_pdf_$code"]))){
											?>
											<a href="admin.php?cmd=pdf_goster&pdf=sozlesme&bilgi_giris_id=<?=$bilgi_giris_id?>&dil=<?=$code?>" class="btn btn-sm purple-studio" title="Sözleşme <?php echo $name ?>">
												<i class="fa fa-file-pdf-o"></i> Sözleşme <?php echo $name ?>
											</a>
											<?php
										}
									}

									?>
								</div>
							</div>
							<?php 
						}
						?>
					</div>
				</div>
			</div>
		</div>

		<?php 

	} 
} 
