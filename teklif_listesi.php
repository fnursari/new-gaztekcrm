<?
defined('_ADMIN_GIRDI') or die('Erişim engellendi.');
if(canUserAccessAdminArea()) {
	$firma_id = makeSafe($_REQUEST["firma_id"]);
	$teklif_tarihi = makeSafe($_REQUEST["teklif_tarihi"]);
	/*$tarih2 = makeSafe($_REQUEST["tarih2"]);*/
	$gonderen_id = makeSafe($_REQUEST["gonderen_id"]);
	$str = makeSafe($_REQUEST["str"]);
	if($_SESSION["user"]["group"]=="root") {
		$gonderen_id = $_SESSION["user"]["user_id"];
	}
	?>
	<h1 class="page-title"></h1>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet light portlet-fit bordered">
				<div class="portlet-title">
					<div class="caption">
						<span class="caption-subject font-dark bold uppercase">Teklif Listesi</span>
					</div>    
				</div>
				<div class="portlet-body">
					<? require("islemsonucu.php"); ?>
					<form action="admin.php?cmd=teklif_listesi&sayfanum=<?=$sayfanum?>" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
						<div class="form-body">
							<div class="form-group">
								<div class="col-md-3">
									<select name="firma_id" id="teklif_firma_ad" class="form-control">
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
										<input type="text" class="form-control" id="teklif_tarihi"  name="teklif_tarihi" value="<?=$teklif_tarihi;?>" placeholder="Teklif Tarihi">
										<span class="input-group-btn">
											<button class="btn default" type="button">
												<i class="fa fa-calendar"></i>
											</button>
										</span>
									</div>
								</div>
								<!-- <div class="col-md-2">
									<div class="input-group date datepicker" data-date-format="yyyy-mm-dd">
										<input type="text" class="form-control" id="tarih2"  name="tarih2" value="<?=$tarih2;?>" placeholder="Bitiş Tarihi">
										<span class="input-group-btn">
											<button class="btn default" type="button">
												<i class="fa fa-calendar"></i>
											</button>
										</span>
									</div>
								</div> -->
								<?php
								if($_SESSION["user"]["group"]=="root") {
									?>
									<div class="col-md-2">
										<select name="gonderen_id" id="gonderen_id" class="form-control">
											<option value="">--Gönderen Seçiniz--</option>
											<?
											$users = getUsers();
											
											if(!is_null($users)) {
												foreach ($users as $user) {
													$selected = $user["user_id"] == $gonderen_id ? 'selected="selected"' : '';
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
								<th width="15%">Teklif Tarihi</th> 
								<th width="15%">Gönderen</th> 
								<th width="10%">Satış Tipi</th> 
								<th width="15%">Satış Temsilcisi</th> 
								<th width="20%">İşlemler</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$maxsql="SELECT count(t.teklif_id) from teklifler t left join bilgi_giris b on t.bilgi_giris_id=b.bilgi_giris_id left join u1s9e2r6 u on t.gonderen_id=u.user_id  where t.teklif_silindi='0'";
							if($bilgi_giris_id!="") {
								$maxsql.=" and t.bilgi_giris_id='$bilgi_giris_id'";
							}
							if($teklif_tarihi!="") {
								$maxsql.=" and t.teklif_tarihi='$teklif_tarihi'";
							}
							/*if($tarih2!="") {
								$maxsql.=" and t.teklif_tarihi<'$tarih2 23:59:59'";
							}*/
							if($gonderen_id!="") {
								$maxsql.=" and t.gonderen_id='$gonderen_id'";
							}
							if($str!="") {
								$maxsql.=" and ( (b.satis_tipi like '%$str%') or (b.satis_temsilcisi like '%$str%') )";
							}
							$num=$db->get_var($maxsql); 
							$per_page = 20; 
							$showeachside = 5; 
							$start=$sayfanum*$per_page;
							if(empty($start))$start=0;  
							$max_pages = ceil($num / $per_page); 
							$cur = ceil($start / $per_page)+1; 
							$urun_x=0;

							$sql="SELECT t.*,b.* from teklifler t left join bilgi_giris b on t.bilgi_giris_id=b.bilgi_giris_id where t.teklif_silindi='0'";
							if($firma_id!="") {
								$sql.=" and t.firma_id='$firma_id'";
							}
							if($teklif_tarihi!="") {
								$sql.=" and t.teklif_tarihi='$teklif_tarihi'";
							}
							/*if($tarih2!="") {
								$sql.=" and t.teklif_tarihi<'$tarih2 23:59:59'";
							}*/
							if($gonderen_id!="") {
								$sql.=" and t.gonderen_id='$gonderen_id'";
							}
							if($str!="") {
								$sql.=" and ( (b.satis_tipi like '%$str%') or (b.satis_temsilcisi like '%$str%') )";
							}
							$sql.=" order by teklif_id desc limit $start,$per_page";
							
							
							$teklif_x=0;
							$teklifler = $db->get_results($sql,ARRAY_A);

							if($db->num_rows > 0) {
								foreach ($teklifler as $teklif) {
									$satis_tipi=getParameter($teklif["satis_tipi"]);
									$satis_temsilcisi=getParameter($teklif["satis_temsilcisi"]);
									?>
									<tr>
										<td style="vertical-align: middle;"><?php echo ($teklif_x+1);?></td>
										<td style="vertical-align: middle;"><?php echo $teklif["firma_ad"]?></td>
										<td style="vertical-align: middle;"><?php echo $teklif["teklif_tarihi"]?></td>
										<td style="vertical-align: middle;"><?php echo $teklif["gonderen"]?></td>
										<td style="vertical-align: middle;"><?php echo $satis_tipi["parametre_deger_tr"]?> </td>
										<td style="vertical-align: middle;"><?php echo $satis_temsilcisi["parametre_deger_tr"]?> </td>
										<td style="vertical-align: middle;">
											<a href="admin.php?cmd=bilgi_giris_guncelle&bilgi_giris_id=<?php echo $teklif["bilgi_giris_id"]?>" class="btn btn-xs orange" title="Düzenle">
												<i class="fa fa-edit"></i> Düzenle
											</a>
											<a href="teklif_sil.php?teklif_id=<?php echo $teklif["teklif_id"]?>" class="btn btn-xs red" title="Sil" onclick="return confirmDel();">
												<i class="fa fa-trash"></i> Sil
											</a>
										</td>
									</tr>
									<?php
									$teklif_x++;
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
							echo '<a class="btn default" href="admin.php?cmd='.$cmd.'&firma_id='.$firma_id.'&teklif_tarih='.$teklif_tarih.'&gonderen_id='.$gonderen_id.'&str='.$str.'&sayfanum='.($next>0?("").($next/$per_page):"").'">&lt; Önceki</a> ';
						}

						$eitherside = ($showeachside * $per_page);
						if($start+1 > $eitherside)print (" .... ");
						$pg=1;
						for($y=0;$y<$num;$y+=$per_page)
						{
							$class=($y==$start)?"red":"default";
							if(($y > ($start - $eitherside)) && ($y < ($start + $eitherside)))
							{
								echo '<a class="'.$class.' btn" href="admin.php?cmd='.$cmd.'&firma_id='.$firma_id.'&teklif_tarih='.$teklif_tarih.'&gonderen_id='.$gonderen_id.'&str='.$str.'&sayfanum='.($y>=0?("").($y/$per_page):"").'">'.$pg.'</a> ';
							}
							$pg++;
						}
						if(($start+$eitherside)<$num)print (" ... ");
						if($start+$per_page<$num)
						{
							echo ' <a class="btn default" href="admin.php?cmd='.$cmd.'&firma_id='.$firma_id.'&teklif_tarih='.$teklif_tarih.'&gonderen_id='.$gonderen_id.'&str='.$str.'&sayfanum='.(max(0,$start+$per_page)/$per_page).'">Sonraki &gt;</a> ';
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