<?
defined('_ADMIN_GIRDI') or die('Erişim engellendi.');
if(canUserAccessAdminArea()) {
    $ana_id=$_GET["ana_id"];
    $anakategorioptiongoster=1;
    ?>
    <h1 class="page-title"></h1>
    <div class="row">
        <div class="col-md-12 ">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-plus font-dark"></i>
                        <span class="caption-subject font-dark sbold uppercase">ÜRÜN EKLE</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <? require("islemsonucu.php"); ?>
                    <form action="ikincielurun_ekle_islem.php" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
                        <div class="tabbable-custom ">
                            <ul class="nav nav-tabs ">
                                <!-- <li class="active">
                                    <a href="#tab_genel" data-toggle="tab"> Genel Tanımlar </a>
                                </li> -->
                                <?php
                                $diller=getLanguages();
                                if ($db->num_rows > 0) {
                                    $x=0;
                                    foreach ($diller as $d) {
                                        $code=$d["language_code"];
                                        ?>
                                        <li class="<?php echo $x==0 ? 'active' : '' ?>">
                                            <a href="#tab_<?php echo $code?>" data-toggle="tab"> <?php echo $d["language_name"]?> </a>
                                        </li>
                                        <?php 
                                        $x++; 
                                    }  
                                } 
                                ?>
                            </ul>
                            <div class="tab-content">
                                <!-- <div class="tab-pane active" id="tab_genel">

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Resim</label>
                                        <div class="col-md-9">
                                            <input type="file" name="resim">
                                            <p class="help-block"> (800x600) </p>
                                        </div>
                                    </div>
                                    
                                    
                                </div> -->
                                <?php
                                $diller=getLanguages();
                                if ($db->num_rows > 0) {
                                    $y=0;
                                    foreach ($diller as $d) {
                                        $code=$d["language_code"];
                                        $dir=$code=="ar" ? 'dir="rtl"' : '';
                                        ?>

                                        
                                        <div class="tab-pane <?php echo $y==0 ? 'active' : '' ?>" id="tab_<?php echo $code?>">
                                            <?php
                                            if ($y==0) {
                                                ?>
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Resim</label>
                                                    <div class="col-md-9">
                                                        <input type="file" name="resim">
                                                        <p class="help-block"> (800x600) </p>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label"> Fiyatı</label>
                                                    <div class="col-md-3">
                                                        <input type="text" name="fiyat" id="fiyat"  class="form-control" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits': 3, 'digitsOptional': true, 'suffix': ' TL'" required="">
                                                            <span>(Ondalık ayracı olarak . giriniz)</span><br/>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Ürün Adı</label>
                                                <div class="col-md-8">
                                                    <input type="text" name="urun_ad_<?php echo $code?>" id="urun_ad_<?php echo $code?>" class="form-control">
                                                </div>
                                            </div>
                                            

                                            <div class="form-group last">
                                                <label class="control-label col-md-2">Açıklama</label>
                                                <div class="col-md-8">
                                                    <textarea class="ckeditor form-control" name="aciklama_<?php echo $code?>" id="aciklama_<?php echo $code?>" rows="6" data-error-container="#editor2_error"></textarea>
                                                    <div id="editor2_error"> </div>
                                                </div>
                                            </div>

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