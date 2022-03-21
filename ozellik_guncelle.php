<?php
defined('_ADMIN_GIRDI') or die('Erişim engellendi.');
if(canUserAccessAdminArea()) {
  $tablo=$_GET["tablo"];
  $tablo_id=$_GET["tablo_id"];
  $ozellik_id=$_GET["ozellik_id"];
  $sayfa_num=$_GET["sayfa_num"];
  $sql="select * from ozellik where ozellik_id='$ozellik_id'";
  $ozellik = $db->get_row($sql,ARRAY_A);
  switch($tablo)
  {
   case "haber" :
  {
    $sql="select * from haber where haber_id='$tablo_id'";
    $details = $db->get_row($sql,ARRAY_A);
    $title="Haber Özellikleri - ".$details["haber_baslik_$dfl"];
    $baslik_tr=$details["haber_baslik_tr"];
    $baslik_en=$details["haber_baslik_en"];
    $baslik_ru=$details["haber_baslik_ru"];
    $baslik_ar=$details["haber_baslik_ar"];
    $baslik_de=$details["haber_baslik_de"];
    $baslik_fr=$details["haber_baslik_fr"];
    $baslik_es=$details["haber_baslik_es"];
    $baslik_sq=$details["haber_baslik_sq"];
    break;
  }
  case "sayfa" :
  {
    $sql="select * from sayfa where sayfa_id='$tablo_id'";
    $details = $db->get_row($sql,ARRAY_A);
    $title="Sayfa Özellikleri - ".$details["sayfa_ad_$dfl"];
    $baslik_tr=$details["sayfa_ad_tr"];
    $baslik_en=$details["sayfa_ad_en"];
    $baslik_ru=$details["sayfa_ad_ru"];
    $baslik_ar=$details["sayfa_ad_ar"];
    $baslik_de=$details["sayfa_ad_de"];
    $baslik_fr=$details["sayfa_ad_fr"];
    $baslik_es=$details["sayfa_ad_es"];
    $baslik_sq=$details["sayfa_ad_sq"];
    break;
  }   
 
  case "urun" :
  {
    $sql="select * from urun where urun_id='$tablo_id'";
    $details = $db->get_row($sql,ARRAY_A);
    $title="Ürün Özellikleri - ".$details["urun_ad_$dfl"];
    $baslik_tr=$details["urun_ad_tr"];
    $baslik_en=$details["urun_ad_en"];
    $baslik_ru=$details["urun_ad_ru"];
    $baslik_ar=$details["urun_ad_ar"];
    $baslik_de=$details["urun_ad_de"];
    $baslik_fr=$details["urun_ad_fr"];
    $baslik_es=$details["urun_ad_es"];
    $baslik_sq=$details["urun_ad_sq"];
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
                                            <span class="caption-subject font-dark sbold uppercase">Özellik Düzenle</span>
                                        </div>
                                    </div>
                                    <div class="portlet-body form">
                                        <? require("islemsonucu.php"); ?>
                                        <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a href="#tab_1_1" data-toggle="tab"> Özellik Yükle</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane fade active in" id="tab_1_1">
                                                <form action="ozellik_guncelle_islem.php?tablo=<?=$tablo?>&tablo_id=<?=$tablo_id?>&ozellik_id=<?=$ozellik_id?>" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
                                                    <div class="form-body">
                                                        <?php
                                                            $diller=getLanguages();
                                                            if ($db->num_rows > 0) {
                                                                foreach ($diller as $d) {
                                                                    $code=$d["language_code"];
                                                        ?>
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">Başlık <?php echo $d["language_name"]?></label>
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control" name="title_<?php echo $code?>" id="title_<?php echo $code?>" value="<?=$ozellik["title_$code"]?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">Açıklama <?php echo $d["language_name"]?></label>
                                                            <div class="col-md-6">
                                                                <textarea class="form-control " name="description_<?php echo $code?>" id="<?php echo $code?>" required><?=$ozellik["description_$code"]?></textarea>
                                                            </div>
                                                        </div>
                                                        <?php } } ?>
                                                        
                                                        <div class="form-group">
                                                            <label for="exampleInputFile" class="col-md-3 control-label">Resim</label>
                                                            <div class="col-md-9">
                                                                <input type="file" style="float: left;" id="exampleInputFile" name="file">
                                                                <?
                                                                  if (($ozellik["resim"]!="") and file_exists("../upload/".$ozellik["resim"]))
                                                                  {
                                                                     $boyut=getimagesize("../upload/".$ozellik["resim"]);
                                                                     $width=$boyut[0];
                                                                     $height=$boyut[1];
                                                                     $w=100;
                                                                     $h=floor($w*$height/$width);
                                                                ?>
                                                                <img style="float: left;padding: 2px;margin: 2px;border: 1px solid #cccccc;background-color: #FFFFFF;" class="img" width="<?=$w ?>" height="<?=$h ?>" src="../upload/<?=$ozellik["resim"] ?>">
                                                                <?php } ?>
                                                                 <p class="help-block"> (.png - 128x128) </p>
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