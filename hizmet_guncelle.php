<?
defined('_ADMIN_GIRDI') or die('Erişim engellendi.');
if(canUserAccessAdminArea()) {
    $hizmet_id=$_GET['hizmet_id'];
    $sql="select * from hizmet where hizmet_id='$hizmet_id'";
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
                                            <span class="caption-subject font-dark sbold uppercase">Hizmet Güncelle - <?=$details["hizmet_ad_tr"];?></span>
                                        </div>
                                    </div>
                                    <div class="portlet-body form">
                                        <? require("islemsonucu.php"); ?>
                                        <form action="hizmet_guncelle_islem.php?hizmet_id=<?=$hizmet_id?>" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
                                            <div class="form-body">
                                                
                                                                                                
                                                <div class="portlet-body">
                                                    <div class="panel-group accordion scrollable" id="accordion2">
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading">
                                                                <h4 class="panel-title">
                                                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#genel" aria-expanded="true"> Genel Tanımlamalar </a>
                                                                </h4>
                                                            </div>
                                                            <div id="genel" class="panel-collapse collapse in" aria-expanded="true">
                                                                <div class="panel-body">
                                                                    
                                                                    <div class="form-group">
                                                                        <label class="col-md-2 control-label">Resim</label>
                                                                        <div class="col-md-9">
                                                                            <input type="file" style="float: left;" name="resim">
                                                                            <?
                                                                              if (($details["resim_kucuk"]!="") and file_exists("../upload/hizmet/".$details["resim_kucuk"]))
                                                                              {
                                                                                 $boyut=getimagesize("../upload/hizmet/".$details["resim_kucuk"]);
                                                                                 $width=$boyut[0];
                                                                                 $height=$boyut[1];
                                                                                 $w=100;
                                                                                 $h=floor($w*$height/$width);
                                                                            ?>
                                                                            <img style="float: left;padding: 2px;margin: 2px;border: 1px solid #cccccc;background-color: #FFFFFF;" class="img" width="<?=$w ?>" height="<?=$h ?>" src="../upload/hizmet/<?=$details["resim_kucuk"] ?>">
                                                                            <a href="hizmet_resim_sil.php?hizmet_id=<?=$details["hizmet_id"]?>" onclick="return confirmDel();">Sil</a>
                                                                            <?php } ?>
                                                                            <p class="help-block"> (800x600) </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                            $diller=getLanguages();
                                                            if ($db->num_rows > 0) {
                                                                foreach ($diller as $d) {
                                                                    $code=$d["language_code"];
                                                        ?>
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading">
                                                                <h4 class="panel-title">
                                                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#seo<?php echo $code?>"> SEO <?php echo $d["language_name"]?> </a>
                                                                </h4>
                                                            </div>
                                                            <div id="seo<?php echo $code?>" class="panel-collapse collapse">
                                                                <div class="panel-body">
                                                                    <div class="form-group">
                                                                        <label class="col-md-2 control-label">Seo Başlık</label>
                                                                        <div class="col-md-8">
                                                                            <input type="text" name="seo_baslik_<?php echo $code?>" id="seo_baslik_<?php echo $code?>" value="<?=$details["seo_baslik_$code"]?>" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-md-2 control-label">Seo Keyword</label>
                                                                        <div class="col-md-8">
                                                                            <input type="text" name="seo_keyword_<?php echo $code?>" id="seo_keyword_<?php echo $code?>" value="<?=$details["seo_keyword_$code"]?>"  class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-md-2 control-label">Seo Description</label>
                                                                        <div class="col-md-8">
                                                                            <input type="text" name="seo_description_<?php echo $code?>" id="seo_description_<?php echo $code?>" value="<?=$details["seo_description_$code"]?>"  class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="control-label col-md-2">Etiket</label>
                                                                        <div class="col-md-8">
                                                                            <input type="text" class="form-control" name="seo_etiket_<?php echo $code?>" id="seo_etiket_<?php echo $code?>" value="<?=$details["seo_etiket_$code"]?>" >
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php } } ?>
                                                        <?php
                                                            $lang=getLanguages();
                                                            if ($db->num_rows > 0) {
                                                                foreach ($lang as $l) {
                                                                    $kod=$l["language_code"];
                                                        ?>
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading">
                                                                <h4 class="panel-title">
                                                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#icerik<?php echo $kod?>"> İçerik <?php echo $l["language_name"]?> </a>
                                                                </h4>
                                                            </div>
                                                            <div id="icerik<?php echo $kod?>" class="panel-collapse collapse">
                                                                <div class="panel-body">
                                                                    <div class="form-group">
                                                                        <label class="col-md-2 control-label">Hizmet Adı</label>
                                                                        <div class="col-md-8">
                                                                            <input type="text" name="hizmet_ad_<?php echo $kod?>" id="hizmet_ad_<?php echo $kod?>"  value="<?=$details["hizmet_ad_$kod"]?>" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-md-2 control-label">Hizmet Kısa Açıklama</label>
                                                                        <div class="col-md-8">
                                                                            <textarea name="aciklama_<?php echo $kod?>" id="aciklama_<?php echo $kod?>"  class="form-control"><?=$details["aciklama_$kod"]?></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group last">
                                                                        <label class="control-label col-md-2">Hizmet İçerik</label>
                                                                        <div class="col-md-8">
                                                                            <textarea class="ckeditor form-control" name="hizmet_icerik_<?php echo $kod?>" id="hizmet_icerik_<?php echo $kod?>" rows="6" data-error-container="#editor2_error"><?=$details["hizmet_icerik_$kod"]?></textarea>
                                                                            <div id="editor2_error"> </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php } } ?>
                                                        
                                                    </div>
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