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
                                            <span class="caption-subject font-dark sbold uppercase">KATEGORİ EKLE</span>
                                        </div>
                                    </div>
                                    <div class="portlet-body form">
                                    	<? require("islemsonucu.php"); ?>
                                        <form action="proje_kategori_ekle_islem.php" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
                                            <div class="form-body">
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Ana Kategorisi</label>
                                                    <div class="col-md-8">
                                                        <? require("proje_kategori_kombo.php");?>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Kategori Adı Türkçe</label>
                                                    <div class="col-md-8">
                                                        <input type="text" name="kategori_ad_tr" id="kategori_ad_tr" class="form-control" required="">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Kategori Adı İngilizce</label>
                                                    <div class="col-md-8">
                                                        <input type="text" name="kategori_ad_en" id="kategori_ad_en" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Kategori Adı Rusça</label>
                                                    <div class="col-md-8">
                                                        <input type="text" name="kategori_ad_ru" id="kategori_ad_ru" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Kategori Adı Arapça</label>
                                                    <div class="col-md-8">
                                                        <input type="text" dir="rtl" name="kategori_ad_ar" id="kategori_ad_ar" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputFile" class="col-md-2 control-label">Resim</label>
                                                    <div class="col-md-9">
                                                        <input type="file" id="exampleInputFile" name="resim" required="">
                                                        <p class="help-block"> (800x600) </p>
                                                    </div>
                                                </div>
                                                <div class="form-group last">
                                                    <label class="control-label col-md-2">Açıklama Türkçe</label>
                                                    <div class="col-md-8">
                                                        <textarea class="ckeditor form-control" name="aciklama_tr" id="aciklama_tr" rows="6" data-error-container="#editor2_error"></textarea>
                                                        <div id="editor2_error"> </div>
                                                    </div>
                                                </div>
                                                <div class="form-group last">
                                                    <label class="control-label col-md-2">Açıklama İngilizce</label>
                                                    <div class="col-md-8">
                                                        <textarea class="ckeditor form-control" name="aciklama_en" id="aciklama_en" rows="6" data-error-container="#editor2_error"></textarea>
                                                        <div id="editor2_error"> </div>
                                                    </div>
                                                </div>
                                                <div class="form-group last">
                                                    <label class="control-label col-md-2">Açıklama Rusça</label>
                                                    <div class="col-md-8">
                                                        <textarea class="ckeditor form-control" name="aciklama_ru" id="aciklama_ru" rows="6" data-error-container="#editor2_error"></textarea>
                                                        <div id="editor2_error"> </div>
                                                    </div>
                                                </div>
                                                <div class="form-group last">
                                                    <label class="control-label col-md-2">Açıklama Arapça</label>
                                                    <div class="col-md-8">
                                                        <textarea class="ckeditor form-control" name="aciklama_ar" id="aciklama_ar" rows="6" data-error-container="#editor2_error"></textarea>
                                                        <div id="editor2_error"> </div>
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