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
                                            <span class="caption-subject font-dark bold uppercase">S.S.S. Listesi</span>
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
                                                    <th width="50%">S.S.S. Soru</th> 
                                                    <th width="20%">Sıra</th> 
                                                    <th width="10%">Durum</th>
                                                    <th width="15%">İşlemler</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $sss_x=0;
                                                    $sql="SELECT * from sss order by sira asc";
                                                    $ssler = $db->get_results($sql,ARRAY_A);  
                                                    if($db->num_rows > 0)
                                                    {
                                                        foreach ($ssler as $sss)  
                                                        {
                                                      
                                                ?>
                                                    <tr>
                                                        <!-- <td></td> -->
                                                        <td style="vertical-align: middle;"><?=($sss_x+1);?></td>
                                                        
                                                        <td style="vertical-align: middle;">
                                                            <?=$sss["sss_soru_$dfl"];?>
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            <input style="width: 80px;" class="form-control" contenteditable="true" onBlur="saveToDatabase(this,'sira','<?php echo $sss["sss_id"]; ?>','sss','sss_id')" onClick="showEdit(this);" type="text" name="sira" value="<?=$sss["sira"]; ?>">
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                        <?php
                                                            if ($sss["sss_aktif"]=="1") {
                                                                $durum="Aktif";
                                                                $color="green-meadow";
                                                            } else{
                                                                $durum="Pasif";
                                                                $color="red";
                                                            }                                                         
                                                        ?>
                                                            <a href="sss_durum.php?sss_id=<?=$sss["sss_id"]?>&sss_aktif=<?=$sss["sss_aktif"]?>" class="btn btn-sm <?=$color?>" title="Aktif/Pasif"><?=$durum?></a>
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                        
                                                            
                                                            <a href="admin.php?cmd=sss_guncelle&sss_id=<?=$sss["sss_id"]?>" class="btn btn-sm orange" title="Düzenle">
                                                                <i class="fa fa-edit"></i> Düzenle
                                                            </a>
                                                            <a href="sss_sil.php?sss_id=<?=$sss["sss_id"]?>" class="btn btn-sm red" title="Sil" onclick="return confirmDel();">
                                                                <i class="fa fa-trash"></i> Sil
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php
                                                            $sss_x++;
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