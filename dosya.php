<?php
defined('_ADMIN_GIRDI') or die('Erişim engellendi.');
if(canUserAccessAdminArea()) {
	$tablo=$_GET["tablo"];
	$tablo_id=$_GET["tablo_id"];
	switch($tablo)
	{
		case "sayfa" :
		{
			$sql="select * from sayfa where sayfa_id='$tablo_id'";
			$details = $db->get_row($sql,ARRAY_A);
			$title="Sayfa Dosyaları - ".$details["sayfa_ad_$dfl"];
			$baslik_tr=$details["sayfa_ad_tr"];
			$baslik_en=$details["sayfa_ad_en"];
			$baslik_ru=$details["sayfa_ad_ru"];
			$baslik_ar=$details["sayfa_ad_ar"];
			$baslik_fr=$details["sayfa_ad_fr"];
			$baslik_de=$details["sayfa_ad_de"];
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
			$baslik_es=$details["urun_ad_es"];
			$baslik_fr=$details["urun_ad_fr"];
			$baslik_sq=$details["urun_ad_sq"];
			$s="urun";
			break;
		}

		case "kategori" :
		{
			$sql="select * from urun_kategori where kategori_id='$tablo_id'";
			$details = $db->get_row($sql,ARRAY_A);
			$title="Kategori Dosyaları - ".$details["kategori_ad_$dfl"];
			$baslik_tr=$details["kategori_ad_tr"];
			$baslik_en=$details["kategori_ad_en"];
			$baslik_ru=$details["kategori_ad_ru"];
			$baslik_ar=$details["kategori_ad_ar"];
			$baslik_fr=$details["kategori_ad_fr"];
			$baslik_de=$details["kategori_ad_de"];
			$baslik_es=$details["kategori_ad_es"];
			$baslik_sq=$details["kategori_ad_sq"];
			$s="kategori";
			break;
		}

		case "haber" :
		{
			$sql="select * from haber where haber_id='$tablo_id'";
			$details = $db->get_row($sql,ARRAY_A);
			$title="Haber Dosyaları - ".$details["haber_baslik_$dfl"];
			$baslik_tr=$details["haber_baslik_tr"];
			$baslik_en=$details["haber_baslik_en"];
			$baslik_ru=$details["haber_baslik_ru"];
			$baslik_ar=$details["haber_baslik_ar"];
			$baslik_fr=$details["haber_baslik_fr"];
			$baslik_de=$details["haber_baslik_de"];
			$baslik_es=$details["haber_baslik_es"];
			$baslik_sq=$details["haber_baslik_sq"];
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
						<i class="icon-plus font-dark"></i>
						<span class="caption-subject font-dark sbold uppercase">Dosya Ekle</span>
					</div>
				</div>
				<div class="portlet-body form">
					<? require("islemsonucu.php"); ?>
					<form action="dosya_ekle_islem.php?tablo=<?=$tablo?>&tablo_id=<?=$tablo_id?>" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
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
												<input type="text" class="form-control ad" name="ad_<?php echo $code?>" id="<?php echo $code?>" value="<?php echo ${"baslik_" . $code}; ?>">
											</div>
										</div>
										<div class="form-group">
											<label for="exampleInputFile" class="col-md-3 control-label">Dosya <?php echo $d["language_name"]?></label>
											<div class="col-md-9">
												<input type="file" id="exampleInputFile" name="file_<?php echo $code?>">
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
									<button type="submit" class="btn green">Yükle</button>
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
						<i class="fa fa-image"></i>Yüklenmiş Dosyaler
					</div>
				</div>
				<div class="portlet-body">
					<form name="myform" class="pager-form" method="post" action="dosya_toplu_sil.php?tablo=<?=$tablo?>&tablo_id=<?=$tablo_id?>">
						<table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
							<thead>
								<tr>
									<th width="5%">#</th>
									<th style="width: 20px;">
										<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
											<input type="checkbox" name="sil[]" class="group-checkable" data-set="#sample_1 .checkboxes" />
											<span></span>
										</label>
									</th>

									<th width="25%">Dosya Adı</th>
									<th width="20%">Dosya</th>
									<th width="20%">Sıra</th>
									<th width="10%">Durum</th>
									<th width="20%">İşlemler</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$dosyaler=$db->get_results("SELECT * FROM dosya WHERE tablo='$tablo' and tablo_id='$tablo_id'  ORDER BY sira",ARRAY_A);
								if ($db->num_rows > 0) {
									foreach ($dosyaler as $dosya) {

										?>
										<tr class="odd gradeX">
											<td><?=($sayfanum*$per_page)+($dosya_x+1);?></td> 
											<td>
												<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
													<input type="checkbox" name="sil[]" class="checkboxes" value="<?=$dosya["dosya_id"]?>" />
													<span></span>
												</label>
											</td>
											<td class="highlight">
												<?
												if(!is_null($diller)) {
													foreach ($diller as $d) {
														$code=$d["language_code"];
														echo $dosya["ad_$code"].'<br>';
													}
												}
												?>
											</td>
											<td>
												<?
												if(!is_null($diller)) {
													foreach ($diller as $d) {
														$code=$d["language_code"];
														if (($dosya["dosya_$code"]!="") and file_exists("../upload/".$dosya["dosya_$code"]))
														{
															echo  '<a href="../upload/'.$dosya["dosya_$code"].'" target="_blank" class="btn btn-xs btn-default" title="Görüntüle"><i class="fa fa-file"></i> '.$dosya["dosya_$code"].'</a><br>';
														}
													}
												}
												?>
											</td>
											<td>
												<input style="width: 80px;" class="form-control" contenteditable="true" onBlur="saveToDatabase(this,'sira','<?php echo $dosya["dosya_id"]; ?>','dosya','dosya_id')" onClick="showEdit(this);" type="text" name="sira" value="<?=$dosya["sira"]; ?>">
											</td> 

											<td>
												<?php
												if ($dosya["dosya_aktif"]=="1") {
													$durum="Aktif";
													$color="green-meadow";
												} else{
													$durum="Pasif";
													$color="red";
												}                                                         
												?>
												<a href="dosya_durum.php?dosya_id=<?=$dosya["dosya_id"]?>&dosya_aktif=<?=$dosya["dosya_aktif"]?>&sayfanum=<?=$sayfanum?>&tablo=<?=$tablo?>&tablo_id=<?=$tablo_id?>" class="btn btn-sm <?=$color?>" title="Aktif/Pasif"><?=$durum?></a>
											</td>
											<td>

												<a href="admin.php?cmd=dosya_guncelle&dosya_id=<?=$dosya["dosya_id"]?>&sayfanum=<?=$sayfanum?>&tablo=<?=$tablo?>&tablo_id=<?=$tablo_id?>&s=<?=$tablo?>" class="btn btn-sm orange" title="Düzenle">
													<i class="fa fa-edit"></i> Düzenle
												</a> 
												<a href="dosya_sil.php?dosya_id=<?=$dosya["dosya_id"]?>&sayfanum=<?=$sayfanum?>&tablo=<?=$tablo?>&tablo_id=<?=$tablo_id?>" class="btn btn-sm red" title="Sil" onclick="return confirmDel();">
													<i class="fa fa-trash"></i> Sil
												</a>                                                                
											</td>
										</tr>
										<?php
										$dosya_x++;
									} 
								}
								?>
							</tbody>
						</table>
						<div class="form-actions">
							<div class="row" style="float: left;margin-left: 270px;margin-top: -39px;">
								<div class="col-md-12">
									<button type="submit" class="btn red" onclick="return confirmDel();">Toplu Sil</button>
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