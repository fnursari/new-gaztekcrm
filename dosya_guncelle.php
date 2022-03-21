<?php
defined('_ADMIN_GIRDI') or die('Erişim engellendi.');
if(canUserAccessAdminArea()) {
	$tablo=$_GET["tablo"];
	$tablo_id=$_GET["tablo_id"];
	$dosya_id=$_GET["dosya_id"];
	$sayfa_num=$_GET["sayfa_num"];
	$sql="select * from dosya where dosya_id='$dosya_id'";
	$dosya = $db->get_row($sql,ARRAY_A);
	switch($tablo)
	{
		case "haber" :
		{
			$sql="select * from haber where haber_id='$tablo_id'";
			$details = $db->get_row($sql,ARRAY_A);
			$title="Haber Dosyaları - ".$details["haber_baslik_$dfl"];
			$baslik_tr=$details["haber_baslik_tr"];
			$baslik_en=$details["haber_baslik_en"];
			$baslik_ru=$details["haber_baslik_ru"];
			$baslik_ar=$details["haber_baslik_ar"];
			$baslik_de=$details["haber_baslik_de"];
			$baslik_fr=$details["haber_baslik_fr"];
			$baslik_es=$details["haber_baslik_es"];
			$baslik_sq=$details["haber_baslik_sq"];
			break;
		}
		case "sayfa" :
		{
			$sql="select * from sayfa where sayfa_id='$tablo_id'";
			$details = $db->get_row($sql,ARRAY_A);
			$title="Sayfa Dosyaları - ".$details["sayfa_ad_$dfl"];
			$baslik_tr=$details["sayfa_ad_tr"];
			$baslik_en=$details["sayfa_ad_en"];
			$baslik_ru=$details["sayfa_ad_ru"];
			$baslik_ar=$details["sayfa_ad_ar"];
			$baslik_de=$details["sayfa_ad_de"];
			$baslik_fr=$details["sayfa_ad_fr"];
			$baslik_es=$details["sayfa_ad_es"];
			$baslik_sq=$details["sayfa_ad_sq"];
			break;
		}   

		case "urun" :
		{
			$sql="select * from urun where urun_id='$tablo_id'";
			$details = $db->get_row($sql,ARRAY_A);
			$title="Ürün Dosyaları - ".$details["urun_ad_$dfl"];
			$baslik_tr=$details["urun_ad_tr"];
			$baslik_en=$details["urun_ad_en"];
			$baslik_ru=$details["urun_ad_ru"];
			$baslik_ar=$details["urun_ad_ar"];
			$baslik_de=$details["urun_ad_de"];
			$baslik_fr=$details["urun_ad_fr"];
			$baslik_es=$details["urun_ad_es"];
			$baslik_sq=$details["urun_ad_sq"];
			break;
		}


	}
	?>
	<h1 class="page-title"><?=$title?></h1>
	<div class="row">
		<div class="col-md-12 ">
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-note font-dark"></i>
						<span class="caption-subject font-dark sbold uppercase">Dosya Düzenle</span>
					</div>
				</div>
				<div class="portlet-body form">
					<? require("islemsonucu.php"); ?>
					<form action="dosya_guncelle_islem.php?tablo=<?=$tablo?>&tablo_id=<?=$tablo_id?>&dosya_id=<?=$dosya_id?>" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
						<ul class="nav nav-tabs">
							<?php
							$diller=getLanguages();
							if (!is_null($diller)) {
								$x=0;
								foreach ($diller as $d) {
									$code=$d["language_code"];
									$active = $x==0 ? 'active' : '';
									?>
									<li class="<?=$active?>">
										<a href="#tab_<?php echo $code?>" data-toggle="tab"> <?php echo $d["language_name"]?> </a>
									</li>
									<?php 
									$x++; 
								}  
							} 
							?>
						</ul>
						<div class="tab-content">
							<?php
							
							if (!is_null($diller)) {
								$y=0;
								foreach ($diller as $d) {
									$active = $y==0 ? 'active in' : 'fade';
									$code=$d["language_code"];
									$dir=$code=="ar" ? 'dir="rtl"' : '';
									?>

									<div class="tab-pane <?=$active?>" id="tab_<?php echo $code?>">
										<div class="form-group">
											<label class="col-md-3 control-label">Dosya Adı <?php echo $d["language_name"]?></label>
											<div class="col-md-6">
												<input type="text" class="form-control ad" name="ad_<?php echo $code?>" id="<?php echo $code?>" value="<?php echo $dosya["ad_$code"]?>">
											</div>
										</div>
										<div class="form-group">
											<label for="exampleInputFile" class="col-md-3 control-label">Dosya <?php echo $d["language_name"]?></label>
											<div class="col-md-9">
												<input type="file" id="exampleInputFile" name="file_<?php echo $code?>">
												<?
												if (($dosya["dosya_$code"]!="") and file_exists("../upload/".$dosya["dosya_$code"]))
												{
													echo  '<br><a href="../upload/'.$dosya["dosya_$code"].'" target="_blank" class="btn btn-xs blue" title="Görüntüle"><i class="fa fa-file"></i> Görüntüle</a>';
												}
												?>
												<p class="help-block"> (.pdf) </p>

											</div>
										</div>
									</div>
									<?
									$y++;
								}
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