<?
defined('_ADMIN_GIRDI') or die('Erişim engellendi.');
if(canUserAccessAdminArea()) {
	$ana_id=$_GET["ana_id"];
	$anakategorioptiongoster=1;
	?>
	<h1 class="page-title"></h1>
	<div class="row">
		<div class="col-md-12 ">
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-plus font-dark"></i>
						<span class="caption-subject font-dark sbold uppercase">Firma Ekle</span>
					</div>
				</div>
				<div class="portlet-body form">
					<? require("islemsonucu.php"); ?>
					<form action="firma_ekle_islem.php" enctype="multipart/form-data" method="post" class="form-horizontal" role="form">
						<div class="tabbable-custom ">
							<ul class="nav nav-tabs ">
								<li class="active">
									<a href="#tab_genel" data-toggle="tab"> Firma Bilgileri </a>
								</li>

							</ul>
							<div class="tab-content">
								<div class="tab-pane active" id="tab_genel">
									<div class="form-group">
										<label class="col-md-2 control-label">Firma Adı</label>
										<div class="col-md-8">
											<input type="text" name="firma_ad" id="firma_ad" class="form-control" value="" required="">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Firma Telefon</label>
										<div class="col-md-4">
											<input type="tel" name="firma_telefon" id="firma_telefon" class="form-control phone-number" value="">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Firma Telefon 1</label>
										<div class="col-md-4">
											<input type="tel" name="firma_telefon1" id="firma_telefon1" class="form-control phone-number" value="">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Firma Telefon 2</label>
										<div class="col-md-4">
											<input type="tel" name="firma_telefon2" id="firma_telefon2" class="form-control phone-number" value="">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Firma Adres</label>
										<div class="col-md-8">
											<textarea name="firma_adres" id="firma_adres" class="form-control" rows="3"></textarea>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Firma Cep Telefon</label>
										<div class="col-md-4">
											<input type="tel" name="firma_ceptelefon" id="firma_ceptelefon" class="form-control phone-number" value="">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Firma Cep Telefon 1</label>
										<div class="col-md-4">
											<input type="tel" name="firma_ceptelefon1" id="firma_ceptelefon1" class="form-control phone-number" value="">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Firma Cep Telefon 2</label>
										<div class="col-md-4">
											<input type="tel" name="firma_ceptelefon2" id="firma_ceptelefon2" class="form-control phone-number" value="">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Firma Yetkili</label>
										<div class="col-md-6">
											<input type="text" name="firma_yetkili" id="firma_yetkili" class="form-control" value="">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Firma Yetkili Telefon</label>
										<div class="col-md-4">
											<input type="tel" name="firma_yetkili_telefon" id="firma_yetkili_telefon" class="form-control phone-number" value="">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Firma Fax</label>
										<div class="col-md-4">
											<input type="tel" name="firma_fax" id="firma_fax" class="form-control phone-number" value="">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Firma Email</label>
										<div class="col-md-6">
											<input type="email" name="firma_email" id="firma_email" class="form-control" value="">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Firma Web</label>
										<div class="col-md-6">
											<input type="text" name="firma_web" id="firma_web" class="form-control" value="">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Firma Vergi Daire</label>
										<div class="col-md-4">
											<input type="text" name="firma_vergidaire" id="firma_vergidaire" class="form-control" value="" >
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Firma Vergi No</label>
										<div class="col-md-4">
											<input type="number" name="firma_vergino" id="firma_vergino" class="form-control" value="" max="99999999999">
										</div>
									</div>

								</div>

							</div>

						</div>
						<div class="form-actions">
							<div class="row">
								<div class="col-md-offset-2 col-md-9">
									<button type="submit" class="btn green">Ekle</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<?php 
} 
