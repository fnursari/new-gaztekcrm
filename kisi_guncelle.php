<?
defined('_ADMIN_GIRDI') or die('Erişim engellendi.');
if(canUserAccessAdminArea()) {
    $id=$_GET['id'];
    $sql="select * from kisi_iletisim where id='$id'";
    $details = $db->get_row($sql,ARRAY_A);
?>
                        <h1 class="page-title"></h1>
                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="icon-plus font-dark"></i>
                                            <span class="caption-subject font-dark sbold uppercase">BANNER GÜNCELLE</span>
                                        </div>
                                    </div>
                                    <div class="portlet-body form">
                                        <? require("islemsonucu.php"); ?>
                                        <form action="kisi_guncelle_islem.php?id=<?=$id?>" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
                                            <div class="tabbable-custom ">
                                                <ul class="nav nav-tabs ">
                                                    <li class="active">
                                                        <a href="#tab_genel" data-toggle="tab"> Genel Tanımlar </a>
                                                    </li>
                                                    
                                                </ul>
                                                <div class="tab-content">
                                                    <div class="tab-pane active" id="tab_genel">
                                                        <?php
                                                        $diller=getLanguages();
                                                        if ($db->num_rows > 0) {
                                                            $y=0;
                                                            foreach ($diller as $d) {
                                                                $code=$d["language_code"];
                                                                ?>
                                                                <div class="form-group">
                                                                    <label class="col-md-2 control-label">Bayi Adı <?php echo $d["language_name"]?>:</label>
                                                                    <div class="col-md-8">
                                                                        <input type="text" name="bayi_ad_<?php echo $code?>" id="bayi_ad_<?php echo $code?>" value="<?=$details["bayi_ad_$code"]?>" class="form-control">
                                                                    </div>
                                                                </div>

                                                                <?php 
                                                                $y++; 
                                                            } 
                                                        } 
                                                        ?>
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Firma Adı:</label>
                                                            <div class="col-md-8">
                                                                <input type="text" name="firma_ad" id="firma_ad" value="<?=$details["firma_ad"]?>" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Kişi Adı:</label>
                                                            <div class="col-md-8">
                                                                <input type="text" name="kisi_ad" id="kisi_ad" value="<?=$details["kisi_ad"]?>" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Telefon:</label>
                                                            <div class="col-md-8">
                                                                <input type="text" name="telefon" id="telefon" class="form-control" value="<?=$details["telefon"]?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Email:</label>
                                                            <div class="col-md-8">
                                                                <input type="text" name="email" id="email" class="form-control" value="<?=$details["email"]?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Adres:</label>
                                                            <div class="col-md-8">
                                                                <input type="text" name="adres" id="adres" value="<?=$details["adres"]?>" class="form-control">
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="form-actions">
                                                <div class="row">
                                                    <div class="col-md-offset-3 col-md-9">
                                                        <button type="submit" class="btn green">Güncelle</button>
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