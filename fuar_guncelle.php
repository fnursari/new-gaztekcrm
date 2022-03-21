<?
defined('_ADMIN_GIRDI') or die('Erişim engellendi.');
if(canUserAccessAdminArea()) {
	$fuar_id=$_GET['fuar_id'];
	$sql="select * from fuar where fuar_id='$fuar_id'";
	$details = $db->get_row($sql,ARRAY_A);
	$ana_id=$details['kategori_id'];
	?>
	<h1 class="page-title"></h1>
	<div class="row">
		<div class="col-md-12 ">
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-plus font-dark"></i>
						<span class="caption-subject font-dark sbold uppercase">Fuar Güncelle - <?=$details["fuar_baslik_tr"];?></span>
					</div>
				</div>
				<div class="portlet-body form">
					<? require("islemsonucu.php"); ?>
					<form action="fuar_guncelle_islem.php?fuar_id=<?=$fuar_id?>" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
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
											<input type="file" style="float: left;" name="resim">
											<?
											if (($details["resim_kucuk"]!="") and file_exists("../upload/fairs/".$details["resim_kucuk"]))
											{
												$boyut=getimagesize("../upload/fairs/".$details["resim_kucuk"]);
												$width=$boyut[0];
												$height=$boyut[1];
												$w=100;
												$h=floor($w*$height/$width);
												?>
												<img style="float: left;padding: 2px;margin: 2px;border: 1px solid #cccccc;background-color: #FFFFFF;" class="img" width="<?=$w ?>" height="<?=$h ?>" src="../upload/fairs/<?=$details["resim_kucuk"] ?>">
												<a href="fuar_resim_sil.php?fuar_id=<?=$details["fuar_id"]?>" onclick="return confirmDel();">Sil</a>
												<?php 
											}
											?>
											<p class="help-block"> (800x432) </p>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Fuar Tarih</label>
										<div class="col-md-2">
											<div class="input-group date datepicker" data-date-format="yyyy-mm-dd">
												<input type="text" class="form-control" id="fuar_tarih"  name="fuar_tarih" value="<?=$details["fuar_tarih"]?>">
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
													<input type="text" <?php echo $dir?> name="fuar_baslik_<?php echo $code?>" id="fuar_baslik_<?php echo $code?>"  value="<?=$details["fuar_baslik_$code"]?>" class="form-control">
												</div>
											</div>
											
											<div class="form-group last">
												<label class="control-label col-md-2">Fuar İçerik</label>
												<div class="col-md-8">
													<textarea class="ckeditor form-control" name="fuar_icerik_<?php echo $code?>" id="fuar_icerik_<?php echo $code?>" rows="6" data-error-container="#editor2_error"><?=$details["fuar_icerik_$code"]?></textarea>
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
									<button type="submit" class="btn green">Güncelle</button>
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