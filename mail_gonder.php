<?php
session_start();
header("Content-Type: text/html; charset=utf-8"); 
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";

$dil=$_GET["dil"];
$pdf=$_GET["pdf"];
$teklif_id=$_GET["teklif_id"];

if($pdf=="sozlesme"){
	$pdf_name="SÖZLEŞME";
}else{
	$pdf_name=ucwords($pdf);
}

if ($dil=='') $dil=$cfg["DefaultLanguage"];
if(!file_exists('languages/'.$dil.'.php')) { $dil=$cfg["DefaultLanguage"];}

function file_ext_bul($filename) {
	return end(explode(".", $filename));
}


$sqlteklif="select * from teklifler where teklif_id='$teklif_id'";
$detailsteklif = $db->get_row($sqlteklif,ARRAY_A);
$bilgi_giris_id = $detailsteklif["bilgi_giris_id"];


$sql="select * from bilgi_giris where bilgi_giris_id='$bilgi_giris_id' and bilgi_giris_aktif='1'";
$details = $db->get_row($sql,ARRAY_A);


/*
if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
	$verifyResponse = GetMetodu('https://www.google.com/recaptcha/api/siteverify?secret='.$cfg["secret_key"].'&response='.$_POST['g-recaptcha-response']);
	$responseData = json_decode($verifyResponse);
	if($responseData->success) {*/
		$allowed_filetypes = array('pdf','doc','docx');
		if($pdf=="teklif"){
			$dosya=$detailsteklif["teklif_pdf_$dil"];
			$dosya_yolu='upload/pdfs/proposals/';
		}
		if($pdf=="proforma"){
			$dosya=$detailsteklif["proforma_pdf_$dil"];
			$dosya_yolu='upload/pdfs/proforma/';
		}
		if($pdf=="sozlesme"){
			$dosya=$detailsteklif["sozlesme_pdf_$dil"];
			$dosya_yolu='upload/pdfs/contract/';
		}

		if($dosya!="") {
			$ext = file_ext_bul($dosya);
			$dosyauzanti=getFileExtension($dosya);
			if ($dosyauzanti==".pdf" || $dosyauzanti==".doc" || $dosyauzanti==".docx") {

				
				$email = makeSafe($details["firma_email"]);
				$name = makeSafe($details["firma_ad"]);
				$phone = makeSafe($details["firma_telefon"]);

				/*$name = makeSafe($_POST["name"]);
				$email = makeSafe($_POST["email"]);
				$phone = makeSafe($_POST["phone"]);
				$tarih=date("Y-m-d H:i:s");

				$uploadFileData = [
					"file" 					=> $_FILES["dosya"],
					"filename"				=> "cv",
				];
				$insertData2  =[
					"ad"		=> $name,
					"email"		=> $email,
					"telefon"	=> $phone,
					"tarih"		=> $tarih,

				];
				$defaultinsertData = [
					"dosya" 			=> uploadFile($uploadFileData),
				];

				$insertData =$defaultinsertData + $insertData2;
				$basvuru_id=insertDatatoTable("is_basvurusu",$insertData);*/


				$subject = $pdf_name;
				$content = file_get_contents($cfg["SiteRoot"].'email_templates/teklif.tpl');

				$email_template = file_get_contents($cfg["FullDir"].'email_templates/email_template.tpl');
				$email_template=str_replace("{#mesaj_icerigi#}",$content,$email_template);
				$email_template=str_replace("{#mesaj_konusu#}",$subject,$email_template);


				$email_template=str_replace("{#firma_adi#}",$name,$email_template);
				$email_template=str_replace("{#ad_soyad#}",$name,$email_template);
				$email_template=str_replace("{#mail#}",$email,$email_template);
				$email_template=str_replace("{#telefon#}",$phone,$email_template);

				$email_template=str_replace("{#logo#}",$cfg["SiteUrl"]."assets/img/logo1.png",$email_template);
				$email_template=str_replace("{#web#}",$config["web"],$email_template);
				$email_template=str_replace("{#email#}",$config["email"],$email_template);


				/*$pdfFile=getDocumentsPdfs($dosya,$dosya_yolu);*/

				

				$data = [
					"fromname"		 	=> $config["mail_name"],
					"toemail" 		 	=> makeSafe($email),
					"toname" 		 	=> makeSafe($name),
					"subject" 		 	=> $subject,
					"body" 			 	=> $email_template,
					"attachmentName" 	=> $name.'.pdf',
					"attachment" 		=> $dosya_yolu.$dosya,


				];
				sendEmail($data);




				header("location:admin.php?cmd=pdf_goster&pdf=$pdf&bilgi_giris_id=$bilgi_giris_id&dil=$dil&result=mail_ok");

			} else {
				
				header("location:admin.php?cmd=pdf_goster&pdf=$pdf&bilgi_giris_id=$bilgi_giris_id&dil=$dil&result=mail_error");
			}
		}

/*
		
	} else{
		header("location:insankaynaklari_error_".$dil.".html");
	}
	

}	else{
	header("location:insankaynaklari_error_".$dil.".html");
}	*/
?>