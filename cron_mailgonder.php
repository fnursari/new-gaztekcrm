<?
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  

require("phpmailer/class.phpmailer.php");



$sql = "SELECT 
z.*,
f.firma_ad,
u.name 
FROM
ziyaret z 
LEFT JOIN u1s9e2r6 u 
ON u.user_id = z.kullanici_id 
LEFT JOIN firma f 
ON z.firma_id = f.firma_id
WHERE z.ziyaret_tarihi > '".date("Y-m-d")." 00:00:01' 
AND z.ziyaret_tarihi < '".date("Y-m-d")." 23:59:59' 
AND z.ziyaret_silindi = '0' 
ORDER BY z.kullanici_id, z.ziyaret_tarihi";



$gorusmeler = $db->get_results($sql,ARRAY_A);

$html='<table width="98%"  id="tbl" cellpadding="0" cellspacing="0">
<tr> 
<th><div align="left"><strong>Sıra</strong></div></th>
<th><div align="left"><strong>Pazarlamacı</strong></div></th>
<th><div align="left"><strong>Tarih</strong></div></th>
<th><div align="left"><strong>Firma</strong></div></th>
<th><div align="left"><strong>Konu</strong></div></th>
<th><div align="left"><strong>Görüşülen Kişi</strong></div></th>
<th><div align="left"><strong>Görüşme notları</strong></div></th>

</tr>';

if(!is_null($gorusmeler)) {
	foreach ($gorusmeler as $gorusme) {
		$html .= '<tr>
		<td><div align="left">'.($x+1).'</div></td>
		<td><div align="left">'.$gorusme["name"].'</div></td>
		<td><div align="left">'.$gorusme["ziyaret_tarihi"].'</div></td>
		<td><div align="left">'.$gorusme["firma_ad"].'</div></td>
		<td><div align="left">'.$gorusme["ziyaret_konusu"].'</div></td>
		<td><div align="left">'.$gorusme["gorusulen_kisi"].'</div></td>
		<td><div align="left">'.$gorusme["gorusme_notlari"].'</div></td>
		</tr>';
	}
}
$html .= '</table>';



$mail = new PHPMailer();
$mail->SetLanguage("tr","../phpmailer/language/");
$mail->IsSMTP();
$mail->Host = "mail.vizyoner.com.tr";
$mail->SMTPAuth = true;     
$mail->Username = "info@vizyoner.com.tr";
$mail->Password = "Revizyon2Bak";
$mail->From = "info@vizyoner.com.tr";
$mail->FromName = "Vizyoner"; 
$mail->AddAddress("mersoy@vizyoner.com.tr","Meersoy");
$mail->IsHTML(true);
$mail->Subject = "Pazarlamacı Görüşme Notları - ".date("Y-m-d");
$mail->Body ='<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style>
body { margin:0px; padding:0px; color:#333333; font-family:Arial, Helvetica, sans-serif; font-size:12px;}
			#tbl { border-top:1px solid #dae0e5;border-left:1px solid #dae0e5;}
			#tbl th { background-color:#F2F2F2; height:22px; border-right:1px solid #dae0e5;border-bottom:1px solid #dae0e5; padding:2px;color:#003366; font-weight:bold;font-size:12px; }
			#tbl td { border-bottom:1px solid #dae0e5;border-right:1px solid #dae0e5; background-color:#ffffff; padding-top:2px; padding-bottom:2px; padding-left:2px; padding-right:2px; font-weight:normal; font-size:11px; color:#333333; }
</style>
</head>
<body  topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0">
'.$html.'
</body>
</html>';
echo $mail->Body;
if (!$mail->Send()) echo  $mail->ErrorInfo;
