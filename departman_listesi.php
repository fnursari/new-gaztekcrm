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
                                            <span class="caption-subject font-dark bold uppercase">Departman Listesi</span>
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
                                                    <th width="30%">Departman Adı</th> 
                                                    <th width="10%">Sıra</th> 
                                                    <th width="10%">Durum</th>
                                                    
                                                    <th width="30%">İşlemler</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $departman_x=0;
                                                    $sql="SELECT * from departman where '1'='1'";
                                                    $sql.=" order by sira";
                                                    $departmanler = $db->get_results($sql,ARRAY_A);   
                                                    if($db->num_rows > 0)
                                                    {
                                                        foreach ($departmanler as $departman)  
                                                        {
                                                      
                                                ?>
                                                    <tr>
                                                        <!-- <td></td> -->
                                                        <td style="vertical-align: middle;"><?=($departman_x+1);?></td>
                                                        <td>
                                                            <?
                                                                if (($departman["resim_kucuk"]!="") and file_exists("../upload/departments/".$departman["resim_kucuk"]))
                                                                {
                                                                    $boyut=getimagesize("../upload/departments/".$departman["resim_kucuk"]);
                                                                    $width=$boyut[0];
                                                                    $height=$boyut[1];
                                                                    $w=100;
                                                                    $h=floor($w*$height/$width);
                                                                    echo  '<img width="'.$w.'" height="'.$h.'" src="../upload/departments/'.$departman["resim_kucuk"].'"  class="img" />';
                                                                } else {
                                                                    $boyut=getimagesize("../images/noimg.jpg");
                                                                    $width=$boyut[0];
                                                                    $height=$boyut[1];
                                                                    $w=100;
                                                                    $h=floor($w*$height/$width);
                                                                    echo  '<img width="'.$w.'" height="'.$h.'" src="../images/noimg.jpg"  class="img" />';
                                                                }
                                                            ?>
                                                            
                                                        </td>
                                                       
                                                        
                                                        <td style="vertical-align: middle;"><?=$departman["departman_ad_$dfl"];?></td>
                                                        <td style="vertical-align: middle;">
                                                            <input style="width: 80px;" class="form-control" contenteditable="true" onBlur="saveToDatabase(this,'sira','<?php echo $departman["departman_id"]; ?>','departman','departman_id')"   onClick="showEdit(this);" type="text" name="sira" value="<?=$departman["sira"]; ?>">
                                                        </td>
                                                        
                                                        <td style="vertical-align: middle;">
                                                        <?php
                                                            if ($departman["departman_aktif"]=="1") {
                                                                $durum="Aktif";
                                                                $color="green-meadow";
                                                            } else{
                                                                $durum="Pasif";
                                                                $color="red";
                                                            }                                                         
                                                        ?>
                                                            <a href="departman_durum.php?departman_id=<?=$departman["departman_id"]?>&departman_aktif=<?=$departman["departman_aktif"]?>" class="btn btn-sm <?=$color?>" title="Aktif/Pasif"><?=$durum?></a>
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                        
                                                            <a href="admin.php?cmd=resim&tablo=departman&tablo_id=<?=$departman["departman_id"]?>&s=departman" class="btn btn-sm blue" title="Departman Resimleri">
                                                                <i class="fa fa-image"></i> Resimler
                                                            </a>
                                                         
                                                            <a href="admin.php?cmd=departman_guncelle&departman_id=<?=$departman["departman_id"]?>" class="btn btn-sm orange" title="Düzenle">
                                                                <i class="fa fa-edit"></i> Düzenle
                                                            </a>
                                                            
                                                            <a href="departman_sil.php?departman_id=<?=$departman["departman_id"]?>" class="btn btn-sm red" title="Sil" onclick="return confirmDel();">
                                                                <i class="fa fa-trash"></i> Sil
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php
                                                            $departman_x++;
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