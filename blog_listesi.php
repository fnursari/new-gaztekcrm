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
                                            <span class="caption-subject font-dark bold uppercase">Blog Listesi</span>
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
                                                    <th width="15%">Resim</th>
                                                    <th width="30%">Blog Başlık</th> 
                                                    <th width="15%">Blog Tarih</th> 
                                                    <th width="10%">Durum</th>
                                                    <th width="15%">İşlemler</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $blog_x=0;
                                                    $sql="SELECT * from blog order by sira asc";
                                                    $blogler = $db->get_results($sql,ARRAY_A);  
                                                    if($db->num_rows > 0)
                                                    {
                                                        foreach ($blogler as $blog)  
                                                        {
                                                      
                                                ?>
                                                    <tr>
                                                        <!-- <td></td> -->
                                                        <td style="vertical-align: middle;"><?=($blog_x+1);?></td>
                                                        <td>
                                                            <?
                                                                if (($blog["resim_kucuk"]!="") and file_exists("../upload/".$blog["resim_kucuk"]))
                                                                {
                                                                    $boyut=getimagesize("../upload/".$blog["resim_kucuk"]);
                                                                    $width=$boyut[0];
                                                                    $height=$boyut[1];
                                                                    $w=100;
                                                                    $h=floor($w*$height/$width);
                                                                    echo  '<img width="'.$w.'" height="'.$h.'" src="../upload/'.$blog["resim_kucuk"].'"  class="img" />';
                                                                }
                                                            ?>
                                                            
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            <?=$blog["blog_baslik_tr"];?>
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            <?=$blog["blog_tarih"];?>
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                        <?php
                                                            if ($blog["blog_aktif"]=="1") {
                                                                $durum="Aktif";
                                                                $color="green-meadow";
                                                            } else{
                                                                $durum="Pasif";
                                                                $color="red";
                                                            }                                                         
                                                        ?>
                                                            <a href="blog_durum.php?blog_id=<?=$blog["blog_id"]?>&blog_aktif=<?=$blog["blog_aktif"]?>" class="btn btn-sm <?=$color?>" title="Aktif/Pasif"><?=$durum?></a>
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            <a href="admin.php?cmd=blog_guncelle&blog_id=<?=$blog["blog_id"]?>" class="btn btn-sm orange" title="Düzenle">
                                                                <i class="fa fa-edit"></i> Düzenle
                                                            </a>
                                                            <!-- <a href="admin.php?cmd=resim&tablo=blog&tablo_id=<?=$blog["blog_id"]?>" class="btn btn-sm blue" title="blog Resimleri">
                                                                <i class="fa fa-image"></i>
                                                            </a> -->
                                                            <a href="blog_sil.php?blog_id=<?=$blog["blog_id"]?>" class="btn btn-sm red" title="Sil" onclick="return confirmDel();">
                                                                <i class="fa fa-trash"></i> Sil
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php
                                                            $blog_x++;
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