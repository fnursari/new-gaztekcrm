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
                                            <span class="caption-subject font-dark bold uppercase">Kişi Listesi </span>
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
                                                    <th width="15%">Bayi</th> 
                                                    <th width="10%">Firma Adı</th> 
                                                    <th width="10%">Kişi Adı</th> 
                                                    <th width="10%">Telefon</th> 
                                                    <th width="5%">Email</th> 
                                                    <th width="10%">Adres</th> 
                                                    <th width="10%">Sıra</th> 
                                                    <th width="10%">Durum</th>
                                                    <th width="15%">İşlemler</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $kisi_x=0;
                                                    $sql="SELECT * from kisi_iletisim order by sira";
                                                    $kisiler = $db->get_results($sql,ARRAY_A);  
                                                    if($db->num_rows > 0) {
                                                        foreach ($kisiler as $kisi) {
                                                      
                                                ?>
                                                    <tr>
                                                        <!-- <td></td> -->
                                                        <td><?=($kisi_x+1);?></td>
                                                        
                                                        <td>
                                                            <?=$kisi["bayi_ad_tr"];?>
                                                        </td>
                                                        <td>
                                                            <?=$kisi["firma_ad"];?>
                                                        </td>
                                                        <td>
                                                            <?=$kisi["kisi_ad"];?>
                                                        </td>
                                                        <td>
                                                            <?=$kisi["telefon"];?>
                                                        </td>
                                                        <td>
                                                            <?=$kisi["email"];?>
                                                        </td>
                                                        <td>
                                                            <?=$kisi["adres"];?>
                                                        </td>
                                                        <td>
                                                            <input style="width: 80px;" class="form-control" contenteditable="true" onBlur="saveToDatabase(this,'sira','<?php echo $kisi["id"]; ?>','kisi_iletisim','id')" onClick="showEdit(this);" type="text" name="sira" value="<?=$kisi["sira"]; ?>">
                                                        </td>
                                                        <td>
                                                        <?php
                                                            if ($kisi["aktif"]=="1") {
                                                                $durum="Aktif";
                                                                $color="green-meadow";
                                                            } else{
                                                                $durum="Pasif";
                                                                $color="red";
                                                            }                                                         
                                                        ?>
                                                            <a href="kisi_durum.php?id=<?=$kisi["id"]?>&aktif=<?=$kisi["aktif"]?>" class="btn btn-sm <?=$color?>" title="Aktif/Pasif"><?=$durum?></a>
                                                        </td>
                                                        <td>
                                                            <a href="admin.php?cmd=kisi_guncelle&id=<?=$kisi["id"]?>" class="btn btn-sm orange" title="Düzenle">
                                                                <i class="fa fa-edit"></i> Düzenle
                                                            </a>
                                                            <a href="kisi_sil.php?id=<?=$kisi["id"]?>" class="btn btn-sm red" title="Sil" onclick="return confirmDel();">
                                                                <i class="fa fa-trash"></i> Sil
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php
                                                            $kisi_x++;
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