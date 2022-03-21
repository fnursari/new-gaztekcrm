<?php
defined('_ADMIN_GIRDI') or die('Erişim engellendi.');
if(canUserAccessAdminArea()) {
  $tablo=$_GET["tablo"];
  $tablo_id=$_GET["tablo_id"];
  $urunvideo_id=$_GET["urunvideo_id"];
  $sayfa_num=$_GET["sayfa_num"];
  $sql="select * from urunvideo where urunvideo_id='$urunvideo_id'";
  $urunvideo = $db->get_row($sql,ARRAY_A);
  switch($tablo)
  {
   case "haber" :
  {
    $sql="select * from haber where haber_id='$tablo_id'";
    $details = $db->get_row($sql,ARRAY_A);
    $title="Haber Videoları - ".$details["haber_baslik_tr"];
    break;
  }

  case "sayfa" :
  {
    $sql="select * from sayfa where sayfa_id='$tablo_id'";
    $details = $db->get_row($sql,ARRAY_A);
    $title="Sayfa Videoları - ".$details["sayfa_ad_tr"];
    break;
  }   
 
  case "urun" :
  {
    $sql="select * from urun where urun_id='$tablo_id'";
    $details = $db->get_row($sql,ARRAY_A);
    $title="Ürün Videoları - ".$details["urun_ad_tr"];
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
                                                <form action="urunvideo_guncelle_islem.php?tablo=<?=$tablo?>&tablo_id=<?=$tablo_id?>&urunvideo_id=<?=$urunvideo_id?>" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
                                                    <div class="form-body">
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">Video Adı Türkçe</label>
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control" name="ad_tr" id="ad_tr" value="<?=$urunvideo["ad_tr"]?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputFile" class="col-md-3 control-label">Video Resmi</label>
                                                            <div class="col-md-9">
                                                                <input style="float: left;" type="file" id="exampleInputFile" name="urunvideo">
                                                                <?
                                                                  if (($urunvideo["image"]!="") and file_exists("../upload/".$urunvideo["image"]))
                                                                  {
                                                                     $boyut=getimagesize("../upload/".$urunvideo["image"]);
                                                                     $width=$boyut[0];
                                                                     $height=$boyut[1];
                                                                     $w=100;
                                                                     $h=floor($w*$height/$width);
                                                                ?>
                                                                <img style="float: left;padding: 2px;margin: 2px;border: 1px solid #cccccc;background-color: #FFFFFF;" class="img" width="<?=$w ?>" height="<?=$h ?>" src="../upload/<?=$urunvideo["image"] ?>">
                                                                <?php } ?>
                                                                <p class="help-block"> (800x600) </p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">Embed Kod</label>
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control" name="embed" id="embed" value="<?=$urunvideo["embed"]?>">
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