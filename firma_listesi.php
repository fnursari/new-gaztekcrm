<?
defined('_ADMIN_GIRDI') or die('Erişim engellendi.');
if(canUserAccessAdminArea()) {
	$str = makeSafe($_REQUEST["str"]);
	?>
	<h1 class="page-title"></h1>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet light portlet-fit bordered">
				<div class="portlet-title">
					<div class="caption">
						<span class="caption-subject font-dark bold uppercase">Firma Listesi</span>
					</div>    
				</div>
				<div class="portlet-body">
					<? require("islemsonucu.php"); ?>
					<form action="admin.php?cmd=firma_listesi&sayfanum=<?=$sayfanum?>" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
						<div class="form-body">
							<div class="form-group">
								<div class="col-md-4">
									<input type="text" class="form-control" id="str"  name="str" value="<?=$str;?>" placeholder="Arama">
								</div>

								<div class="col-md-2">
									<button type="submit" class="btn green">Ara</button>
								</div>

							</div>
						</div>
					</form>
					<table class="table table-striped table-bordered table-hover table-checkable order-column">
						<thead>
							<tr>
								<th width="1%">Sıra</th> 
								<th width="15%">Firma Adı</th> 
								<th width="15%">Telefon</th> 
								<th width="15%">Yetkili</th> 
								<th width="15%">Yetkili Telefon</th> 
								<th width="15%">Email</th> 
								<th width="30%">İşlemler</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$maxsql="SELECT count(firma_id) from firma  where firma_silindi='0'";
							if($str!="") {
								$maxsql.=" and ( (firma_ad like '%$str%') or (firma_telefon like '%$str%') or (firma_yetkili like '%$str%')or (firma_email like '%$str%') )";
							}
							$num=$db->get_var($maxsql); 
							$per_page = 20; 
							$showeachside = 5; 
							$start=$sayfanum*$per_page;
							if(empty($start))$start=0;  
							$max_pages = ceil($num / $per_page); 
							$cur = ceil($start / $per_page)+1; 
							$urun_x=0;

							$sql="SELECT * from firma where firma_silindi='0'";
							if($str!="") {
								$sql.=" and ( (firma_ad like '%$str%') or (firma_telefon like '%$str%') or (firma_yetkili like '%$str%')or (firma_email like '%$str%') )";
							}
							$sql.=" order by firma_id desc limit $start,$per_page";
							$firma_x=0;
							$firmalar = $db->get_results($sql,ARRAY_A);   
							if($db->num_rows > 0) {
								foreach ($firmalar as $firma) {
									?>
									<tr>
										<td style="vertical-align: middle;"><?php echo ($firma_x+1);?></td>
										<td style="vertical-align: middle;"><?php echo $firma["firma_ad"]?></td>
										<td style="vertical-align: middle;"><?php echo beautifyPhone($firma["firma_telefon"])?></td>
										<td style="vertical-align: middle;"><?php echo $firma["firma_yetkili"]?></td>
										<td style="vertical-align: middle;"><?php echo beautifyPhone($firma["firma_yetkili_telefon"])?></td>
										<td style="vertical-align: middle;"><?php echo $firma["firma_email"]?></td>
										<td style="vertical-align: middle;">

											<a  href="admin.php?cmd=bilgi_giris&firma_id=<?php echo $firma["firma_id"]?>" class="btn btn-xs green" title="Bilgi Giriş">
												<i class="icon-book-open"></i> Bilgi Giriş 
											</a>
											<a target="_blank" href="admin.php?cmd=ziyaret_listesi&firma_id=<?php echo $firma["firma_id"]?>" class="btn btn-xs purple" title="Düzenle">
												<i class="fa fa-list"></i> Ziyaretler
											</a>
											<a href="admin.php?cmd=firma_guncelle&firma_id=<?php echo $firma["firma_id"]?>" class="btn btn-xs orange" title="Düzenle">
												<i class="fa fa-edit"></i> Düzenle
											</a>
											<a href="firma_sil.php?firma_id=<?php echo $firma["firma_id"]?>" class="btn btn-xs red" title="Sil" onclick="return confirmDel();">
												<i class="fa fa-trash"></i> Sil
											</a>
										</td>
									</tr>
									<?php
									$firma_x++;
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
							echo '<a class="btn default" href="admin.php?cmd='.$cmd.'&str='.$str.'&sayfanum='.($next>0?("").($next/$per_page):"").'">&lt; Önceki</a> ';
						}

						$eitherside = ($showeachside * $per_page);
						if($start+1 > $eitherside)print (" .... ");
						$pg=1;
						for($y=0;$y<$num;$y+=$per_page)
						{
							$class=($y==$start)?"red":"default";
							if(($y > ($start - $eitherside)) && ($y < ($start + $eitherside)))
							{
								echo '<a class="'.$class.' btn" href="admin.php?cmd='.$cmd.'&str='.$str.'&sayfanum='.($y>=0?("").($y/$per_page):"").'">'.$pg.'</a> ';
							}
							$pg++;
						}
						if(($start+$eitherside)<$num)print (" ... ");
						if($start+$per_page<$num)
						{
							echo ' <a class="btn default" href="admin.php?cmd='.$cmd.'&str='.$str.'&sayfanum='.(max(0,$start+$per_page)/$per_page).'">Sonraki &gt;</a> ';
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