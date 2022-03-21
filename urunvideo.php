<?php
defined('_ADMIN_GIRDI') or die('Erişim engellendi.');
if(canUserAccessAdminArea()) {
  $tablo=$_GET["tablo"];
  $tablo_id=$_GET["tablo_id"];
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
                                            <i class="icon-plus font-dark"></i>
                                            <span class="caption-subject font-dark sbold uppercase">Video Yükle</span>
                                        </div>
                                    </div>
                                    <div class="portlet-body form">
                                        <? require("islemsonucu.php"); ?>
                                        <div class="tab-content">
                                            <div class="tab-pane fade active in" id="tab_1_1">
                                                <form action="urunvideo_ekle_islem.php?tablo=<?=$tablo?>&tablo_id=<?=$tablo_id?>" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
                                                    <div class="form-body">
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">Video Adı Türkçe</label>
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control" name="ad_tr" id="ad_tr">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputFile" class="col-md-3 control-label">Video Resmi</label>
                                                            <div class="col-md-9">
                                                                <input type="file" id="exampleInputFile" name="urunvideo">
                                                                <p class="help-block"> (800x600) </p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">Embed Kod</label>
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control" name="embed" id="embed">
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
                                            <i class="fa fa-play"></i>Yüklenmiş Videoler
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <form name="myform" class="pager-form" method="post" action="urunvideo_toplu_sil.php?tablo=<?=$tablo?>&tablo_id=<?=$tablo_id?>">
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
                                                        
                                                        <th>Video Adı</th>
                                                        <th>Video</th>
                                                        <th style="width: 80px;">Sıra</th>
                                                        <th style="width: 200px;">İşlemler</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    $urunvideoler=$db->get_results("SELECT * from urunvideo where tablo='$tablo' and tablo_id='$tablo_id' order by sira",ARRAY_A);
                                                    if ($db->num_rows > 0) {
                                                        foreach ($urunvideoler as $urunvideo) {
                                                      
                                                ?>
                                                    <tr class="odd gradeX">
                                                        <td><?=($sayfanum*$per_page)+($urunvideo_x+1);?></td> 
                                                        <td>
                                                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                                <input type="checkbox" name="sil[]" class="checkboxes" value="<?=$urunvideo["urunvideo_id"]?>" />
                                                                <span></span>
                                                            </label>
                                                        </td>
                                                        <td class="highlight"> <?=$urunvideo["ad_tr"];?></td>
                                                        <td>
                                                            <?
                                                               if (($urunvideo["thumb"]!="") and file_exists("../upload/".$urunvideo["thumb"]))
                                                               {
                                                                $boyut=getimagesize("../upload/".$urunvideo["thumb"]);
                                                                $width=$boyut[0];
                                                                $height=$boyut[1];
                                                                $w=75;
                                                                $h=floor($w*$height/$width);
                                                                echo  '<img width="'.$w.'" height="'.$h.'" src="../upload/'.$urunvideo["thumb"].'"  class="img" />';
                                                              }
                                                          ?>
                                                        </td>
                                                       <td>
                                                            <input style="width: 80px;" contenteditable="true" onBlur="saveDatabase(this,'sira','<?php echo $urunvideo["urunvideo_id"]; ?>')" onClick="showEdit(this);" type="text" name="sira" value="<?=$urunvideo["sira"]; ?>">
                                                        </td> 
                                                        <td>
                                                        <?php
                                                            if ($urunvideo["urunvideo_aktif"]=="1") {
                                                                $durum="A";
                                                                $color="green";
                                                            } else{
                                                                $durum="P";
                                                                $color="red";
                                                            }                                                         
                                                        ?>
                                                            <a href="urunvideo_durum.php?urunvideo_id=<?=$urunvideo["urunvideo_id"]?>&urunvideo_aktif=<?=$urunvideo["urunvideo_aktif"]?>&sayfanum=<?=$sayfanum?>&tablo=<?=$tablo?>&tablo_id=<?=$tablo_id?>" class="btn btn-sm <?=$color?>" title="Aktif/Pasif"><?=$durum?></a>
                                                            <a href="admin.php?cmd=urunvideo_guncelle&urunvideo_id=<?=$urunvideo["urunvideo_id"]?>&sayfanum=<?=$sayfanum?>&tablo=<?=$tablo?>&tablo_id=<?=$tablo_id?>" class="btn btn-sm green" title="Güncelle">
                                                                <i class="fa fa-edit"></i>
                                                            </a> 
                                                            <a href="urunvideo_sil.php?urunvideo_id=<?=$urunvideo["urunvideo_id"]?>&sayfanum=<?=$sayfanum?>&tablo=<?=$tablo?>&tablo_id=<?=$tablo_id?>" class="btn btn-sm red" title="Sil" onclick="return confirmDel();">
                                                                <i class="fa fa-trash"></i>
                                                            </a>                                                                
                                                        </td>
                                                    </tr>
                                                <?php
                                                    $urunvideo_x++;
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