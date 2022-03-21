<?php
defined('_ADMIN_GIRDI') or die('Erişim engellendi.');
if(canUserAccessAdminArea() && $_SESSION["user"]["group"]=='root') {
	$tip_id = makeSafe($_GET["tip_id"]);
	$parametre_tipi = getParameterType($tip_id);
	?>
	<h1 class="page-title">Parametreler - <?php echo $parametre_tipi["tip_adi"]?></h1>
	<div class="row">
		<div class="col-md-12 ">
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-plus font-dark"></i>
						<span class="caption-subject font-dark sbold uppercase"><?php echo $parametre_tipi["tip_adi"]?> Ekle</span>
					</div>
				</div>
				<div class="portlet-body form">
					<?php require("islemsonucu.php"); ?>
					<form action="parametre_ekle_islem.php?tip_id=<?php echo $parametre_tipi["tip_id"]?>" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
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
												<input type="text" class="form-control" name="parametre_deger_<?php echo $code?>"  value="">
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
															<option value="<?php echo $tezgah_olcusu["parametre_deger_$code"]?>"><?php echo $tezgah_olcusu["parametre_deger_$code"]?></option>
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
															<option value="<?php echo $kesim_kalinligi["parametre_deger_$code"]?>"><?php echo $kesim_kalinligi["parametre_deger_$code"]?></option>
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
												<textarea style="resize:vertical;" rows="3" class="form-control" name="kdv_yazi_<?php echo $code?>" id="kdv_yazi_<?php echo $code?>" value=""></textarea>
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
														<option value="<?php echo str_replace('%','',$vat_rate["parametre_deger_tr"])?>"><?php echo $vat_rate["parametre_deger_tr"]?></option>
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
											<input type="text" class="form-control" name="parametre_deger_tr"  value="">
										</div>
									</div>
									<?php
								}
								?>
								<?
								if( $parametre_tipi["tip_id"]==23) {
									?>
									<div class="form-group">
										<label class="col-md-3 control-label"><?php echo $parametre_tipi["tip_adi"]?> Sembol</label>
										<div class="col-md-6">
											<input type="text" class="form-control" name="para_sembol"  value="">
										</div>
									</div>
									<?php
								}
								?>


								<div class="form-actions">
									<div class="row">
										<div class="col-md-offset-3 col-md-9">
											<button type="submit" class="btn green">Ekle</button>
										</div>
									</div>
								</div>
							</div>
						</form>

					</div>
				</div>
			</div>

			<div class="col-md-12">
				<div class="portlet">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-angle-right"></i><?php echo $parametre_tipi["tip_adi"]?> Listesi
						</div>
					</div>
					<div class="portlet-body">
						<table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
							<thead>
								<tr>
									<th width="5%">#</th>
									<th width="60%">Parametre Adı</th>
									<th width="10%">Durum</th>
									<th width="25%">İşlemler</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$parametre_x = 0;
								$parametreler = getParameters($parametre_tipi["tip_id"]);
								if(!is_null($parametreler)) {
									foreach ($parametreler as $parametre) {

										?>
										<tr class="odd gradeX">
											<td><?=($parametre_x+1);?></td> 

											<td class="highlight">
												<?=$parametre["parametre_deger_tr"];?>
												<?php
												if($parametre_tipi["tip_id"]==22) {
													echo '<small> (KDV Oranı : '.$parametre["kdv_orani"].')</small>';
												}
												if($parametre_tipi["tip_id"]==4) {
													echo '<small> (Tezgah Ölçüsü : '.$parametre["tezgah_olcusu_tr"].')</small>';
												}
												if($parametre_tipi["tip_id"]==2) {
													echo '<small> (Kesim Kalınlığı : '.$parametre["kesim_kalinligi_tr"].')</small>';
												}
												if($parametre_tipi["tip_id"]==18) {
													echo '<small> (Masraf Sahibi : '.$parametre["masraf_sahibi_tr"].')</small>';
												}
												?>

											</td>


											<td>
												<?php
												if ($parametre["parametre_aktif"]=="1") {
													$durum="Aktif";
													$color="green-meadow";
												} else{
													$durum="Pasif";
													$color="red";
												}                                                         
												?>
												<a href="parametre_durum.php?parametre_id=<?=$parametre["parametre_id"]?>&parametre_aktif=<?=$parametre["parametre_aktif"]?>&tip_id=<?=$parametre_tipi["tip_id"]?>" class="btn btn-xs <?=$color?>" title="Aktif/Pasif"><?=$durum?></a>
											</td>
											<td>

												<a href="admin.php?cmd=parametre_guncelle&parametre_id=<?=$parametre["parametre_id"]?>&tip_id=<?=$parametre_tipi["tip_id"]?>" class="btn btn-xs orange" title="Düzenle">
													<i class="fa fa-edit"></i> Düzenle
												</a> 
												<a href="parametre_sil.php?parametre_id=<?=$parametre["parametre_id"]?>&tip_id=<?=$parametre_tipi["tip_id"]?>" class="btn btn-xs red" title="Sil" onclick="return confirmDel();">
													<i class="fa fa-trash"></i> Sil
												</a>                                                                
											</td>
										</tr>
										<?php
										$parametre_x++;
									} 
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<?php 
	}