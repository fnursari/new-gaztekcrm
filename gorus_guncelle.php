<?
defined('_ADMIN_GIRDI') or die('Erişim engellendi.');
if(canUserAccessAdminArea()) {
    $id=$_GET['id'];
    $sql="select * from musteri_gorusleri where id='$id'";
    $details = $db->get_row($sql,ARRAY_A);
?>
                        <h1 class="page-title"></h1>
                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="icon-note font-dark"></i>
                                            <span class="caption-subject font-dark sbold uppercase">MÜŞTERİ GÖRÜŞÜ GÜNCELLE</span>
                                        </div>
                                    </div>
                                    <div class="portlet-body form">
                                    	<? require("islemsonucu.php"); ?>
                                        <form action="gorus_guncelle_islem.php?id=<?=$id?>" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
                                            <div class="form-body">
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Müşteri İsmi</label>
                                                    <div class="col-md-8">
                                                        <input type="text" name="musteri_adi" id="musteri_adi" value="<?=$details["musteri_adi"]?>" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group last">
                                                    <label class="control-label col-md-2">Müşteri Görüşü Türkçe</label>
                                                    <div class="col-md-8">
                                                        <textarea class="ckeditor form-control" name="gorus_icerik_tr" id="gorus_icerik_tr" rows="6" data-error-container="#editor2_error"><?=$details["gorus_icerik_tr"]?></textarea>
                                                        <div id="editor2_error"> </div>
                                                    </div>
                                                </div>
                                                <div class="form-group last">
                                                    <label class="control-label col-md-2">Müşteri Görüşü İngilizce</label>
                                                    <div class="col-md-8">
                                                        <textarea class="ckeditor form-control" name="gorus_icerik_en" id="gorus_icerik_en" rows="6" data-error-container="#editor2_error"><?=$details["gorus_icerik_en"]?></textarea>
                                                        <div id="editor2_error"> </div>
                                                    </div>
                                                </div>
                                                <div class="form-group last">
                                                    <label class="control-label col-md-2">Müşteri Görüşü Rusça</label>
                                                    <div class="col-md-8">
                                                        <textarea class="ckeditor form-control" name="gorus_icerik_ru" id="gorus_icerik_ru" rows="6" data-error-container="#editor2_error"><?=$details["gorus_icerik_ru"]?></textarea>
                                                        <div id="editor2_error"> </div>
                                                    </div>
                                                </div>
                                                <div class="form-group last">
                                                    <label class="control-label col-md-2">Müşteri Görüşü Arapça</label>
                                                    <div class="col-md-8">
                                                        <textarea class="ckeditor form-control" name="gorus_icerik_ar" id="gorus_icerik_ar" rows="6" data-error-container="#editor2_error"><?=$details["gorus_icerik_ar"]?></textarea>
                                                        <div id="editor2_error"> </div>
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