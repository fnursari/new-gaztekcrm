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
                        <span class="caption-subject font-dark bold uppercase">İstatistik Listesi </span>
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
                                <th width="15%">İstatistik Başlık</th> 
                                <th width="15%">Değer</th> 
                                <th width="15%">Birim</th> 
                                <th width="10%">Sıra</th> 
                                <th width="10%">Durum</th>
                                <th width="15%">İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $istatistik_x=0;
                            $sql="SELECT * from istatistik order by sira";
                            $istatistikler = $db->get_results($sql,ARRAY_A);  
                            if($db->num_rows > 0) {
                                foreach ($istatistikler as $istatistik) {

                                    ?>
                                    <tr>
                                        <!-- <td></td> -->
                                        <td><?=($istatistik_x+1);?></td>

                                        <td>
                                            <?=$istatistik["baslik_tr"];?>
                                        </td>
                                        <td>
                                            <?=$istatistik["deger"];?>
                                        </td>
                                        <td>
                                            <?=$istatistik["birim"];?>
                                        </td>
                                        <td>
                                            <input style="width: 80px;" class="form-control" contenteditable="true" onBlur="saveToDatabase(this,'sira','<?php echo $istatistik["id"]; ?>','istatistik','id')" onClick="showEdit(this);" type="text" name="sira" value="<?=$istatistik["sira"]; ?>">
                                        </td>
                                        <td>
                                            <?php
                                            if ($istatistik["aktif"]=="1") {
                                                $durum="Aktif";
                                                $color="green-meadow";
                                            } else{
                                                $durum="Pasif";
                                                $color="red";
                                            }                                                         
                                            ?>
                                            <a href="istatistik_durum.php?id=<?=$istatistik["id"]?>&aktif=<?=$istatistik["aktif"]?>" class="btn btn-sm <?=$color?>" title="Aktif/Pasif"><?=$durum?></a>
                                        </td>
                                        <td>
                                            <a href="admin.php?cmd=istatistik_guncelle&id=<?=$istatistik["id"]?>" class="btn btn-sm orange" title="Düzenle">
                                                <i class="fa fa-edit"></i> Düzenle
                                            </a>
                                            <a href="istatistik_sil.php?id=<?=$istatistik["id"]?>" class="btn btn-sm red" title="Sil" onclick="return confirmDel();">
                                                <i class="fa fa-trash"></i> Sil
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
                                    $istatistik_x++;
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