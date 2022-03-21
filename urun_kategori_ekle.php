<?
defined('_ADMIN_GIRDI') or die('Erişim engellendi.');
if(canUserAccessAdminArea()) {
    $ana_id = $_GET["ana_id"];
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
                    <form action="urun_kategori_ekle_islem.php" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
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
                                        <?php $x++; }  } ?>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab_genel">
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Ana Kategorisi</label>
                                                <div class="col-md-8">
                                                    <? require("kategori_kombo.php");?>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputFile" class="col-md-2 control-label">Resim</label>
                                                <div class="col-md-9">
                                                    <input type="file" id="exampleInputFile" name="resim">
                                                    <p class="help-block"> (800x600) </p>
                                                </div>
                                            </div>
                                            <!-- <div class="form-group">
                                                <label for="exampleInputFile" class="col-md-2 control-label">Kategori Icon</label>
                                                <div class="col-md-9">
                                                    <input type="file" id="exampleInputFile" name="kategori_icon">
                                                    <p class="help-block"> (150x150 - .svg,.png uzantılı resim) </p>
                                                </div>
                                            </div> -->
                                                       <!--  <div class="form-group">
                                                            <label class="col-md-2 control-label">Kategori Icon</label>
                                                            <div class="col-md-8">
                                                                <input type="text" name="kategori_icon" id="kategori_icon" class="form-control" >
                                                            </div>
                                                        </div> -->
                                                        <!-- <div class="form-group">
                                                            <label class="col-md-2 control-label">Kategori Katalog</label>
                                                            <div class="col-md-8">
                                                                <input type="file" style="float: left;" name="katalog">
                                                                <p class="help-block"> (.pdf uzantılı dosya) </p>
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
                                                                    <label class="col-md-2 control-label">Kategori Adı</label>
                                                                    <div class="col-md-8">
                                                                        <input type="text" name="kategori_ad_<?php echo $code?>" id="kategori_ad_<?php echo $code?>" class="form-control" >
                                                                    </div>
                                                                </div>
                                                                <!-- <div class="form-group">
                                                                    <label class="col-md-2 control-label">Kategori Açıklama</label>
                                                                    <div class="col-md-8">
                                                                        <textarea name="aciklama_<?php echo $code?>" id="aciklama_<?php echo $code?>" class="form-control"></textarea>
                                                                    </div>
                                                                </div> -->
                                                                <!-- <div class="form-group">
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
                                                                </div> -->
                                                            </div>
                                                            <?php $y++; }  } ?>
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