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
                                           <!--  <i class="fa fa-clone"></i>Sayfa Listesi -->
                                            <span class="caption-subject font-dark bold uppercase">Sayfa Listesi</span>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <? require("islemsonucu.php"); ?>
                                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                                            <thead>
                                                <tr>
                                                    <th class="hidden"></th>
                                                    <th data-orderable="false" width="5%" style="text-align: center;">
                                                        <label>
                                                            <span>#</span>
                                                        </label>
                                                    </th>
                                                    <!-- <th style="width: 5%;">Sıra</th>  -->
                                                    <th data-orderable="false" width="70%">Sayfa Adı</th> 
                                                    <th data-orderable="false" width="25%">İşlemler</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $sayfa_x=0;
                                                    $sql="SELECT * from sayfa where sayfa_aktif='1' order by sira";
                                                    $sayfaler = $db->get_results($sql,ARRAY_A);  
                                                    if($db->num_rows > 0)
                                                    {
                                                        foreach ($sayfaler as $sayfa)  
                                                        {
                                                      
                                                ?>
                                                    <tr>
                                                        <td class="hidden"></td>
                                                        <td style="text-align: center;"><?=($sayfa_x+1);?></td>
                                                        <td>
                                                            <?=$sayfa["sayfa_ad_$dfl"];?>
                                                        </td>
                                                        <td>
                                                        <?php
                                                            if ($sayfa["sayfa_aktif"]=="1") {
                                                                $durum="A";
                                                                $color="green";
                                                            } else{
                                                                $durum="P";
                                                                $color="red";
                                                            }                                                         
                                                        ?>
                                                            <!-- <a href="sayfa_durum.php?sayfa_id=<?=$sayfa["sayfa_id"]?>&sayfa_aktif=<?=$sayfa["sayfa_aktif"]?>&sayfanum=<?=$sayfanum?>" class="btn btn-sm <?=$color?>" title="Aktif/Pasif"><?=$durum?></a> -->
                                                            <a href="admin.php?cmd=sayfa_guncelle&sayfa_id=<?=$sayfa["sayfa_id"]?>" class="btn btn-sm orange" title="Düzenle">
                                                                <i class="fa fa-edit"></i> Düzenle
                                                            </a>
                                                            <a href="admin.php?cmd=resim&tablo=sayfa&tablo_id=<?=$sayfa["sayfa_id"]?>&s=sayfa" class="btn btn-sm blue" title="Sayfa Resimleri">
                                                                <i class="fa fa-image"></i> Resimler
                                                            </a>
                                                            <a href="admin.php?cmd=video&tablo=sayfa&tablo_id=<?=$sayfa["sayfa_id"]?>&s=sayfa" class="btn btn-sm purple" title="Sayfa Videoları">
                                                                <i class="fa fa-play"></i> Videolar
                                                            </a>
                                                            <!-- <a href="sayfa_sil.php?sayfa_id=<?=$sayfa["sayfa_id"]?>&sayfanum=<?=$sayfanum?>" class="btn btn-sm red" title="Sil" onclick="return confirmDel();">
                                                                <i class="fa fa-trash"></i>
                                                            </a> -->
                                                        </td>
                                                    </tr>
                                                <?php
                                                            $sayfa_x++;
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