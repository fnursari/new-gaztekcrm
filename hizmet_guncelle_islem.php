<?
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {
	require("pictureprocess.php");
	
	$hizmet_id=$_GET["hizmet_id"];
	$hizmet_kodu=makeSafe($_POST['hizmet_kodu']);
	$hizmet_video=makeSafe($_POST['hizmet_video']);
	$hizmet_ad_tr=makeSafe($_POST['hizmet_ad_tr']);
	$hizmet_ad_en=makeSafe($_POST['hizmet_ad_en']);
	$hizmet_ad_de=makeSafe($_POST['hizmet_ad_de']);
	$hizmet_ad_ru=makeSafe($_POST['hizmet_ad_ru']);
	$hizmet_ad_ar=makeSafe($_POST['hizmet_ad_ar']);
	$hizmet_ad_fr=makeSafe($_POST['hizmet_ad_fr']);

	$hizmet_icerik_tr=makeSafe($_POST['hizmet_icerik_tr']);
	$hizmet_icerik_en=makeSafe($_POST['hizmet_icerik_en']);
	$hizmet_icerik_de=makeSafe($_POST['hizmet_icerik_de']);
	$hizmet_icerik_ru=makeSafe($_POST['hizmet_icerik_ru']);
	$hizmet_icerik_ar=makeSafe($_POST['hizmet_icerik_ar']);
	$hizmet_icerik_fr=makeSafe($_POST['hizmet_icerik_fr']);




	$seo_etiket_tr=makeSafe($_POST['seo_etiket_tr']);
	$seo_etiket_en=makeSafe($_POST['seo_etiket_en']);
	$seo_etiket_ru=makeSafe($_POST['seo_etiket_ru']);
	$seo_etiket_ar=makeSafe($_POST['seo_etiket_ar']);
	$seo_etiket_de=makeSafe($_POST['seo_etiket_de']);
	$seo_etiket_fr=makeSafe($_POST['seo_etiket_fr']);


	$aciklama_tr=makeSafe($_POST['aciklama_tr']);
	$aciklama_en=makeSafe($_POST['aciklama_en']);
	$aciklama_ru=makeSafe($_POST['aciklama_ru']);
	$aciklama_ar=makeSafe($_POST['aciklama_ar']);
	$aciklama_de=makeSafe($_POST['aciklama_de']);
	$aciklama_fr=makeSafe($_POST['aciklama_fr']);

	$seo_baslik_tr=makeSafe($_POST['seo_baslik_tr']);
	$seo_keyword_tr=makeSafe($_POST['seo_keyword_tr']);
	$seo_description_tr=makeSafe($_POST['seo_description_tr']);

	$seo_baslik_en=makeSafe($_POST['seo_baslik_en']);
	$seo_keyword_en=makeSafe($_POST['seo_keyword_en']);
	$seo_description_en=makeSafe($_POST['seo_description_en']);


	$seo_baslik_ru=makeSafe($_POST['seo_baslik_ru']);
	$seo_keyword_ru=makeSafe($_POST['seo_keyword_ru']);
	$seo_description_ru=makeSafe($_POST['seo_description_ru']);

	$seo_baslik_ar=makeSafe($_POST['seo_baslik_ar']);
	$seo_keyword_ar=makeSafe($_POST['seo_keyword_ar']);
	$seo_description_ar=makeSafe($_POST['seo_description_ar']);

	$seo_baslik_de=makeSafe($_POST['seo_baslik_de']);
	$seo_keyword_de=makeSafe($_POST['seo_keyword_de']);
	$seo_description_de=makeSafe($_POST['seo_description_de']);

	$seo_baslik_fr=makeSafe($_POST['seo_baslik_fr']);
	$seo_keyword_fr=makeSafe($_POST['seo_keyword_fr']);
	$seo_description_fr=makeSafe($_POST['seo_description_fr']);


	$resimdir = '../upload/hizmet/';
	$resim=$_FILES["resim"]["name"];
	$tmp_resim=$_FILES["resim"]["tmp_name"];
	if($resim!="")
	{
		$image = new SimpleImage();
		if ($seo_etiket_tr!="") {
			$namek=permayap($seo_etiket_tr)."-k-1.".$image->getFileExtension($resim);
			$resized_thumb=getImageNameControl($namek);
			$nameb=permayap($seo_etiket_tr)."-b-1.".$image->getFileExtension($resim);
			$resized_image=getImageNameControl($nameb);
		} else {
			$namek=permayap($hizmet_ad_tr)."-b-1.".$image->getFileExtension($resim);
			$resized_thumb=getImageNameControl($namek);
			$nameb=permayap($hizmet_ad_tr)."-k-1.".$image->getFileExtension($resim);
			$resized_image=getImageNameControl($nameb);
		}

		$image->load($tmp_resim);
		$image->resizeToFit(400,300);
		$image->save($resimdir.$resized_thumb);
		$image->load($tmp_resim);
		$image->resizeToFit(800,600);
		$image->save($resimdir.$resized_image);
	}



	$hizmet_guncelle="update hizmet set hizmet_ad_tr='$hizmet_ad_tr',hizmet_ad_en='$hizmet_ad_en',hizmet_ad_ru='$hizmet_ad_ru',hizmet_ad_ar='$hizmet_ad_ar',hizmet_ad_de='$hizmet_ad_de',hizmet_ad_fr='$hizmet_ad_fr',hizmet_icerik_tr='$hizmet_icerik_tr',hizmet_icerik_en='$hizmet_icerik_en',hizmet_icerik_ru='$hizmet_icerik_ru',hizmet_icerik_ar='$hizmet_icerik_ar',hizmet_icerik_de='$hizmet_icerik_de',hizmet_icerik_fr='$hizmet_icerik_fr',seo_etiket_tr='$seo_etiket_tr',seo_etiket_en='$seo_etiket_en',seo_etiket_ru='$seo_etiket_ru',seo_etiket_ar='$seo_etiket_ar' ,seo_etiket_de='$seo_etiket_de' ,seo_etiket_fr='$seo_etiket_fr' ,aciklama_tr='$aciklama_tr',aciklama_en='$aciklama_en',aciklama_ru='$aciklama_ru',aciklama_ar='$aciklama_ar' ,aciklama_de='$aciklama_de' ,aciklama_fr='$aciklama_fr' ,seo_baslik_tr='$seo_baslik_tr',seo_keyword_tr='$seo_keyword_tr',seo_description_tr='$seo_description_tr',seo_baslik_en='$seo_baslik_en',seo_keyword_en='$seo_keyword_en',seo_description_en='$seo_description_en',seo_baslik_ru='$seo_baslik_ru',seo_keyword_ru='$seo_keyword_ru',seo_description_ru='$seo_description_ru',seo_baslik_ar='$seo_baslik_ar',seo_keyword_ar='$seo_keyword_ar',seo_description_ar='$seo_description_ar',seo_baslik_de='$seo_baslik_de',seo_keyword_de='$seo_keyword_de',seo_description_de='$seo_description_de',seo_baslik_fr='$seo_baslik_fr',seo_keyword_fr='$seo_keyword_fr',seo_description_fr='$seo_description_fr'";

	if($resim!="") $hizmet_guncelle.=" ,resim_buyuk='$resized_image',resim_kucuk='$resized_thumb'";
	$hizmet_guncelle.="  where hizmet_id='$hizmet_id'";
	$db->query($hizmet_guncelle);
	header("location:admin.php?cmd=hizmet_guncelle&hizmet_id=$hizmet_id&result=guncellendi");
}
?>