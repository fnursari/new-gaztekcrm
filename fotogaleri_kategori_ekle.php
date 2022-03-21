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
                                            <span class="caption-subject font-dark bold uppercase">Galeri Kategori Ekle</span>
                                        </div>    
                                    </div>
                                    <div class="portlet-body">
                                        <? require("islemsonucu.php"); ?>
                                        <div class="table-scrollable" id="lang">
                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th width="5%"> # </th>
                                                        <th width="45%"> Kategori Ad </th>
                                                        <th width="20%">Sıra</th> 
                                                        <th width="15%"> Durum </th>
                                                        <th width="15%"> İşlem </th>
                                                    </tr>
                                                </thead>
                                                <?php
                                                    $kategoriler=getAllGalleryCategories();
                                                    if ($db->num_rows > 0) {
                                                ?>
                                                <tbody>
                                                    <?php
                                                        $x=1;
                                                        foreach ($kategoriler as $kat) {
                                                            if ($kat["kategori_aktif"]=="1") {
                                                                $text="Aktif";
                                                                $color="green-meadow";
                                                            } else{
                                                                $text="Pasif";
                                                                $color="red";
                                                            }                                                         
                                                    ?>
                                                    <tr>
                                                        <td> <?php echo $x?> </td>
                                                        <td> <?php echo $kat["kategori_ad_tr"]?> </td>
                                                        <td style="vertical-align: middle;">
                                                            <input style="width: 80px;" class="form-control" contenteditable="true" onBlur="saveToGalleyCat(this,'sira','<?php echo $kat["kategori_id"]; ?>')" onClick="showEdit(this);" type="text" name="sira" value="<?=$kat["sira"]; ?>">
                                                        </td>
                                                        <td>
                                                            <a href="fotogaleri_kategori_durum.php?kategori_id=<?=$kat["kategori_id"]?>&kategori_aktif=<?=$kat["kategori_aktif"]?>" class="btn btn-sm <?php echo $color?>" title="Aktif/Pasif">
                                                                <?php echo $text?>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <a href="admin.php?cmd=fotogaleri_ekle&kategori_id=<?=$kat["kategori_id"]?>" class="btn btn-sm blue" title="Kategori Resimleri">
                                                                <i class="fa fa-image"></i> Resimler
                                                            </a>
                                                            <a href="fotogaleri_kategori_sil.php?kategori_id=<?=$kat["kategori_id"]?>" class="btn btn-sm red" title="Sil" onclick="return confirmDel();">
                                                                Sil
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    
                                                    <?php $x++; }  ?>

                                                </tbody>
                                                <?php } ?>
                                                <tfoot>
                                                    <form action="fotogaleri_kategori_ekle_islem.php" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
                                                    <tr>
                                                        <td></td>
                                                        
                                                        <td colspan="3">
                                                        <?php
                                                            $diller=getLanguages();
                                                            if ($db->num_rows > 0) {
                                                                foreach ($diller as $d) {
                                                                    $code=$d["language_code"];
                                                        ?>
                                                            <input type="text" name="kategori_ad_<?php echo $code?>" id="kategori_ad_<?php echo $code?>" class="form-control colmd4" required="" placeholder="Kategori Adı <?php echo $d["language_name"]?>">
                                                            <?php } } ?>
                                                        </td>
                                                        
                                                        <td colspan="2">
                                                            <input class="btn btn-sm blue" name="ekle"  type="submit" value="Ekle">
                                                            
                                                        </td>
                                                    </tr>
                                                    </form>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
<?php } ?>