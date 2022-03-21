<?
defined('_ADMIN_GIRDI') or die('Erişim engellendi.');
if(canUserAccessAdminArea()) {
    $referans_id=$_GET['referans_id'];
    $sql="select * from Referans where referans_id='$referans_id'";
    $details = $db->get_row($sql,ARRAY_A);
    $sehir_id=$details['sehir'];
    $urun_id=$details['urun_id'];
?>
                        <h1 class="page-title"></h1>
                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="icon-plus font-dark"></i>
                                            <span class="caption-subject font-dark sbold uppercase">REFERANS GÜNCELLE</span>
                                        </div>
                                    </div>
                                    <div class="portlet-body form">
                                        <? require("islemsonucu.php"); ?>
                                        <form action="referans_guncelle_islem.php?referans_id=<?=$referans_id?>" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
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
                                                                            <input type="file" style="float: left;" name="resim">
                                                                            <?
                                                                              if (($details["thumb"]!="") and file_exists("../upload/".$details["thumb"]))
                                                                              {
                                                                                 $boyut=getimagesize("../upload/".$details["thumb"]);
                                                                                 $width=$boyut[0];
                                                                                 $height=$boyut[1];
                                                                                 $w=100;
                                                                                 $h=floor($w*$height/$width);
                                                                            ?>
                                                                            <img style="float: left;padding: 2px;margin: 2px;border: 1px solid #cccccc;background-color: #FFFFFF;" class="img" width="<?=$w ?>" height="<?=$h ?>" src="../upload/<?=$details["thumb"] ?>">
                                                                            <a href="urun_resim_sil.php?urun_id=<?=$details["urun_id"]?>" onclick="return confirmDel();">Sil</a>
                                                                            <?php } ?>
                                                                            <p class="help-block"> (200x100) </p>
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
                                                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" aria-expanded="false" href="#icerik<?php echo $code?>"> Referans <?php echo $d["language_name"]?> </a>
                                                                </h4>
                                                            </div>
                                                            <div id="icerik<?php echo $code?>" class="panel-collapse collapse" aria-expanded="true">
                                                                <div class="panel-body">
                                                                    <div class="form-group">
                                                                        <label class="col-md-2 control-label">Referans Adı</label>
                                                                        <div class="col-md-8">
                                                                            <input type="text" name="referans_ad_<?php echo $code?>" id="referans_ad_<?php echo $code?>" value="<?=$details["referans_ad_$code"]?>" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <!-- <div class="form-group last">
                                                                        <label class="control-label col-md-2">Referans İçerik</label>
                                                                        <div class="col-md-8">
                                                                            <textarea class="ckeditor form-control" name="referans_icerik_<?php echo $code?>" id="referans_icerik_<?php echo $code?>" rows="6" data-error-container="#editor2_error"><?=$details["referans_icerik_$code"]?></textarea>
                                                                            <div id="editor2_error"> </div>
                                                                        </div>
                                                                    </div> -->
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