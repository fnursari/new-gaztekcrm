<?php
defined('_ADMIN_GIRDI') or die('Erişim engellendi.');
if(canUserAccessAdminArea()) {
	$firma_id=makeSafe($_GET['firma_id']);
	$sql="select * from firma where firma_id='$firma_id'";
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
							<span class="caption-subject font-dark sbold uppercase">Firma Güncelle - <?=$details["firma_ad"];?></span>
						</div>
					</div>
					<div class="portlet-body form">
						<? require("islemsonucu.php"); ?>
						<form action="firma_guncelle_islem.php?firma_id=<?=$firma_id?>" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
							<div class="tabbable-custom ">
								<ul class="nav nav-tabs ">
									<li class="active">
										<a href="#tab_genel" data-toggle="tab"> Genel Bilgiler </a>
									</li>
									
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="tab_genel">
										<div class="form-group">
											<label class="col-md-2 control-label">Kategorisi</label>
											<div class="col-md-8">
												<? require("kategori_kombo.php");?>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-2 control-label">Resim</label>
											<div class="col-md-9">
												<input type="file" style="float: left;" name="resim">
												<?
												if (($details["resim_kucuk"]!="") and file_exists("../upload/product/".$details["resim_kucuk"]))
												{
													$boyut=getimagesize("../upload/product/".$details["resim_kucuk"]);
													$width=$boyut[0];
													$height=$boyut[1];
													$w=100;
													$h=floor($w*$height/$width);
													?>
													<img style="float: left;padding: 2px;margin: 2px;border: 1px solid #cccccc;background-color: #FFFFFF;" class="img" width="<?=$w ?>" height="<?=$h ?>" src="../upload/product/<?=$details["resim_kucuk"] ?>">
													<a href="urun_resim_sil.php?urun_id=<?=$details["urun_id"]?>" onclick="return confirmDel();">Sil</a>
												<?php } ?>
												<p class="help-block"> (1000x1000) </p>
											</div>
										</div>
                                                        <!-- <div class="form-group">
                                                            <label class="col-md-2 control-label">Grm Kodu</label>
                                                            <div class="col-md-8">
                                                                <input type="text" name="grm_no" id="grm_no" class="form-control" value="<?=$details["grm_no"]?>">
                                                            </div>
                                                        </div> -->
                                                        <!-- <div class="form-group">
                                                            <label class="col-md-2 control-label">Oem Kodu</label>
                                                            <div class="col-md-8">
                                                                <input type="text" name="oem_no" id="oem_no" class="form-control" value="<?=$details["oem_no"]?>">
                                                            </div>
                                                        </div> -->
                                                        <!-- <div class="form-group">
                                                            <label class="col-md-2 control-label">Cross Kodu</label>
                                                            <div class="col-md-8">
                                                                <input type="text" name="cross_no" id="cross_no" class="form-control" value="<?=$details["cross_no"]?>">
                                                            </div>
                                                        </div> -->
                                                        <!-- <div class="form-group">
                                                            <label class="col-md-2 control-label">Year</label>
                                                            <div class="col-md-8">
                                                                <input type="text" name="year" id="year" class="form-control" value="<?=$details["year"]?>">
                                                            </div>
                                                        </div> -->
                                                        <!-- <div class="form-group">
                                                            <label class="col-md-2 control-label">Position</label>
                                                            <div class="col-md-8">
                                                                <input type="text" name="position" id="position" class="form-control" value="<?=$details["position"]?>">
                                                            </div>
                                                        </div> -->
                                                        <!-- <div class="form-group">
                                                            <label class="col-md-2 control-label">Marka</label>
                                                            <div class="col-md-8">
                                                                <select name="marka" id="marka" class="form-control">
                                                                    <?php
                                                                    $markalar=getBrands();
                                                                    if ($db->num_rows > 0) {
                                                                        foreach ($markalar as $marka) {
                                                                    ?>
                                                                    <option value="<?php echo $marka["marka"]?>" <? if(rtrim($details["marka"])==rtrim($marka["marka"])) echo 'selected="selected"'?> ><?php echo $marka["marka"]?></option>
                                                                    <?php } } ?>
                                                                </select>
                                                            </div>
                                                        </div> -->
                                                        <!-- <div class="form-group">
                                                            <label class="col-md-2 control-label">Model</label>
                                                            <div class="col-md-8">
                                                                <select name="model" id="model" class="form-control">
                                                                    <option value="<?php echo $details["model"]?>" ><?php echo ($details["model"]) ?></option>
                                                                </select>
                                                                
                                                            </div>
                                                        </div> -->
                                                        
                                                        
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
                                                    				<label class="col-md-2 control-label">Ürün Adı</label>
                                                    				<div class="col-md-8">
                                                    					<input type="text" name="urun_ad_<?php echo $code?>" id="urun_ad_<?php echo $code?>"  value="<?=$details["urun_ad_$code"]?>" class="form-control">
                                                    				</div>
                                                    			</div>

                                                        <!-- <div class="form-group">
                                                            <label class="col-md-2 control-label">Seo Başlık</label>
                                                            <div class="col-md-8">
                                                                <input type="text" name="seo_baslik_<?php echo $code?>" id="seo_baslik_<?php echo $code?>" value="<?=$details["seo_baslik_$code"]?>" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Seo Keyword</label>
                                                            <div class="col-md-8">
                                                                <input type="text" name="seo_keyword_<?php echo $code?>" id="seo_keyword_<?php echo $code?>" value="<?=$details["seo_keyword_$code"]?>"  class="form-control" data-role="tagsinput">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Seo Description</label>
                                                            <div class="col-md-8">
                                                                <input type="text" name="seo_description_<?php echo $code?>" id="seo_description_<?php echo $code?>" value="<?=$details["seo_description_$code"]?>"  class="form-control">
                                                            </div>
                                                        </div> -->
                                                       <!--  <div class="form-group last">
                                                            <label class="control-label col-md-2">Ürün Kısa Açıklama</label>
                                                            <div class="col-md-8">
                                                                <textarea class="form-control" name="aciklama_<?php echo $code?>" id="aciklama_<?php echo $code?>" rows="4" ><?=$details["aciklama_$code"]?></textarea>
                                                            </div>
                                                        </div> -->
                                                        
                                                        <div class="form-group last">
                                                        	<label class="control-label col-md-2">Ürün İçerik</label>
                                                        	<div class="col-md-8">
                                                        		<textarea class="ckeditor form-control" name="urun_icerik_<?php echo $code?>" id="urun_icerik_<?php echo $code?>" rows="6" data-error-container="#editor2_error"><?=$details["urun_icerik_$code"]?></textarea>
                                                        		<div id="editor2_error"> </div>
                                                        	</div>
                                                        </div>
                                                        <div class="form-group last">
                                                        	<label class="control-label col-md-2">Teknik Özellikler</label>
                                                        	<div class="col-md-8">
                                                        		<textarea class="ckeditor form-control" name="teknik_tablo_<?php echo $code?>" id="teknik_tablo_<?php echo $code?>" rows="6" data-error-container="#editor2_error"><?=$details["teknik_tablo_$code"]?></textarea>
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
    <?php 

} 
} 
