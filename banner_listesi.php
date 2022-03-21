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
                                            <span class="caption-subject font-dark bold uppercase">Banner Listesi </span>
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
                                                    <th width="20%">Banner Resmi</th> 
                                                    <th width="35%">Banner Slogan</th> 
                                                    <th width="10%">Sıra</th> 
                                                    <th width="10%">Durum</th>
                                                    <th width="20%">İşlemler</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $banner_x=0;
                                                    $sql="SELECT * from banner order by sira";
                                                    $bannerler = $db->get_results($sql,ARRAY_A);  
                                                    if($db->num_rows > 0) {
                                                        foreach ($bannerler as $banner) {
                                                      
                                                ?>
                                                    <tr>
                                                        <!-- <td></td> -->
                                                        <td><?=($banner_x+1);?></td>
                                                        <td>
                                                            <?
                                                                if (($banner["resim"]!="") and file_exists("../upload/banner/".$banner["resim"]))
                                                                {
                                                                    $boyut=getimagesize("../upload/banner/".$banner["resim"]);
                                                                    $width=$boyut[0];
                                                                    $height=$boyut[1];
                                                                    $w=100;
                                                                    $h=floor($w*$height/$width);
                                                                    echo  '<img width="'.$w.'" height="'.$h.'" src="../upload/banner/'.$banner["resim"].'"  class="img" />';
                                                                }
                                                            ?>
                                                            
                                                        </td>
                                                        <td>
                                                            <?=$banner["slogan1_$dfl"];?>
                                                        </td>
                                                        <td>
                                                            <input style="width: 80px;" class="form-control" contenteditable="true" onBlur="saveToDatabase(this,'sira','<?php echo $banner["banner_id"]; ?>','banner','banner_id')" onClick="showEdit(this);" type="text" name="sira" value="<?=$banner["sira"]; ?>">
                                                        </td>
                                                        <td>
                                                        <?php
                                                            if ($banner["banner_aktif"]=="1") {
                                                                $durum="Aktif";
                                                                $color="green-meadow";
                                                            } else{
                                                                $durum="Pasif";
                                                                $color="red";
                                                            }                                                         
                                                        ?>
                                                            <a href="banner_durum.php?banner_id=<?=$banner["banner_id"]?>&banner_aktif=<?=$banner["banner_aktif"]?>" class="btn btn-sm <?=$color?>" title="Aktif/Pasif"><?=$durum?></a>
                                                        </td>
                                                        <td>
                                                            <a href="admin.php?cmd=banner_guncelle&banner_id=<?=$banner["banner_id"]?>" class="btn btn-sm orange" title="Düzenle">
                                                                <i class="fa fa-edit"></i> Düzenle
                                                            </a>
                                                            <a href="banner_sil.php?banner_id=<?=$banner["banner_id"]?>" class="btn btn-sm red" title="Sil" onclick="return confirmDel();">
                                                                <i class="fa fa-trash"></i> Sil
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php
                                                            $banner_x++;
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