<?php
defined('_ADMIN_GIRDI') or die('Erişim engellendi.');
if(canUserAccessAdminArea()) {
  $tablo=$_GET["tablo"];
  $tablo_id=$_GET["tablo_id"];
  $video_id=$_GET["video_id"];
  $sql="select * from videolar where video_id='$video_id'";
  $video = $db->get_row($sql,ARRAY_A);
  switch($tablo)
  {
   case "hizmet" :
  {
    $sql="select * from hizmet where hizmet_id='$tablo_id'";
    $details = $db->get_row($sql,ARRAY_A);
    $title="Hizmet Videoları - ".$details["hizmet_ad"];
    break;
  }

}
?>
                        <h1 class="page-title"><?=$title?></h1>
                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="icon-note font-dark"></i>
                                            <span class="caption-subject font-dark sbold uppercase">Video Düzenle</span>
                                        </div>
                                    </div>
                                    <div class="portlet-body form">
                                        <? require("islemsonucu.php"); ?>
                                        <div class="tab-content">
                                            <div class="tab-pane fade active in" id="tab_1_1">
                                                <form action="videolar_guncelle_islem.php?tablo=<?=$tablo?>&tablo_id=<?=$tablo_id?>&video_id=<?=$video_id?>" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
                                                    <div class="form-body">
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">Video Adı</label>
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control" name="ad_tr" id="ad_tr" value="<?=$video["ad_tr"]?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputFile" class="col-md-3 control-label">Video Resmi</label>
                                                            <div class="col-md-9">
                                                                <input style="float: left;" type="file" id="exampleInputFile"  name="video">
                                                                <?
                                                                  if (($video["image"]!="") and file_exists("../upload/".$video["image"]))
                                                                  {
                                                                     $boyut=getimagesize("../upload/".$video["image"]);
                                                                     $width=$boyut[0];
                                                                     $height=$boyut[1];
                                                                     $w=100;
                                                                     $h=floor($w*$height/$width);
                                                                ?>
                                                                <img style="float: left;padding: 2px;margin: 2px;border: 1px solid #cccccc;background-color: #FFFFFF;" class="img" width="<?=$w ?>" height="<?=$h ?>" src="../upload/<?=$video["image"] ?>">
                                                                <?php } ?>
                                                                <p class="help-block"> (800x600) </p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">Embed Kod</label>
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control" name="embed" id="embed" required="" value="<?=$video["embed"]?>">
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
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
<?php } ?>