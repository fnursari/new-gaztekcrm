<?
defined('_ADMIN_GIRDI') or die('Erişim engellendi.');
if(canUserAccessAdminArea()) {
    $id=$_GET['id'];
    $sql="select * from istatistik where id='$id'";
    $details = $db->get_row($sql,ARRAY_A);
    ?>
    <h1 class="page-title"></h1>
    <div class="row">
        <div class="col-md-12 ">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-plus font-dark"></i>
                        <span class="caption-subject font-dark sbold uppercase">İstatistik Güncelle</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <? require("islemsonucu.php"); ?>
                    <form action="istatistik_guncelle_islem.php?id=<?=$id?>" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
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
                                                <label class="col-md-2 control-label">İstatistik Başlığı <?php echo $d["language_name"]?>:</label>
                                                <div class="col-md-8">
                                                    <input type="text" name="baslik_<?php echo $code?>" id="baslik_<?php echo $code?>" value="<?=$details["baslik_$code"]?>" class="form-control">
                                                </div>
                                            </div>

                                            <?php 
                                            $y++; 
                                        } 
                                    } 
                                    ?>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">İstatistik Değeri :</label>
                                        <div class="col-md-8">
                                            <input type="text" name="deger" id="deger" value="<?=$details["deger"]?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">İstatistik Birimi :</label>
                                        <div class="col-md-8">
                                            <input type="text" name="birim" id="birim" class="form-control" value="<?=$details["birim"]?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">İstatistik Icon :</label>
                                        <div class="col-md-8">
                                            <input type="text" name="icon" id="icon" class="form-control" value="<?=$details["icon"]?>">
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