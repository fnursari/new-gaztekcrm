<?php
	date_default_timezone_set("Europe/Istanbul");
	$host = $_SERVER["HTTP_HOST"];

	if($host === "localhost" || strpos($host, "192.168.") === 0){
		$hostcfg = [
			"DatabaseName"      => 'gaztekcrm2',
			"DatabaseHost"      => 'localhost',
			"DatabaseUsername"  => 'root',
			"DatabasePassword"  => '',
			"SiteRoot" 			=> 'E:/wamp64/www/gaztekcrm/',
			"SiteUrl" 			=> 'http://localhost/gaztekcrm/',
			"cookieDomain" 		=> 'localhost',
			"public_key" 		=> '6LdN5YUaAAAAABqgjT2GrqL2McNy1f_EImdlw9LI',
			"secret_key" 		=> '6LdN5YUaAAAAABbkJwbZE7J9qiNBQZXYL79W7w4D',
			"mode" 				=> 'dev',
		];
	} else {
		$hostcfg = [
			"DatabaseName"      => 'mtrsan_db',
			"DatabaseHost"      => 'localhost',
			"DatabaseUsername"  => 'mtrsan_usr',
			"DatabasePassword"  => 'ESQ7FD02K',
			"SiteRoot" 			=> '/home/eklf/domains/ekolfirinmakina.com.tr/public_html/',
			"SiteUrl" 			=> 'https://www.ekolfirinmakina.com.tr/',
			"cookieDomain" 		=> '.ekolfirinmakina.com.tr',
			"emailEnabled" 		=> true,
			"public_key" 		=> '6Ld0gPgaAAAAAMQK4ajjFqeOlaMt59APLIMEhaYD',
			"secret_key" 		=> '6Ld0gPgaAAAAAIdf05mAHrJgNHGBTTJMT-I9mjoG',
			"mode" 				=> 'live',
		];
	}
	$defaultcfg = [
		"UploadDir"         => 'upload/',
		"makeSafe" 			=> '1',
		"FileUpload" 		=> 
		[
			"file"              => [],
			"filename"              => '',
			"uploadfolder"      => $hostcfg["SiteRoot"].'upload/',
			"preservefilename"  => false,
			"allowed_filetypes" => array('.pdf','.doc','.docx','.zip')
		],

		"ImageUpload" 		=> 
		[
			"image"             => [],
			"imagename"              => '',
			"resize"			=> true,
			"resizedata" 		=>
			[
				"type"			=> "fit",
				"width"			=> 800,
				"height"		=> 600
			],
			"overlay"			=> false,
			"overlayimg"		=> $hostcfg["SiteRoot"].'upload/overlay.png',
			"uploadfolder"      => $hostcfg["SiteRoot"].'upload/',
			"preserveimagename" => false,
			"allowed_imagetypes" => array('.jpg','.jpeg','.gif','.png','.svg')


		]
	];

	$dilcfg = [
		"uyari_tr"         => 'Sayfa İçeriği Hazırlanıyor',
		"uyari_en"         => 'Preparing The Page Content',
		"uyari_de"         => 'Preparing The Page Content',
		"uyari_sq"         => 'Preparing The Page Content',
		"uyari_ru"         => 'Страница на стадии разработки',
		"uyari_fr"         => 'Prepare le contenu de page',
		"uyari_ar"         => 'إعداد محتوى الصفحة',
		"video_tr"         => 'Videolar',
		"video_en"         => 'Videos',
		"video_de"         => 'Videos',
		"video_sq"         => 'Videos',
		"video_ru"         => 'Videos',
		"video_fr"         => 'Videos',
		"video_ar"         => 'Videos',
	];

	$cfg = $defaultcfg + $hostcfg + $dilcfg;
?>