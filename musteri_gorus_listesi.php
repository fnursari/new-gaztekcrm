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
                                            <i class="fa fa-clone"></i>Müşteri Görüş Listesi </div>
                                    </div>
                                    <div class="portlet-body">
                                        <? require("islemsonucu.php"); ?>
                                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <label>
                                                            <span>#</span>
                                                        </label>
                                                    </th>
                                                    <th>Sıra</th> 
                                                    <th>Müşteri Adı</th> 
                                                    <th style="width: 186px;">İşlemler</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $sayfanum=$_GET["sayfanum"];
                                                    $num=$db->get_var("SELECT count(id) from musteri_gorusleri"); 
                                                    $per_page = 20; 
                                                    $showeachside = 5; 
                                                    $start=$sayfanum*$per_page;
                                                    if(empty($start))$start=0;  
                                                    $max_pages = ceil($num / $per_page); 
                                                    $cur = ceil($start / $per_page)+1; 
                                                    $haber_x=0;
                                                    $sql="SELECT * from musteri_gorusleri order by sira desc limit $start,$per_page";
                                                    $gorusler = $db->get_results($sql,ARRAY_A);  
                                                    if($db->num_rows > 0)
                                                    {
                                                        foreach ($gorusler as $gorus)  
                                                        {
                                                      
                                                ?>
                                                    <tr>
                                                        <td></td>
                                                        <td><?=($sayfanum*$per_page)+($haber_x+1);?></td>
                                                        <td>
                                                            <?=$gorus["musteri_adi"];?>
                                                        </td>
                                                        <td>
                                                        <?php
                                                            if ($gorus["gorus_aktif"]=="1") {
                                                                $durum="A";
                                                                $color="green";
                                                            } else{
                                                                $durum="P";
                                                                $color="red";
                                                            }                                                         
                                                        ?>
                                                            <a href="gorus_durum.php?id=<?=$gorus["id"]?>&gorus_aktif=<?=$gorus["gorus_aktif"]?>&sayfanum=<?=$sayfanum?>" class="btn btn-sm <?=$color?>" title="Aktif/Pasif"><?=$durum?></a>
                                                            <a href="admin.php?cmd=gorus_guncelle&id=<?=$gorus["id"]?>" class="btn btn-sm yellow" title="Güncelle">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            <a href="gorus_sil.php?id=<?=$gorus["id"]?>&sayfanum=<?=$sayfanum?>" class="btn btn-sm red" title="Sil" onclick="return confirmDel();">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php
                                                            $haber_x++;
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