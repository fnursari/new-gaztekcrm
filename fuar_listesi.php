<?
defined('_ADMIN_GIRDI') or die('Erişim engellendi.');
if(canUserAccessAdminArea()) {
?>
                        <h1 class="page-title"></h1>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="portlet light portlet-fit bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <span class="caption-subject font-dark bold uppercase">Fuar Listesi</span>
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
                                                    <!-- <th width="30">Sıra</th>  -->
                                                    <th width="20%">Resim</th> 
                                                    <th width="40%">Fuar Adı</th> 
                                                    <th width="15%">Durum</th>
                                                    <th width="20%">İşlemler</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $fuar_x=0;
                                                    $sql="SELECT * from fuar where '1'='1'";
                                                    $sql.=" order by sira";
                                                    $fuarler = $db->get_results($sql,ARRAY_A);   
                                                    if($db->num_rows > 0)
                                                    {
                                                        foreach ($fuarler as $fuar)  
                                                        {
                                                      
                                                ?>
                                                    <tr>
                                                        <!-- <td></td> -->
                                                        <td style="vertical-align: middle;"><?=($fuar_x+1);?></td>
                                                        <td>
                                                            <?
                                                                if (($fuar["resim_kucuk"]!="") and file_exists("../upload/fairs/".$fuar["resim_kucuk"]))
                                                                {
                                                                    $boyut=getimagesize("../upload/fairs/".$fuar["resim_kucuk"]);
                                                                    $width=$boyut[0];
                                                                    $height=$boyut[1];
                                                                    $w=80;
                                                                    $h=floor($w*$height/$width);
                                                                    echo  '<img width="'.$w.'" height="'.$h.'" src="../upload/fairs/'.$fuar["resim_kucuk"].'"  class="img" />';
                                                                }
                                                            ?>
                                                            
                                                        </td>
                                                        
                                                        <td style="vertical-align: middle;"><?=$fuar["fuar_baslik_$dfl"];?></td>
                                                        
                                                        <td style="vertical-align: middle;">
                                                        <?php
                                                            if ($fuar["fuar_aktif"]=="1") {
                                                                $durum="Aktif";
                                                                $color="green-meadow";
                                                            } else{
                                                                $durum="Pasif";
                                                                $color="red";
                                                            }                                                         
                                                        ?>
                                                            <a href="fuar_durum.php?fuar_id=<?=$fuar["fuar_id"]?>&fuar_aktif=<?=$fuar["fuar_aktif"]?>" class="btn btn-sm <?=$color?>" title="Aktif/Pasif"><?=$durum?></a>
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                        
                                                           <!--  <a href="admin.php?cmd=resim&tablo=fuar&tablo_id=<?=$fuar["fuar_id"]?>" class="btn btn-sm blue" title="Fuar Resimleri">
                                                                <i class="fa fa-image"></i> Resimler
                                                            </a> -->
                                                            
                                                            <a href="admin.php?cmd=fuar_guncelle&fuar_id=<?=$fuar["fuar_id"]?>" class="btn btn-sm orange" title="Düzenle">
                                                                <i class="fa fa-edit"></i> Düzenle
                                                            </a>
                                                            <a href="fuar_sil.php?fuar_id=<?=$fuar["fuar_id"]?>" class="btn btn-sm red" title="Sil" onclick="return confirmDel();">
                                                                <i class="fa fa-trash"></i> Sil
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php
                                                            $fuar_x++;
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