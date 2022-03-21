<?php
defined('_ADMIN_GIRDI') or die('Erişim engellendi.');
if(canUserAccessAdminArea() && $_SESSION["user"]["group"]=='root') {
	$details = getConfig();
	$details_teklif = getConfigTeklif();
	$details_proforma = getConfigProforma();
	?>
	<h1 class="page-title"></h1>
	<div class="row">
		<div class="col-md-12 ">
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-settings font-dark"></i>
						<span class="caption-subject font-dark sbold uppercase">Ayar Güncelle</span>
					</div>
				</div>
				<div class="portlet-body form">
					<? require("islemsonucu.php"); ?>
					<form action="config_guncelle_islem.php" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
						<div class="tabbable-custom">
							<ul class="nav nav-tabs">
								<li class="active">
									<a href="#tab_genel" data-toggle="tab"> Genel Tanımlar </a>
								</li>
								<li>
									<a href="#tab_smtp" data-toggle="tab"> SMTP Ayarları </a>
								</li>
								<?php
								$diller=getLanguages();
								if ($db->num_rows > 0) {

									foreach ($diller as $d) {
										$code=$d["language_code"];
										?>
										<li class="">
											<a href="#tab_teklif_<?php echo $code?>" data-toggle="tab"> Teklif <?php echo $d["language_name"]?> </a>
										</li>
										<?php
									}  
									foreach ($diller as $d) {
										$code=$d["language_code"];
										?>
										<li class="">
											<a href="#tab_proforma_<?php echo $code?>" data-toggle="tab"> Proforma <?php echo $d["language_name"]?> </a>
										</li>
										<?php 
									}
									foreach ($diller as $d) {
										$code=$d["language_code"];
										?>
										<li class="">
											<a href="#tab_sozlesme_<?php echo $code?>" data-toggle="tab"> Sözleşme <?php echo $d["language_name"]?> </a>
										</li>
										<?php 
									}
								} ?>

							</ul>
							<div class="tab-content">
								<div class="tab-pane active" id="tab_genel">
									<div class="form-group">
										<label class="col-md-2 control-label">Firma Adı</label>
										<div class="col-md-8">
											<input type="text" class="form-control" name="company_name" id="company_name" value="<?=$details["company_name"]?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Telefon</label>
										<div class="col-md-8">
											<input type="text" class="form-control" name="phone" id="phone" value="<?=$details["phone"]?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Gsm</label>
										<div class="col-md-8">
											<input type="text" class="form-control" name="gsm" id="gsm" value="<?=$details["gsm"]?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Fax</label>
										<div class="col-md-8">
											<input type="text" class="form-control" name="fax" id="fax" value="<?=$details["fax"]?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Address</label>
										<div class="col-md-8">
											<input type="text" class="form-control" name="address" id="address" value="<?=$details["address"]?>">
										</div>
									</div>

									<div class="form-group">
										<label class="col-md-2 control-label">Email</label>
										<div class="col-md-8">
											<input type="text" class="form-control" name="email" id="email" value="<?=$details["email"]?>">
										</div>
									</div>

									<div class="form-group">
										<label class="col-md-2 control-label">Web</label>
										<div class="col-md-8">
											<input type="text" class="form-control" name="web" id="web" value="<?=$details["web"]?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Ticaret Sicil No</label>
										<div class="col-md-8">
											<input type="text" class="form-control" name="registration_number" id="registration_number" value="<?=$details["registration_number"]?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Vergi Dairesi</label>
										<div class="col-md-8">
											<input type="text" class="form-control" name="tax_office" id="tax_office" value="<?=$details["tax_office"]?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Vergi Numarası</label>
										<div class="col-md-8">
											<input type="text" class="form-control" name="tax_number" id="tax_number" value="<?=$details["tax_number"]?>">
										</div>
									</div>
									


									<div class="form-group">
										<label class="col-md-2 control-label">Logo 1</label>
										<div class="col-md-9">
											<input type="file" style="float: left;" name="logo1">
											<?php
											if (($details["logo1"]!="") and file_exists("upload/company/".$details["logo1"])) {
												?>
												<img class="img" width="100" src="upload/company/<?=$details["logo1"] ?>">
												<?php 
											} 
											?>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Logo 2</label>
										<div class="col-md-9">
											<input type="file" style="float: left;" name="logo2">
											<?php
											if (($details["logo2"]!="") and file_exists("upload/company/".$details["logo2"])) {
												?>
												<img class="img" width="100" src="upload/company/<?=$details["logo2"] ?>">
												<?php 
											} 
											?>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">İmza</label>
										<div class="col-md-9">
											<input type="file" style="float: left;" name="signature">
											<?php
											if (($details["signature"]!="") and file_exists("upload/company/".$details["signature"])) {
												?>
												<img class="img" width="100" src="upload/company/<?=$details["signature"] ?>">
												<?php 
											} 
											?>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Sözleşme Resim</label>
										<div class="col-md-9">
											<input type="file" style="float: left;" name="sozlesme_resim">
											<?php
											if (($details["sozlesme_resim"]!="") and file_exists("upload/company/".$details["sozlesme_resim"])) {
												?>
												<img class="img" width="100" src="upload/company/<?=$details["sozlesme_resim"] ?>">
												<?php 
											} 
											?>
										</div>
									</div>



								</div>
								<div class="tab-pane" id="tab_smtp">
									<div class="form-group">
										<label class="col-md-2 control-label">SMTP Host</label>
										<div class="col-md-8">
											<input type="text" class="form-control" name="smtp_host" id="smtp_host" value="<?=$details["smtp_host"]?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">SMTP Kullanıcı Adı</label>
										<div class="col-md-8">
											<input type="text" class="form-control" name="smtp_username" id="smtp_username" value="<?=$details["smtp_username"]?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">SMTP Şifre</label>
										<div class="col-md-8">
											<input type="text" class="form-control" name="smtp_password" id="smtp_password" value="<?=$details["smtp_password"]?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Mail Adresi</label>
										<div class="col-md-8">
											<input type="text" class="form-control" name="mail_address" id="mail_address" value="<?=$details["mail_address"]?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Mail Adı</label>
										<div class="col-md-8">
											<input type="text" class="form-control" name="mail_name" id="mail_name" value="<?=$details["mail_name"]?>">
										</div>
									</div>
								</div>

								

								<?php
								$diller=getLanguages();
								if ($db->num_rows > 0) {
									$y=0;
									foreach ($diller as $d) {
										$code=$d["language_code"];
										$dir=$code=="ar" ? 'dir="rtl"' : '';

										?>
										<div class="tab-pane " id="tab_teklif_<?php echo $code?>">
											<div class="form-group">
												<label class="col-md-2 control-label">Geçerlilik Süresi</label>
												<div class="col-md-8">
													<input type="text" class="form-control" name="gecerlilik_suresi_<?php echo $code?>" id="gecerlilik_suresi_<?php echo $code?>" value="<?=$details_teklif["gecerlilik_suresi_$code"]?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Teklif Yazı 1</label>
												<div class="col-md-8">
													<input type="text" class="form-control" name="teklif_yazi1_<?php echo $code?>" id="teklif_yazi1_<?php echo $code?>" value="<?=$details_teklif["teklif_yazi1_$code"]?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Teklif Yazı 2</label>
												<div class="col-md-8">
													<input type="text" class="form-control" name="teklif_yazi2_<?php echo $code?>" id="teklif_yazi2_<?php echo $code?>" value="<?=$details_teklif["teklif_yazi2_$code"]?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Teklif Fan Yazı</label>
												<div class="col-md-8">
													<input type="text" class="form-control" name="teklif_fan_yazi_<?php echo $code?>" id="teklif_fan_yazi_<?php echo $code?>" value="<?=$details_teklif["teklif_fan_yazi_$code"]?>">
												</div>
											</div>
											<div class="form-group">
												<div class="col-md-12">
													<span class="col-md-2 control-label caption-subject font-dark sbold uppercase">Makine Detayları</span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Makina Modeli</label>
												<div class="col-md-8">
													<input type="text" class="form-control" name="makina_modeli_<?php echo $code?>" id="makina_modeli_<?php echo $code?>" value="<?=$details_teklif["makina_modeli_$code"]?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Kesim Alanı</label>
												<div class="col-md-8">
													<input type="text" class="form-control" name="kesim_alani_<?php echo $code?>" id="kesim_alani_<?php echo $code?>" value="<?=$details_teklif["kesim_alani_$code"]?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Tezgah Ölçüleri</label>
												<div class="col-md-8">
													<input type="text" class="form-control" name="tezgah_olculeri_<?php echo $code?>" id="tezgah_olculeri_<?php echo $code?>" value="<?=$details_teklif["tezgah_olculeri_$code"]?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Plazma Kesim</label>
												<div class="col-md-8">
													<input type="text" class="form-control" name="plazma_kesim_<?php echo $code?>" id="plazma_kesim_<?php echo $code?>" value="<?=$details_teklif["plazma_kesim_$code"]?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Kesim Kalınlığı</label>
												<div class="col-md-8">
													<input type="text" class="form-control" name="kesim_kalinligi_<?php echo $code?>" id="kesim_kalinligi_<?php echo $code?>" value="<?=$details_teklif["kesim_kalinligi_$code"]?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Detay Yazı 1</label>
												<div class="col-md-8">
													<input type="text" class="form-control" name="detay_yazi1_<?php echo $code?>" id="detay_yazi1_<?php echo $code?>" value="<?=$details_teklif["detay_yazi1_$code"]?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Yükseklik Kontrol</label>
												<div class="col-md-8">
													<input type="text" class="form-control" name="yukseklik_kontrol_<?php echo $code?>" id="yukseklik_kontrol_<?php echo $code?>" value="<?=$details_teklif["yukseklik_kontrol_$code"]?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Detay Yazı 2</label>
												<div class="col-md-8">
													<input type="text" class="form-control" name="detay_yazi2_<?php echo $code?>" id="detay_yazi2_<?php echo $code?>" value="<?=$details_teklif["detay_yazi2_$code"]?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Detay Yazı 3</label>
												<div class="col-md-8">
													<input type="text" class="form-control" name="detay_yazi3_<?php echo $code?>" id="detay_yazi3_<?php echo $code?>" value="<?=$details_teklif["detay_yazi3_$code"]?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Raylar</label>
												<div class="col-md-8">
													<input type="text" class="form-control" name="raylar_<?php echo $code?>" id="raylar_<?php echo $code?>" value="<?=$details_teklif["raylar_$code"]?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Kramiyer</label>
												<div class="col-md-8">
													<input type="text" class="form-control" name="kramiyer_<?php echo $code?>" id="kramiyer_<?php echo $code?>" value="<?=$details_teklif["kramiyer_$code"]?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Motor Tipi</label>
												<div class="col-md-8">
													<input type="text" class="form-control" name="motor_tipi_<?php echo $code?>" id="motor_tipi_<?php echo $code?>" value="<?=$details_teklif["motor_tipi_$code"]?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Cnc Kontrol</label>
												<div class="col-md-8">
													<input type="text" class="form-control" name="cnc_kontrol_<?php echo $code?>" id="cnc_kontrol_<?php echo $code?>" value="<?=$details_teklif["cnc_kontrol_$code"]?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Detay Yazı 4</label>
												<div class="col-md-8">
													<input type="text" class="form-control" name="detay_yazi4_<?php echo $code?>" id="detay_yazi4_<?php echo $code?>" value="<?=$details_teklif["detay_yazi4_$code"]?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Detay Yazı 5</label>
												<div class="col-md-8">
													<input type="text" class="form-control" name="detay_yazi5_<?php echo $code?>" id="detay_yazi5_<?php echo $code?>" value="<?=$details_teklif["detay_yazi5_$code"]?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Detay Yazı 6</label>
												<div class="col-md-8">
													<input type="text" class="form-control" name="detay_yazi6_<?php echo $code?>" id="detay_yazi6_<?php echo $code?>" value="<?=$details_teklif["detay_yazi6_$code"]?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Detay Yazı 7</label>
												<div class="col-md-8">
													<input type="text" class="form-control" name="detay_yazi7_<?php echo $code?>" id="detay_yazi7_<?php echo $code?>" value="<?=$details_teklif["detay_yazi7_$code"]?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Detay Yazı 8</label>
												<div class="col-md-8">
													<input type="text" class="form-control" name="detay_yazi8_<?php echo $code?>" id="detay_yazi8_<?php echo $code?>" value="<?=$details_teklif["detay_yazi8_$code"]?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Detay Yazı 9</label>
												<div class="col-md-8">
													<input type="text" class="form-control" name="detay_yazi9_<?php echo $code?>" id="detay_yazi9_<?php echo $code?>" value="<?=$details_teklif["detay_yazi9_$code"]?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Detay Yazı 10</label>
												<div class="col-md-8">
													<input type="text" class="form-control" name="detay_yazi10_<?php echo $code?>" id="detay_yazi10_<?php echo $code?>" value="<?=$details_teklif["detay_yazi10_$code"]?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Detay Yazı 11</label>
												<div class="col-md-8">
													<input type="text" class="form-control" name="detay_yazi11_<?php echo $code?>" id="detay_yazi11_<?php echo $code?>" value="<?=$details_teklif["detay_yazi11_$code"]?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Detay Yazı 12</label>
												<div class="col-md-8">
													<input type="text" class="form-control" name="detay_yazi12_<?php echo $code?>" id="detay_yazi12_<?php echo $code?>" value="<?=$details_teklif["detay_yazi12_$code"]?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Detay Yazı 13</label>
												<div class="col-md-8">
													<input type="text" class="form-control" name="detay_yazi13_<?php echo $code?>" id="detay_yazi13_<?php echo $code?>" value="<?=$details_teklif["detay_yazi13_$code"]?>">
												</div>
											</div>
											
											
											

										</div>
										
										<div class="tab-pane " id="tab_proforma_<?php echo $code?>">
											
											<div class="form-group">
												<label class="col-md-2 control-label">Makina Modeli</label>
												<div class="col-md-8">
													<input type="text" class="form-control" name="proforma_makina_modeli_<?php echo $code?>" id="proforma_makina_modeli_<?php echo $code?>" value="<?=$details_proforma["proforma_makina_modeli_$code"]?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Kesim Alanı</label>
												<div class="col-md-8">
													<input type="text" class="form-control" name="proforma_kesim_alani_<?php echo $code?>" id="proforma_kesim_alani_<?php echo $code?>" value="<?=$details_proforma["proforma_kesim_alani_$code"]?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Tezgah Ölçüleri</label>
												<div class="col-md-8">
													<input type="text" class="form-control" name="proforma_tezgah_olculeri_<?php echo $code?>" id="proforma_tezgah_olculeri_<?php echo $code?>" value="<?=$details_proforma["proforma_tezgah_olculeri_$code"]?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Plazma Kesim</label>
												<div class="col-md-8">
													<input type="text" class="form-control" name="proforma_plazma_kesim_<?php echo $code?>" id="proforma_plazma_kesim_<?php echo $code?>" value="<?=$details_proforma["proforma_plazma_kesim_$code"]?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Kesim Kalınlığı</label>
												<div class="col-md-8">
													<input type="text" class="form-control" name="proforma_kesim_kalinligi_<?php echo $code?>" id="proforma_kesim_kalinligi_<?php echo $code?>" value="<?=$details_proforma["proforma_kesim_kalinligi_$code"]?>">
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-md-2 control-label">Raylar</label>
												<div class="col-md-8">
													<input type="text" class="form-control" name="proforma_raylar_<?php echo $code?>" id="proforma_raylar_<?php echo $code?>" value="<?=$details_proforma["proforma_raylar_$code"]?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Kramiyer</label>
												<div class="col-md-8">
													<input type="text" class="form-control" name="proforma_kramiyer_<?php echo $code?>" id="proforma_kramiyer_<?php echo $code?>" value="<?=$details_proforma["proforma_kramiyer_$code"]?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Motor Tipi</label>
												<div class="col-md-8">
													<input type="text" class="form-control" name="proforma_motor_tipi_<?php echo $code?>" id="proforma_motor_tipi_<?php echo $code?>" value="<?=$details_proforma["proforma_motor_tipi_$code"]?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Cnc Kontrol</label>
												<div class="col-md-8">
													<input type="text" class="form-control" name="proforma_cnc_kontrol_<?php echo $code?>" id="proforma_cnc_kontrol_<?php echo $code?>" value="<?=$details_proforma["proforma_cnc_kontrol_$code"]?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Yükselik Kontrol</label>
												<div class="col-md-8">
													<input type="text" class="form-control" name="proforma_yukseklik_kontrol_<?php echo $code?>" id="proforma_yukseklik_kontrol_<?php echo $code?>" value="<?=$details_proforma["proforma_yukseklik_kontrol_$code"]?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Oksijen</label>
												<div class="col-md-8">
													<input type="text" class="form-control" name="proforma_oksijen_<?php echo $code?>" id="proforma_oksijen_<?php echo $code?>" value="<?=$details_proforma["proforma_oksijen_$code"]?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">UPS Güç Kaynağı</label>
												<div class="col-md-8">
													<input type="text" class="form-control" name="proforma_ups_<?php echo $code?>" id="proforma_ups_<?php echo $code?>" value="<?=$details_proforma["proforma_ups_$code"]?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Fan</label>
												<div class="col-md-8">
													<input type="text" class="form-control" name="proforma_fan_<?php echo $code?>" id="proforma_fan_<?php echo $code?>" value="<?=$details_proforma["proforma_fan_$code"]?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Kompresör</label>
												<div class="col-md-8">
													<input type="text" class="form-control" name="proforma_kompresor_<?php echo $code?>" id="proforma_kompresor_<?php echo $code?>" value="<?=$details_proforma["proforma_kompresor_$code"]?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Kurutucu</label>
												<div class="col-md-8">
													<input type="text" class="form-control" name="proforma_kurutucu_<?php echo $code?>" id="proforma_kurutucu_<?php echo $code?>" value="<?=$details_proforma["proforma_kurutucu_$code"]?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Proforma Yazı 1</label>
												<div class="col-md-8">
													<input type="text" class="form-control" name="proforma_yazi1_<?php echo $code?>" id="proforma_yazi1_<?php echo $code?>" value="<?=$details_proforma["proforma_yazi1_$code"]?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">G.T.İ.P Kodu</label>
												<div class="col-md-8">
													<input type="text" class="form-control" name="gtip_kodu_<?php echo $code?>" id="gtip_kodu_<?php echo $code?>" value="<?=$details_proforma["gtip_kodu_$code"]?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Alt Bilgi Yazı 1</label>
												<div class="col-md-8">
													<input type="text" class="form-control" name="proforma_bilgi_yazi1_<?php echo $code?>" id="proforma_bilgi_yazi1_<?php echo $code?>" value="<?=$details_proforma["proforma_bilgi_yazi1_$code"]?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Alt Bilgi Yazı 2</label>
												<div class="col-md-8">
													<input type="text" class="form-control" name="proforma_bilgi_yazi2_<?php echo $code?>" id="proforma_bilgi_yazi2_<?php echo $code?>" value="<?=$details_proforma["proforma_bilgi_yazi2_$code"]?>">
												</div>
											</div>

										</div>

										<div class="tab-pane" id="tab_sozlesme_<?php echo $code?>">
											<div class="form-group">
												<label class="col-md-2 control-label">Sözleşme Konusu</label>
												<div class="col-md-8">
													<textarea style="resize:vertical;" rows="4" type="text" class="form-control" name="sozlesme_konusu_<?php echo $code?>" id="sozlesme_konusu_<?php echo $code?>"><?=$details["sozlesme_konusu_$code"]?></textarea>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Teslim Süresi</label>
												<div class="col-md-8">
													<input type="text" class="form-control" name="teslim_suresi_<?php echo $code?>" id="teslim_suresi_<?php echo $code?>" value="<?=$details["teslim_suresi_$code"]?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Ödeme</label>
												<div class="col-md-8">
													<input type="text" class="form-control" name="odeme_<?php echo $code?>" id="odeme_<?php echo $code?>" value="<?=$details["odeme_$code"]?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Ödeme Yazı</label>
												<div class="col-md-8">
													<input type="text" class="form-control" name="odeme_yazi_<?php echo $code?>" id="odeme_yazi_<?php echo $code?>" value="<?=$details["odeme_yazi_$code"]?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Teslim Yeri ve Şekli</label>
												<div class="col-md-8">
													<textarea style="resize:vertical;" rows="4" type="text" class="form-control" name="teslim_yeri_<?php echo $code?>" id="teslim_yeri_<?php echo $code?>"><?=$details["teslim_yeri_$code"]?></textarea>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Kurulum</label>
												<div class="col-md-8">
													<textarea style="resize:vertical;" rows="4" type="text" class="form-control" name="kurulum_<?php echo $code?>" id="kurulum_<?php echo $code?>"><?=$details["kurulum_$code"]?></textarea>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Eğitim</label>
												<div class="col-md-8">
													<textarea style="resize:vertical;" rows="4" type="text" class="form-control" name="egitim_<?php echo $code?>" id="egitim_<?php echo $code?>"><?=$details["egitim_$code"]?></textarea>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Mücbir Sebepler</label>
												<div class="col-md-8">
													<textarea style="resize:vertical;" rows="4" type="text" class="form-control" name="mucbir_sebepler_<?php echo $code?>" id="mucbir_sebepler_<?php echo $code?>"><?=$details["mucbir_sebepler_$code"]?></textarea>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Garanti</label>
												<div class="col-md-8">
													<textarea style="resize:vertical;" rows="4" type="text" class="form-control" name="garanti_<?php echo $code?>" id="garanti_<?php echo $code?>"><?=$details["garanti_$code"]?></textarea>
												</div>
											</div>
											<div class="form-group last">
												<label class="control-label col-md-2">Genel Hükümler</label>
												<div class="col-md-8">
													<textarea style="resize:vertical;" class="ckeditor form-control" name="genel_hukum_<?php echo $code?>" id="genel_hukum_<?php echo $code?>" rows="6" data-error-container="#editor2_error"><?=$details["genel_hukum_$code"]?></textarea>
													<div id="editor2_error"> </div>
												</div>
											</div>
										</div>
										<?php 
										$y++; 
									}  
								} 
								?>


							</div>
						</div>
						<div class="form-actions">
							<div class="row">
								<div class="col-md-offset-2 col-md-9">
									<button type="submit" class="btn green">Güncelle</button>
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
