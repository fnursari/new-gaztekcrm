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
                                            <span class="caption-subject font-dark bold uppercase">Fotoğraf Listesi</span>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <? require("islemsonucu.php"); ?>
                                        <form name="myform" class="pager-form" method="post" action="fotogaleri_toplu_sil.php">
                                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                                            <thead>
                                                <tr>
                                                    <th width="5%">
                                                        <label>
                                                            <span>#</span>
                                                        </label>
                                                    </th>
                                                    <th width="5%">
                                                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                            <input type="checkbox" name="sil[]" class="group-checkable" data-set="#sample_1 .checkboxes" />
                                                            <span></span>
                                                        </label>
                                                    </th>
                                                    <!-- <th width="41">Sıra</th>  -->
                                                    <th width="15%">Resim</th> 
                                                    <!-- <th width="20%">Kategori Adı</th>  -->
                                                    <th width="40%">Resim Adı</th> 
                                                    <th width="1%">Sıra</th> 
                                                    <th width="10%">Durum</th> 
                                                    <th width="15%">İşlemler</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php

                                                    $fotogaleri_x=0;
                                                    $sql="SELECT * from fotogaleri where '1'='1'";
                                                    $sql.=" order by sira ";
                                                    $fotogaleriler = $db->get_results($sql,ARRAY_A);   
                                                    if($db->num_rows > 0)
                                                    {
                                                        foreach ($fotogaleriler as $fotogaleri)  
                                                        {
                                                      
                                                ?>
                                                    <tr>
                                                        <!-- <td></td> -->
                                                        <td style="vertical-align: middle;"><?=($fotogaleri_x+1);?></td>
                                                        <td>
                                                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                                <input type="checkbox" name="sil[]" class="checkboxes" value="<?=$fotogaleri["fotogaleri_id"]?>" />
                                                                <span></span>
                                                            </label>
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            <?
                                                                if (($fotogaleri["image"]!="") and file_exists("../upload/photogallery/".$fotogaleri["image"]))
                                                                {
                                                                    $boyut=getimagesize("../upload/photogallery/".$fotogaleri["image"]);
                                                                    $width=$boyut[0];
                                                                    $height=$boyut[1];
                                                                    $w=100;
                                                                    $h=floor($w*$height/$width);
                                                                    echo  '<img width="'.$w.'" height="'.$h.'" src="../upload/photogallery/'.$fotogaleri["image"].'"  class="img" />';
                                                                }
                                                            ?>
                                                            
                                                        </td>
                                                        <!-- <td style="vertical-align: middle;">
                                                            <?
                                                                $sql="SELECT * from fotogaleri_kategori where kategori_id='$fotogaleri[kategori_id]'";
                                                                $kategori = $db->get_row($sql,ARRAY_A);
                                                                echo $kategori["kategori_ad_tr"];  
                                                            ?>
                                                        </td> -->
                                                        <td style="vertical-align: middle;"><?=$fotogaleri["fotogaleri_ad_$dfl"];?></td>
                                                        <td>
                                                            <input  class="form-control" style="width: 80px;" contenteditable="true" onBlur="saveToDatabase(this,'sira','<?php echo $fotogaleri["fotogaleri_id"]; ?>','fotogaleri','fotogaleri_id')" onclick="showEdit(this);" type="text" name="sira" value="<?=$fotogaleri["sira"]; ?>">
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                        <?php
                                                            if ($fotogaleri["fotogaleri_aktif"]=="1") {
                                                                $durum="Aktif";
                                                                $color="green-meadow";
                                                            } else{
                                                                $durum="Pasif";
                                                                $color="red";
                                                            }                                                         
                                                        ?>
                                                        <a href="fotogaleri_durum.php?fotogaleri_id=<?=$fotogaleri["fotogaleri_id"]?>&fotogaleri_aktif=<?=$fotogaleri["fotogaleri_aktif"]?>" class="btn btn-sm <?=$color?>" title="Aktif/Pasif"><?=$durum?></a>
                                                           
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            
                                                            <a href="admin.php?cmd=fotogaleri_guncelle&fotogaleri_id=<?=$fotogaleri["fotogaleri_id"]?>" class="btn btn-sm orange" title="Düzenle">
                                                                <i class="fa fa-edit"></i> Düzenle
                                                            </a>
                                                            <a href="fotogaleri_sil.php?fotogaleri_id=<?=$fotogaleri["fotogaleri_id"]?>" class="btn btn-sm red" title="Sil" onclick="return confirmDel();">
                                                                <i class="fa fa-trash"></i> Sil
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php
                                                            $fotogaleri_x++;
                                                        } 
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                        <div class="form-actions">
                                                <div class="row" style="float: left;margin-left: 270px;margin-top: -39px;">
                                                    <div class="col-md-12">
                                                        <button type="submit" class="btn red" onclick="return confirmDel();">Toplu Sil</button>
                                                    </div>
                                                </div>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
<?php } ?>