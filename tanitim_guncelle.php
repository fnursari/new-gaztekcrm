<?php
defined('_ADMIN_GIRDI') or die('Erişim engellendi.');
if(canUserAccessAdminArea()) {
 $sql="select * from tanitim_filmi where film_id='1'";
 $details = $db->get_row($sql,ARRAY_A);

?>
                        <h1 class="page-title">Tanıtım Filmi Güncelle</h1>
                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="icon-plus font-dark"></i>
                                            <span class="caption-subject font-dark sbold uppercase">Tanıtım Filmi</span>
                                        </div>
                                    </div>
                                    <div class="portlet-body form">
                                        <? require("islemsonucu.php"); ?>
                                        <div class="tab-content">
                                            <div class="tab-pane fade active in" id="tab_1_1">
                                                <form action="tanitim_guncelle_islem.php?film_id=<?=$details["film_id"]?>" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
                                                    <div class="form-body">
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">Aktif</label>
                                                            <div class="col-md-1">
                                                                <input type="checkbox" class="form-control" name="aktif" id="aktif" value="1" <? if($details["aktif"]=="1") echo 'checked="checked";'?>>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">Video Link</label>
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control" name="link_tr" id="link_tr" value="<?=$details["link_tr"]?>">
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
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
<?php } ?>