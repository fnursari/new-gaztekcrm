<?
defined('_ADMIN_GIRDI') or die('Erişim engellendi.');
if(canUserAccessAdminArea() && $_SESSION["user"]["group"]=='root')  
{
	$banka_id=$_GET['banka_id'];
	$sql="select * from banka where banka_id='$banka_id'";
	$details = $db->get_row($sql,ARRAY_A);

	?>
	<h1 class="page-title"></h1>
	<div class="row">
		<? require("islemsonucu.php"); ?>
		<div class="col-md-12">
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption ">
						<i class="fa fa-credit-card font-dark "></i>Banka Hesapları </div>
					</div>
					<div class="portlet-body">

						<table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
							<thead>
								<tr>
									<th width="5%">
										<label>
											<span>#</span>
										</label>
									</th>
									<!-- <th width="21">Sıra</th>  -->
									<th width="10%">Banka Adı</th> 
									<th width="20%">Şube</th> 
									<th width="10%">Hesap No</th> 
									<th width="25%">IBAN</th> 
									<th width="10%">Sıra</th> 
									<th width="5%">Durum</th> 
									<th width="15%">İşlemler</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$banka_x=0;
								$sql="select * from banka order by banka_id";
								$bankas = $db->get_results($sql,ARRAY_A);  
								if($db->num_rows > 0) {
									foreach ($bankas as $banka) {
										
										?>
										<tr>
											<!-- <td></td> -->
											<td><?=($banka_x+1);?></td>
											<td>
												<?=$banka["banka_ad"]?>
											</td>
											<td>
												<?=$banka["banka_sube"]?>
											</td>
											<td>
												<?=$banka["hesap_no"]?>
											</td>
											<td>
												<?=$banka["iban"]?>
											</td>
											
											<td style="vertical-align: middle;">
												<input style="width: 80px;" class="form-control" contenteditable="true" onBlur="saveToDatabase(this,'sira','<?php echo $banka["banka_id"]; ?>','banka','banka_id')"   onClick="showEdit(this);" type="text" name="sira" value="<?=$banka["sira"]; ?>">
											</td>
											<td style="vertical-align: middle;">
												<?php
												if ($banka["banka_aktif"]=="1") {
													$durum="Aktif";
													$color="green-meadow";
												} else{
													$durum="Pasif";
													$color="red";
												}                                                         
												?>
												<a href="banka_durum.php?banka_id=<?=$banka["banka_id"]?>&banka_aktif=<?=$banka["banka_aktif"]?>" class="btn btn-sm <?=$color?>" title="Aktif/Pasif"><?=$durum?></a>
											</td>
											
											<td>
												<a href="admin.php?cmd=bankalar&banka_id=<?=$banka["banka_id"]?>" class="btn btn-xs orange" title="Düzenle">
													<i class="fa fa-edit"></i> Düzenle
												</a>
												<a href="banka_sil.php?banka_id=<?=$banka["banka_id"]?>" class="btn btn-xs red" title="Sil" onclick="return confirmDel();">
													<i class="fa fa-trash"></i> Sil
												</a>
											</td>
										</tr>
										<?php
										$banka_x++;
									} 
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-md-12 ">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-plus font-dark"></i>
							<span class="caption-subject font-dark ">Hesap <?php echo (!$details)?"Ekle":"Düzenle - ".$details["banka_ad"] ?></span>
						</div>
					</div>
					<div class="portlet-body form">
						<?
						if (!$details) {
							?>
							<form action="banka_ekle_islem.php" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
								<? 
							} 
							else { 
								?>
								<form action="banka_guncelle_islem.php?banka_id=<?=$banka_id?>" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
									<? 
								} 
								?>    
								<div class="form-body">
									<div class="form-group">
										<label class="col-md-2 control-label">Banka</label>
										<div class="col-md-8">
											<input type="text" name="banka_ad" id="banka_ad" required="" class="form-control" value="<?=$details["banka_ad"]?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Şube</label>
										<div class="col-md-8">
											<input type="text" name="banka_sube" id="banka_sube" required="" class="form-control" value="<?=$details["banka_sube"]?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Hesap No</label>
										<div class="col-md-8">
											<input type="text" name="hesap_no" id="hesap_no" required="" class="form-control" value="<?=$details["hesap_no"]?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">IBAN</label>
										<div class="col-md-8">
											<input type="text" name="iban" id="iban" required="" class="form-control" value="<?=$details["iban"]?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Swift</label>
										<div class="col-md-8">
											<input type="text" name="swift" id="swift" required="" class="form-control" value="<?=$details["swift"]?>">
										</div>
									</div>

								</div>
								<?
								if (!$details) {
									?>
									<div class="form-actions">
										<div class="row">
											<div class="col-md-offset-2 col-md-9">
												<button type="submit" class="btn green">Ekle</button>
											</div>
										</div>
									</div>
								<? } else {?>
									<div class="form-actions">
										<div class="row">
											<div class="col-md-offset-2 col-md-9">
												<button type="submit" class="btn green">Güncelle</button>
											</div>
										</div>
									</div>
								<? } ?>
							</form>
						</div>
					</div>
				</div>
                          <!--   <div class="col-md-12">
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption ">
                                            <i class="fa fa-group font-dark "></i>Gruplar </div>
                                    </div>
                                    <div class="portlet-body">
                                        
                                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                                            <thead>
                                                <tr>
                                                    <th width="11">
                                                        <label>
                                                            <span>#</span>
                                                        </label>
                                                    </th>
                                                    <th width="21">Sıra</th> 
                                                    <th width="300">Adı</th> 
                                                    <th width="100">İşlemler</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $group_x=0;
                                                    $sql="select * from banka_group order by group_id";
                                                    $groups = $db->get_results($sql,ARRAY_A);  
                                                    if($db->num_rows > 0) {
                                                        foreach ($groups as $group) {
                                                      
                                                ?>
                                                    <tr>
                                                        <td></td>
                                                        <td><?=($group_x+1);?></td>
                                                        <td>
                                                            <?=$group["group_name"]?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                                if ($group["group_state"]=="1") {
                                                                    $durum="Aktif";
                                                                    $color="green-meadow";
                                                                } else{
                                                                    $durum="Pasif";
                                                                    $color="red";
                                                                }                                                         
                                                            ?>
                                                            <a href="grup_durum.php?group_id=<?=$group["group_id"]?>&group_state=<?=$group["group_state"]?>" class="btn btn-xs <?=$color?>" title="Aktif/Pasif"><?=$durum?></a>
                                                            <a href="admin.php?cmd=bankalar&group_id=<?=$group["group_id"]?>" class="btn btn-xs orange" title="Güncelle">
                                                                <i class="fa fa-edit"></i> Düzenle
                                                            </a>
                                                            <a href="grup_sil.php?group_id=<?=$group["group_id"]?>" class="btn btn-xs red" title="Sil" onclick="return confirmDel();">
                                                                <i class="fa fa-trash"></i> Sil
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php
                                                            $group_x++;
                                                        } 
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> -->
                           <!--  <div class="col-md-12 ">
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="icon-plus font-dark"></i>
                                            <span class="caption-subject font-dark ">Grup Ekle</span>
                                        </div>
                                    </div>
                                    <div class="portlet-body form">
                                        <?
                                            if (!$details_group) {
                                        ?>
                                        <form action="grup_ekle_islem.php" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
                                        <? } else { ?>
                                        <form action="grup_guncelle_islem.php?group_id=<?=$group_id?>" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
                                        <? } ?>    
                                            <div class="form-body">
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Grup Adı</label>
                                                    <div class="col-md-8">
                                                        <input type="text" name="group_name" id="group_name" required="" class="form-control" value="<?=$details_group["group_name"]?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <?
                                                if (!$details_group) {
                                            ?>
                                            <div class="form-actions">
                                                <div class="row">
                                                    <div class="col-md-offset-3 col-md-9">
                                                        <button type="submit" class="btn green">Ekle</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <? } else {?>
                                            <div class="form-actions">
                                                <div class="row">
                                                    <div class="col-md-offset-3 col-md-9">
                                                        <button type="submit" class="btn green">Güncelle</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <? } ?>
                                        </form>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <?php } ?>