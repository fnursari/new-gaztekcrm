<?
defined('_ADMIN_GIRDI') or die('Erişim engellendi.');
if(canUserAccessAdminArea()) {
    $banner_id=$_GET['banner_id'];
    $sql="select * from banner where banner_id='$banner_id'";
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
                                        <form action="banner_guncelle_islem.php?banner_id=<?=$banner_id?>" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
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
                                                                <?php
                                                                    if (($details["resim"]!="") and file_exists("../upload/banner/".$details["resim"]))
                                                                    {
                                                                        $boyut=getimagesize("../upload/banner/".$details["resim"]);
                                                                        $width=$boyut[0];
                                                                        $height=$boyut[1];
                                                                        $w=100;
                                                                        $h=floor($w*$height/$width);
                                                                ?>
                                                                <img style="float: left;padding: 2px;margin: 2px;border: 1px solid #cccccc;background-color: #FFFFFF;" class="img" width="<?=$w ?>" height="<?=$h ?>" src="../upload/banner/<?=$details["resim"] ?>">
                                                                <a href="banner_resim_sil.php?banner_id=<?=$details["banner_id"]?>" onclick="return confirmDel();">Sil</a>
                                                                <?php } ?>
                                                                <p class="help-block"> (1920x700) </p>
                                                            </div>
                                                        </div>
                                                       <!--  <div class="form-group">
                                                            <label class="col-md-2 control-label">Yazı Rengi 1:</label>
                                                            <div class="col-md-2">
                                                                <input type="text" name="yazi_renk1" id="yazi_renk1" class="form-control colorpicker-default " value="<?=$details["yazi_renk1"] ?>">
                                                                 <p class="help-block"> (Tema Rengi : #515e5a) </p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Yazı Rengi 2:</label>
                                                            <div class="col-md-2">
                                                                <input type="text" name="yazi_renk2" id="yazi_renk2" class="form-control colorpicker-default " value="<?=$details["yazi_renk2"] ?>">
                                                                 <p class="help-block">  (Tema Rengi : #ed7902) </p>
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
                                                    <div class="tab-pane" id="tab_<?php echo $code?>">
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Banner Link:</label>
                                                            <div class="col-md-8">
                                                                <input type="text" name="banner_link_<?php echo $code?>" id="banner_link_<?php echo $code?>" value="<?=$details["banner_link_$code"]?>" class="form-control">
                                                            </div>
                                                        </div>
                                                        <!-- <div class="form-group">
                                                            <label for="exampleInputFile" class="col-md-2 control-label">Banner Resmi</label>
                                                            <div class="col-md-9">
                                                                <input type="file" id="exampleInputFile" name="resim_<?php echo $code?>" >
                                                                <?php
                                                                    if (($details["resim_$code"]!="") and file_exists("../upload/banner/".$details["resim_$code"]))
                                                                    {
                                                                        $boyut=getimagesize("../upload/banner/".$details["resim_$code"]);
                                                                        $width=$boyut[0];
                                                                        $height=$boyut[1];
                                                                        $w=100;
                                                                        $h=floor($w*$height/$width);
                                                                ?>
                                                                <img style="float: left;padding: 2px;margin: 2px;border: 1px solid #cccccc;background-color: #FFFFFF;" class="img" width="<?=$w ?>" height="<?=$h ?>" src="../upload/banner/<?=$details["resim_$code"] ?>">
                                                                <a href="banner_resim_sil.php?banner_id=<?=$details["banner_id"]?>&dil=<?=$code?>" onclick="return confirmDel();">Sil</a>
                                                                <?php } ?>
                                                                <p class="help-block"> (1920x700) </p>
                                                            </div>
                                                        </div> -->
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Banner Slogan 1:</label>
                                                            <div class="col-md-8">
                                                                <input type="text" name="slogan1_<?php echo $code?>" id="slogan1_<?php echo $code?>" value="<?=$details["slogan1_$code"]?>" class="form-control">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Banner Slogan 2:</label>
                                                            <div class="col-md-8">
                                                                <input type="text" name="slogan2_<?php echo $code?>" id="slogan2_<?php echo $code?>" value='<?=$details["slogan2_$code"]?>' class="form-control">
                                                                
                                                            </div>
                                                        </div>
                                                        <!-- <div class="form-group">
                                                            <label class="col-md-2 control-label">Banner Slogan 3:</label>
                                                            <div class="col-md-8">
                                                                <input type="text" name="slogan3_<?php echo $code?>" id="slogan3_<?php echo $code?>" value="<?=$details["slogan3_$code"]?>" class="form-control">
                                                            </div>
                                                        </div> -->
                                                    </div>
                                                    <?php $y++; }  } ?>
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