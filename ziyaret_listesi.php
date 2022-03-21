<?
defined('_ADMIN_GIRDI') or die('Erişim engellendi.');
if(canUserAccessAdminArea()) {
	$firma_id = makeSafe($_REQUEST["firma_id"]);
	$tarih1 = makeSafe($_REQUEST["tarih1"]);
	$tarih2 = makeSafe($_REQUEST["tarih2"]);
	$kullanici_id = makeSafe($_REQUEST["kullanici_id"]);
	$str = makeSafe($_REQUEST["str"]);
	if($_SESSION["user"]["group"]!="root") {
		$kullanici_id = $_SESSION["user"]["user_id"];
	}
	?>
	<h1 class="page-title"></h1>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet light portlet-fit bordered">
				<div class="portlet-title">
					<div class="caption">
						<span class="caption-subject font-dark bold uppercase">Ziyaret Listesi</span>
					</div>    
				</div>
				<div class="portlet-body">
					<? require("islemsonucu.php"); ?>
					<form action="admin.php?cmd=ziyaret_listesi&sayfanum=<?=$sayfanum?>" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
						<div class="form-body">
							<div class="form-group">
								<div class="col-md-3">
									<select name="firma_id" id="ziyaret_firma_ad" class="form-control">
										<option value="">--Firma Seçiniz--</option>
										<?
										$companies = getCompanies();
										if(!is_null($companies)) {
											foreach ($companies as $company) {
												$selected = $firma_id==$company["firma_id"] ? 'selected="selected"' : '';
												?>
												<option <?php echo $selected?> value="<?=$company["firma_id"]?>"><?=$company["firma_ad"]?></option>
												<?
											}
										}
										?>
									</select>
								</div>
								<div class="col-md-2">
									<div class="input-group date datepicker" data-date-format="yyyy-mm-dd">
										<input type="text" class="form-control" id="tarih1"  name="tarih1" value="<?=$tarih1;?>" placeholder="Başlangıç Tarihi">
										<span class="input-group-btn">
											<button class="btn default" type="button">
												<i class="fa fa-calendar"></i>
											</button>
										</span>
									</div>
								</div>
								<div class="col-md-2">
									<div class="input-group date datepicker" data-date-format="yyyy-mm-dd">
										<input type="text" class="form-control" id="tarih2"  name="tarih2" value="<?=$tarih2;?>" placeholder="Bitiş Tarihi">
										<span class="input-group-btn">
											<button class="btn default" type="button">
												<i class="fa fa-calendar"></i>
											</button>
										</span>
									</div>
								</div>
								<?php
								if($_SESSION["user"]["group"]=="root") {
									?>
									<div class="col-md-2">
										<select name="kullanici_id" id="kullanici_id" class="form-control">
											<option value="">--Kullanıcı Seçiniz--</option>
											<?
											$users = getUsers();
											if(!is_null($users)) {
												foreach ($users as $user) {
													$selected = $user["user_id"] == $kullanici_id ? 'selected="selected"' : '';
													?>
													<option <?php echo $selected?>  value="<?=$user["user_id"]?>"><?=$user["name"]?></option>
													<?
												}
											}
											?>
										</select>
									</div>
									<?php
								}
								?>
								<div class="col-md-2">
									<input type="text" class="form-control" id="str"  name="str" value="<?=$str;?>" placeholder="Arama">
								</div>

								<div class="col-md-1">
									<button type="submit" class="btn green">Ara</button>
								</div>

							</div>
						</div>
					</form>
					<table class="table table-striped table-bordered table-hover table-checkable order-column">
						<thead>
							<tr>
								<th width="1%">Sıra</th> 
								<th width="25%">Firma</th> 
								<th width="15%">Ziyaret Tarihi</th> 
								<th width="20%">Ziyaret Konusu</th> 
								<th width="10%">Görüşülen Kişi</th> 
								<th width="10%">Ziyareti Gerçekleştiren</th> 
								<th width="20%">İşlemler</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$maxsql="SELECT count(z.ziyaret_id) from ziyaret z left join firma f on z.firma_id=f.firma_id left join u1s9e2r6 u on z.kullanici_id=u.user_id  where z.ziyaret_silindi='0'";
							if($firma_id!="") {
								$maxsql.=" and z.firma_id='$firma_id'";
							}
							if($tarih1!="") {
								$maxsql.=" and z.ziyaret_tarihi>'$tarih1 00:00:01'";
							}
							if($tarih2!="") {
								$maxsql.=" and z.ziyaret_tarihi<'$tarih2 23:59:59'";
							}
							if($kullanici_id!="") {
								$maxsql.=" and z.kullanici_id='$kullanici_id'";
							}
							if($str!="") {
								$maxsql.=" and ( (z.ziyaret_konusu like '%$str%') or (z.gorusulen_kisi like '%$str%') or (f.firma_ad like '%$str%') )";
							}
							$num=$db->get_var($maxsql); 
							$per_page = 20; 
							$showeachside = 5; 
							$start=$sayfanum*$per_page;
							if(empty($start))$start=0;  
							$max_pages = ceil($num / $per_page); 
							$cur = ceil($start / $per_page)+1; 
							$urun_x=0;

							$sql="SELECT z.*,f.firma_ad,u.name from ziyaret z left join firma f on z.firma_id=f.firma_id left join u1s9e2r6 u on z.kullanici_id=u.user_id  where z.ziyaret_silindi='0'";
							if($firma_id!="") {
								$sql.=" and z.firma_id='$firma_id'";
							}
							if($tarih1!="") {
								$sql.=" and z.ziyaret_tarihi>'$tarih1 00:00:01'";
							}
							if($tarih2!="") {
								$sql.=" and z.ziyaret_tarihi<'$tarih2 23:59:59'";
							}
							if($kullanici_id!="") {
								$sql.=" and z.kullanici_id='$kullanici_id'";
							}
							if($str!="") {
								$sql.=" and ( (z.ziyaret_konusu like '%$str%') or (z.gorusulen_kisi like '%$str%') or (f.firma_ad like '%$str%') )";
							}
							$sql.=" order by ziyaret_id desc limit $start,$per_page";
							
							$ziyaret_x=0;
							$ziyaretler = $db->get_results($sql,ARRAY_A);   
							if($db->num_rows > 0) {
								foreach ($ziyaretler as $ziyaret) {
									?>
									<tr>
										<td style="vertical-align: middle;"><?php echo ($ziyaret_x+1);?></td>
										<td style="vertical-align: middle;"><?php echo $ziyaret["firma_ad"]?></td>
										<td style="vertical-align: middle;"><?php echo $ziyaret["ziyaret_tarihi"]?></td>
										<td style="vertical-align: middle;"><?php echo $ziyaret["ziyaret_konusu"]?></td>
										<td style="vertical-align: middle;"><?php echo $ziyaret["gorusulen_kisi"]?></td>
										<td style="vertical-align: middle;"><?php echo $ziyaret["name"]?></td>
										<td style="vertical-align: middle;">
											<a href="admin.php?cmd=ziyaret_guncelle&ziyaret_id=<?php echo $ziyaret["ziyaret_id"]?>" class="btn btn-xs orange" title="Düzenle">
												<i class="fa fa-edit"></i> Düzenle
											</a>
											<a href="ziyaret_sil.php?ziyaret_id=<?php echo $ziyaret["ziyaret_id"]?>" class="btn btn-xs red" title="Sil" onclick="return confirmDel();">
												<i class="fa fa-trash"></i> Sil
											</a>
										</td>
									</tr>
									<?php
									$ziyaret_x++;
								} 
							}
							?>
						</tbody>
					</table>
					<div class="pagination">    
						Toplam <?=$num?> kayıt. Sayfa <?=$cur?>/<?=$max_pages?>&nbsp;&nbsp;
						<?
						if(($start-$per_page) >= 0)
						{
							$next = ($start-$per_page);
							echo '<a class="btn default" href="admin.php?cmd='.$cmd.'&firma_id='.$firma_id.'&tarih1='.$tarih1.'&tarih2='.$tarih2.'&kullanici_id='.$kullanici_id.'&str='.$str.'&sayfanum='.($next>0?("").($next/$per_page):"").'">&lt; Önceki</a> ';
						}

						$eitherside = ($showeachside * $per_page);
						if($start+1 > $eitherside)print (" .... ");
						$pg=1;
						for($y=0;$y<$num;$y+=$per_page)
						{
							$class=($y==$start)?"red":"default";
							if(($y > ($start - $eitherside)) && ($y < ($start + $eitherside)))
							{
								echo '<a class="'.$class.' btn" href="admin.php?cmd='.$cmd.'&firma_id='.$firma_id.'&tarih1='.$tarih1.'&tarih2='.$tarih2.'&kullanici_id='.$kullanici_id.'&str='.$str.'&sayfanum='.($y>=0?("").($y/$per_page):"").'">'.$pg.'</a> ';
							}
							$pg++;
						}
						if(($start+$eitherside)<$num)print (" ... ");
						if($start+$per_page<$num)
						{
							echo ' <a class="btn default" href="admin.php?cmd='.$cmd.'&firma_id='.$firma_id.'&tarih1='.$tarih1.'&tarih2='.$tarih2.'&kullanici_id='.$kullanici_id.'&str='.$str.'&sayfanum='.(max(0,$start+$per_page)/$per_page).'">Sonraki &gt;</a> ';
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
	<?php 
}