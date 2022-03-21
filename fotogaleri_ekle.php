<?
defined('_ADMIN_GIRDI') or die('Erişim engellendi.');
if(canUserAccessAdminArea()) {
    $kategori_id=$_GET["kategori_id"];
?>
                        <h1 class="page-title"></h1>
                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="icon-plus font-dark"></i>
                                            <span class="caption-subject font-dark sbold uppercase">Resim Ekle</span>
                                        </div>
                                    </div>
                                    <div class="portlet-body form">
                                        <? require("islemsonucu.php"); ?>
                                        <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a href="#tab_1_1" data-toggle="tab"> Resim Yükle</a>
                                            </li>
                                            <li>
                                                <a href="#tab_1_2" data-toggle="tab"> Çoklu Yükleme </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane fade active in" id="tab_1_1">
                                                <form action="fotogaleri_ekle_islem.php" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
                                                    <div class="form-body">
                                                        <!-- <div class="form-group">
                                                            <input type="hidden" class="form-control" name="kategori_id" id="kategori_id" value="<?php echo $kategori_id?>">   
                                                        </div> -->
                                                        <?php
                                                            $diller=getLanguages();
                                                            if ($db->num_rows > 0) {
                                                                foreach ($diller as $d) {
                                                                    $code=$d["language_code"];
                                                        ?>
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">Resim Adı <?php echo $d["language_name"]?></label>
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control ad" name="fotogaleri_ad_<?php echo $code?>" id="<?php echo $code?>" >
                                                            </div>
                                                        </div>
                                                        <?php } } ?>
                                                        <div class="form-group">
                                                            <label for="exampleInputFile" class="col-md-3 control-label">Resim</label>
                                                            <div class="col-md-9">
                                                                <input type="file" id="exampleInputFile" name="file" required>
                                                                <p class="help-block"> (800x600) </p>
                                                            </div>
                                                        </div>
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
                                        <div class="tab-pane fade" id="tab_1_2">
                                            <div class="form-body toplu">
                                                <form action="fotogaleri_ekle_islem.php" method="post" enctype="multipart/form-data" class="dropzone dropzone-file-area" id="my-dropzone" style="width: 500px; margin-top: 50px;">
                                                    <h3 class="sbold">BURAYA SÜRÜKLEYİN</h3>
                                                        <input type="hidden" class="form-control" name="fotogaleri_ad_tr" id="ad_tr" value="Foto Galeri">
                                                        <input type="hidden" class="form-control" name="fotogaleri_ad_en" id="ad_en" value="Photo Gallery">
                                                        <input type="hidden" class="form-control" name="fotogaleri_ad_de" id="ad_de" value="Fotogalerie">
                                                        <input type="hidden" class="form-control" name="fotogaleri_ad_ru" id="ad_ru" value="Фотогалерея">
                                                        <input type="hidden" class="form-control" name="fotogaleri_ad_ar" id="ad_ar" value="معرض الصور">
                                                        <input type="hidden" class="form-control" name="fotogaleri_ad_fr" id="ad_fr" value="Photo Gallery">
                                                        <input type="hidden" class="form-control" name="fotogaleri_ad_es" id="ad_es" value="Photo Gallery">
                                                        <input type="hidden" class="form-control" name="fotogaleri_ad_sq" id="ad_sq" value="Photo Gallery">
                                                        <input type="hidden" class="form-control" name="kategori_id" id="kategori_id" value="<?php echo $kategori_id?>">   

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
<?php } ?>