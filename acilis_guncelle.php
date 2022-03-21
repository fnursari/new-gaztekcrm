<?php
defined('_ADMIN_GIRDI') or die('Erişim engellendi.');
if(canUserAccessAdminArea()) {
    
    $sql="select * from acilis where acilis_id='1'";
    $details = $db->get_row($sql,ARRAY_A);
?>
                        <h1 class="page-title"></h1>
                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="icon-plus font-dark"></i>
                                            <span class="caption-subject font-dark sbold uppercase">Popup Banner Güncelle</span>
                                        </div>
                                    </div>
                                    <div class="portlet-body form">
                                        <? require("islemsonucu.php"); ?>
                                        <form action="acilis_guncelle_islem.php?acilis_id=<?=$details["acilis_id"]?>" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
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
                                                       
                                                        <div class="form-group form-md-checkboxes">
                                                            <div class="md-checkbox-inline col-md-6 col-md-offset-3">
                                                                <div class="md-checkbox">
                                                                    <input type="checkbox" id="checkbox2_4"  name="aktif" id="aktif" value="1" <? if($details["aktif"]=="1") echo 'checked="checked";'?> class="md-check col-md-3">
                                                                    <label for="checkbox2_4">
                                                                        <span></span>
                                                                        <span class="check"></span>
                                                                        <span class="box"></span> Aktif </label>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
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
                                                                <input type="text" name="link_<?php echo $code?>" id="link_<?php echo $code?>" class="form-control" value="<?=$details["link_$code"]?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputFile" class="col-md-2 control-label">Popup Resmi</label>
                                                            <div class="col-md-9">
                                                                <input type="file" id="exampleInputFile" name="resim_<?php echo $code?>" >
                                                                <?
                                                                if (($details["resim_$code"]!="") and file_exists("../upload/banner/".$details["resim_$code"]))
                                                                {
                                                                   $boyut=getimagesize("../upload/banner/".$details["resim_$code"]);
                                                                   $width=$boyut[0];
                                                                   $height=$boyut[1];
                                                                   $w=100;
                                                                   $h=floor($w*$height/$width);
                                                                   ?>
                                                                   <img style="float: left;padding: 2px;margin: 2px;border: 1px solid #cccccc;background-color: #FFFFFF;" class="img" width="<?=$w ?>" height="<?=$h ?>" src="../upload/banner/<?=$details["resim_$code"] ?>">
                                                                   <a href="acilis_sil.php?acilis_id=<?=$details["acilis_id"]?>&dil=<?=$code?>" onclick="return confirmDel();">Sil</a>
                                                               <?php } ?>
                                                               <p class="help-block"> (800x450) </p>
                                                           </div>
                                                        </div>
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