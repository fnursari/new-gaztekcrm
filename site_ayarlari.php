<?php
defined('_ADMIN_GIRDI') or die('Erişim engellendi.');
if(canUserAccessAdminArea()) {

?>

                        <h1 class="page-title"></h1>
                        <div class="row">
                            
                            <div class="col-md-12">
                                <div class="portlet light portlet-fit bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <span class="caption-subject font-dark bold uppercase">DİL</span>
                                        </div>
                                    </div>
                                    <? require("islemsonucu.php"); ?>
                                    <div class="portlet-body">
                                        <div class="table-scrollable" id="lang">
                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th width="5%"> # </th>
                                                        <th width="35%"> Dil </th>
                                                        <th width="35%"> Dil Kodu </th>
                                                        <th width="10%"> Durum </th>
                                                        <th width="15%"> İşlem </th>
                                                    </tr>
                                                </thead>
                                                <?php
                                                    $diller=$db->get_results("select * from languages where 1 order by language_id",ARRAY_A);
                                                    if ($db->num_rows > 0) {
                                                ?>
                                                <tbody>
                                                    <?php
                                                        $x=1;
                                                        foreach ($diller as $d) {
                                                            $id=$d["language_id"];
                                                            if ($d["language_state"]=="1") {
                                                                $durum="Aktif";
                                                                $color="green-meadow";
                                                            } else{
                                                                $durum="Pasif";
                                                                $color="red";
                                                            }                                                         
                                                    ?>
                                                    <tr id="view_lang_<?php echo $id?>">
                                                        <td> <?php echo $x?> </td>
                                                        <td> <?php echo $d["language_name"]?> </td>
                                                        <td> <?php echo $d["language_code"]?> </td>
                                                        <td>
                                                            <!-- <a href="#" class="btn btn-sm <?php echo $color?>" title="Aktif/Pasif">
                                                                <?php echo $durum?>
                                                            </a> -->
                                                            <span  data-id="<?php echo $id?>" id="<?php echo $d["language_state"]?>" class="btn btn-sm <?php echo $color?> state_lang" title="Aktif/Pasif"><?php echo $durum?></span>
                                                        </td>
                                                        <td>
                                                            <a href="#" class="btn btn-sm orange edit_lang"  data-id="<?php echo $id?>" title="Düzenle">
                                                                Düzenle
                                                            </a>
                                                            <a href="dil_sil.php?language_id=<?=$id?>" class="btn btn-sm red" title="Sil" onclick="return confirmDel();">
                                                                Sil
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <form action="dil_guncelle_islem.php?language_id=<?=$id?>" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
                                                    <tr id="edit_lang_<?php echo $id?>" hidden="hidden">
                                                        <td> <?php echo $id?> </td>
                                                        <td>
                                                            <!-- <input id="language_name_<?php echo $id?>" class="input-md form-control" value="<?php echo $d["language_name"]?>"> -->
                                                        </td>
                                                        <td>
                                                            <!-- <input id="language_code_<?php echo $id?>" class="input-md form-control" value="<?php echo $d["language_code"]?>"> -->
                                                            <select class="input-md form-control" name="lang_code">
                                                                <option <?php if ($d["language_code"]=="tr") echo "selected='selected'"; ?> value="tr-Türkçe">Türkçe</option>
                                                                <option <?php if ($d["language_code"]=="en") echo "selected='selected'"; ?> value="en-İngilizce">İngilizce</option>
                                                                <option <?php if ($d["language_code"]=="ar") echo "selected='selected'"; ?> value="ar-Arapça">Arapça</option>
                                                                <option <?php if ($d["language_code"]=="de") echo "selected='selected'"; ?> value="de-Almanca">Almanca</option>
                                                                <option <?php if ($d["language_code"]=="fr") echo "selected='selected'"; ?> value="fr-Fransızca">Fransızca</option>
                                                                <option <?php if ($d["language_code"]=="ru") echo "selected='selected'"; ?> value="ru-Rusça">Rusça</option>
                                                                <option <?php if ($d["language_code"]=="es") echo "selected='selected'"; ?> value="es-İspanyolca">İspanyolca</option>
                                                                <option <?php if ($d["language_code"]=="sq") echo "selected='selected'"; ?> value="sq-Arnavutça">Arnavutça</option>
                                                            </select>
                                                        </td>
                                                        <td></td>
                                                        <td>
                                                            <input class="btn btn-sm blue" name="edit_btn_lang"  data-id="<?php echo $id?>" type="submit" value="Düzenle">
                                                            <a href="#" class="btn btn-sm red close_edit" data-id="<?php echo $id?>"  title="Vazgeç"> Vazgeç </a>
                                                        </td>
                                                    </tr>
                                                    </form>
                                                    <?php $x++; }  ?>

                                                </tbody>
                                                <?php } ?>
                                                <tfoot>
                                                    <form action="dil_ekle_islem.php" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
                                                    <tr>
                                                        
                                                        <td colspan="2">
                                                            <!-- <input class="input-md form-control" name="language_name"> -->
                                                        </td>
                                                        <td>
                                                            <select class="input-md form-control" name="language_code">
                                                                <option value="tr-Türkçe">Türkçe</option>
                                                                <option value="en-İngilizce">İngilizce</option>
                                                                <option value="ar-Arapça">Arapça</option>
                                                                <option value="de-Almanca">Almanca</option>
                                                                <option value="fr-Fransızca">Fransızca</option>
                                                                <option value="ru-Rusça">Rusça</option>
                                                                <option value="es-İspanyolca">İspanyolca</option>
                                                                <option value="sq-Arnavutça">Arnavutça</option>
                                                            </select>
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