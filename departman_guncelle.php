<?
defined('_ADMIN_GIRDI') or die('Erişim engellendi.');
if(canUserAccessAdminArea()) {
    $departman_id=$_GET['departman_id'];
    $sql="select * from departman where departman_id='$departman_id'";
    $details = $db->get_row($sql,ARRAY_A);
    $ana_id=$details['kategori_id'];
?>
                        <h1 class="page-title"></h1>
                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="icon-plus font-dark"></i>
                                            <span class="caption-subject font-dark sbold uppercase">Departman Güncelle - <?=$details["departman_ad_$dfl"];?></span>
                                        </div>
                                    </div>
                                    <div class="portlet-body form">
                                        <? require("islemsonucu.php"); ?>
                                        <form action="departman_guncelle_islem.php?departman_id=<?=$departman_id?>" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
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
                                                            <label class="col-md-2 control-label">Resim</label>
                                                            <div class="col-md-9">
                                                                <input type="file" style="float: left;" name="resim">
                                                                <?
                                                                if (($details["resim_kucuk"]!="") and file_exists("../upload/departments/".$details["resim_kucuk"]))
                                                                {
                                                                    $boyut=getimagesize("../upload/departments/".$details["resim_kucuk"]);
                                                                    $width=$boyut[0];
                                                                    $height=$boyut[1];
                                                                    $w=100;
                                                                    $h=floor($w*$height/$width);
                                                                    ?>
                                                                    <img style="float: left;padding: 2px;margin: 2px;border: 1px solid #cccccc;background-color: #FFFFFF;" class="img" width="<?=$w ?>" height="<?=$h ?>" src="../upload/departments/<?=$details["resim_kucuk"] ?>">
                                                                    <a href="departman_resim_sil.php?departman_id=<?=$details["departman_id"]?>" onclick="return confirmDel();">Sil</a>
                                                                <?php } ?>
                                                                <p class="help-block"> (800x600) </p>
                                                            </div>
                                                        </div>
                                                       
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
                                                            <label class="col-md-2 control-label">Departman Adı</label>
                                                            <div class="col-md-8">
                                                                <input type="text" name="departman_ad_<?php echo $code?>" id="departman_ad_<?php echo $code?>"  value="<?=$details["departman_ad_$code"]?>" class="form-control">
                                                            </div>
                                                        </div>
                                                    
                                                        
                                                        <div class="form-group last">
                                                            <label class="control-label col-md-2">Departman İçerik</label>
                                                            <div class="col-md-8">
                                                                <textarea class="ckeditor form-control" name="departman_icerik_<?php echo $code?>" id="departman_icerik_<?php echo $code?>" rows="6" data-error-container="#editor2_error"><?=$details["departman_icerik_$code"]?></textarea>
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