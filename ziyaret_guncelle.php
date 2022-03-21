<?php
defined('_ADMIN_GIRDI') or die('Erişim engellendi.');
if(canUserAccessAdminArea()) {
	$ziyaret_id=makeSafe($_GET['ziyaret_id']);

	if($_SESSION["user"]["group"]=="root") {
		$sql="select * from ziyaret where ziyaret_id='$ziyaret_id' and ziyaret_silindi='0'";
	}
	else {
		$sql="select * from ziyaret where ziyaret_id='$ziyaret_id' and ziyaret_silindi='0' and kullanici_id='".$_SESSION["user"]["user_id"]."'";
	}

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
							<span class="caption-subject font-dark sbold uppercase">Ziyaret Güncelle - <?=$details["ziyaret_konusu"];?></span>
						</div>
					</div>
					<div class="portlet-body form">
						<? require("islemsonucu.php"); ?>
						<form action="ziyaret_guncelle_islem.php?ziyaret_id=<?=$ziyaret_id?>" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
							<div class="tabbable-custom ">
								<ul class="nav nav-tabs ">
									<li class="active">
										<a href="#tab_genel" data-toggle="tab"> Genel Bilgiler </a>
									</li>
									
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="tab_genel">
										<div class="form-group">
											<label class="col-md-3 control-label">Ziyaret Edilen Firma</label>
											<div class="col-md-8">
												<select name="firma_id" id="ziyaret_firma_ad" class="form-control" required="">
													<option value="">--Seçiniz--</option>
													<?
													$companies = getCompanies();
													if(!is_null($companies)) {
														foreach ($companies as $company) {
															$selected = $details["firma_id"]==$company["firma_id"] ? 'selected="selected"' : '';
															?>
															<option <?php echo $selected?> value="<?=$company["firma_id"]?>"><?=$company["firma_ad"]?></option>
															<?
														}
													}
													?>
												</select>
											</div>
										</div>

										<div class="form-group">
											<label class="control-label col-md-3">Ziyaret Tarihi</label>
											<div class="col-md-8">
												<div class="input-group date form_datetime input-large">
													<input name="ziyaret_tarihi" type="text" size="16" readonly="" required="" class="form-control" value="<?php echo $details["ziyaret_tarihi"];?>">
													<span class="input-group-btn">
														<button class="btn default date-set" type="button">
															<i class="fa fa-calendar"></i>
														</button>
													</span>
												</div>
											</div>
										</div>

										<div class="form-group">
											<label class="col-md-3 control-label">Ziyaret Konusu</label>
											<div class="col-md-4">
												<input type="text" required="" name="ziyaret_konusu" id="ziyaret_konusu" class="form-control" value="<?php echo $details["ziyaret_konusu"];?>">
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label">Görüşülen Kişi</label>
											<div class="col-md-4">
												<input type="text" required="" name="gorusulen_kisi" id="gorusulen_kisi" class="form-control" value="<?php echo $details["gorusulen_kisi"];?>">
											</div>
										</div>

										<div class="form-group last">
											<label class="control-label col-md-3">Görüşme Notları</label>
											<div class="col-md-8">
												<textarea class="ckeditor form-control" name="gorusme_notlari" id="gorusme_notlari" rows="6" data-error-container="#editor2_error"><?php echo $details["gorusme_notlari"]?></textarea>
												<div id="editor2_error"> </div>
											</div>
										</div>

									</div>

								</div>

								<div class="form-actions">
									<div class="row">
										<div class="col-md-offset-2 col-md-9">
											<button type="submit" class="btn green">Güncelle</button>
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
