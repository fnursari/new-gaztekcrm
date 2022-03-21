<?php
defined('_ADMIN_GIRDI') or die('Erişim engellendi.');
if(canUserAccessAdminArea()) {
  $tablo=$_GET["tablo"];
  $tablo_id=$_GET["tablo_id"];
  $resim_id=$_GET["resim_id"];
  $sql="select * from teknik_resim where resim_id='$resim_id'";
  $resim = $db->get_row($sql,ARRAY_A);
  switch($tablo)
  {
  
 
  case "urun" :
  {
    $sql="select * from urun where urun_id='$tablo_id'";
    $details = $db->get_row($sql,ARRAY_A);
    $title="Ürüne ait teknik resimler - ".$details["urun_ad_tr"];
    $baslik_tr=$details["urun_ad_tr"];
    $baslik_en=$details["urun_ad_en"];
    $baslik_ru=$details["urun_ad_ru"];
    $baslik_ar=$details["urun_ad_ar"];
    $baslik_fr=$details["urun_ad_fr"];
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
                                            <span class="caption-subject font-dark sbold uppercase">Resim Düzenle</span>
                                        </div>
                                    </div>
                                    <div class="portlet-body form">
                                        <? require("islemsonucu.php"); ?>
                                        <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a href="#tab_1_1" data-toggle="tab"> Resim Yükle</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane fade active in" id="tab_1_1">
                                                <form action="teknik_resim_guncelle_islem.php?tablo=<?=$tablo?>&tablo_id=<?=$tablo_id?>&resim_id=<?=$resim_id?>" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
                                                    <div class="form-body">
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">Resim Adı Türkçe</label>
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control" name="ad_tr" id="ad_tr" value="<?=$resim["ad_tr"]?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">Resim Adı İngilizce</label>
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control" name="ad_en" id="ad_en" value="<?=$resim["ad_en"]?>">
                                                            </div>
                                                        </div>
                                                        <!-- <div class="form-group">
                                                            <label class="col-md-3 control-label">Resim Adı Fransızca</label>
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control" name="ad_fr" id="ad_fr" value="<?=$resim["ad_fr"]?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">Resim Adı Rusça</label>
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control" name="ad_ru" id="ad_ru" value="<?=$resim["ad_ru"]?>">
                                                            </div>
                                                        </div> -->
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">Resim Adı Arapça</label>
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control" name="ad_ar" id="ad_ar" value="<?=$resim["ad_ar"]?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputFile" class="col-md-3 control-label">Resim</label>
                                                            <div class="col-md-9">
                                                                <input type="file" style="float: left;" id="exampleInputFile" name="file">
                                                                <?
                                                                  if (($resim["image"]!="") and file_exists("../upload/".$resim["image"]))
                                                                  {
                                                                     $boyut=getimagesize("../upload/".$resim["image"]);
                                                                     $width=$boyut[0];
                                                                     $height=$boyut[1];
                                                                     $w=100;
                                                                     $h=floor($w*$height/$width);
                                                                ?>
                                                                <img style="float: left;padding: 2px;margin: 2px;border: 1px solid #cccccc;background-color: #FFFFFF;" class="img" width="<?=$w ?>" height="<?=$h ?>" src="../upload/<?=$resim["image"] ?>">
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
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
<?php } ?>