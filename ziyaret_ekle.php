<?
defined('_ADMIN_GIRDI') or die('Erişim engellendi.');
if(canUserAccessAdminArea()) {
	$ana_id=$_GET["ana_id"];
	$anakategorioptiongoster=1;
	?>
	<h1 class="page-title"></h1>
	<div class="row">
		<div class="col-md-12 ">
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-plus font-dark"></i>
						<span class="caption-subject font-dark sbold uppercase">Firma Ziyareti Ekle</span>
					</div>
				</div>
				<div class="portlet-body form">
					<? require("islemsonucu.php"); ?>
					<form action="ziyaret_ekle_islem.php" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
						<div class="tabbable-custom ">
							<ul class="nav nav-tabs ">
								<li class="active">
									<a href="#tab_genel" data-toggle="tab"> Ziyaret Bilgileri </a>
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
														?>
														<option  value="<?=$company["firma_id"]?>"><?=$company["firma_ad"]?></option>
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
												<input name="ziyaret_tarihi" type="text" size="16" readonly="" required="" class="form-control" value="<?php echo date('Y-m-d H:i:s');?>">
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
											<input type="text" required="" name="ziyaret_konusu" id="ziyaret_konusu" class="form-control" value="">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label">Görüşülen Kişi</label>
										<div class="col-md-4">
											<input type="text" required="" name="gorusulen_kisi" id="gorusulen_kisi" class="form-control" value="">
										</div>
									</div>
									
									<div class="form-group last">
										<label class="control-label col-md-3">Görüşme Notları</label>
										<div class="col-md-8">
											<textarea class="ckeditor form-control" name="gorusme_notlari" id="gorusme_notlari" rows="6" data-error-container="#editor2_error"></textarea>
											<div id="editor2_error"> </div>
										</div>
									</div>

								</div>

							</div>

						</div>
						<div class="form-actions">
							<div class="row">
								<div class="col-md-offset-3 col-md-9">
									<button type="submit" class="btn green">Ekle</button>
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
