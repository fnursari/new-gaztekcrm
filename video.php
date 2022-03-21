<?php
defined('_ADMIN_GIRDI') or die('Erişim engellendi.');
if(canUserAccessAdminArea()) {
  $tablo=$_GET["tablo"];
  $tablo_id=$_GET["tablo_id"];
  switch($tablo)
  {
      case "sayfa" :
      {
        $sql="select * from sayfa where sayfa_id='$tablo_id'";
        $details = $db->get_row($sql,ARRAY_A);
        $title="Sayfa Videoları - ".$details["sayfa_ad_$dfl"];
        $baslik_tr=$details["sayfa_ad_tr"];
        $baslik_en=$details["sayfa_ad_en"];
        $baslik_ru=$details["sayfa_ad_ru"];
        $baslik_ar=$details["sayfa_ad_ar"];
        $baslik_fr=$details["sayfa_ad_fr"];
        $baslik_de=$details["sayfa_ad_de"];
        $baslik_es=$details["sayfa_ad_es"];
        $baslik_sq=$details["sayfa_ad_sq"];
        $s="sayfa";
        break;
    }   

    case "urun" :
    {
        $sql="select * from urun where urun_id='$tablo_id'";
        $details = $db->get_row($sql,ARRAY_A);
        $title="Ürün Videoları - ".$details["urun_ad_$dfl"];
        $baslik_tr=$details["urun_ad_tr"];
        $baslik_en=$details["urun_ad_en"];

        $baslik_ru=$details["urun_ad_ru"];
        $baslik_ar=$details["urun_ad_ar"];
        $baslik_de=$details["urun_ad_de"];
        $baslik_es=$details["urun_ad_es"];
        $baslik_fr=$details["urun_ad_fr"];
        $baslik_sq=$details["urun_ad_sq"];
        $s="urun";
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
                                            <i class="icon-plus font-dark"></i>
                                            <span class="caption-subject font-dark sbold uppercase">Video Yükle</span>
                                        </div>
                                    </div>
                                    <div class="portlet-body form">
                                        <? require("islemsonucu.php"); ?>
                                        <div class="tab-content">
                                            <div class="tab-pane fade active in" id="tab_1_1">
                                                <form action="video_ekle_islem.php?tablo=<?=$tablo?>&tablo_id=<?=$tablo_id?>" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
                                                    <div class="form-body">
                                                        <?php
                                                            $diller=getLanguages();
                                                            if ($db->num_rows > 0) {
                                                                foreach ($diller as $d) {
                                                                    $code=$d["language_code"];
                                                                    switch ($code) {
                                                                        case 'tr':$baslik=$baslik_tr;break;
                                                                        case 'en':$baslik=$baslik_en;break;
                                                                        case 'ar':$baslik=$baslik_ar;break;
                                                                        case 'ru':$baslik=$baslik_ru;break;
                                                                        case 'de':$baslik=$baslik_de;break;
                                                                        case 'fr':$baslik=$baslik_fr;break;        
                                                                        case 'es':$baslik=$baslik_es;break;        
                                                                        default:$url=$tr_url;break;
                                                                      }
                                                        ?>
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">Video Adı <?php echo $d["language_name"]?></label>
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control ad" name="ad_<?php echo $code?>" id="<?php echo $code?>" value="<?php echo $baslik?>" required>
                                                            </div>
                                                        </div>
                                                        <?php } } ?>
                                                        <div class="form-group">
                                                            <label for="exampleInputFile" class="col-md-3 control-label">Video Resmi</label>
                                                            <div class="col-md-9">
                                                                <input type="file" id="exampleInputFile" name="file" required="">
                                                                <p class="help-block"> (800x600) </p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">Video Url</label>
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control" name="video_link" id="video_link" required="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-actions">
                                                        <div class="row">
                                                            <div class="col-md-offset-3 col-md-9">
                                                                <button type="submit" class="btn green">Yükle</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="portlet">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-image"></i>Yüklenmiş Videolar
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <form name="myform" class="pager-form" method="post" action="video_toplu_sil.php?tablo=<?=$tablo?>&tablo_id=<?=$tablo_id?>">
                                            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                                                <thead>
                                                    <tr>
                                                        <th width="5%">#</th>
                                                        <th style="width: 20px;">
                                                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                                <input type="checkbox" name="sil[]" class="group-checkable" data-set="#sample_1 .checkboxes" />
                                                                <span></span>
                                                            </label>
                                                        </th>
                                                        
                                                        <th width="25%">Video Adı</th>
                                                        <th width="20%">Video</th>
                                                        <th width="20%">Sıra</th>
                                                        <th width="10%">Durum</th>
                                                        <th width="20%">İşlemler</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    $videoler=$db->get_results("SELECT * FROM videolar WHERE tablo='$tablo' and tablo_id='$tablo_id'  ORDER BY sira",ARRAY_A);
                                                    if ($db->num_rows > 0) {
                                                        foreach ($videoler as $video) {
                                                      
                                                ?>
                                                    <tr class="odd gradeX">
                                                        <td><?=($sayfanum*$per_page)+($video_x+1);?></td> 
                                                        <td>
                                                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                                <input type="checkbox" name="sil[]" class="checkboxes" value="<?=$video["video_id"]?>" />
                                                                <span></span>
                                                            </label>
                                                        </td>
                                                        <td class="highlight"> <?=$video["ad_tr"];?></td>
                                                        <td>
                                                            <?
                                                               if (($video["thumb"]!="") and file_exists("../upload/".$video["thumb"]))
                                                               {
                                                                $boyut=getimagesize("../upload/".$video["thumb"]);
                                                                $width=$boyut[0];
                                                                $height=$boyut[1];
                                                                $w=75;
                                                                $h=floor($w*$height/$width);
                                                                echo  '<img width="'.$w.'" height="'.$h.'" src="../upload/'.$video["thumb"].'"  class="img" />';
                                                              }
                                                          ?>
                                                        </td>
                                                       <td>
                                                            <input style="width: 80px;" class="form-control" contenteditable="true" onBlur="saveToDatabase(this,'sira','<?php echo $video["video_id"]; ?>','videolar','video_id')" onClick="showEdit(this);" type="text" name="sira" value="<?=$video["sira"]; ?>">
                                                        </td> 
                                                        
                                                        <td>
                                                            <?php
                                                            if ($video["video_aktif"]=="1") {
                                                                $durum="Aktif";
                                                                $color="green-meadow";
                                                            } else{
                                                                $durum="Pasif";
                                                                $color="red";
                                                            }                                                         
                                                        ?>
                                                            <a href="video_durum.php?video_id=<?=$video["video_id"]?>&video_aktif=<?=$video["video_aktif"]?>&sayfanum=<?=$sayfanum?>&tablo=<?=$tablo?>&tablo_id=<?=$tablo_id?>" class="btn btn-sm <?=$color?>" title="Aktif/Pasif"><?=$durum?></a>
                                                        </td>
                                                        <td>
                                                        
                                                            <a href="admin.php?cmd=video_guncelle&video_id=<?=$video["video_id"]?>&sayfanum=<?=$sayfanum?>&tablo=<?=$tablo?>&tablo_id=<?=$tablo_id?>&s=sayfa" class="btn btn-sm orange" title="Düzenle">
                                                                <i class="fa fa-edit"></i> Düzenle
                                                            </a> 
                                                            <a href="video_sil.php?video_id=<?=$video["video_id"]?>&sayfanum=<?=$sayfanum?>&tablo=<?=$tablo?>&tablo_id=<?=$tablo_id?>" class="btn btn-sm red" title="Sil" onclick="return confirmDel();">
                                                                <i class="fa fa-trash"></i> Sil
                                                            </a>                                                                
                                                        </td>
                                                    </tr>
                                                <?php
                                                    $video_x++;
                                                    } 
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                            <div class="form-actions">
                                                <div class="row" style="float: left;margin-left: 270px;margin-top: -39px;">
                                                    <div class="col-md-12">
                                                        <button type="submit" class="btn red" onclick="return confirmDel();">Toplu Sil</button>
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