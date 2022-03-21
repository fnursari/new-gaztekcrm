<?
defined('_ADMIN_GIRDI') or die('Erişim engellendi.');
if(canUserAccessAdminArea()) {
    $proje_id=$_GET['proje_id'];
    $sql="select * from proje where proje_id='$proje_id'";
    $details = $db->get_row($sql,ARRAY_A);
    $ana_id=$details['kategori_id'];
?>
                        <h1 class="page-title"></h1>
                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="icon-plus font-dark"></i>
                                            <span class="caption-subject font-dark sbold uppercase">Proje Güncelle - <?=$details["proje_ad_tr"];?></span>
                                        </div>
                                    </div>
                                    <div class="portlet-body form">
                                        <? require("islemsonucu.php"); ?>
                                        <form action="proje_guncelle_islem.php?proje_id=<?=$proje_id?>" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
                                            <div class="form-body">
                                                
                                                                                                
                                                <div class="portlet-body">
                                                    <div class="panel-group accordion scrollable" id="accordion2">
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading">
                                                                <h4 class="panel-title">
                                                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#genel" aria-expanded="true"> Genel Tanımlamalar </a>
                                                                </h4>
                                                            </div>
                                                            <div id="genel" class="panel-collapse collapse in" aria-expanded="true">
                                                                <div class="panel-body">
                                                                    <div class="form-group">
                                                                        <label class="col-md-2 control-label">Resim</label>
                                                                        <div class="col-md-9">
                                                                            <input type="file" style="float: left;" name="resim">
                                                                            <?
                                                                              if (($details["resim_kucuk"]!="") and file_exists("../upload/".$details["resim_kucuk"]))
                                                                              {
                                                                                 $boyut=getimagesize("../upload/".$details["resim_kucuk"]);
                                                                                 $width=$boyut[0];
                                                                                 $height=$boyut[1];
                                                                                 $w=100;
                                                                                 $h=floor($w*$height/$width);
                                                                            ?>
                                                                            <img style="float: left;padding: 2px;margin: 2px;border: 1px solid #cccccc;background-color: #FFFFFF;" class="img" width="<?=$w ?>" height="<?=$h ?>" src="../upload/<?=$details["resim_kucuk"] ?>">
                                                                            <a href="proje_resim_sil.php?proje_id=<?=$details["proje_id"]?>" onclick="return confirmDel();">Sil</a>
                                                                            <?php } ?>
                                                                            <p class="help-block"> (800x600) </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading">
                                                                <h4 class="panel-title">
                                                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#icerikturkce"> İçerik Türkçe </a>
                                                                </h4>
                                                            </div>
                                                            <div id="icerikturkce" class="panel-collapse collapse">
                                                                <div class="panel-body">
                                                                    <div class="form-group">
                                                                        <label class="col-md-2 control-label">Proje Adı</label>
                                                                        <div class="col-md-8">
                                                                            <input type="text" name="proje_ad_tr" id="proje_ad_tr" required="" value="<?=$details["proje_ad_tr"]?>" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading">
                                                                <h4 class="panel-title">
                                                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#icerikingilizce"> İçerik İngilizce </a>
                                                                </h4>
                                                            </div>
                                                            <div id="icerikingilizce" class="panel-collapse collapse">
                                                                <div class="panel-body">
                                                                    <div class="form-group">
                                                                        <label class="col-md-2 control-label">Proje Adı</label>
                                                                        <div class="col-md-8">
                                                                            <input type="text" name="proje_ad_en" id="proje_ad_en" value="<?=$details["proje_ad_en"]?>" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading">
                                                                <h4 class="panel-title">
                                                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#icerikrusca"> İçerik Rusça </a>
                                                                </h4>
                                                            </div>
                                                            <div id="icerikrusca" class="panel-collapse collapse">
                                                                <div class="panel-body">
                                                                    <div class="form-group">
                                                                        <label class="col-md-2 control-label">Proje Adı</label>
                                                                        <div class="col-md-8">
                                                                            <input type="text" name="proje_ad_ru" id="proje_ad_ru" value="<?=$details["proje_ad_ru"]?>" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading">
                                                                <h4 class="panel-title">
                                                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#icerikarapca"> İçerik Arapça </a>
                                                                </h4>
                                                            </div>
                                                            <div id="icerikarapca" class="panel-collapse collapse">
                                                                <div class="panel-body">
                                                                    <div class="form-group">
                                                                        <label class="col-md-2 control-label">Proje Adı</label>
                                                                        <div class="col-md-8">
                                                                            <input type="text" name="proje_ad_ar" id="proje_ad_ar" value="<?=$details["proje_ad_ar"]?>" class="form-control" >
                                                                        </div>
                                                                    </div>
                                                                    
                                                                </div>
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