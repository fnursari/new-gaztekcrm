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
                                            <span class="caption-subject font-dark bold uppercase">Ürün Listesi</span>
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
                                                    <th width="15%">Kategori Adı</th> 
                                                    <th width="15%">Ürün Adı</th> 
                                                    <th width="10%">Sıra</th> 
                                                    <th width="10%">Durum</th>
                                                    
                                                    <th width="30%">İşlemler</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $urun_x=0;
                                                    $sql="SELECT * from urun where '1'='1'";
                                                    $sql.=" order by sira";
                                                    $urunler = $db->get_results($sql,ARRAY_A);   
                                                    if($db->num_rows > 0)
                                                    {
                                                        foreach ($urunler as $urun)  
                                                        {
                                                      
                                                ?>
                                                    <tr>
                                                        <!-- <td></td> -->
                                                        <td style="vertical-align: middle;"><?=($urun_x+1);?></td>
                                                        <td>
                                                            <?
                                                                if (($urun["resim_kucuk"]!="") and file_exists("../upload/product/".$urun["resim_kucuk"]))
                                                                {
                                                                    $boyut=getimagesize("../upload/product/".$urun["resim_kucuk"]);
                                                                    $width=$boyut[0];
                                                                    $height=$boyut[1];
                                                                    $w=100;
                                                                    $h=floor($w*$height/$width);
                                                                    echo  '<img width="'.$w.'" height="'.$h.'" src="../upload/product/'.$urun["resim_kucuk"].'"  class="img" />';
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
                                                        <td style="vertical-align: middle;">
                                                            <?
                                                                $sql="SELECT * from urun_kategori where kategori_id='$urun[kategori_id]'";
                                                                $kategori = $db->get_row($sql,ARRAY_A);
                                                                echo $kategori["kategori_ad_$dfl"];  
                                                            ?>
                                                        </td>
                                                        
                                                        <td style="vertical-align: middle;"><?=$urun["urun_ad_$dfl"];?></td>
                                                        <td style="vertical-align: middle;">
                                                            <input style="width: 80px;" class="form-control" contenteditable="true" onBlur="saveToDatabase(this,'sira','<?php echo $urun["urun_id"]; ?>','urun','urun_id')"   onClick="showEdit(this);" type="text" name="sira" value="<?=$urun["sira"]; ?>">
                                                        </td>
                                                        
                                                        <td style="vertical-align: middle;">
                                                        <?php
                                                            if ($urun["urun_aktif"]=="1") {
                                                                $durum="Aktif";
                                                                $color="green-meadow";
                                                            } else{
                                                                $durum="Pasif";
                                                                $color="red";
                                                            }                                                         
                                                        ?>
                                                            <a href="urun_durum.php?urun_id=<?=$urun["urun_id"]?>&urun_aktif=<?=$urun["urun_aktif"]?>" class="btn btn-sm <?=$color?>" title="Aktif/Pasif"><?=$durum?></a>
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                        
                                                            <a href="admin.php?cmd=resim&tablo=urun&tablo_id=<?=$urun["urun_id"]?>&s=urun" class="btn btn-sm blue" title="Ürün Resimleri">
                                                                <i class="fa fa-image"></i> Resimler
                                                            </a>
                                                            <!-- <a href="admin.php?cmd=video&tablo=urun&tablo_id=<?=$urun["urun_id"]?>&s=urun" class="btn btn-sm purple" title="Ürün Videolar">
                                                                <i class="fa fa-play"></i> Videolar
                                                            </a> -->
                                                            <a href="admin.php?cmd=urun_guncelle&urun_id=<?=$urun["urun_id"]?>" class="btn btn-sm orange" title="Düzenle">
                                                                <i class="fa fa-edit"></i> Düzenle
                                                            </a>
                                                            
                                                            <!-- <a href="admin.php?cmd=ozellik&tablo=urun&tablo_id=<?=$urun["urun_id"]?>&s=urun" class="btn btn-sm green" title="Ürün Özellikleri">
                                                                <i class="fa fa-check"></i> Özellikler
                                                            </a> -->
                                                            <a href="urun_sil.php?urun_id=<?=$urun["urun_id"]?>" class="btn btn-sm red" title="Sil" onclick="return confirmDel();">
                                                                <i class="fa fa-trash"></i> Sil
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php
                                                            $urun_x++;
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