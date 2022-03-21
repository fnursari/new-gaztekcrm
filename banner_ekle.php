<?
defined('_ADMIN_GIRDI') or die('Erişim engellendi.');
if(canUserAccessAdminArea()) {
?>
                        <h1 class="page-title"></h1>
                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="icon-plus font-dark"></i>
                                            <span class="caption-subject font-dark sbold uppercase">BANNER EKLE</span>
                                        </div>
                                    </div>
                                    <div class="portlet-body form">
                                        <? require("islemsonucu.php"); ?>
                                        <form action="banner_ekle_islem.php" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
                                            <div class="tabbable-custom ">
                                                <ul class="nav nav-tabs ">
                                                    <li class="active">
                                                        <a href="#tab_genel" data-toggle="tab"> Genel Tanımlar </a>
                                                    </li>
                                                    <?php
                                                        $diller=getLanguages();
                                                        if ($db->num_rows > 0) {
                                                            $x=0;
                                                            foreach ($diller as $d) {
                                                                $code=$d["language_code"];
                                                    ?>
                                                    <li class="">
                                                        <a href="#tab_<?php echo $code?>" data-toggle="tab"> <?php echo $d["language_name"]?> </a>
                                                    </li>
                                                    <?php $x++; }  } ?>
                                                </ul>
                                                <div class="tab-content">
                                                    <div class="tab-pane active" id="tab_genel">
                                                        
                                                        <div class="form-group">
                                                            <label for="exampleInputFile" class="col-md-2 control-label">Banner Resmi</label>
                                                            <div class="col-md-9">
                                                                <input type="file" id="exampleInputFile" name="resim" >
                                                                <p class="help-block"> (1920x700) </p>
                                                            </div>
                                                        </div>
                                                      <!--    <div class="form-group">
                                                            <label class="col-md-2 control-label">Yazı Rengi 1:</label>
                                                            <div class="col-md-2">
                                                                <input type="text" name="yazi_renk1" id="yazi_renk1" value="#515e5a" class="form-control colorpicker-default ">
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Yazı Rengi 2:</label>
                                                            <div class="col-md-2">
                                                                <input type="text" name="yazi_renk2" id="yazi_renk2" value="#ed7902" class="form-control colorpicker-default ">
                                                            </div>
                                                            
                                                        </div> -->
                                                    </div>
                                                    <?php
                                                        $diller=getLanguages();
                                                        if ($db->num_rows > 0) {
                                                            $y=0;
                                                            foreach ($diller as $d) {
                                                                $code=$d["language_code"];
                                                    ?>
                                                    <div class="tab-pane " id="tab_<?php echo $code?>">
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Banner Link:</label>
                                                            <div class="col-md-8">
                                                                <input type="text" name="banner_link_<?php echo $code?>" id="banner_link_<?php echo $code?>" class="form-control">
                                                            </div>
                                                        </div>
                                                        <!-- <div class="form-group">
                                                            <label for="exampleInputFile" class="col-md-2 control-label">Banner Resmi</label>
                                                            <div class="col-md-9">
                                                                <input type="file" id="exampleInputFile" name="resim_<?php echo $code?>" >
                                                               <p class="help-block"> (1920x700) </p>
                                                           </div>
                                                        </div> -->
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Banner Slogan 1:</label>
                                                            <div class="col-md-8">
                                                                <input type="text" name="slogan1_<?php echo $code?>" id="slogan1_<?php echo $code?>" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Banner Slogan 2:</label>
                                                            <div class="col-md-8">
                                                                <input type="text" name="slogan2_<?php echo $code?>" id="slogan2_<?php echo $code?>" class="form-control">
                                                            </div>
                                                        </div>
                                                        <!-- <div class="form-group">
                                                            <label class="col-md-2 control-label">Banner Slogan 3:</label>
                                                            <div class="col-md-8">
                                                                <input type="text" name="slogan3_<?php echo $code?>" id="slogan3_<?php echo $code?>" class="form-control">
                                                            </div>
                                                        </div> -->
                                                    </div>
                                                    <?php $y++; }  } ?>
                                                </div>
                                            </div>
                                            <div class="form-actions">
                                                <div class="row">
                                                    <div class="col-md-offset-3 col-md-9">
                                                        <button type="submit" class="btn green">Ekle</button>
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