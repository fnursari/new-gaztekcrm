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
                                            <i class="fa fa-clone"></i>Proje Kategori Listesi </div>
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
                                                    <th width="41">Sıra</th> 
                                                    <th width="553">Ana Kategorisi</th> 
                                                    <th width="1008">Kategori Adı</th> 
                                                    <th style="width: 10%;">İşlemler</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $kategori_x=0;
                                                    $sql="SELECT * from proje_kategori order by sira";
                                                    $kategoriler = $db->get_results($sql,ARRAY_A);  
                                                    if($db->num_rows > 0)
                                                    {
                                                        foreach ($kategoriler as $kategori)  
                                                        {
                                                      
                                                ?>
                                                    <tr>
                                                        <td style="vertical-align: middle;"></td>
                                                        <td style="vertical-align: middle;"><?=($kategori_x+1);?></td>
                                                        <td style="vertical-align: middle;">
                                                            <?
                                                                if($kategori["ana_id"]=="0")
                                                                {
                                                                    echo "<strong>Ana Kategori</strong>";
                                                                }
                                                                else
                                                                {
                                                                    $ana_kategori=$db->get_row("select kategori_ad_tr from proje_kategori where kategori_id='$kategori[ana_id]'",ARRAY_A);
                                                                    echo "<strong>".$ana_kategori["kategori_ad_tr"]."</strong>";
                                                                }
                                                            ?>
                                                            
                                                        </td>
                                                        <td style="vertical-align: middle;"><?=$kategori["kategori_ad_tr"];?></td>
                                                        <td style="vertical-align: middle;">
                                                        <?php
                                                            if ($kategori["kategori_aktif"]=="1") {
                                                                $durum="A";
                                                                $color="green";
                                                            } else{
                                                                $durum="P";
                                                                $color="red";
                                                            }                                                         
                                                        ?>
                                                            <a href="proje_kategori_durum.php?kategori_id=<?=$kategori["kategori_id"]?>&kategori_aktif=<?=$kategori["kategori_aktif"]?>" class="btn btn-sm <?=$color?>" title="Aktif/Pasif"><?=$durum?></a>
                                                            <a href="admin.php?cmd=proje_kategori_guncelle&kategori_id=<?=$kategori["kategori_id"]?>" class="btn btn-sm yellow" title="Güncelle">
                                                                <i class="fa fa-edit"></i>  </a>
                                                            <a href="proje_kategori_sil.php?kategori_id=<?=$kategori["kategori_id"]?>" class="btn btn-sm red" title="Sil" onclick="return confirmDel();">
                                                                <i class="fa fa-trash"></i>  </a>
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