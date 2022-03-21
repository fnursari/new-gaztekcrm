
<?php

defined('_ADMIN_GIRDI') or die('Erişim engellendi.');
if(canUserAccessAdminArea()) {

	$dil=$_GET["dil"];
	$pdf=$_GET["pdf"];
	if($pdf=="sozlesme"){
		$pdf_name="SÖZLEŞME";
	}else{
		$pdf_name=ucwords($pdf);
	}
	


	$bilgi_giris_id=makeSafe($_GET['bilgi_giris_id']);
	$sql="select * from bilgi_giris where bilgi_giris_id='$bilgi_giris_id' and bilgi_giris_aktif='1'";
	$details = $db->get_row($sql,ARRAY_A);

	$sqlteklif="select * from teklifler where bilgi_giris_id='$bilgi_giris_id'";
	$detailsteklif = $db->get_row($sqlteklif,ARRAY_A);
	$teklif_id=$detailsteklif["teklif_id"];

	$config = getConfig();
	if(!is_null($details)) {
		?>
		<div class="row">
			<div class="col-md-12 ">
				<a href="admin.php?cmd=bilgi_giris_guncelle&bilgi_giris_id=<?php echo $bilgi_giris_id ?>"> < Geri Dön</a>
			</div>
		</div>
		<h1 class="page-title" id="offer"></h1>
		<div class="row">
			<div class="col-md-12 ">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-plus font-dark"></i>
							<span class="caption-subject font-dark sbold uppercase"><?=$pdf_name?> - <?=$details["firma_ad"];?></span>
						</div>
					</div>
					<div class="portlet-body form">

						<? require("islemsonucu.php"); ?>
						<?php 
						if($pdf=="teklif"){
							?>
							<iframe id="iframepdf" width="100%" height="600px" src="<?php echo $cfg["SiteUrl"] ?>upload/pdfs/proposals/<?php echo $detailsteklif["teklif_pdf_$dil"] ?>"></iframe>
							<?php
						}
						?>
						<?php 
						if($pdf=="proforma"){
							?>
							<iframe id="iframepdf" width="100%" height="600px" src="<?php echo $cfg["SiteUrl"] ?>upload/pdfs/proforma/<?php echo $detailsteklif["proforma_pdf_$dil"] ?>"></iframe>
							<?php 
						}
						?>
						<?php 
						if($pdf=="sozlesme"){
							?>
							<iframe id="iframepdf" width="100%" height="600px" src="<?php echo $cfg["SiteUrl"] ?>upload/pdfs/contract/<?php echo $detailsteklif["sozlesme_pdf_$dil"] ?>"></iframe>
							<?php 
						}
						?>



						<form action="mail_gonder.php?teklif_id=<?=$teklif_id?>&pdf=<?=$pdf?>&dil=<?=$dil?>" method="post" enctype="multipart/form-data" class="ml-2 mr-2" style="display: inline-block;margin-top: 15px;">
							<button type="submit" name="sendmail" class="btn btn-primary mt-2">Mail Gönder <?php echo $name ?></button>
						</form>
					</div>
				</div>
			</div>
		</div>

		<?php 

	} 
} 
