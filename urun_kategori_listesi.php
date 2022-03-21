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
                                            <span class="caption-subject font-dark bold uppercase">Ürün Kategori Listesi</span>
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
                                                    <th width="10%">Resim</th> 
                                                    <th width="20%">Ana Kategorisi</th> 
                                                    <th width="20%">Kategori Adı</th> 
                                                    <th width="10%">Sıra</th>
                                                    <th width="10%">Durum</th>
                                                    <th width="25%">İşlemler</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $kategori_x=0;
                                                    $sql="SELECT * from urun_kategori order by sira";
                                                    $kategoriler = $db->get_results($sql,ARRAY_A);  
                                                    if($db->num_rows > 0)
                                                    {
                                                        foreach ($kategoriler as $kategori)  
                                                        {
                                                      
                                                ?>
                                                    <tr>
                                                        <!-- <td></td> -->
                                                        <td><?=($sayfanum*$per_page)+($kategori_x+1);?></td>
                                                        <td>
                                                            <?
                                                                if (($kategori["thumb"]!="") and file_exists("../upload/category/".$kategori["thumb"]))
                                                                {
                                                                    $boyut=getimagesize("../upload/category/".$kategori["thumb"]);
                                                                    $width=$boyut[0];
                                                                    $height=$boyut[1];
                                                                    $w=100;
                                                                    $h=floor($w*$height/$width);
                                                                    echo  '<img width="'.$w.'" height="'.$h.'" src="../upload/category/'.$kategori["thumb"].'"  class="img" />';
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
                                                        <td>
                                                            <?
                                                                if($kategori["ana_id"]=="0")
                                                                {
                                                                    echo "<strong>Ana Kategori</strong>";
                                                                }
                                                                else
                                                                {
                                                                    $ana_kategori=$db->get_row("select * from urun_kategori where kategori_id='$kategori[ana_id]'",ARRAY_A);
                                                                    echo "<strong>".$ana_kategori["kategori_ad_$dfl"]."</strong>";
                                                                }
                                                            ?>
                                                            
                                                        </td>
                                                        <td><?=$kategori["kategori_ad_$dfl"];?></td>
                                                        <td>
                                                            <input style="width: 80px;" class="form-control" contenteditable="true" onBlur="saveToDatabase(this,'sira','<?php echo $kategori["kategori_id"]; ?>','urun_kategori','kategori_id')" onClick="showEdit(this);" type="text" name="sira" value="<?=$kategori["sira"]; ?>">
                                                        </td>
                                                        <td>
                                                        <?php
                                                            if ($kategori["kategori_aktif"]=="1") {
                                                                $durum="Aktif";
                                                                $color="green-meadow";
                                                            } else{
                                                                $durum="Pasif";
                                                                $color="red";
                                                            }                                                         
                                                        ?>
                                                            <a href="urun_kategori_durum.php?kategori_id=<?=$kategori["kategori_id"]?>&kategori_aktif=<?=$kategori["kategori_aktif"]?>" class="btn btn-sm <?=$color?>" title="Aktif/Pasif"><?=$durum?></a>
                                                        </td>
                                                        <td>
                                                        
                                                            <a href="admin.php?cmd=urun_kategori_guncelle&kategori_id=<?=$kategori["kategori_id"]?>" class="btn btn-sm orange" title="Düzenle">
                                                                <i class="fa fa-edit"></i> Düzenle </a>
                                                            <!-- <a href="admin.php?cmd=resim&tablo=kategori&tablo_id=<?=$kategori["kategori_id"]?>" class="btn btn-sm blue" title="Kategori Resimleri">
                                                                <i class="fa fa-image"></i> Kategori Resimleri
                                                            </a>  -->   
                                                            <a href="urun_kategori_sil.php?kategori_id=<?=$kategori["kategori_id"]?>" class="btn btn-sm red" title="Sil" onclick="return confirmDel();">
                                                                <i class="fa fa-trash"></i> Sil </a>
                                                        </td>
                                                    </tr>
                                                <?php
                                                            $kategori_x++;
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