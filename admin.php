<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {
	$cmd=$_GET["cmd"];
	if($cmd=="") $cmd="main";
	if(!file_exists($cmd.".php")) $cmd="main";
	$config = getConfig();
	$dfl=$config["default_lang"];
	$s=$_GET["s"];
	?>
	<!DOCTYPE html>
	<html lang="tr">
	<head>
		<meta charset="utf-8" />
		<title> Yönetim Paneli / <?=$config["company_name"]?></title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="width=device-width, initial-scale=1" name="viewport" />
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
		<link href="assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
		<link href="assets/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
		<link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="assets/dropzone/dropzone.min.css" rel="stylesheet" type="text/css" />
		<link href="assets/dropzone/basic.min.css" rel="stylesheet" type="text/css" />
		<link href="assets/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
		<link href="assets/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="assets/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" type="text/css" />
		<link href="assets/bootstrap-tagsinput/bootstrap-tagsinput-typeahead.css" rel="stylesheet" type="text/css" />
		<link href="assets/bootstrap-colorpicker/css/colorpicker.css" rel="stylesheet" type="text/css" />
		<link href="assets/jquery-minicolors/jquery.minicolors.css" rel="stylesheet" type="text/css" />
		<link href="assets/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
		<link href="assets/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
		<link href="assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
		<link href="assets/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
		<link href="assets/css/plugins.min.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/layout.min.css" rel="stylesheet" type="text/css" />
		<link href="assets/themes/darkblue.min.css" rel="stylesheet" type="text/css" id="style_color" />
		<link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon" />
		<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
			<div class="page-wrapper">
				<div class="page-header navbar navbar-fixed-top">
					<div class="page-header-inner ">
						<div class="page-logo">
							<div class="menu-toggler sidebar-toggler">
								<span></span>
							</div>
						</div>
						<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
							<span></span>
						</a>
						<div class="top-menu">
							<ul class="nav navbar-nav pull-right">
								<li>
									Son Giris Tarihiniz : <strong><i><?=turkce_tarih(makeUnixTime($_SESSION["user"]["last_online"]));?></i></strong>
								</li>
								<li class="dropdown dropdown-user">
									<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
										<span class="username username-hide-on-mobile"> Kullanıcı</span>
										<i class="fa fa-angle-down"></i>
									</a>
									<ul class="dropdown-menu dropdown-menu-default">
										<li>
											<a href="admin.php?cmd=bilgi_guncelle">
												<i class="icon-user"></i> Bilgi Güncelle
											</a>
										</li>
										<li class="divider"> </li>
										<li>
											<a href="logout.php">
												<i class="icon-key"></i> Çıkış
											</a>
										</li>
									</ul>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="clearfix"> </div>
				<div class="page-container">
					<div class="page-sidebar-wrapper">
						<div class="page-sidebar navbar-collapse collapse">
							<ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
								<li class="sidebar-toggler-wrapper hide">
									<div class="sidebar-toggler">
										<span></span>
									</div>
								</li>
								<li class="nav-item start <?=$cmd=="main" ? 'active' : ''?>">
									<a href="admin.php" class="nav-link nav-toggle">
										<i class="icon-home"></i>
										<span class="title">Anasayfa</span>
										<span class="selected"></span>
									</a>
								</li>
								<li class="heading">
									<h3 class="uppercase">İşlemler</h3>
								</li>
								<?php
								if($_SESSION["user"]["group"]=='root')  {
									?>

									<li class="nav-item <?=$cmd=="config_guncelle" ? 'active open' : ''?>">
										<a href="admin.php?cmd=config_guncelle" class="nav-link nav-toggle">
											<i class="icon-settings"></i>
											<span class="title">Ayarlar</span>

										</a>
									</li>
									<li class="nav-item <?=$cmd=="site_ayarlari" ? 'active open' : ''?>">
										<a href="admin.php?cmd=site_ayarlari" class="nav-link nav-toggle">
											<i class="icon-settings"></i>
											<span class="title">Site Ayarları</span>
											
										</a>
									</li>
									<li class="nav-item <?=$cmd=="parametreler" || $cmd=="parametre_guncelle" ? 'active open' : ''?>">
										<a href="" class="nav-link nav-toggle">
											<i class="icon-settings"></i>
											<span class="title">Parametreler</span>
											<span class="arrow"></span>
										</a>
										<ul class="sub-menu">
											<?php
											$parametre_tipleri = getParameterTypes();
											if(!is_null($parametre_tipleri)) {
												foreach ($parametre_tipleri as $tip) {
													?>
													<li class="nav-item">
														<a href="admin.php?cmd=parametreler&tip_id=<?php echo $tip["tip_id"]?>" class="nav-link ">
															<span class="title"><?php echo $tip["tip_adi"]?></span>
														</a>
													</li>
													<?
												}
											}
											?>
										</ul>
									</li>
									<li class="nav-item <?=$cmd=="kullanicilar" ? 'active open' : ''?>">
										<a href="admin.php?cmd=kullanicilar" class="nav-link nav-toggle">
											<i class="icon-user"></i>
											<span class="title">Kullanıcılar</span>

										</a>
									</li>
									<? 
								} 
								?>
								<li class="nav-item <?=$cmd=="bankalar" ? 'active open' : ''?>">
									<a href="admin.php?cmd=bankalar" class="nav-link nav-toggle">
										<i class="fa fa-credit-card"></i>
										<span class="title">Hesaplar</span>

									</a>
								</li>
								<li class="nav-item <?=$cmd=="firma_ekle" || $cmd=="firma_listesi"|| $cmd=="firma_guncelle" ? 'active open' : ''?>">
									<a href="" class="nav-link nav-toggle">
										<i class="icon-list"></i>
										<span class="title">Firmalar</span>
										<span class="arrow"></span>
									</a>
									<ul class="sub-menu">
										<li class="nav-item">
											<a href="admin.php?cmd=firma_ekle" class="nav-link ">
												<span class="title">Firma Ekle</span>
											</a>
										</li>
										<li class="nav-item">
											<a href="admin.php?cmd=firma_listesi" class="nav-link ">
												<span class="title">Firma Listesi</span>
											</a>
										</li>

									</ul>
								</li>
								<li class="nav-item <?=$cmd=="ziyaret_ekle" || $cmd=="ziyaret_listesi"|| $cmd=="ziyaret_guncelle" ? 'active open' : ''?>">
									<a href="" class="nav-link nav-toggle">
										<i class="icon-direction"></i>
										<span class="title">Ziyaretler</span>
										<span class="arrow"></span>
									</a>
									<ul class="sub-menu">
										<li class="nav-item">
											<a href="admin.php?cmd=ziyaret_ekle" class="nav-link ">
												<span class="title">Ziyaret Ekle</span>
											</a>
										</li>
										<li class="nav-item">
											<a href="admin.php?cmd=ziyaret_listesi" class="nav-link ">
												<span class="title">Ziyaret Listesi</span>
											</a>
										</li>

									</ul>
								</li>
								<li class="nav-item <?=$cmd=="bilgi_giris_ekle" || $cmd=="teklif_listesi"|| $cmd=="teklif" || $cmd=="bilgi_giris_guncelle" ? 'active open' : ''?>">
									<a href="" class="nav-link nav-toggle">
										<i class="fa fa-files-o"></i>
										<span class="title">Teklifler</span>
										<span class="arrow"></span>
									</a>
									<ul class="sub-menu">
										<li class="nav-item">
											<a href="admin.php?cmd=teklif_listesi" class="nav-link ">
												<span class="title">Teklif Listesi</span>
											</a>
										</li>

									</ul>
								</li>

							</ul>
						</div>
					</div>
					<div class="page-content-wrapper">
						<div class="page-content">
							<?
							require($cmd.".php");
							?>
						</div>
					</div>
				</div>
				<div class="page-footer">
					<div class="page-footer-inner"> Vizyoner Yönetim Paneli v.2.0 </div>
					<div class="scroll-to-top">
						<i class="icon-arrow-up"></i>
					</div>
				</div>
			</div>
			<script src="assets/js/jquery.min.js" type="text/javascript"></script>
			<script src="assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
			<script src="assets/js/js.cookie.min.js" type="text/javascript"></script>
			<script src="assets/js/jquery.blockui.min.js" type="text/javascript"></script>
			<script src="assets/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
			<script src="assets/dropzone/dropzone.min.js" type="text/javascript"></script>
			<script src="assets/morris/morris.min.js" type="text/javascript"></script>
			<script src="assets/select2/js/select2.full.min.js" type="text/javascript"></script>
			<script src="assets/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
			<script src="assets/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
			<script src="assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
			<script src="assets/bootstrap-datepicker/locales/bootstrap-datepicker.tr.min.js" type="text/javascript" charset="UTF-8"></script>
			<script src="assets/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
			<script src="assets/bootstrap-tagsinput/bootstrap-tagsinput.min.js" type="text/javascript"></script>
			<script src="assets/ckeditor/ckeditor.js" type="text/javascript"></script>
			<script src="assets/js/app.min.js" type="text/javascript"></script>
			<script src="assets/js/datatable.js" type="text/javascript"></script>
			<script src="assets/js/bootbox.min.js" type="text/javascript"></script>
			<script src="assets/datatables/datatables.min.js" type="text/javascript"></script>
			<script src="assets/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
			<script src="assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js" type="text/javascript"></script>
			<script src="assets/jquery-minicolors/jquery.minicolors.min.js" type="text/javascript"></script>
			<script src="assets/js/table-datatables-managed.min.js" type="text/javascript"></script>
			<script src="assets/js/jquery.inputmask.bundle.js" type="text/javascript"></script>
			<script src="assets/js/components-date-time-pickers.min.js" type="text/javascript"></script>
			<script src="assets/js/form-validation.min.js" type="text/javascript"></script>
			<script src="assets/js/layout.min.js" type="text/javascript"></script>
			<script src="assets/js/components-color-pickers.min.js" type="text/javascript"></script>
			<script src="assets/js/demo.min.js" type="text/javascript"></script>
			<script src="assets/js/site.js" type="text/javascript"></script>
		</body>
		</html>
		<?php
	}
	else header("location:loginform.php");