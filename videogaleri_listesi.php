<?
defined('_ADMIN_GIRDI') or die('Erişim engellendi.');
if(canUserAccessAdminArea()) {
?>
                        <h1 class="page-title"></h1>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="portlet  light portlet-fit bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <span class="caption-subject font-dark bold uppercase">Video Listesi</span>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <? require("islemsonucu.php"); ?>
                                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                                            <thead>
                                                <tr>
                                                    <th width="5%">
                                                        <label>
                                                            <span>#</span>
                                                        </label>
                                                    </th>
                                                    <!-- <th width="41">Sıra</th>  -->
                                                    <th width="15%">Resim</th> 
                                                    <th width="40%">Video Adı</th> 
                                                    <th width="15%">Sıra</th> 
                                                    <th width="10%">Durum</th> 
                                                    <th width="15%">İşlemler</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php

                                                    $video_x=0;
                                                    $sql="SELECT * from video where '1'='1'";
                                                    $sql.=" order by sira ";
                                                    $videoler = $db->get_results($sql,ARRAY_A);   
                                                    if($db->num_rows > 0)
                                                    {
                                                        foreach ($videoler as $video)  
                                                        {
                                                      
                                                ?>
                                                    <tr>
                                                        <!-- <td></td> -->
                                                        <td style="vertical-align: middle;"><?=($video_x+1);?></td>
                                                        <td style="vertical-align: middle;">
                                                            <?
                                                                if (($video["resim"]!="") and file_exists("../upload/videogallery/".$video["resim"]))
                                                                {
                                                                    $boyut=getimagesize("../upload/videogallery/".$video["resim"]);
                                                                    $width=$boyut[0];
                                                                    $height=$boyut[1];
                                                                    $w=100;
                                                                    $h=floor($w*$height/$width);
                                                                    echo  '<img width="'.$w.'" height="'.$h.'" src="../upload/videogallery/'.$video["resim"].'"  class="img" />';
                                                                }
                                                            ?>
                                                            
                                                        </td>
                                                        
                                                        <td style="vertical-align: middle;"><?=$video["video_ad_$dfl"];?></td>
                                                        <td>
                                                            <input class="form-control" style="width: 80px;" contenteditable="true" onBlur="saveToDatabase(this,'sira','<?php echo $video["video_id"]; ?>','video','video_id')"  onClick="showEdit(this);" type="text" name="sira" value="<?=$video["sira"]; ?>">
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
                                                            <a href="videogaleri_durum.php?video_id=<?=$video["video_id"]?>&video_aktif=<?=$video["video_aktif"]?>" class="btn btn-sm <?=$color?>" title="Aktif/Pasif"><?=$durum?></a>
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                        
                                                            <a href="admin.php?cmd=videogaleri_guncelle&video_id=<?=$video["video_id"]?>" class="btn btn-sm orange" title="Düzenle">
                                                                <i class="fa fa-edit"></i> Düzenle
                                                            </a>
                                                            <a href="videogaleri_sil.php?video_id=<?=$video["video_id"]?>" class="btn btn-sm red" title="Sil" onclick="return confirmDel();">
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
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
<?php } ?>