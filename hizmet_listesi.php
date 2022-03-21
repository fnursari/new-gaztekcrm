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
                                            <span class="caption-subject font-dark bold uppercase">Hizmet Listesi</span>
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
                                                    <th width="15%">Resim</th> 
                                                    <th width="30%">Hizmet Adı</th> 
                                                    <th width="15%">Sıra</th> 
                                                    <th width="15%">Durum</th>
                                                    <th width="20%">İşlemler</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $hizmet_x=0;
                                                    $sql="SELECT * from hizmet where '1'='1'";
                                                    $sql.=" order by sira";
                                                    $hizmetler = $db->get_results($sql,ARRAY_A);   
                                                    if($db->num_rows > 0)
                                                    {
                                                        foreach ($hizmetler as $hizmet)  
                                                        {
                                                      
                                                ?>
                                                    <tr>
                                                        <!-- <td></td> -->
                                                        <td style="vertical-align: middle;"><?=($hizmet_x+1);?></td>
                                                        <td>
                                                            <?
                                                                if (($hizmet["resim_kucuk"]!="") and file_exists("../upload/hizmet/".$hizmet["resim_kucuk"]))
                                                                {
                                                                    $boyut=getimagesize("../upload/hizmet/".$hizmet["resim_kucuk"]);
                                                                    $width=$boyut[0];
                                                                    $height=$boyut[1];
                                                                    $w=80;
                                                                    $h=floor($w*$height/$width);
                                                                    echo  '<img width="'.$w.'" height="'.$h.'" src="../upload/hizmet/'.$hizmet["resim_kucuk"].'"  class="img" />';
                                                                }
                                                            ?>
                                                            
                                                        </td>
                                                        
                                                        <td style="vertical-align: middle;"><?=$hizmet["hizmet_ad_tr"];?></td>
                                                        <td style="vertical-align: middle;">
                                                            <input style="width: 80px;" class="form-control" contenteditable="true" onBlur="saveToServices(this,'sira','<?php echo $hizmet["hizmet_id"]; ?>')" onClick="showEdit(this);" type="text" name="sira" value="<?=$hizmet["sira"]; ?>">
                                                        </td>
                                                        
                                                        <td style="vertical-align: middle;">
                                                        <?php
                                                            if ($hizmet["hizmet_aktif"]=="1") {
                                                                $durum="Aktif";
                                                                $color="green-meadow";
                                                            } else{
                                                                $durum="Pasif";
                                                                $color="red";
                                                            }                                                         
                                                        ?>
                                                            <a href="hizmet_durum.php?hizmet_id=<?=$hizmet["hizmet_id"]?>&hizmet_aktif=<?=$hizmet["hizmet_aktif"]?>" class="btn btn-sm <?=$color?>" title="Aktif/Pasif"><?=$durum?></a>
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                        
                                                            <a href="admin.php?cmd=resim&tablo=hizmet&tablo_id=<?=$hizmet["hizmet_id"]?>" class="btn btn-sm blue" title="Hizmet Resimleri">
                                                                <i class="fa fa-image"></i> Resimler
                                                            </a>
                                                            
                                                            <a href="admin.php?cmd=hizmet_guncelle&hizmet_id=<?=$hizmet["hizmet_id"]?>" class="btn btn-sm orange" title="Düzenle">
                                                                <i class="fa fa-edit"></i> Düzenle
                                                            </a>
                                                            <a href="hizmet_sil.php?hizmet_id=<?=$hizmet["hizmet_id"]?>" class="btn btn-sm red" title="Sil" onclick="return confirmDel();">
                                                                <i class="fa fa-trash"></i> Sil
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php
                                                            $hizmet_x++;
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