<?php
$result=$_GET['result'];
$resultstr="";
switch ($result) {
    case 'guncellendi':
    $resultstr='<div class="alert alert-success text-center">Güncelleme Gerçekleştirilmiştir.</div>';
    break;

    case 'eklendi':
    $resultstr='<div class="alert alert-success text-center">Ekleme Gerçekleştirilmiştir.</div>';
    break;

    case 'teklif':
    $resultstr='<div class="alert alert-success text-center">Teklif Oluşturuldu.</div>';
    break;

    case 'proforma':
    $resultstr='<div class="alert alert-success text-center">Proforma Oluşturuldu.</div>';
    break;

    case 'sozlesme':
    $resultstr='<div class="alert alert-success text-center">Sözleşme Oluşturuldu.</div>';
    break;

    case 'mail_ok':
    $resultstr='<div class="alert alert-success text-center">E-mail Gönderildi.</div>';
    break;

    case 'mail_error':
    $resultstr='<div class="alert alert-danger text-center">E-mail Gönderilemedi.</div>';
    break;

    case 'kullanici_hata':
    $resultstr='<div class="alert alert-danger text-center">Kullanıcı Adı Başka Kullanıcı Tarafından Kullanılmaktadır.</div>';
    break;

    case 'silindi':
    $resultstr='<div class="alert alert-success text-center">Silme Gerçekleştirilmiştir.</div>';
    break;

    case 'hata':
    $resultstr='<div class="alert alert-danger text-center">Lütfen Resim Adı Giriniz</div>';
    break;  

    case 'eski_sifre_yanlis':
    $resultstr='<div class="alert alert-danger text-center">Eski Şifrenizi Yanlış Girdiniz!</div>';
    break;
}
if ($resultstr!="") {
    echo $resultstr;
}
?>