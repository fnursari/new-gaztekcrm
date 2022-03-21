<?
defined('_ADMIN_GIRDI') or die('Erişim engellendi.');
if(canUserAccessAdminArea()) {
    $id=$_GET['id'];
    $sql="select * from arizaonarim where id='$id'";
    $details = $db->get_row($sql,ARRAY_A);
?>
                        <h1 class="page-title"></h1>
                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="icon-note font-dark"></i>
                                            <span class="caption-subject font-dark sbold uppercase">Arıza-Onarım</span>
                                        </div>
                                    </div>
                                    <div class="portlet-body form">
                                    	<? require("islemsonucu.php"); ?>
                                        <form action="arizaonarim_cevapla_islem.php?id=<?=$id?>" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
                                            <div class="form-body row">
                                                <div class="form-group col-md-6">
                                                    <label class="col-md-2 control-label">Cihaz Id</label>
                                                    <div class="col-md-8">
                                                        <input type="text" name="device_id" id="device_id" value="<?=$details["device_id"]?>" class="form-control" disabled>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="col-md-2 control-label">Destek Türü</label>
                                                    <div class="col-md-8">
                                                        <input type="text" name="destek_turu" id="destek_turu" value="<?=$details["destek_turu"]?>" class="form-control" disabled>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="col-md-2 control-label">Makina Adı</label>
                                                    <div class="col-md-8">
                                                        <input type="text" name="makina_adi" id="makina_adi" value="<?=$details["makina_adi"]?>" class="form-control" disabled>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="col-md-2 control-label">Makina Kodu</label>
                                                    <div class="col-md-8">
                                                        <input type="text" name="makina_kodu" id="makina_kodu" value="<?=$details["makina_kodu"]?>" class="form-control" disabled>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="col-md-2 control-label">Üretim Yılı</label>
                                                    <div class="col-md-8">
                                                        <input type="text" name="uretim_yili" id="uretim_yili" value="<?=$details["uretim_yili"]?>" class="form-control" disabled>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="col-md-2 control-label">Firma Adı</label>
                                                    <div class="col-md-8">
                                                        <input type="text" name="firma_adi" id="firma_adi" value="<?=$details["firma_adi"]?>" class="form-control" disabled>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="col-md-2 control-label">Firma Email</label>
                                                    <div class="col-md-8">
                                                        <input type="text" name="firma_email" id="firma_email" value="<?=$details["firma_email"]?>" class="form-control" disabled>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="col-md-2 control-label">Firma Telefon</label>
                                                    <div class="col-md-8">
                                                        <input type="text" name="firma_telefon" id="firma_telefon" value="<?=$details["firma_telefon"]?>" class="form-control" disabled>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="col-md-2 control-label">Notlar</label>
                                                    <div class="col-md-8">
                                                        <textarea class="form-control" name="notlar" id="notlar"  disabled><?=$details["notlar"]?></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="col-md-2 control-label">Cevap</label>
                                                    <div class="col-md-8">
                                                        <textarea class="form-control" name="geri_donus" id="geri_donus"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="col-md-2 control-label">Resim</label>
                                                    <div class="col-md-8">
                                                       <?
                                                          if (($details["resim"]!="") and file_exists("../api/upload/".$details["resim"]))
                                                          {
                                                        ?>
                                                        <img style="float: left;padding: 2px;margin: 2px;border: 1px solid #cccccc;background-color: #FFFFFF;" class="img" width="50%" src="../api/upload/<?=$details["resim"] ?>">
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-actions">
                                                <div class="row">
                                                    <div class="col-md-offset-3 col-md-9">
                                                        <button type="submit" class="btn green">Cevapla</button>
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