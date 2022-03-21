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
                                            <span class="caption-subject font-dark bold uppercase">Haber Listesi</span>
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
                                                    <th width="40%">Haber Başlık</th> 
                                                    <th width="15%">Durum</th>
                                                    <th width="20%">İşlemler</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $haber_x=0;
                                                    $sql="SELECT * from haber where '1'='1'";
                                                    $sql.=" order by sira";
                                                    $haberler = $db->get_results($sql,ARRAY_A);   
                                                    if($db->num_rows > 0)
                                                    {
                                                        foreach ($haberler as $haber)  
                                                        {
                                                      
                                                ?>
                                                    <tr>
                                                        <!-- <td></td> -->
                                                        <td style="vertical-align: middle;"><?=($haber_x+1);?></td>
                                                        <td>
                                                            <?
                                                                if (($haber["resim_kucuk"]!="") and file_exists("../upload/news/".$haber["resim_kucuk"]))
                                                                {
                                                                    $boyut=getimagesize("../upload/news/".$haber["resim_kucuk"]);
                                                                    $width=$boyut[0];
                                                                    $height=$boyut[1];
                                                                    $w=80;
                                                                    $h=floor($w*$height/$width);
                                                                    echo  '<img width="'.$w.'" height="'.$h.'" src="../upload/news/'.$haber["resim_kucuk"].'"  class="img" />';
                                                                }
                                                            ?>
                                                            
                                                        </td>
                                                        
                                                        <td style="vertical-align: middle;"><?=$haber["haber_baslik_$dfl"];?></td>
                                                        
                                                        <td style="vertical-align: middle;">
                                                        <?php
                                                            if ($haber["haber_aktif"]=="1") {
                                                                $durum="Aktif";
                                                                $color="green-meadow";
                                                            } else{
                                                                $durum="Pasif";
                                                                $color="red";
                                                            }                                                         
                                                        ?>
                                                            <a href="haber_durum.php?haber_id=<?=$haber["haber_id"]?>&haber_aktif=<?=$haber["haber_aktif"]?>" class="btn btn-sm <?=$color?>" title="Aktif/Pasif"><?=$durum?></a>
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                        
                                                            <!-- <a href="admin.php?cmd=resim&tablo=haber&tablo_id=<?=$haber["haber_id"]?>" class="btn btn-sm blue" title="Haber Resimleri">
                                                                <i class="fa fa-image"></i> Resimler
                                                            </a> -->
                                                            
                                                            <a href="admin.php?cmd=haber_guncelle&haber_id=<?=$haber["haber_id"]?>" class="btn btn-sm orange" title="Düzenle">
                                                                <i class="fa fa-edit"></i> Düzenle
                                                            </a>
                                                            <a href="haber_sil.php?haber_id=<?=$haber["haber_id"]?>" class="btn btn-sm red" title="Sil" onclick="return confirmDel();">
                                                                <i class="fa fa-trash"></i> Sil
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php
                                                            $haber_x++;
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