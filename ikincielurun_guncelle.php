<?
defined('_ADMIN_GIRDI') or die('Erişim engellendi.');
if(canUserAccessAdminArea()) {
    $urun_id=$_GET['urun_id'];
    $sql="select * from ikincielurun where urun_id='$urun_id'";
    $details = $db->get_row($sql,ARRAY_A);
?>
                        <h1 class="page-title"></h1>
                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="icon-plus font-dark"></i>
                                            <span class="caption-subject font-dark sbold uppercase">Ürün Güncelle - <?=$details["urun_ad_$dfl"];?></span>
                                        </div>
                                    </div>
                                    <div class="portlet-body form">
                                        <? require("islemsonucu.php"); ?>
                                        <form action="ikincielurun_guncelle_islem.php?urun_id=<?=$urun_id?>" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
                                            <div class="tabbable-custom ">
                                                <ul class="nav nav-tabs ">
                                                    
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
                                                    <?php $x++; }  } ?>
                                                </ul>
                                                <div class="tab-content">
                                                    
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
                                                                <input type="file" style="float: left;" name="resim">
                                                                <?
                                                                if (($details["resim_kucuk"]!="") and file_exists("../upload/usedproduct/".$details["resim_kucuk"]))
                                                                {
                                                                    $boyut=getimagesize("../upload/usedproduct/".$details["resim_kucuk"]);
                                                                    $width=$boyut[0];
                                                                    $height=$boyut[1];
                                                                    $w=100;
                                                                    $h=floor($w*$height/$width);
                                                                    ?>
                                                                    <img style="float: left;padding: 2px;margin: 2px;border: 1px solid #cccccc;background-color: #FFFFFF;" class="img" width="<?=$w ?>" height="<?=$h ?>" src="../upload/usedproduct/<?=$details["resim_kucuk"] ?>">
                                                                <?php } ?>
                                                                <p class="help-block"> (800x600) </p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label"> Fiyatı</label>
                                                            <div class="col-md-3">
                                                                <input type="text" name="fiyat" id="fiyat"  class="form-control" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits': 3, 'digitsOptional': true, 'suffix': ' TL'" required="" value="<?=number_format($details["fiyat"],3)?>">
                                                                <span>(Ondalık ayracı olarak . giriniz)</span><br/>
                                                            </div>
                                                        </div>
                                                    <?php } ?>    

                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Ürün Adı</label>
                                                            <div class="col-md-8">
                                                                <input type="text" name="urun_ad_<?php echo $code?>" id="urun_ad_<?php echo $code?>"  value="<?=$details["urun_ad_$code"]?>" class="form-control">
                                                            </div>
                                                        </div>
                                                        
                                                        
                                                        
                                                        <div class="form-group last">
                                                            <label class="control-label col-md-2">Ürün İçerik</label>
                                                            <div class="col-md-8">
                                                                <textarea class="ckeditor form-control" name="aciklama_<?php echo $code?>" id="aciklama_<?php echo $code?>" rows="6" data-error-container="#editor2_error"><?=$details["aciklama_$code"]?></textarea>
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