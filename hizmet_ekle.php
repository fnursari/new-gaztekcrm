<?
defined('_ADMIN_GIRDI') or die('Erişim engellendi.');
if(canUserAccessAdminArea()) {
    $anakategorioptiongoster=1;
?>
                        <h1 class="page-title"></h1>
                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="icon-plus font-dark"></i>
                                            <span class="caption-subject font-dark sbold uppercase">HİZMET EKLE</span>
                                        </div>
                                    </div>
                                    <div class="portlet-body form">
                                        <? require("islemsonucu.php"); ?>
                                        <form action="hizmet_ekle_islem.php" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
                                            <div class="form-body">
                                                
                                                                                                
                                                <div class="portlet-body">
                                                    <div class="panel-group accordion scrollable" id="accordion2">
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading">
                                                                <h4 class="panel-title">
                                                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2"  href="#genel" aria-expanded="true"> Genel Tanımlamalar </a>
                                                                </h4>
                                                            </div>
                                                            <div id="genel" class="panel-collapse collapse in" aria-expanded="true">
                                                                <div class="panel-body">
                                                                    <div class="form-group">
                                                                        <label class="col-md-2 control-label">Resim</label>
                                                                        <div class="col-md-9">
                                                                            <input type="file" name="resim">
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
                                                                            <input type="text" name="seo_baslik_<?php echo $code?>" id="seo_baslik_<?php echo $code?>" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-md-2 control-label">Seo Keyword</label>
                                                                        <div class="col-md-8">
                                                                            <input type="text" name="seo_keyword_<?php echo $code?>" id="seo_keyword_<?php echo $code?>"  class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-md-2 control-label">Seo Description</label>
                                                                        <div class="col-md-8">
                                                                            <input type="text" name="seo_description_<?php echo $code?>" id="seo_description_<?php echo $code?>"  class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="control-label col-md-2">Etiket</label>
                                                                        <div class="col-md-8">
                                                                            <input type="text" class="form-control" name="seo_etiket_<?php echo $code?>" id="seo_etiket_<?php echo $code?>" >
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
                                                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" aria-expanded="false" href="#icerik<?php echo $kod?>"> İçerik <?php echo $l["language_name"]?> </a>
                                                                </h4>
                                                            </div>
                                                            <div id="icerik<?php echo $kod?>" class="panel-collapse collapse" aria-expanded="false">
                                                                <div class="panel-body">
                                                                    <div class="form-group">
                                                                        <label class="col-md-2 control-label">Hizmet Adı</label>
                                                                        <div class="col-md-8">
                                                                            <input type="text" name="hizmet_ad_<?php echo $kod?>" id="hizmet_ad_<?php echo $kod?>" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-md-2 control-label">Hizmet Kısa Açıklama</label>
                                                                        <div class="col-md-8">
                                                                            <textarea name="aciklama_<?php echo $kod?>" id="aciklama_<?php echo $kod?>"  class="form-control"></textarea>
                                                                        </div>
                                                                    </div>
                                                                     
                                                                    <div class="form-group last">
                                                                        <label class="control-label col-md-2">Hizmet İçerik</label>
                                                                        <div class="col-md-8">
                                                                            <textarea class="ckeditor form-control" name="hizmet_icerik_<?php echo $kod?>" id="hizmet_icerik_<?php echo $kod?>" rows="6" data-error-container="#editor2_error"></textarea>
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