<?
defined('_ADMIN_GIRDI') or die('Erişim engellendi.');
if(canUserAccessAdminArea()) {
    $fotogaleri_id=$_GET['fotogaleri_id'];
    $sql="select * from fotogaleri where fotogaleri_id='$fotogaleri_id'";
    $details = $db->get_row($sql,ARRAY_A);  
?>
                        <h1 class="page-title"></h1>
                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="icon-note font-dark"></i>
                                            <span class="caption-subject font-dark sbold uppercase">Resim Güncelle - <?=$details["fotogaleri_ad_$dfl"];?></span>
                                        </div>
                                    </div>
                                    <div class="portlet-body form">
                                        <? require("islemsonucu.php"); ?>
                                        <form action="fotogaleri_guncelle_islem.php?fotogaleri_id=<?=$fotogaleri_id?>" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
                                            <div class="form-body">
                                                <?php
                                                    $diller=getLanguages();
                                                    if ($db->num_rows > 0) {
                                                        foreach ($diller as $d) {
                                                            $code=$d["language_code"];
                                                ?>
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Resim Adı <?php echo $d["language_name"]?></label>
                                                    <div class="col-md-8">
                                                        <input type="text" name="fotogaleri_ad_<?php echo $code?>" id="fotogaleri_ad_<?php echo $code?>" class="form-control" value="<?=$details["fotogaleri_ad_$code"]?>">
                                                    </div>
                                                </div>
                                                <?php } } ?>
                                                <div class="form-group">
                                                    <label for="exampleInputFile" class="col-md-2 control-label">Resim <p class="help-block"> (800x600) </p></label>
                                                    <div class="col-md-9">
                                                        <input type="file" style="float: left;" id="exampleInputFile" name="file">
                                                        <?
                                                        if (($details["image"]!="") and file_exists("../upload/photogallery/".$details["image"]))
                                                        {
                                                         $boyut=getimagesize("../upload/photogallery/".$details["image"]);
                                                         $width=$boyut[0];
                                                         $height=$boyut[1];
                                                         $w=100;
                                                         $h=floor($w*$height/$width);
                                                         ?>
                                                         <img style="float: left;padding: 2px;margin: 2px;border: 1px solid #cccccc;background-color: #FFFFFF;" class="img" width="<?=$w ?>" height="<?=$h ?>" src="../upload/photogallery/<?=$details["image"] ?>">
                                                         <?php } ?>
                                                        <p class="help-block"> (800x600) </p>
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