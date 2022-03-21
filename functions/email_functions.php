<?php
function sendEmail($data) {
    global $cfg,$db;
    include_once $cfg["SiteRoot"]."phpmailer-5.2.17/PHPMailerAutoload.php";
    $mail = new PHPMailer;
    $mail->isSMTP();
    $config = getConfig();
    $mail->Host = $config["smtp_host"];
    $mail->SMTPAuth = true;     
    $mail->Username = $config["smtp_username"];
    $mail->Password = $config["smtp_password"];
    $mail->From = $config["smtp_username"];
    $mail->FromName = $name;
    $mail->AddAddress($config["mail_address"],$config["mail_name"]);
    $mail->IsHTML(true);

    $mail->Host = $config["smtp_host"];
    $mail->SMTPAuth = true;             
    $mail->Username = $config["smtp_username"];
    $mail->Password = $config["smtp_password"];        
    $mail->Port = 587; 
    $mail->From = $config["smtp_username"];
    $mail->FromName = $data["fromname"];

    
    $mail->addAddress($data["toemail"],$data["toname"]);   
    if($data["ccemail"]!="") {
        $mail->addCC($data["ccemail"]);    
    }
    if($data["bccemail"]!="") {
        $mail->addBCC($data["bccemail"]);    
    }
    
    $mail->isHTML(true);
    $mail->Subject = $data["subject"];
    $mail->Body =$data["body"];
   /* $mail->addAttachment($data["attachment"]);*/
    /*$mail->AddAttachment("upload/pdfs/proforma/", $name = "vizyoner-patent_proforma_tr_599988506.pdf",  $encoding = 'base64', $type = 'application/pdf');*/
    $mail->AddAttachment($data["attachment"] , $name = $data["attachmentName"] , $encoding = 'base64', $type = 'application/pdf');
/*    dd($mail);
    die();*/

    if($cfg["emailEnabled"]) {
        $mail->Send();
    }

    $logData = [
    "to"        => $data["toemail"],
    "subject"   => $data["subject"],
    "message"   => $data["body"]
    ];
    /*createEmailLog($logData);*/
}


function createEmailLog($data) {
    global $db;
    $insertData = [
    "email_to" => $data["to"],
    "email_subject" => $data["subject"],
    "email_message" => $data["message"],
    "email_date"    => date('Y-m-d H:i:s')
    ];
    insertDatatoTable('email_log',$insertData);
}