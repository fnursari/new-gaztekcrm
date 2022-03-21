<?php
defined('_ADMIN_GIRDI') or die('Erişim engellendi.');
if(canUserAccessAdminArea() && $_SESSION["user"]["group"]=='root') {
	$parametre_id=makeSafe($_GET["parametre_id"]);
	$details = getParameter($parametre_id);
	$tip_id = makeSafe($_GET["tip_id"]);
	$parametre_tipi = getParameterType($tip_id);
	?>
	<h1 class="page-title">Parametreler - <?php echo $parametre_tipi["tip_adi"]?></h1>
	<div class="row">
		<div class="col-md-12 ">
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-note font-dark"></i>
						<span class="caption-subject font-dark sbold uppercase">Parametre Güncelle</span>
					</div>
				</div>
				<div class="portlet-body form">
					<? require("islemsonucu.php"); ?>


					<form action="parametre_guncelle_islem.php?parametre_id=<?=$parametre_id?>&tip_id=<?=$parametre_tipi["tip_id"]?>" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
						<div class="form-body">

							<?php
							$diller=getLanguages();
							if ($db->num_rows > 0) {
								foreach ($diller as $d) {
									$code=$d["language_code"];
									$name=$d["language_name"];
									?>

									<?
									if($parametre_tipi["tip_id"]!=20 && $parametre_tipi["tip_id"]!=21 && $parametre_tipi["tip_id"]!=23) {
										?>

										<div class="form-group">
											<label class="col-md-3 control-label"><?php echo $parametre_tipi["tip_adi"]?> Adı <?php echo $name?></label>
											<div class="col-md-6">
												<input type="text" class="form-control" name="parametre_deger_<?php echo $code?>" id="parametre_deger_<?php echo $code?>" value="<?=$details["parametre_deger_$code"]?>">
											</div>
										</div>
										<?php
									}
									?>
									
									<?
									if($parametre_tipi["tip_id"]==4) {
										?>
										<div class="form-group">
											<label class="col-md-3 control-label">Tezgah Ölçüsü <?php echo $name?></label>
											<div class="col-md-6">
												<select class="form-control" name="tezgah_olcusu_<?php echo $code?>">
													<?
													$tezgah_olculeri = getParameters(5,true);
													if(!is_null($tezgah_olculeri)) {
														foreach ($tezgah_olculeri as $tezgah_olcusu) {
															?>
															<option <?php echo $tezgah_olcusu["parametre_deger_$code"]==$details["tezgah_olcusu_$code"] ? 'selected="selected"' : '' ?> value="<?php echo $tezgah_olcusu["parametre_deger_$code"]?>"><?php echo $tezgah_olcusu["parametre_deger_$code"]?></option>
															<?php
														}
													}
													?>
												</select>
											</div>
										</div>
										<?php
									}
									?>
									<?
									if($parametre_tipi["tip_id"]==2) {
										?>
										<div class="form-group">
											<label class="col-md-3 control-label">Kesim Kalınlıkları <?php echo $name?></label>
											<div class="col-md-6">
												<select class="form-control" name="kesim_kalinligi_<?php echo $code?>">
													<?
													$kesim_kalinliklari = getParameters(3,true);
													if(!is_null($kesim_kalinliklari)) {
														foreach ($kesim_kalinliklari as $kesim_kalinligi) {
															?>
															<option <?php echo $kesim_kalinligi["parametre_deger_$code"]==$details["kesim_kalinligi_$code"] ? 'selected="selected"' : '' ?> value="<?php echo $kesim_kalinligi["parametre_deger_$code"]?>"><?php echo $kesim_kalinligi["parametre_deger_$code"]?></option>
															<?php
														}
													}
													?>
												</select>
											</div>
										</div>
										<?php
									}
									?>
									<?
									if($parametre_tipi["tip_id"]==22) {
										?>
										<div class="form-group">
											<label class="col-md-3 control-label">KDV Yazı <?php echo $name?></label>
											<div class="col-md-6">
												<textarea style="resize:vertical;" rows="3" class="form-control" name="kdv_yazi_<?php echo $code?>" id="kdv_yazi_<?php echo $code?>"><?=$details["kdv_yazi_$code"]?></textarea>
											</div>
										</div>
										
										<?php
									}
									?>
									<?
									if($parametre_tipi["tip_id"]==18) {
										?>
										<div class="form-group">
											<label class="col-md-3 control-label">Masraf Sahibi <?php echo $name?></label>
											<div class="col-md-6">
												<select class="form-control" name="masraf_sahibi_<?php echo $code?>">
													<?
													$masraf_sahibi = getParameters(24,true);
													if(!is_null($masraf_sahibi)) {
														foreach ($masraf_sahibi as $masraf) {
															?>
															<option value="<?php echo $masraf["parametre_deger_$code"]?>"><?php echo $masraf["parametre_deger_$code"]?></option>
															<?php
														}
													}
													?>
												</select>
											</div>
										</div>
										
										<?php
									}
									?>
								<?php } } ?>

								<?
								if($parametre_tipi["tip_id"]==22) {
									?>
									<div class="form-group">
										<label class="col-md-3 control-label">KDV Oranı</label>
										<div class="col-md-6">
											<select class="form-control" name="kdv_orani">
												<?
												$vat_rates = getParameters(21,true);
												if(!is_null($vat_rates)) {
													foreach ($vat_rates as $vat_rate) {
														?>
														<option <?php echo intval(str_replace('%','',$vat_rate["parametre_deger_tr"]))==$details["kdv_orani"] ? 'selected="selected"' : '' ?> value="<?php echo str_replace('%','',$vat_rate["parametre_deger_tr"])?>"><?php echo $vat_rate["parametre_deger_tr"]?></option>
														<?php
													}
												}
												?>
											</select>
										</div>
									</div>
									<?php
								}
								?>
								<?
								if($parametre_tipi["tip_id"]==20 || $parametre_tipi["tip_id"]==21 || $parametre_tipi["tip_id"]==23) {
									?>

									<div class="form-group">
										<label class="col-md-3 control-label"><?php echo $parametre_tipi["tip_adi"]?> Adı</label>
										<div class="col-md-6">
											<input type="text" class="form-control" name="parametre_deger_tr" id="parametre_deger_tr" value="<?=$details["parametre_deger_tr"]?>">
										</div>
									</div>
									<?php
								}
								?>
								<?
								if($parametre_tipi["tip_id"]==23) {
									?>
									<div class="form-group">
										<label class="col-md-3 control-label"><?php echo $parametre_tipi["tip_adi"]?> Sembol</label>
										<div class="col-md-6">
											<input type="text" class="form-control" name="para_sembol"  value="<?=$details["para_sembol"]?>">
										</div>
									</div>
									<?php
								}
								?>

							</div>
							<div class="form-actions">
								<div class="row">
									<div class="col-md-offset-3 col-md-9">
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