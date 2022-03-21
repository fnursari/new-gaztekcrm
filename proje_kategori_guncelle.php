<?
defined('_ADMIN_GIRDI') or die('Erişim engellendi.');
if(canUserAccessAdminArea()) {
   $kategori_id=$_GET['kategori_id'];
   $sql="select * from proje_kategori where kategori_id='$kategori_id'";
   $details = $db->get_row($sql,ARRAY_A);
   $ana_id=$details['ana_id'];
?>
                        <h1 class="page-title"></h1>
                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="icon-note font-dark"></i>
                                            <span class="caption-subject font-dark sbold uppercase">KATEGORİ GÜNCELLE - <?=$details["kategori_ad_tr"];?></span>
                                        </div>
                                    </div>
                                    <div class="portlet-body form">
                                    	<? require("islemsonucu.php"); ?>
                                        <form action="proje_kategori_guncelle_islem.php?kategori_id=<?=$kategori_id?>" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
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
                                                        <input type="text" name="kategori_ad_tr" id="kategori_ad_tr" class="form-control" value="<?=$details["kategori_ad_tr"]?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Kategori Adı İngilizce</label>
                                                    <div class="col-md-8">
                                                        <input type="text" name="kategori_ad_en" id="kategori_ad_en" class="form-control" value="<?=$details["kategori_ad_en"]?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Kategori Adı Rusça</label>
                                                    <div class="col-md-8">
                                                        <input type="text" name="kategori_ad_ru" id="kategori_ad_ru" class="form-control" value="<?=$details["kategori_ad_ru"]?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Kategori Adı Arapça</label>
                                                    <div class="col-md-8">
                                                        <input type="text" name="kategori_ad_ar" id="kategori_ad_ar" class="form-control" value="<?=$details["kategori_ad_ar"]?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputFile" class="col-md-2 control-label">Resim</label>
                                                    <div class="col-md-9">
                                                        <input style="float: left;" type="file" id="exampleInputFile" name="resim">
                                                        <?
                                                          if (($details["kategori_resim"]!="") and file_exists("../upload/".$details["kategori_resim"]))
                                                          {
                                                             $boyut=getimagesize("../upload/".$details["kategori_resim"]);
                                                             $width=$boyut[0];
                                                             $height=$boyut[1];
                                                             $w=100;
                                                             $h=floor($w*$height/$width);
                                                        ?>
                                                        <img style="float: left;padding: 2px;margin: 2px;border: 1px solid #cccccc;background-color: #FFFFFF;" class="img" width="<?=$w ?>" height="<?=$h ?>" src="../upload/<?=$details["kategori_resim"] ?>">
                                                        <a href="proje_kategori_resim_sil.php?kategori_id=<?=$details["kategori_id"]?>" onclick="return confirmDel();">Sil</a>
                                                        <?php } ?>
                                                        <p class="help-block"> (800x600) </p>
                                                    </div>
                                                </div>
                                                <div class="form-group last">
                                                    <label class="control-label col-md-2">Açıklama Türkçe</label>
                                                    <div class="col-md-8">
                                                        <textarea class="ckeditor form-control" name="aciklama_tr" id="aciklama_tr" rows="6" data-error-container="#editor2_error">
                                                            <?=$details["aciklama_tr"]?>
                                                        </textarea>
                                                        <div id="editor2_error"> </div>
                                                    </div>
                                                </div>
                                                <div class="form-group last">
                                                    <label class="control-label col-md-2">Açıklama İngilizce</label>
                                                    <div class="col-md-8">
                                                        <textarea class="ckeditor form-control" name="aciklama_en" id="aciklama_en" rows="6" data-error-container="#editor2_error">
                                                            <?=$details["aciklama_en"]?>
                                                        </textarea>
                                                        <div id="editor2_error"> </div>
                                                    </div>
                                                </div>
                                                <div class="form-group last">
                                                    <label class="control-label col-md-2">Açıklama Rusça</label>
                                                    <div class="col-md-8">
                                                        <textarea class="ckeditor form-control" name="aciklama_ru" id="aciklama_ru" rows="6" data-error-container="#editor2_error">
                                                            <?=$details["aciklama_ru"]?>
                                                        </textarea>
                                                        <div id="editor2_error"> </div>
                                                    </div>
                                                </div>
                                                <div class="form-group last">
                                                    <label class="control-label col-md-2">Açıklama Arapça</label>
                                                    <div class="col-md-8">
                                                        <textarea class="ckeditor form-control" name="aciklama_ar" id="aciklama_ar" rows="6" data-error-container="#editor2_error">
                                                            <?=$details["aciklama_ar"]?>
                                                        </textarea>
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