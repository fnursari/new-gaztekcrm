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
                                            <span class="caption-subject font-dark bold uppercase">Referans Listesi</span>
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
                                                    <th width="20%">Resim</th> 
                                                    <th width="50%">Referans Adı</th> 
                                                    <th width="10%">Durum</th>
                                                    <th width="15%">İşlemler</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $referans_x=0;
                                                    $sql="SELECT * from referans order by sira asc";
                                                    $referansler = $db->get_results($sql,ARRAY_A);  
                                                    if($db->num_rows > 0)
                                                    {
                                                        foreach ($referansler as $referans)  
                                                        {
                                                      
                                                ?>
                                                    <tr>
                                                        <!-- <td></td> -->
                                                        <td style="vertical-align: middle;"><?=($referans_x+1);?></td>
                                                        <td>
                                                            <?
                                                                if (($referans["thumb"]!="") and file_exists("../upload/".$referans["thumb"]))
                                                                {
                                                                    $boyut=getimagesize("../upload/".$referans["thumb"]);
                                                                    $width=$boyut[0];
                                                                    $height=$boyut[1];
                                                                    $w=100;
                                                                    $h=floor($w*$height/$width);
                                                                    echo  '<img width="'.$w.'" height="'.$h.'" src="../upload/'.$referans["thumb"].'"  class="img" />';
                                                                }
                                                            ?>
                                                            
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            <?=$referans["referans_ad_tr"];?>
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                        <?php
                                                            if ($referans["referans_aktif"]=="1") {
                                                                $durum="Aktif";
                                                                $color="green-meadow";
                                                            } else{
                                                                $durum="Pasif";
                                                                $color="red";
                                                            }                                                         
                                                        ?>
                                                            <a href="referans_durum.php?referans_id=<?=$referans["referans_id"]?>&referans_aktif=<?=$referans["referans_aktif"]?>" class="btn btn-sm <?=$color?>" title="Aktif/Pasif"><?=$durum?>
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            <a href="admin.php?cmd=referans_guncelle&referans_id=<?=$referans["referans_id"]?>" class="btn btn-sm orange" title="Düzenle">
                                                                <i class="fa fa-edit"></i> Düzenle
                                                            </a>
                                                            <!-- <a href="admin.php?cmd=resim&tablo=referans&tablo_id=<?=$referans["referans_id"]?>" class="btn btn-sm blue" title="Referans Resimleri">
                                                                <i class="fa fa-image"></i>
                                                            </a> -->
                                                            <a href="referans_sil.php?referans_id=<?=$referans["referans_id"]?>" class="btn btn-sm red" title="Sil" onclick="return confirmDel();">
                                                                <i class="fa fa-trash"></i> Sil
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php
                                                            $referans_x++;
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