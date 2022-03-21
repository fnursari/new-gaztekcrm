<?
defined('_ADMIN_GIRDI') or die('Erişim engellendi.');
if(canUserAccessAdminArea() && $_SESSION["user"]["group"]=='root')  
{
	$user_id=$_GET['user_id'];
	$sql="select * from u1s9e2r6 where user_id='$user_id'";
	$details = $db->get_row($sql,ARRAY_A);
	$g_id=$details["group_id"];

	$group_id=$_GET['group_id'];
	$sql="select * from u1s9e2r6_group where group_id='$group_id'";
	$details_group = $db->get_row($sql,ARRAY_A);
	?>
	<h1 class="page-title"></h1>
	<div class="row">
		<? require("islemsonucu.php"); ?>
		<div class="col-md-12">
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption ">
						<i class="fa fa-users font-dark "></i>Kullanıcılar </div>
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
									<th width="200">Kullanıcı Adı</th> 
									<th width="200">Grup</th> 
									<th width="300">Email</th> 
									<th width="100">İşlemler</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$user_x=0;
								$sql="select * from u1s9e2r6 order by user_id";
								$users = $db->get_results($sql,ARRAY_A);  
								if($db->num_rows > 0) {
									foreach ($users as $user) {
										$groupid=$user["group_id"];
										$group_name=$db->get_row("select * from u1s9e2r6_group where group_id='$groupid'",ARRAY_A);

										?>
										<tr>
											<td></td>
											<td><?=($user_x+1);?></td>
											<td>
												<?=$user["name"]?>
											</td>
											<td>
												<?=$user["user_name"]?>
											</td>
											<td>
												<?=$group_name["group_display_name"]?>
											</td>
											<td>
												<?=$user["user_email"]?>
											</td>
											<td>
												<a href="admin.php?cmd=kullanicilar&user_id=<?=$user["user_id"]?>" class="btn btn-xs orange" title="Düzenle">
													<i class="fa fa-edit"></i> Düzenle
												</a>
												<a href="kullanici_sil.php?user_id=<?=$user["user_id"]?>" class="btn btn-xs red" title="Sil" onclick="return confirmDel();">
													<i class="fa fa-trash"></i> Sil
												</a>
											</td>
										</tr>
										<?php
										$user_x++;
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
							<span class="caption-subject font-dark ">Kullanıcı Ekle/Düzenle</span>
						</div>
					</div>
					<div class="portlet-body form">
						<?
						if (!$details) {
							?>
							<form action="kullanici_ekle_islem.php" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
								<? 
							} 
							else { 
								?>
								<form action="kullanici_guncelle_islem.php?user_id=<?=$user_id?>" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
									<? 
								} 
								?>    
								<div class="form-body">
									<div class="form-group">
										<label class="col-md-2 control-label">Adı</label>
										<div class="col-md-8">
											<input type="text" name="name" id="name" required="" class="form-control" value="<?=$details["name"]?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Email</label>
										<div class="col-md-8">
											<input type="text" name="user_email" id="user_email" required="" class="form-control">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Grup</label>
										<div class="col-md-8">
											<select name="group_id" id="group_id" required class="form-control">
												<option value="">Grup Seçiniz</option>
												<?
												$sql="SELECT * from u1s9e2r6_group where group_state='1'  order by group_id"; 
												$gruplar = $db->get_results($sql,ARRAY_A);  
												if($db->num_rows > 0)
												{
													foreach ($gruplar as $grup)  
													{
														if($g_id==$grup["group_id"]) $selected='selected="selected"';
														else $selected="";
														echo '<option value="'.$grup["group_id"].'" '.$selected.'>'.$grup["group_display_name"].'</option>';
													}
												}
												?>
											</select>
										</div>
									</div>

									<?php 
									if (!$details) {
										?>
										<div class="form-group">
											<label class="col-md-2 control-label">Kullanıcı Adı</label>
											<div class="col-md-8">
												<input type="text" name="user_name" id="user_name" required="" class="form-control">
											</div>
										</div>
									<? } ?>
									<div class="form-group">
										<label class="col-md-2 control-label">Şifre</label>
										<div class="col-md-8">
											<input type="text" name="user_pass" id="user_pass" required="" class="form-control">
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
                                                    $sql="select * from u1s9e2r6_group order by group_id";
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
                                                            <a href="admin.php?cmd=kullanicilar&group_id=<?=$group["group_id"]?>" class="btn btn-xs orange" title="Güncelle">
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