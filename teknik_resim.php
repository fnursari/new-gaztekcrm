<?php
defined('_ADMIN_GIRDI') or die('Erişim engellendi.');
if(canUserAccessAdminArea()) {
  $tablo=$_GET["tablo"];
  $tablo_id=$_GET["tablo_id"];
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
    $cmd="urun_guncelle";
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
                                            <span class="caption-subject font-dark sbold uppercase">Teknik Resim Ekle</span>
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
                                                <form action="teknik_resim_ekle_islem.php?tablo=<?=$tablo?>&tablo_id=<?=$tablo_id?>" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
                                                    <div class="form-body">
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">Resim Adı Türkçe</label>
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control" name="ad_tr" id="ad_tr" value="<?=$baslik_tr?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">Resim Adı İnglizce</label>
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control" name="ad_en" id="ad_en" value="<?=$baslik_en?>">
                                                            </div>
                                                        </div>
                                                        <!-- <div class="form-group">
                                                            <label class="col-md-3 control-label">Resim Adı Fransızca</label>
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control" name="ad_fr" id="ad_fr" value="<?=$baslik_fr?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">Resim Adı Rusça</label>
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control" name="ad_ru" id="ad_ru" value="<?=$baslik_ru?>">
                                                            </div>
                                                        </div> -->
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">Resim Adı Arapça</label>
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control" name="ad_ar" id="ad_ar" value="<?=$baslik_ar?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputFile" class="col-md-3 control-label">Resim</label>
                                                            <div class="col-md-9">
                                                                <input type="file" id="exampleInputFile" name="file" required>
                                                                <p class="help-block"> (800x600) </p>
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
                                            <div class="form-body">
                                                <form action="teknik_resim_ekle_islem.php?tablo=<?=$tablo?>&tablo_id=<?=$tablo_id?>" method="post" enctype="multipart/form-data" class="dropzone dropzone-file-area" id="my-dropzone" style="width: 500px; margin-top: 50px;">
                                                    <h3 class="sbold">BURAYA SÜRÜKLEYİN</h3>
                                                        <input type="hidden" class="form-control" name="ad_tr" id="ad_tr" value="<?=$baslik_tr?>">
                                                        <input type="hidden" class="form-control" name="ad_en" id="ad_en" value="<?=$baslik_en?>">
                                                        <!-- <input type="hidden" class="form-control" name="ad_ru" id="ad_ru" value="<?=$baslik_ru?>">
                                                        <input type="hidden" class="form-control" name="ad_ar" id="ad_ar" value="<?=$baslik_ar?>"> -->
                                                        <input type="hidden" class="form-control" name="ad_fr" id="ad_fr" value="<?=$baslik_fr?>">
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
                                            <i class="fa fa-image"></i>Yüklenmiş Teknik Resimler
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <form name="myform" class="pager-form" method="post" action="teknik_resim_toplu_sil.php?tablo=<?=$tablo?>&tablo_id=<?=$tablo_id?>">
                                            <table class="table table-striped table-bordered table-hover" table-checkable order-column" id="sample_1">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 20px;">#</th>
                                                        <th style="width: 20px;">
                                                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                                <input type="checkbox" name="sil[]" class="group-checkable" data-set="#sample_1 .checkboxes" />
                                                                <span></span>
                                                            </label>
                                                        </th>
                                                        
                                                        <th>Resim Adı</th>
                                                        <th>Resim</th>
                                                        <th style="width: 80px;">Sıra</th>
                                                        <th style="width: 200px;">İşlemler</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    $resimler=$db->get_results("SELECT * FROM teknik_resim WHERE tablo='$tablo' and tablo_id='$tablo_id'  ORDER BY sira",ARRAY_A);
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
                                                        <td class="highlight"> <?=$resim["ad_tr"];?></td>
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
                                                            <input style="width: 80px;" contenteditable="true" onBlur="saveToteknikresim(this,'sira','<?php echo $resim["resim_id"]; ?>')" onClick="showEdit(this);" type="text" name="sira" value="<?=$resim["sira"]; ?>">
                                                        </td> 
                                                        <td>
                                                        <?php
                                                            if ($resim["resim_aktif"]=="1") {
                                                                $durum="A";
                                                                $color="green";
                                                            } else{
                                                                $durum="P";
                                                                $color="red";
                                                            }                                                         
                                                        ?>
                                                            <a href="teknik_resim_durum.php?resim_id=<?=$resim["resim_id"]?>&resim_aktif=<?=$resim["resim_aktif"]?>&tablo=<?=$tablo?>&tablo_id=<?=$tablo_id?>" class="btn btn-sm <?=$color?>" title="Aktif/Pasif"><?=$durum?></a>
                                                            <a href="admin.php?cmd=teknik_resim_guncelle&resim_id=<?=$resim["resim_id"]?>&tablo=<?=$tablo?>&tablo_id=<?=$tablo_id?>" class="btn btn-sm yellow" title="Güncelle">
                                                                <i class="fa fa-edit"></i>
                                                            </a> 
                                                            <a href="teknik_resim_sil.php?resim_id=<?=$resim["resim_id"]?>&tablo=<?=$tablo?>&tablo_id=<?=$tablo_id?>" class="btn btn-sm red" title="Sil" onclick="return confirmDel();">
                                                                <i class="fa fa-trash"></i>
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