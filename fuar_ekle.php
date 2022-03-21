<?
defined('_ADMIN_GIRDI') or die('Erişim engellendi.');
if(canUserAccessAdminArea()) {

	?>
	<h1 class="page-title"></h1>
	<div class="row">
		<div class="col-md-12 ">
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-plus font-dark"></i>
						<span class="caption-subject font-dark sbold uppercase">Fuar Ekle</span>
					</div>
				</div>
				<div class="portlet-body form">
					<? require("islemsonucu.php"); ?>
					<form action="fuar_ekle_islem.php" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
						<div class="tabbable-custom ">
							<ul class="nav nav-tabs ">
								<li class="active">
									<a href="#tab_genel" data-toggle="tab"> Genel Tanımlar </a>
								</li>
								<?php
								$diller=getLanguages();
								if ($db->num_rows > 0) {
									$x=0;
									foreach ($diller as $d) {
										$code=$d["language_code"];
										?>
										<li class="">
											<a href="#tab_<?php echo $code?>" data-toggle="tab"> <?php echo $d["language_name"]?> </a>
										</li>
										<?php 
										$x++; 
									}  
								} 
								?>
							</ul>
							<div class="tab-content">
								<div class="tab-pane active" id="tab_genel">
									<div class="form-group">
										<label class="col-md-2 control-label">Resim</label>
										<div class="col-md-9">
											<input type="file" name="resim">
											<p class="help-block"> (800x432) </p>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Fuar Tarih</label>
										<div class="col-md-2">
											<div class="input-group date datepicker" data-date-format="yyyy-mm-dd">
												<input type="text" class="form-control" id="fuar_tarih"  name="fuar_tarih" value="<?=date("Y-m-d");?>">
												<span class="input-group-btn">
													<button class="btn default" type="button">
														<i class="fa fa-calendar"></i>
													</button>
												</span>
											</div>
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
										<div class="tab-pane " id="tab_<?php echo $code?>">
											<div class="form-group">
												<label class="col-md-2 control-label">Fuar Başlık</label>
												<div class="col-md-8">
													<input type="text" <?php echo $dir?> name="fuar_baslik_<?php echo $code?>" id="fuar_baslik_<?php echo $code?>" class="form-control">
												</div>
											</div>

											<div class="form-group last">
												<label class="control-label col-md-2">Fuar İçerik</label>
												<div class="col-md-8">
													<textarea class="ckeditor form-control" <?php echo $dir?> name="fuar_icerik_<?php echo $code?>" id="fuar_icerik_<?php echo $code?>" rows="6" data-error-container="#editor2_error"></textarea>
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
	<div class="clearfix"></div>
</div>
</div>
</div>
<?php } ?>