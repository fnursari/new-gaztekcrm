<?
defined('_ADMIN_GIRDI') or die('Erişim engellendi.');
if($_SESSION["user"]["auth"]==md5(session_id()."vizyoner"))  
    {
    $user_id=$_SESSION["user"]["user_id"];
    $sql="select * from u1s9e2r6 where user_id='$user_id'";
    $details = $db->get_row($sql,ARRAY_A);
?>

                        <h1 class="page-title"></h1>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="portlet light portlet-fit portlet-form bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="icon-note font-dark"></i>
                                            <span class="caption-subject font-dark sbold uppercase">BİLGİ GÜNCELLE - <?=$details["user_name"];?></span>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <? require("islemsonucu.php"); ?>
                                        <form action="bilgi_guncelle_islem.php" enctype="multipart/form-data" method="post" id="form_sample_3" class="form-horizontal">
                                            <div class="form-body">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Kullanıcı Adı</label>
                                                    <div class="col-md-4">
                                                        <input type="text" data-required="1" class="form-control" name="user_name" id="user_name" value="<?=$details["user_name"]?>" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Eski Şifreniz</label>
                                                    <div class="col-md-4">
                                                        <input type="text" name="user_pass_eski" id="user_pass_eski" class="form-control" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Yeni Şifreniz</label>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control" name="user_pass_yeni" id="user_pass_yeni" />
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