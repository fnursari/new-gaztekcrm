<?
defined('_ADMIN_GIRDI') or die('Erişim engellendi.');
if(canUserAccessAdminArea()) {
?>
                        <h1 class="page-title"></h1>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="portlet">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-clone"></i>Proje Listesi </div>
                                    </div>
                                    <div class="portlet-body">
                                        <? require("islemsonucu.php"); ?>
                                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                                            <thead>
                                                <tr>
                                                    <th width="11">
                                                        <label>
                                                            <span>#</span>
                                                        </label>
                                                    </th>
                                                    <th width="41">Sıra</th> 
                                                    <th width="300">Resim</th> 
                                                    <th width="300">Proje Adı</th> 
                                                    <th width="150">Sıra</th> 
                                                    <th width="200">İşlemler</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $proje_x=0;
                                                    $sql="SELECT * from proje where '1'='1'";
                                                    $sql.=" order by sira";
                                                    $projeler = $db->get_results($sql,ARRAY_A);   
                                                    if($db->num_rows > 0)
                                                    {
                                                        foreach ($projeler as $proje)  
                                                        {
                                                      
                                                ?>
                                                    <tr>
                                                        <td></td>
                                                        <td style="vertical-align: middle;"><?=($proje_x+1);?></td>
                                                        <td style="vertical-align: middle;">
                                                            <?
                                                                if (($proje["resim_kucuk"]!="") and file_exists("../upload/".$proje["resim_kucuk"]))
                                                                {
                                                                    $boyut=getimagesize("../upload/".$proje["resim_kucuk"]);
                                                                    $width=$boyut[0];
                                                                    $height=$boyut[1];
                                                                    $w=100;
                                                                    $h=floor($w*$height/$width);
                                                                    echo  '<img width="'.$w.'" height="'.$h.'" src="../upload/'.$proje["resim_kucuk"].'"  class="img" />';
                                                                }
                                                            ?>
                                                            
                                                        </td>
                                                        <!-- <td>
                                                            <?
                                                                $sql="SELECT * from proje_kategori where kategori_id='$proje[kategori_id]'";
                                                                $kategori = $db->get_row($sql,ARRAY_A);
                                                                echo $kategori["kategori_ad_tr"];  
                                                            ?>
                                                        </td> -->
                                                        
                                                        <td style="vertical-align: middle;"><?=$proje["proje_ad_tr"];?></td>
                                                        <td style="vertical-align: middle;">
                                                            <input style="width: 80px;" contenteditable="true" onBlur="saveToProject(this,'sira','<?php echo $proje["proje_id"]; ?>')" onClick="showEdit(this);" type="text" name="sira" value="<?=$proje["sira"]; ?>">
                                                        </td>
                                                        <td style="vertical-align: middle;"> 
                                                        <?php
                                                            if ($proje["proje_aktif"]=="1") {
                                                                $durum="A";
                                                                $color="green";
                                                            } else{
                                                                $durum="P";
                                                                $color="red";
                                                            }                                                         
                                                        ?>
                                                            <a href="proje_durum.php?proje_id=<?=$proje["proje_id"]?>&proje_aktif=<?=$proje["proje_aktif"]?>" class="btn btn-sm <?=$color?>" title="Aktif/Pasif"><?=$durum?></a>
                                                            <a href="admin.php?cmd=proje_guncelle&proje_id=<?=$proje["proje_id"]?>" class="btn btn-sm yellow" title="Güncelle">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            <a href="admin.php?cmd=resim&tablo=proje&tablo_id=<?=$proje["proje_id"]?>" class="btn btn-sm blue" title="Proje Resimleri">
                                                                <i class="fa fa-image"></i>
                                                            </a>
                                                            <a href="proje_sil.php?proje_id=<?=$proje["proje_id"]?>" class="btn btn-sm red" title="Sil" onclick="return confirmDel();">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php
                                                            $proje_x++;
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