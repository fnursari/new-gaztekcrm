<?
defined('_ADMIN_GIRDI') or die('Erişim engellendi.');
if(canUserAccessAdminArea()) {
    $details =getSayfaBilgileri($_GET['sayfa_id']);
?>
                        <h1 class="page-title"></h1>
                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="icon-note font-dark"></i>
                                            <span class="caption-subject font-dark sbold uppercase">SAYFA GÜNCELLE - <?=$details["sayfa_ad_$dfl"];?></span>
                                        </div>
                                    </div>
                                    <div class="portlet-body form">
                                        <? require("islemsonucu.php"); ?>
                                        <form action="sayfa_guncelle_islem.php?sayfa_id=<?=$_GET['sayfa_id']?>" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
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
                                                    ?>
                                                    <div class="tab-pane <?php echo $y==0 ? 'active' : '' ?>" id="tab_<?php echo $code?>">
                                                        <?php
                                                            if($_SESSION["user"]["group"]=='root')  {
                                                        ?>
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Sayfa Adı <?php echo $d["language_name"]?></label>
                                                            <div class="col-md-8">
                                                                <input type="text" name="sayfa_ad_<?php echo $code?>" id="sayfa_ad_<?php echo $code?>" value="<?=$details["sayfa_ad_$code"]?>" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Sayfa Link <?php echo $d["language_name"]?></label>
                                                            <div class="col-md-8">
                                                                <input type="text" name="sayfa_link_<?php echo $code?>" id="sayfa_link_<?php echo $code?>" value="<?=$details["sayfa_link_$code"]?>" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Sayfa Etiket <?php echo $d["language_name"]?></label>
                                                            <div class="col-md-8">
                                                                <textarea name="sayfa_etiket_<?php echo $code?>" id="sayfa_etiket_<?php echo $code?>" class="form-control"><?=$details["sayfa_etiket_$code"]?></textarea>
                                                            </div>
                                                        </div>
                                                        <?php } ?>
                                                        <div class="form-group last">
                                                            <label class="control-label col-md-2">Sayfa İçerik <?php echo $d["language_name"]?></label>
                                                            <div class="col-md-8">
                                                                <textarea class="ckeditor form-control" name="icerik_<?php echo $code?>" id="icerik_<?php echo $code?>" rows="6" data-error-container="#editor2_error"><?=$details["icerik_$code"]?></textarea>
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