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
        $title="Sayfa Resimleri - ".$details["sayfa_ad_$dfl"];
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
        $title="Ürün Resimleri - ".$details["urun_ad_$dfl"];
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
     case "departman" :
    {
        $sql="select * from departman where departman_id='$tablo_id'";
        $details = $db->get_row($sql,ARRAY_A);
        $title="Departman Resimleri - ".$details["departman_ad_$dfl"];
        $baslik_tr=$details["departman_ad_tr"];
        $baslik_en=$details["departman_ad_en"];

        $baslik_ru=$details["departman_ad_ru"];
        $baslik_ar=$details["departman_ad_ar"];
        $baslik_de=$details["departman_ad_de"];
        $baslik_es=$details["departman_ad_es"];
        $baslik_fr=$details["departman_ad_fr"];
        $baslik_sq=$details["departman_ad_sq"];
        $s="departman";
        break;
    }
    case "ikincielurun" :
    {
        $sql="select * from ikincielurun where urun_id='$tablo_id'";
        $details = $db->get_row($sql,ARRAY_A);
        $title="Ürün Resimleri - ".$details["urun_ad_$dfl"];
        $baslik_tr=$details["urun_ad_tr"];
        $baslik_en=$details["urun_ad_en"];

        $baslik_ru=$details["urun_ad_ru"];
        $baslik_ar=$details["urun_ad_ar"];
        $baslik_de=$details["urun_ad_de"];
        $baslik_es=$details["urun_ad_es"];
        $baslik_fr=$details["urun_ad_fr"];
        $baslik_sq=$details["urun_ad_sq"];
        $s="ikincielurun";
        break;
    }
    case "kategori" :
    {
        $sql="select * from urun_kategori where kategori_id='$tablo_id'";
        $details = $db->get_row($sql,ARRAY_A);
        $title="Kategori Resimleri - ".$details["kategori_ad_$dfl"];
        $baslik_tr=$details["kategori_ad_tr"];
        $baslik_en=$details["kategori_ad_en"];
        $baslik_ru=$details["kategori_ad_ru"];
        $baslik_ar=$details["kategori_ad_ar"];
        $baslik_fr=$details["kategori_ad_fr"];
        $baslik_de=$details["kategori_ad_de"];
        $baslik_es=$details["kategori_ad_es"];
        $baslik_sq=$details["kategori_ad_sq"];
        $s="kategori";
        break;
    }

    case "haber" :
    {
        $sql="select * from haber where haber_id='$tablo_id'";
        $details = $db->get_row($sql,ARRAY_A);
        $title="Haber Resimleri - ".$details["haber_baslik_$dfl"];
        $baslik_tr=$details["haber_baslik_tr"];
        $baslik_en=$details["haber_baslik_en"];
        $baslik_ru=$details["haber_baslik_ru"];
        $baslik_ar=$details["haber_baslik_ar"];
        $baslik_fr=$details["haber_baslik_fr"];
        $baslik_de=$details["haber_baslik_de"];
        $baslik_es=$details["haber_baslik_es"];
        $baslik_sq=$details["haber_baslik_sq"];
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
                    <span class="caption-subject font-dark sbold uppercase">Resim Ekle</span>
                </div>
            </div>
            <div class="portlet-body form">
                <? require("islemsonucu.php"); ?>
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#tab_1_1" data-toggle="tab"> Resim Yükle</a>
                    </li>
                    <li>
                        <a href="#tab_1_2" data-toggle="tab"> Çoklu Yükleme </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="tab_1_1">
                        <form action="resim_ekle_islem.php?tablo=<?=$tablo?>&tablo_id=<?=$tablo_id?>" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
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
                                            case 'sq':$baslik=$baslik_sq;break;        
                                            default:$url=$tr_url;break;
                                        }
                                        ?>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Resim Adı <?php echo $d["language_name"]?></label>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control ad" name="ad_<?php echo $code?>" id="<?php echo $code?>" value="<?php echo $baslik?>" required>
                                            </div>
                                        </div>
                                    <?php } } ?>

                                    <div class="form-group">
                                        <label for="exampleInputFile" class="col-md-3 control-label">Resim</label>
                                        <div class="col-md-9">
                                            <input type="file" id="exampleInputFile" name="file" required>
                                            <?php
                                            if ($tablo=="sayfa" && $tablo_id==6) {
                                                echo '<p class="help-block"> (514x552) </p>';
                                            }elseif ($tablo=="urun") {
                                                echo '<p class="help-block"> (1000x1000) </p>';
                                            } else {
                                                echo '<p class="help-block"> (800x600) </p>';
                                            }
                                        ?>

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
                    <div class="tab-pane fade" id="tab_1_2">
                        <div class="form-body toplu">
                            <form action="resim_ekle_islem.php?tablo=<?=$tablo?>&tablo_id=<?=$tablo_id?>" method="post" enctype="multipart/form-data" class="dropzone dropzone-file-area" id="my-dropzone" style="width: 500px; margin-top: 50px;">
                                <h3 class="sbold">BURAYA SÜRÜKLEYİN</h3>
                                <input type="hidden" class="form-control" name="ad_tr" id="ad_tr" value="<?=$baslik_tr?>">
                                <input type="hidden" class="form-control" name="ad_en" id="ad_en" value="<?=$baslik_en?>">
                                <input type="hidden" class="form-control" name="ad_ru" id="ad_ru" value="<?=$baslik_ru?>">
                                <input type="hidden" class="form-control" name="ad_ar" id="ad_ar" value="<?=$baslik_ar?>">
                                <input type="hidden" class="form-control" name="ad_de" id="ad_de" value="<?=$baslik_de?>">
                                <input type="hidden" class="form-control" name="ad_fr" id="ad_fr" value="<?=$baslik_fr?>">
                                <input type="hidden" class="form-control" name="ad_es" id="ad_es" value="<?=$baslik_es?>">
                                <input type="hidden" class="form-control" name="ad_sq" id="ad_sq" value="<?=$baslik_sq?>">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-image"></i>Yüklenmiş Resimler
                </div>
            </div>
            <div class="portlet-body">
                <form name="myform" class="pager-form" method="post" action="resim_toplu_sil.php?tablo=<?=$tablo?>&tablo_id=<?=$tablo_id?>">
                    <table class="table table-striped table-bordered table-hover" table-checkable order-column" id="sample_1">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th style="width: 20px;">
                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input type="checkbox" name="sil[]" class="group-checkable" data-set="#sample_1 .checkboxes" />
                                        <span></span>
                                    </label>
                                </th>

                                <th width="25%">Resim Adı</th>
                                <th width="20%">Resim</th>
                                <th width="20%">Sıra</th>
                                <th width="10%">Durum</th>
                                <th width="20%">İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $resimler=$db->get_results("SELECT * FROM resim WHERE tablo='$tablo' and tablo_id='$tablo_id'  ORDER BY sira",ARRAY_A);
                            if ($db->num_rows > 0) {
                                foreach ($resimler as $resim) {

                                    ?>
                                    <tr class="odd gradeX">
                                        <td><?=($sayfanum*$per_page)+($resim_x+1);?></td> 
                                        <td>
                                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                <input type="checkbox" name="sil[]" class="checkboxes" value="<?=$resim["resim_id"]?>" />
                                                <span></span>
                                            </label>
                                        </td>
                                        <td class="highlight"> <?=$resim["ad_$dfl"];?></td>
                                        <td>
                                            <?
                                            if (($resim["thumb"]!="") and file_exists("../upload/".$resim["thumb"]))
                                            {
                                                $boyut=getimagesize("../upload/".$resim["thumb"]);
                                                $width=$boyut[0];
                                                $height=$boyut[1];
                                                $w=75;
                                                $h=floor($w*$height/$width);
                                                echo  '<img width="'.$w.'" height="'.$h.'" src="../upload/'.$resim["thumb"].'"  class="img" />';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <input style="width: 80px;" class="form-control" contenteditable="true" onBlur="saveToDatabase(this,'sira','<?php echo $resim["resim_id"]; ?>','resim','resim_id')" onClick="showEdit(this);" type="text" name="sira" value="<?=$resim["sira"]; ?>">
                                        </td> 

                                        <td>
                                            <?php
                                            if ($resim["resim_aktif"]=="1") {
                                                $durum="Aktif";
                                                $color="green-meadow";
                                            } else{
                                                $durum="Pasif";
                                                $color="red";
                                            }                                                         
                                            ?>
                                            <a href="resim_durum.php?resim_id=<?=$resim["resim_id"]?>&resim_aktif=<?=$resim["resim_aktif"]?>&sayfanum=<?=$sayfanum?>&tablo=<?=$tablo?>&tablo_id=<?=$tablo_id?>" class="btn btn-sm <?=$color?>" title="Aktif/Pasif"><?=$durum?></a>
                                        </td>
                                        <td>

                                            <a href="admin.php?cmd=resim_guncelle&resim_id=<?=$resim["resim_id"]?>&sayfanum=<?=$sayfanum?>&tablo=<?=$tablo?>&tablo_id=<?=$tablo_id?>&s=<?=$s?>" class="btn btn-sm orange" title="Düzenle">
                                                <i class="fa fa-edit"></i> Düzenle
                                            </a> 
                                            <a href="resim_sil.php?resim_id=<?=$resim["resim_id"]?>&sayfanum=<?=$sayfanum?>&tablo=<?=$tablo?>&tablo_id=<?=$tablo_id?>" class="btn btn-sm red" title="Sil" onclick="return confirmDel();">
                                                <i class="fa fa-trash"></i> Sil
                                            </a>                                                                
                                        </td>
                                    </tr>
                                    <?php
                                    $resim_x++;
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